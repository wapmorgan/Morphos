--TEST--
test for russian pluralization. morphos\pluralize() method.
--FILE--
<?php
require dirname(__FILE__).'/../vendor/autoload.php';
for ($i = 1; $i <= 20; $i++)
	echo morphos\pluralize('дом', false, $i)."\n";
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
