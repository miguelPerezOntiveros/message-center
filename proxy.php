<?php
	session_start();
	if(!isset($_SESSION['userName']) && basename($_SERVER["PHP_SELF"]) != 'logIn.php'){
		header('Location: logIn.php');
		exit();
	}

	if(!isset($_GET['service'])){
		exit();
	}
	
	$ch = curl_init();
	curl_setopt($ch, CURLOPT_RETURNTRANSFER,1);

	$url = "";
	switch($_GET['service']){
		case 'getThreads': 
			$url = 'http://boomi-base22.com:9090/ws/rest/messages-center/thread';
		break;
		case 'getMessages': 
			$url = 'http://boomi-base22.com:9090/ws/rest/messages-center/message';
		break;
		case 'postMessage': 
			$url = 'http://boomi-base22.com:9090/ws/rest/messages-center/message';
			$_SESSION['userName']
			$_SESSION['type']
			
			$body = '{
			  "threadId": 0,
			  "authorId":"",
			  "userid":"",
			  "ownerId":"",
			  "delegateId":"",
			  "status": 1,
			  "priority": 1,
			  "subject":"",
			  "message":"",
			  "attachments":""
			}';
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
	echo '{ "data":'.$result.'}';

	echo curl_error( $ch );
	curl_close($ch);
?>