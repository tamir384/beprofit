<?php

namespace App\Core;

use Connection;
use GuzzleHttp\Client;


use mysqli;
use PDO;

class Upload
{

	public static function upload()
	{
		$mysql = new mysqli("localhost", "root", "", "beprofit");
		$val = mysqli_query($mysql,'select 1 from `orders` LIMIT 1');
		if (!$val){
			static::createTables();
		}
		static::insertData();

	}

	static function createTables()
	{
		App::get('database')->createTables();
	}

	static function insertData()
	{
		$client = new Client();
		$res = $client->request('GET', 'https://www.become.co/api/rest/test/', [
			'auth' => ['tzinch', 'r#eD21mA%gNU']
		]);


		$items = json_decode((string) $res->getBody());

		App::get('database')->build($items->{'data'});

	}


}