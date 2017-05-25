<?php
	//include 'session.php';

	if(!isset($_GET['service'])){
		exit();
	}
	
	$ch = curl_init();
	curl_setopt($ch, CURLOPT_RETURNTRANSFER,1);
	
	$base_url = "http://boomi-base22.com:9090/ws/rest/wps/";
	switch($_GET['service']){
		case 'getListing': 
			$url = $base_url.'ls?id='.urlencode($_GET['id']);
		break;
		case 'getFile': 
			$url = $base_url.'file?key='.urlencode($_GET['key']);
		break;
		case 'postFile': 
			$url = $base_url.'file';
			curl_setopt($ch, CURLOPT_POST, 1);
			$body = @file_get_contents('php://input');
			curl_setopt($ch, CURLOPT_POSTFIELDS, $body);

			curl_setopt($ch, CURLOPT_HTTPHEADER, array(
	    		'Content-Type: multipart/mixed; boundary=frontier'
    		));
			error_log('');
			error_log($body);
			error_log('');
		break;
	};

	curl_setopt($ch, CURLOPT_URL, $url);
	$result = curl_exec($ch);
	echo $result;

	echo curl_error( $ch );
	curl_close($ch);
?>