<?php
require dirname(dirname(__FILE__)).'/vendor/autoload.php';
use morphos\Russian\Cases;
use morphos\Russian\GeneralDeclension;
use morphos\Russian\GeographicalNamesDeclension;

$dec = new morphos\Russian\GeneralDeclension();
$plu = new morphos\Russian\Plurality();
?><html>
<head>
	<link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">
	<link rel="stylesheet" href="https://code.getmdl.io/1.3.0/material.indigo-pink.min.css">
	<script defer src="https://code.getmdl.io/1.3.0/material.min.js"></script>
	<title>Morphos Testing Script</title>
</head>
<body>
	<div class="mdl-tabs mdl-js-tabs mdl-js-ripple-effect">
		<div class="mdl-tabs__tab-bar">
	      <a href="#personal-names" class="mdl-tabs__tab is-active">Склонение имен собственных</a>
	      <a href="#geographical-names" class="mdl-tabs__tab">Склонение географических названий</a>
	      <a href="#nouns" class="mdl-tabs__tab">Склонение существительных</a>
		</div>

		<div class="mdl-tabs__panel" id="nouns">
			<div class="mdl-grid">
				<div class="mdl-cell mdl-cell--6-col" style="text-align: right;">
					<form method="post" action="#nouns">
						<table class="mdl-data-table mdl-js-data-table mdl-shadow--2dp" style="margin: 0 0 0 auto;">
							<tbody>
								<tr>
									<td class="mdl-data-table__cell--non-numeric">Введите имя существительное: <input name="noun" value="<?= isset($_POST['noun']) ? $_POST['noun'] : null ?>"></td>
								</tr>
								<tr>
									<td class="mdl-data-table__cell--non-numeric"><label><input type="checkbox" name="animate" <?= isset($_POST['animate']) ? "checked='checked'" : null ?> /> Одушевлённое</label></td>
								</tr>
								<tr>
									<td class="mdl-data-table__cell--non-numeric"><input type="submit"/></td>
								</tr>
							</tbody>
						</table>
					</form>
				</div>
				<div class="mdl-cell mdl-cell--6-col" style="text-align: left;">
<?php if (isset($_POST['noun'])): ?>
	<?php
	$cases = GeneralDeclension::getCases($_POST['noun']);
	?>
				<table class="mdl-data-table mdl-js-data-table mdl-shadow--2dp">
					<tbody>
						<tr>
							<td class="mdl-data-table__cell--non-numeric" colspan="2" style="text-align: center;"><?=$_POST['noun']?> (<?=GeneralDeclension::getDeclension($_POST['noun'])?> склонение)</td>
						</tr>
						<?php foreach(array(Cases::IMENIT => 'Именительный', Cases::RODIT => 'Родительный', Cases::DAT => 'Дательный', Cases::VINIT => 'Винительный', Cases::TVORIT => 'Творительный', Cases::PREDLOJ => 'Предложный') as $case => $name): ?>
							<tr>
								<td class="mdl-data-table__cell--non-numeric"><?=$name?></td>
								<td class="mdl-data-table__cell--non-numeric"><?=$cases[$case]?></td>
							</tr>
						<?php endforeach; ?>
					</tbody>
				</table>
<?php endif; ?>
				</div>
			</div>
		</form>
