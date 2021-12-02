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
			":order_ID",
			":shop_ID",
//			"closed_at",
//			"created_at",
//			"updated_at",
			":total_price"
//			"subtotal_price",
//			"total_weight",
//			"total_tax",
//			"currency",
//			"financial_status",
//			"total_discounts",
//			"name",
//			"processed_at",
//			"fulfillment_status",
//			"country",
//			"province",
//			"total_production_cost",
//			"total_items",
//			"total_order_shipping_cost",
//			"total_order_handling_cost"
		];
			echo implode(',', $structure);

		$stmt = $this->pdo->prepare('INSERT INTO orders VALUES('. implode(',', $structure).
                      ')');
		foreach ($data as $item) {
//			foreach($structure as $field)
//			{
//				$stmt->bindValue($field, $item[$field]);
//			}
			$stmt->bindValue(":order_ID", intval($item['order_ID']));
			$stmt->bindValue(":shop_ID", intval($item['shop_ID']));
			$stmt->bindValue(":total_price", floatval($item['total_price']));
			$stmt->execute();
		}
	}


	public function selectAll($table)
	{
		$statement = $this->pdo->prepare("select * from {$table}");

		$statement->execute();


		return $statement->fetchAll(PDO::FETCH_CLASS);

	}

	public function insert($table, $parameters)
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

	public function createTables()
	{
		// sql to create table
		$sql = "CREATE TABLE orders (
 			order_ID					 INT UNSIGNED PRIMARY KEY,
  			shop_ID 					 INT UNSIGNED NOT NULL,
 			closed_at 					TIMESTAMP,
 			created_at					 TIMESTAMP,
 			updated_at 					TIMESTAMP,
 			total_price 				FLOAT UNSIGNED NOT NULL,
 			subtotal_price 				FLOAT UNSIGNED NOT NULL,
 			total_weight 				FLOAT UNSIGNED NOT NULL,
 			total_tax 					FLOAT UNSIGNED NOT NULL,
 			currency			 		VARCHAR(5) NOT NULL,
 			financial_status 				VARCHAR(12) NOT NULL,
 			total_discounts 				INT UNSIGNED NOT NULL,
 			name 						VARCHAR(255) NOT NULL,
 			processed_at 					TIMESTAMP,
 			fulfillment_status 			VARCHAR(255) NOT NULL,
 			country 						VARCHAR(255) NOT NULL,
 			province 					VARCHAR(255) NOT NULL,
 			total_production_cost 		FLOAT UNSIGNED NOT NULL,
 			total_items 				INT UNSIGNED NOT NULL,
 			total_order_shipping_cost	 FLOAT UNSIGNED NOT NULL,
 			total_order_handling_cost 	FLOAT UNSIGNED NOT NULL
 		)";

		try {
			$statement = $this->pdo->prepare($sql);

			$statement->execute();
		} catch (Exception $e) {
			die ('Whoops ' . $e);
		}
	}
}