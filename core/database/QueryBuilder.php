<?php


class QueryBuilder
{

	protected $pdo;

	public function __construct(PDO $pdo)
	{
		$this->pdo = $pdo;
	}

	public function build($data)
	{

		$structure = [
			["category" => 'order_ID', 'type' => 'str'],
			["category" => 'shop_ID', 'type' => 'int'],
			["category" => 'closed_at', 'type' => 'time'],
			["category" => 'created_at', 'type' => 'time'],
			["category" => 'updated_at', 'type' => 'time'],
			["category" => 'total_price', 'type' => 'float'],
			["category" => 'subtotal_price', 'type' => 'float'],
			["category" => 'total_weight', 'type' => 'float'],
			["category" => 'total_tax', 'type' => 'float'],
			["category" => 'currency', 'type' => 'str'],
			["category" => 'financial_status', 'type' => 'str'],
			["category" => 'total_discounts', 'type' => 'int'],
			["category" => 'name', 'type' => 'str'],
			["category" => 'processed_at', 'type' => 'time'],
			["category" => 'fulfillment_status', 'type' => 'str'],
			["category" => 'country', 'type' => 'str'],
			["category" => 'province', 'type' => 'str'],
			["category" => 'total_production_cost', 'type' => 'float'],
			["category" => 'total_items', 'type' => 'int'],
			["category" => 'total_order_shipping_cost', 'type' => 'float'],
			["category" => 'total_order_handling_cost', 'type' => 'float']
		];

		$fieldX = [];

		foreach ($structure as $field) {
			$fieldX[] = $field['category'];
			$fieldY[] = ':' . $field['category'];
		}

		$sql = "INSERT INTO orders (" . implode(",", $fieldX) . ")  VALUES " .
			"(" . implode(',', $fieldY) . ")";


		$stmt = $this->pdo->prepare($sql);
		static::bindValue_($stmt, $structure, $data);
	}

	static function placeholders($text, $count = 0, $separator = ",")
	{
		$result = array();
		if ($count > 0) {
			for ($x = 0; $x < $count; $x++) {
				$result[] = $text;
			}
		}
		return implode($separator, $result);
	}

	public function sumNetSales(){
		//Net Sales - sum of total_price fields of orders where financial_status is one of the following: 'paid', 'partially_paid'
		try {
			$stmt = $this->pdo->prepare("SELECT sum(total_price) FROM orders WHERE financial_status IN('paid', 'partially_paid')");
			$stmt->execute();

			// set the resulting array to associative
			$result = $stmt->setFetchMode(PDO::FETCH_ASSOC);

			return $stmt->fetchColumn();
		}
		catch(PDOException $e) {
			echo "Error: " . $e->getMessage();
		}
	}


	public function productionCosts(){
		try {
			$stmt = $this->pdo->prepare("SELECT sum(total_production_cost) FROM orders WHERE financial_status IN('paid', 'partially_paid') AND fulfillment_status='fulfilled'");
			$stmt->execute();

			// set the resulting array to associative
			$result = $stmt->setFetchMode(PDO::FETCH_ASSOC);
			return $stmt->fetchColumn();
		}
		catch(PDOException $e) {
			echo "Error: " . $e->getMessage();
		}
	}


	static function bindValue_($stmt, $structure, $data)
	{
		$temp = '';
		foreach ($data as $d) {
			foreach ($structure as $field) {
				switch ($field['type']) {
					case 'int':
						$temp = 'intval';
						break;
					case 'time':
					case 'str':
						$temp = 'strval';
						break;
					case 'float':
						$temp = 'floatval';
						break;
				}
				if ($d->{$field['category']}) {
					$stmt->bindValue(":" . $field['category'], $temp($d->{$field['category']}));
				} else {
					$stmt->bindValue(":" . $field['category'], $d->{$field['category']});
				}
			}
			$stmt->execute();
		}
	}


	public
	function selectAll($table)
	{
		$statement = $this->pdo->prepare("select * from {$table}");

		$statement->execute();


		return $statement->fetchAll(PDO::FETCH_CLASS);

	}

	public
	function insert($table, $parameters)
	{

		$sql = sprintf(
			'insert into %s (%s) values (%s)',
			$table,
			implode(', ', array_keys($parameters)),
			':' . implode(', :', array_keys($parameters))

		);


		try {
			$statement = $this->pdo->prepare($sql);

			$statement->execute($parameters);
		} catch (Exception $e) {
			die ('Whoops ' . $e);
		}

	}

	public
	function createTables()
	{
		// sql to create table
		$sql = "CREATE TABLE orders (
 			order_ID					 VARCHAR(50) PRIMARY KEY,
  			shop_ID 					 VARCHAR(50),
 			closed_at 					TIMESTAMP,
 			created_at					TIMESTAMP,
 			updated_at 					TIMESTAMP,
 			total_price 				FLOAT UNSIGNED ,
 			subtotal_price 				FLOAT UNSIGNED,
 			total_weight 				FLOAT UNSIGNED ,
 			total_tax 					FLOAT UNSIGNED,
 			currency			 		VARCHAR(255),
 			financial_status 				VARCHAR(255),
 			total_discounts 				INT UNSIGNED,
 			name 						VARCHAR(255),
 			processed_at 					TIMESTAMP,
 			fulfillment_status 			VARCHAR(255),
 			country 						VARCHAR(255),
 			province 					VARCHAR(255) ,
 			total_production_cost 		FLOAT UNSIGNED,
 			total_items 				INT UNSIGNED,
 			total_order_shipping_cost	 FLOAT UNSIGNED,
 			total_order_handling_cost 	FLOAT UNSIGNED
 		)";

		try {
			$statement = $this->pdo->prepare($sql);

			$statement->execute();
		} catch (Exception $e) {
			die ('Whoops ' . $e);
		}
	}
}