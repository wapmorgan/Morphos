--TEST--
test for errors in russian declension. Part: hasForms() method. Errors.
--FILE--
<?php
require dirname(__FILE__).'/../vendor/autoload.php';
$dec = new morphos\RussianDeclension();
// foreign names that don't have forms
echo 'Foreign names w/o forms'."\n";
var_dump($dec->hasForms('Тореро', morphos\RussianDeclension::WOMAN));
var_dump($dec->hasForms('Айбу', morphos\RussianDeclension::WOMAN));
var_dump($dec->hasForms('Хосе', morphos\RussianDeclension::WOMAN));
var_dump($dec->hasForms('Каншау', morphos\RussianDeclension::WOMAN));
var_dump($dec->hasForms('Франсуа', morphos\RussianDeclension::WOMAN));
var_dump($dec->hasForms('Тойбухаа', morphos\RussianDeclension::WOMAN));
var_dump($dec->hasForms('Качаа', morphos\RussianDeclension::WOMAN));
var_dump($dec->hasForms('Зиа', morphos\RussianDeclension::WOMAN));
var_dump($dec->hasForms('Хожулаа', morphos\RussianDeclension::WOMAN));
?>
--EXPECT--
Foreign names w/o forms
bool(false)
bool(false)
bool(false)
bool(false)
bool(false)
bool(false)
bool(false)
bool(false)
bool(false)
