<?php
	include 'session.php';

	if(!isset($_GET['service'])){
		exit();
	}
	
	$ch = curl_init();
	curl_setopt($ch, CURLOPT_RETURNTRANSFER,1);
	curl_setopt($ch, CURLOPT_HTTPHEADER, array(
	    'X-WSS-User-Id: '.$_SESSION['dn'],
	    'X-WSS-User-Type: '.$_SESSION['type']
    ));

	$base_url = "http://boomi-base22.com:9090/ws/rest/messages-center/";
	switch($_GET['service']){
		
		case 'postFile': 
			$url = $base_url.'file';
			curl_setopt($ch, CURLOPT_POST, 1);

			$body = @file_get_contents('php://input');
			curl_setopt($ch, CURLOPT_POSTFIELDS, $body);
			
		break;
		
		case 'getThreads': 
			$url = $base_url.'thread?'.$_SERVER['QUERY_STRING'];
			error_log('qs is> '.$_SERVER['QUERY_STRING']);
			error_log('ur lis >'.$url);
			error_log($_SESSION['type']);
			error_log(urlencode($_SESSION['dn']));
		break;
		case 'getMessages': 
			$url = $base_url.'message?threadId='.$_GET['threadId'];
		break;
		case 'postMessage': 
			$url = $base_url.'message';
			
			$body = json_decode(@file_get_contents('php://input'));
			//$body['author-id'] = $_SESSION['dn'];
			//$body = json_encode($body);
		
			curl_setopt($ch, CURLOPT_POSTFIELDS, $body);                                                                    
			curl_setopt($ch, CURLOPT_POST, 1);
		break;
	};

	curl_setopt($ch, CURLOPT_URL, $url);
	$result = curl_exec($ch);
	echo $result;

	echo curl_error( $ch );
	curl_close($ch);
?>