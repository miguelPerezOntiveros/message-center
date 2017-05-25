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
		case 'deleteFile': 
			curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'DELETE');
			$url = $base_url.'file?key='.urlencode($_GET['key']);
			error_log('$baseURL: '.$base_url);
			error_log('url: '.$url);

		break;
		case 'postFile': 
			$url = $base_url.'file';
			curl_setopt($ch, CURLOPT_POST, 1);
			$body = @file_get_contents('php://input');
			curl_setopt($ch, CURLOPT_POSTFIELDS, $body);

			curl_setopt($ch, CURLOPT_HTTPHEADER, array(
	    		'Content-Type: multipart/mixed; boundary=frontier'
    		));
		break;
	};

	curl_setopt($ch, CURLOPT_URL, $url);
	$result = curl_exec($ch);
	echo $result;

	echo curl_error( $ch );
	curl_close($ch);
?>