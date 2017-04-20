<?php
require dirname(dirname(__FILE__)).'/vendor/autoload.php';
use morphos\Russian\CardinalNumeral;
use morphos\Russian\Cases;
use morphos\Russian\GeneralDeclension;
use morphos\Russian\GeographicalNamesDeclension;
use morphos\Russian\Plurality;
use morphos\Russian\OrdinalNumeral;

?><html>
<head>
	<link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">
	<link rel="stylesheet" href="https://code.getmdl.io/1.3.0/material.indigo-pink.min.css">
	<script defer src="https://code.getmdl.io/1.3.0/material.min.js"></script>
	<title>Morphos Testing Script</title>
	<style>
	.demo-layout-transparent {
	}
	.demo-layout-transparent .mdl-layout__header,
	.demo-layout-transparent .mdl-layout__drawer-button {
	  /* This background is dark, so we set text to white. Use 87% black instead if
	     your background is light. */
	  color: white;
	  background-color: #0B5A78;
	}
	</style>
</head>
<body>
	<div class="demo-layout-transparent mdl-layout mdl-js-layout">
		<header class="mdl-layout__header mdl-layout__header--transparent">
			<div class="mdl-layout__header-row">
				<!-- Title -->
				<span class="mdl-layout-title">Morphos Testing Script</span>
				<!-- Add spacer, to align navigation to the right -->
				<div class="mdl-layout-spacer"></div>
				<!-- Navigation -->
				<!-- <nav class="mdl-navigation">
					<a class="mdl-navigation__link" href="">Link</a>
					<a class="mdl-navigation__link" href="">Link</a>
					<a class="mdl-navigation__link" href="">Link</a>
					<a class="mdl-navigation__link" href="">Link</a>
				</nav> -->
			</div>
		</header>
		<div class="mdl-layout__drawer">
			<span class="mdl-layout-title">Useful links</span>
				<nav class="mdl-navigation">
				<a class="mdl-navigation__link" href="https://github.com/wapmorgan/Morphos">GitHub</a>
				<a class="mdl-navigation__link" href="https://packagist.org/packages/wapmorgan/morphos">Packagist</a>
				<a class="mdl-navigation__link" href="https://github.com/wapmorgan/Morphos-Blade">Blade adapter</a>
				<a class="mdl-navigation__link" href="https://github.com/wapmorgan/Morphos-Twig">Twig adapter</a>
			</nav>
		</div>
		<main class="mdl-layout__content">

			<div class="mdl-tabs mdl-js-tabs mdl-js-ripple-effect">
				<div class="mdl-tabs__tab-bar">
			      <a href="#personal-names" class="mdl-tabs__tab is-active">Склонение имен собственных</a>
			      <a href="#geographical-names" class="mdl-tabs__tab">Склонение географических названий</a>
			      <a href="#nouns" class="mdl-tabs__tab">Склонение существительных</a>
			      <a href="#numerals" class="mdl-tabs__tab">Генерация числительных</a>
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
											<td class="mdl-data-table__cell--non-numeric"><input type="submit" value="Просклонять"/> <input name="count" type="submit" value="Посчитать до 100"/></td>
										</tr>
									</tbody>
								</table>
							</form>
						</div>
						<div class="mdl-cell mdl-cell--6-col" style="text-align: left;">
