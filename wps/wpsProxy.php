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

			if(substr($_GET['key'], -4) === '.png' || substr($_GET['key'], -4) === '.jpg' || substr($_GET['key'], -5) === '.jpeg'  ) {
				header("Content-Type: image/jpeg");
				curl_setopt($ch, CURLOPT_HEADER, false);
				curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
				curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
				curl_setopt($ch, CURLOPT_USERAGENT, 'Mozilla/5.0 (Windows NT 6.1) AppleWebKit/537.11 (KHTML, like Gecko) Chrome/23.0.1271.1 Safari/537.11');
			}
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