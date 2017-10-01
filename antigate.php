<?php

class Antigate {
	
	private static $secret_key = '';
	
	public static function read($image)
	{
		$image = file_get_contents($image);
		
		$data = array(
			'clientKey' => self::$secret_key,
			'task' => array(
					'type' => 'ImageToTextTask',
					'body' => base64_encode($image),
				)
		);
		
		$url = 'http://api.anti-captcha.com/createTask';
		
		$request = new Request($url);
		$request->payload($data);
		$request->send();
		
		$json = json_decode($request->response, true);
		
		$data = array(
			'clientKey' => self::$secret_key,
			'taskId' => $json['taskId']
		);
		
		$n = 0;
		
		do
		{
			$n++;
			
			if( $n >= 30) break;
			
			sleep(3);
			
			$request = new Request('http://api.anti-captcha.com/getTaskResult');
			$request->payload($data);
			$request->send();
			
			$json = json_decode($request->response, true);
		}while( $json['status'] !== 'ready');
		
		if( !isset($json['solution']['text'])) return false;
		
		return $json['solution']['text'];
	}
	
}