<?php if (isset($_POST['noun'])): ?>
	<?php
	$animate = !empty($_POST['animate']);
	?>
	<?php if (!isset($_POST['count'])): ?>
	<?php
	$cases = GeneralDeclension::getCases($_POST['noun'], $animate);
	?>
		<table>
			<tr>
				<td>
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
				</td>
				<td>
	<?php
	$cases = Plurality::getCases($_POST['noun'], $animate);
	?>
						<table class="mdl-data-table mdl-js-data-table mdl-shadow--2dp">
							<tbody>
								<tr>
									<td class="mdl-data-table__cell--non-numeric" colspan="2" style="text-align: center;"><?=$_POST['noun']?> (<?=GeneralDeclension::getDeclension($_POST['noun'])?> склонение) во множественном числе</td>
								</tr>
								<?php foreach(array(Cases::IMENIT => 'Именительный', Cases::RODIT => 'Родительный', Cases::DAT => 'Дательный', Cases::VINIT => 'Винительный', Cases::TVORIT => 'Творительный', Cases::PREDLOJ => 'Предложный') as $case => $name): ?>
									<tr>
										<td class="mdl-data-table__cell--non-numeric"><?=$name?></td>
										<td class="mdl-data-table__cell--non-numeric"><?=$cases[$case]?></td>
									</tr>
								<?php endforeach; ?>
							</tbody>
						</table>
				</td>
			</tr>
		</table>
			<?php else: ?>
				<table class="mdl-data-table mdl-js-data-table mdl-shadow--2dp">
					<tbody>
						<tr>
							<td class="mdl-data-table__cell--non-numeric" colspan="2" style="text-align: center;"><?=$_POST['noun']?> (<?=GeneralDeclension::getDeclension($_POST['noun'])?> склонение)</td>
						</tr>
						<?php for ($i = 1; $i <= 20; $i++): ?>
							<tr>
								<td class="mdl-data-table__cell--non-numeric"><?=$i.' '.PLurality::pluralize($_POST['noun'], $i, $animate)?></td>
								<td class="mdl-data-table__cell--non-numeric"><?=($i+20).' '.PLurality::pluralize($_POST['noun'], $i + 20, $animate)?></td>
								<td class="mdl-data-table__cell--non-numeric"><?=($i+40).' '.PLurality::pluralize($_POST['noun'], $i + 40, $animate)?></td>
								<td class="mdl-data-table__cell--non-numeric"><?=($i+60).' '.PLurality::pluralize($_POST['noun'], $i + 60, $animate)?></td>
								<td class="mdl-data-table__cell--non-numeric"><?=($i+80).' '.PLurality::pluralize($_POST['noun'], $i + 80, $animate)?></td>
							</tr>
						<?php endfor; ?>
					</tbody>
				</table>
			<?php endif; ?>
		<?php endif; ?>
						</div>
					</div>
				</form>
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
											<input type="submit" value="Просклонять"/>
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
											<input type="submit" value="Просклонять"/>
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

			<div class="mdl-tabs__panel" id="numerals">
					<div class="mdl-grid">
						<div class="mdl-cell mdl-cell--6-col" style="text-align: right;">
							<form method="post" action="#numerals">
								<table class="mdl-data-table mdl-js-data-table mdl-shadow--2dp" style="margin: 0 0 0 auto;">
									<tbody>
										<tr>
											<td class="mdl-data-table__cell--non-numeric">Введите число: <input name="number" value="<?= isset($_POST['number']) ? $_POST['number'] : null ?>"></td>
										</tr>
										<tr>
											<td class="mdl-data-table__cell--non-numeric"><input type="submit" value="Сгенерировать количественные числительные"/></td>
										</tr>
										<tr>
											<td class="mdl-data-table__cell--non-numeric">
												Выберите пол связанного числительного:
												<label><input type="radio" name="gender" value="<?=morphos\Gender::NEUTER?>" <?= isset($_POST['gender']) && $_POST['gender'] == morphos\Gender::NEUTER ? "checked='checked'" : null ?> /> Средний </label>
												<label><input type="radio" name="gender" value="<?=morphos\Gender::MALE?>" <?= isset($_POST['gender']) && $_POST['gender'] == morphos\Gender::MALE ? "checked='checked'" : null ?> /> Мужской </label>
												<label><input type="radio" name="gender" value="<?=morphos\Gender::FEMALE?>" <?= isset($_POST['gender']) && $_POST['gender'] == morphos\Gender::FEMALE ? "checked='checked'" : null ?> /> Женский </label>
											</td>
										</tr>
										<tr>
											<td class="mdl-data-table__cell--non-numeric"><input type="submit" name="ordinal" value="Сгенерировать порядковые числительные"/></td>
										</tr>
									</tbody>
								</table>
							</form>
						</div>
						<div class="mdl-cell mdl-cell--6-col" style="text-align: left;">
<?php if (isset($_POST['number'])): ?>
	<?php
	$number = intval($_POST['number']);
	?>
	<?php
	if (!isset($_POST['ordinal'])):
	$cases = CardinalNumeral::getCases($number);
	?>
		<table>
			<tr>
				<td>
						<table class="mdl-data-table mdl-js-data-table mdl-shadow--2dp">
							<tbody>
								<tr>
									<td class="mdl-data-table__cell--non-numeric" colspan="2" style="text-align: center;"><?=$number?></td>
								</tr>
								<?php foreach(array(Cases::IMENIT => 'Именительный', Cases::RODIT => 'Родительный', Cases::DAT => 'Дательный', Cases::VINIT => 'Винительный', Cases::TVORIT => 'Творительный', Cases::PREDLOJ => 'Предложный') as $case => $name): ?>
									<tr>
										<td class="mdl-data-table__cell--non-numeric"><?=$name?></td>
										<td class="mdl-data-table__cell--non-numeric"><?=$cases[$case]?></td>
									</tr>
								<?php endforeach; ?>
							</tbody>
						</table>
				</td>
				<td>
	<?php
	else:
	$gender = isset($_POST['gender']) ? $_POST['gender'] : morphos\Gender::MALE;
	$cases = OrdinalNumeral::getCases($number, $gender);
	?>
						<table class="mdl-data-table mdl-js-data-table mdl-shadow--2dp">
							<tbody>
								<tr>
									<td class="mdl-data-table__cell--non-numeric" colspan="2" style="text-align: center;">П<?=$number?> (<?=$gender?>)</td>
								</tr>
								<?php foreach(array(Cases::IMENIT => 'Именительный', Cases::RODIT => 'Родительный', Cases::DAT => 'Дательный', Cases::VINIT => 'Винительный', Cases::TVORIT => 'Творительный', Cases::PREDLOJ => 'Предложный') as $case => $name): ?>
									<tr>
										<td class="mdl-data-table__cell--non-numeric"><?=$name?></td>
										<td class="mdl-data-table__cell--non-numeric"><?=$cases[$case]?></td>
									</tr>
								<?php endforeach; ?>
							</tbody>
						</table>
				</td>
			</tr>
		</table>
			<?php endif; ?>
		<?php endif; ?>
						</div>
					</div>
				</form>
			</div>

		</main>
	</div>
</body>
</html>