<?php


namespace App\Core;



class QueryDB
{


	public function getNetSales(){
		return App::get('database')->sumNetSales();
	}
	public function getProdCosts(){
		return App::get('database')->productionCosts();
	}

	public static function sumNetSales(){
		$sum = (new self)->getNetSales();
		echo $sum;

	}

	public static function productionCosts(){
		$costs = (new self)->getProdCosts();
		echo $costs;
	}

	public static function grossProfit(){
		$sum = (new self)->getNetSales();
		$costs = (new self)->getProdCosts();
		$result = $sum - $costs;
		echo $result;
	}
	public static function grossMargin(){
		$sum = (new self)->getNetSales();
		$costs = (new self)->getProdCosts();
		$result = $sum - $costs;
		echo $result/$sum;
	}



}