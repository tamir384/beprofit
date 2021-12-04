<?php


namespace App\Core;

use GuzzleHttp\Client;


use PDO;

class Upload
{

	public static function upload()
	{
//		static::createTables();
		static::insertData();

	}

	static function createTables()
	{
//		QueryBuilder::createTables();
		App::get('database')->createTables();
	}

	static function insertData()
	{
		$client = new Client();
		$res = $client->request('GET', 'https://www.become.co/api/rest/test/', [
			'auth' => ['tzinch', 'r#eD21mA%gNU']
		]);
//		echo $res->getStatusCode();
//		// "200"
//		echo $res->getHeader('content-type')[0];
//		// 'application/json; charset=utf8'
//		echo $res->getBody();
//		// {"type":"User"...'


//		var_export($res->json());
//		echo $res->getBody()->

		$items = json_decode((string) $res->getBody());
//		foreach ($items['data'] as $key => $item) {
//			echo $item['order_ID'] . ': ';
//			echo $item['shop_ID'] . '<br>';
//		}

		App::get('database')->build($items->{'data'});

	}


}