--TEST--
test for russian names declension. Part: getForm() method.
--FILE--
<?php
require dirname(__FILE__).'/../vendor/autoload.php';
$dec = new morphos\RussianNamesDeclension();
var_dump($dec->getForm('Сергей', morphos\RussianDeclensions::DAT_3, morphos\RussianNamesDeclension::MAN));
?>
--EXPECT--
string(12) "Сергею"
