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
			$url = $base_url.'thread/'.$_GET['threadId'];
		break;
		case 'postMessage': 
			$url = $base_url.'message';
			curl_setopt($ch, CURLOPT_POST, 1);
			
			$body = @file_get_contents('php://input');
			curl_setopt($ch, CURLOPT_POSTFIELDS, $body);                                                                    
		break;
		case 'getCsrs':
			$url = $base_url.'csr';
		break;
		case 'getCustomers':
			$url = $base_url.'customer';
		break;
		case 'getAttachment':
 			//curl_setopt($ch, CURLOPT_BINARYTRANSFER, false);
			$url = $base_url.'thread/'.$_GET['threadId'].'/message/'.$_GET['messageId'].'/attachment/'.$_GET['attachment'];	

			header("Content-Type: image/jpeg");
			curl_setopt($ch, CURLOPT_HEADER, false);
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
			curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
			curl_setopt($ch, CURLOPT_USERAGENT, 'Mozilla/5.0 (Windows NT 6.1) AppleWebKit/537.11 (KHTML, like Gecko) Chrome/23.0.1271.1 Safari/537.11');

			error_log('asked for attachment'.$url);
		break;
	};

	curl_setopt($ch, CURLOPT_URL, $url);
	$result = curl_exec($ch);
	echo $result;

	echo curl_error( $ch );
	curl_close($ch);
?>