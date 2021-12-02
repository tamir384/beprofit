<?php require('partials/head.php');
require('core/Upload.php');
use App\Core\Upload;
?>


<?php
if(isset($_POST['button1'])) {
	Upload::upload();
}
if(isset($_POST['button2'])) {
	echo "This is Button2 that is selected";
}
?>
<form method="POST" action="/">
	<input type="submit" name="button1"
	       value="Upload"/>

	<input type="submit" name="button2"
	       value="Get"/>
</form>


<?php require('partials/footer.php') ?>
