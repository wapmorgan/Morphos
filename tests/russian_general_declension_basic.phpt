--TEST--
test for russian general declension.
--FILE--
<?php
require dirname(__FILE__).'/../vendor/autoload.php';
// var_dump(class_uses('morphos\\RussianPlurality'));
$dec = new morphos\RussianGeneralDeclension();
var_dump($dec->getDeclension('дом'));
var_dump(implode(', ', $dec->getForms('дом')));
var_dump(implode(', ', $dec->pluralizeAllDeclensions('дом')));
echo "\n";
var_dump($dec->getDeclension('поле'));
var_dump(implode(', ', $dec->getForms('поле')));
var_dump(implode(', ', $dec->pluralizeAllDeclensions('поле')));
echo "\n";
var_dump($dec->getDeclension('гвоздь'));
var_dump(implode(', ', $dec->getForms('гвоздь')));
var_dump(implode(', ', $dec->pluralizeAllDeclensions('гвоздь')));
echo "\n";
var_dump($dec->getDeclension('гений'));
var_dump(implode(', ', $dec->getForms('гений', true)));
var_dump(implode(', ', $dec->pluralizeAllDeclensions('гений', true)));
?>
--EXPECT--
int(1)
string(56) "дом, дома, дому, дом, домом, доме"
string(68) "дома, домов, домам, дома, домами, домах"

int(1)
string(60) "поле, поля, полю, поле, полем, поле"
string(68) "поля, полей, полям, поля, полями, полях"

int(1)
string(84) "гвоздь, гвоздя, гвоздю, гвоздь, гвоздем, гвозде"
string(92) "гвоздя, гвоздей, гвоздям, гвоздя, гвоздями, гвоздях"

int(1)
string(72) "гений, гения, гению, гения, гением, гении"
string(82) "гения, гениев, гениям, гениев, гениями, гениях"
