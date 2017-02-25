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
		case 'getThreads': 
			$url = $base_url.'thread?own='.$_GET['own'];
			error_log($url);
			error_log($_SESSION['type']);
			error_log(urlencode($_SESSION['dn']));
		break;
		case 'getMessages': 
			$url = $base_url.'message?threadId='.$_GET['threadId'];
		break;
		case 'postMessage': 
			$url = $base_url.'message';
			
			$body = json_decode(@file_get_contents('php://input'), title);
			//$body['author-id'] = $_SESSION['dn'];
			//$body = json_encode($body);
		
			curl_setopt($ch, CURLOPT_POSTFIELDS, $body);                                                                  
			curl_setopt($ch, CURLOPT_HTTPHEADER, array(                                                                          
				    'Content-Type: application/json',                                                                                
				    'Content-Length: '.strlen($body)
			    )                                                                       
			);  
			curl_setopt($ch, CURLOPT_POST, 1);
		break;
	};

	curl_setopt($ch, CURLOPT_URL, $url);
	$result = curl_exec($ch);
	echo $result;

	echo curl_error( $ch );
	curl_close($ch);
?>