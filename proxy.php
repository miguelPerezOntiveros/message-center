<?php
	include 'session.php';

	if(!isset($_GET['service'])){
		exit();
	}
	
	$ch = curl_init();
	curl_setopt($ch, CURLOPT_RETURNTRANSFER,1);

	$url = "";
	switch($_GET['service']){
		case 'getThreads': 
			$url = 'http://boomi-base22.com:9090/ws/rest/messages-center/thread?authorId='.urlencode($_SESSION['dn']);
			error_log(  $url );
		break;
		case 'getMessages': 
			$url = 'http://boomi-base22.com:9090/ws/rest/messages-center/message?threadId='.$_GET['threadId'].'&own='.$_GET['own'].'&authorId='.urlencode($_SESSION['dn']);
		break;
		case 'postMessage': 
			$url = 'http://boomi-base22.com:9090/ws/rest/messages-center/message';
			
			$body = json_decode(@file_get_contents('php://input'), title);
			$body['authorId'] = $_SESSION['dn'];
			$body = json_encode($body);
		
			curl_setopt($ch, CURLOPT_POSTFIELDS, $body);                                                                  
			curl_setopt($ch, CURLOPT_HTTPHEADER, array(                                                                          
				    'Content-Type: application/json',                                                                                
				    'Content-Length: ' . strlen($body)
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