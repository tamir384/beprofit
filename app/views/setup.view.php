<?php require('partials/head.php');
require('core/Upload.php');
require('core/QueryDB.php');
use App\Core\Upload;
use App\Core\QueryDB;

?>


<?php
if(isset($_POST['button1'])) {
	Upload::upload();
}
if(isset($_POST['button2'])) {
	QueryDB::sumNetSales();
}
 if(isset($_POST['button3'])) {
	QueryDB::productionCosts();
}
 if(isset($_POST['button4'])) {
	QueryDB::grossProfit();
}
 if(isset($_POST['button5'])) {
	QueryDB::grossMargin();
}

?>
<form method="POST" action="/">
	<input type="submit" name="button1"
	       value="Upload"/>

	<input type="submit" name="button2"
	       value="Net Sales"/>
	<input type="submit" name="button3"
	       value="Production Costs"/>
	<input type="submit" name="button4"
	       value="Gross Profit"/>
	<input type="submit" name="button5"
	       value="Gross Margin"/>
</form>


<?php require('partials/footer.php') ?>
