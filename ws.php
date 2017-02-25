<?php
namespace MyApp;
use Ratchet\MessageComponentInterface;
use Ratchet\ConnectionInterface;
use Ratchet\Server\IoServer;
use Ratchet\Http\HttpServer;
use Ratchet\WebSocket\WsServer;

require 'composer/vendor/autoload.php';

function var_debug($variable,$strlen=100,$width=25,$depth=10,$i=0,&$objects = array())
{
  $search = array("\0", "\a", "\b", "\f", "\n", "\r", "\t", "\v");
  $replace = array('\0', '\a', '\b', '\f', '\n', '\r', '\t', '\v');
 
  $string = '';
 
  switch(gettype($variable)) {
    case 'boolean':      $string.= $variable?'true':'false'; break;
    case 'integer':      $string.= $variable;                break;
    case 'double':       $string.= $variable;                break;
    case 'resource':     $string.= '[resource]';             break;
    case 'NULL':         $string.= "null";                   break;
    case 'unknown type': $string.= '???';                    break;
    case 'string':
      $len = strlen($variable);
      $variable = str_replace($search,$replace,substr($variable,0,$strlen),$count);
      $variable = substr($variable,0,$strlen);
      if ($len<$strlen) $string.= '"'.$variable.'"';
      else $string.= 'string('.$len.'): "'.$variable.'"...';
      break;
    case 'array':
      $len = count($variable);
      if ($i==$depth) $string.= 'array('.$len.') {...}';
      elseif(!$len) $string.= 'array(0) {}';
      else {
        $keys = array_keys($variable);
        $spaces = str_repeat(' ',$i*2);
        $string.= "array($len)\n".$spaces.'{';
        $count=0;
        foreach($keys as $key) {
          if ($count==$width) {
            $string.= "\n".$spaces."  ...";
            break;
          }
          $string.= "\n".$spaces."  [$key] => ";
          $string.= var_debug($variable[$key],$strlen,$width,$depth,$i+1,$objects);
          $count++;
        }
        $string.="\n".$spaces.'}';
      }
      break;
    case 'object':
      $id = array_search($variable,$objects,true);
      if ($id!==false)
        $string.=get_class($variable).'#'.($id+1).' {...}';
      else if($i==$depth)
        $string.=get_class($variable).' {...}';
      else {
        $id = array_push($objects,$variable);
        $array = (array)$variable;
        $spaces = str_repeat(' ',$i*2);
        $string.= get_class($variable)."#$id\n".$spaces.'{';
        $properties = array_keys($array);
        foreach($properties as $property) {
          $name = str_replace("\0",':',trim($property));
          $string.= "\n".$spaces."  [$name] => ";
          $string.= var_debug($array[$property],$strlen,$width,$depth,$i+1,$objects);
        }
        $string.= "\n".$spaces.'}';
      }
      break;
  }
 
  if ($i>0) return $string;
 
  $backtrace = debug_backtrace(DEBUG_BACKTRACE_IGNORE_ARGS);
  do $caller = array_shift($backtrace); while ($caller && !isset($caller['file']));
  if ($caller) $string = $caller['file'].':'.$caller['line']."\n".$string;
 
  echo $string;
}

class Chat implements MessageComponentInterface {
    protected $clients;

    public function __construct() {
        $this->clients = new \SplObjectStorage;
    }

    public function onOpen(ConnectionInterface $conn) {
        // Store the new connection to send messages to later
        $this->clients->attach($conn);

        echo "New connection! ({$conn->resourceId})\n";
    }

    public function onMessage(ConnectionInterface $from, $msg) {
    	var_debug($from->WebSocket->request,100,25,5);
    	var_debug($from,100,25,2);

        $numRecv = count($this->clients) - 1;
        echo sprintf('Connection %d sending message "%s" to %d other connection%s' . "\n"
            , $from->resourceId, $msg, $numRecv, $numRecv == 1 ? '' : 's');

        foreach ($this->clients as $client) {
            if ($from !== $client) {
                // The sender is not the receiver, send to each client connected
                $client->send($msg);
            }
        }
    }

    public function onClose(ConnectionInterface $conn) {
        // The connection is closed, remove it, as we can no longer send it messages
        $this->clients->detach($conn);

        echo "Connection {$conn->resourceId} has disconnected\n";
    }

    public function onError(ConnectionInterface $conn, \Exception $e) {
        echo "An error has occurred: {$e->getMessage()}\n";

        $conn->close();
    }
}
    $server = IoServer::factory(
        new HttpServer(
            new WsServer(
                new Chat()
            )
        ),
        8082
    );

    $server->run();
   