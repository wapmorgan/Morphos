--TEST--
test for russian declension. Part: getForm() method.
--FILE--
<?php
require dirname(__FILE__).'/../vendor/autoload.php';
$dec = new morphos\RussianDeclension();
var_dump($dec->getForm('Сергей', morphos\RussianDeclension::DAT_3, morphos\RussianDeclension::MAN));
?>
--EXPECT--
string(12) "Сергею"
