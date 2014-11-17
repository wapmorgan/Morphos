--TEST--
test for russian pluralization.
--FILE--
<?php
require dirname(__FILE__).'/../vendor/autoload.php';
$plu = new morphos\RussianPLurality();
for ($i = 1; $i <= 20; $i++)
	echo $plu->pluralize('дом', $i)."\n";
?>
--EXPECT--
дом
дома
дома
дома
домов
домов
домов
домов
домов
домов
домов
домов
домов
домов
домов
домов
домов
домов
домов
домов