<?php
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
	</div>

	<div class="mdl-tabs__panel" id="geographical-names">
		<div class="mdl-grid">
			<div class="mdl-cell mdl-cell--6-col" style="text-align: right;">
				<form method="post" action="#geographical-names">
					<table class="mdl-data-table mdl-js-data-table mdl-shadow--2dp" style="margin: 0 0 0 auto;">
						<tbody>
							<tr>
								<td class="mdl-data-table__cell--non-numeric">Введите название города или улицы: <input name="geographical-name" value="<?= isset($_POST['geographical-name']) ? $_POST['geographical-name'] : null ?>"></td>
							</tr>
							<tr>
								<td class="mdl-data-table__cell--non-numeric">
									<input type="submit"/>
								</td>
							</tr>
						</tbody>
					</table>
				</form>
			</div>
			<div class="mdl-cell mdl-cell--6-col" style="text-align: left;">
			<?php if (isset($_POST['geographical-name'])): ?>
	<?php
	$cases = GeographicalNamesDeclension::getCases($_POST['geographical-name']);
	?>
				<table class="mdl-data-table mdl-js-data-table mdl-shadow--2dp">
					<tbody>
						<tr>
							<td class="mdl-data-table__cell--non-numeric" colspan="2" style="text-align: center;"><?=$_POST['geographical-name']?></td>
						</tr>
						<?php foreach(array(Cases::IMENIT => 'Именительный', Cases::RODIT => 'Родительный', Cases::DAT => 'Дательный', Cases::VINIT => 'Винительный', Cases::TVORIT => 'Творительный', Cases::PREDLOJ => 'Предложный') as $case => $name): ?>
							<tr>
								<td class="mdl-data-table__cell--non-numeric"><?=$name?></td>
								<td class="mdl-data-table__cell--non-numeric"><?=$cases[$case]?></td>
							</tr>
						<?php endforeach; ?>
					</tbody>
				</table>
<?php endif; ?>
			</div>
		</div>
	</div>

	<div class="mdl-tabs__panel is-active" id="personal-names">
		<div class="mdl-grid">
			<div class="mdl-cell mdl-cell--6-col" style="text-align: right;">
				<form method="post" action="#personal-names">
					<table class="mdl-data-table mdl-js-data-table mdl-shadow--2dp" style="margin: 0 0 0 auto;">
						<tbody>
							<tr>
								<td class="mdl-data-table__cell--non-numeric">Введите Имя: <input name="name" value="<?= isset($_POST['name']) ? $_POST['name'] : null ?>"></td>
							</tr>
							<tr>
								<td class="mdl-data-table__cell--non-numeric">
									Выберите пол:
									<label><input type="radio" name="gender" value="" <?= isset($_POST['gender']) && $_POST['gender'] == '' ? "checked='checked'" : null ?> /> Автоматически </label>
									<label><input type="radio" name="gender" value="<?=morphos\Gender::MALE?>" <?= isset($_POST['gender']) && $_POST['gender'] == morphos\Gender::MALE ? "checked='checked'" : null ?> /> Мужской </label>
									<label><input type="radio" name="gender" value="<?=morphos\Gender::FEMALE?>" <?= isset($_POST['gender']) && $_POST['gender'] == morphos\Gender::FEMALE ? "checked='checked'" : null ?> /> Женский </label>
								</td>
							</tr>
							<tr>
								<td class="mdl-data-table__cell--non-numeric">
									<input type="submit"/>
								</td>
							</tr>
						</tbody>
					</table>
				</form>
			</div>
			<div class="mdl-cell mdl-cell--6-col" style="text-align: left;">
<?php if (isset($_POST['name'])): ?>
	<?php
	$gender = !empty($_POST['gender']) ? $_POST['gender'] : morphos\Russian\detectGender($_POST['name']);
	$cases = morphos\Russian\name($_POST['name'], null, $gender);
	?>
				<table class="mdl-data-table mdl-js-data-table mdl-shadow--2dp">
					<tbody>
						<tr>
							<td class="mdl-data-table__cell--non-numeric" colspan="2" style="text-align: center;"><?=$_POST['name']?> (<?=$gender?>)</td>
						</tr>
						<?php foreach(array(Cases::IMENIT => 'Именительный', Cases::RODIT => 'Родительный', Cases::DAT => 'Дательный', Cases::VINIT => 'Винительный', Cases::TVORIT => 'Творительный', Cases::PREDLOJ => 'Предложный') as $case => $name): ?>
							<tr>
								<td class="mdl-data-table__cell--non-numeric"><?=$name?></td>
								<td class="mdl-data-table__cell--non-numeric"><?=$cases[$case]?></td>
							</tr>
						<?php endforeach; ?>
					</tbody>
				</table>
<?php endif; ?>
			</div>
		</div>
	</div>
</body>
</html>