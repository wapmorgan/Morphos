<html>
<form method="post">
Введите слово: <input name="word" value="<?= isset($_POST['word']) ? $_POST['word'] : null ?>"> <label><input type="checkbox" name="animate" <?= isset($_POST['animate']) ? "checked='checked'" : null ?> /> одушевл. </label><input type="submit"/>
</form>
<?php
require dirname(dirname(__FILE__)).'/vendor/autoload.php';
$dec = new morphos\Russian\GeneralDeclension();
$plu = new morphos\Russian\Plurality();
if (isset($_POST['word'])) {
	if (!isset($_POST['animate'])) $_POST['animate'] = false;
	else $_POST['animate'] = true;

	echo '<pre>';
		var_dump($dec->getDeclension($_POST['word']));
	echo '</pre>';
	echo '<pre>';
		var_dump($dec->getForms($_POST['word'], $_POST['animate']));
	echo '</pre>';
	echo '<pre>';
		var_dump($plu->getForms($_POST['word'], $_POST['animate']));
	echo '</pre>';

	echo "<blockquote>";
	for ($i = 0; $i <= 20; $i++) {
		echo $i.' '.$plu->pluralize($_POST['word'], $i, $_POST['animate'])."<br/>";
	}
	echo "</blockquote>";
}
?>
<form method="post">
Введите Имя: <input name="name" value="<?= isset($_POST['name']) ? $_POST['name'] : null ?>"> <label><input type="radio" name="gender" value="m" <?= isset($_POST['gender']) && $_POST['gender'] == 'm' ? "checked='checked'" : null ?> /> Муж. </label> <label><input type="radio" name="gender" value="w" <?= isset($_POST['gender']) && $_POST['gender'] == 'w' ? "checked='checked'" : null ?> /> Жен. </label><input type="submit"/>
</form>
<?php
if (isset($_POST['name'])) {
	$gender = isset($_POST['gender']) ? $_POST['gender'] : null;
	echo '<pre>';
		var_dump($gender ?: morphos\Russian\detectGender($_POST['name']));
	echo '</pre>';
	echo '<pre>';
		var_dump(morphos\Russian\nameCase($_POST['name'], null, $gender));
	echo '</pre>';
}
?>
</html>