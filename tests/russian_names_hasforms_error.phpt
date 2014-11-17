--TEST--
test for errors in russian names declension. Part: hasForms() method. Errors.
--FILE--
<?php
require dirname(__FILE__).'/../vendor/autoload.php';
$dec = new morphos\RussianNamesDeclension();
// foreign names that don't have forms
echo 'Foreign names w/o forms'."\n";
var_dump($dec->hasForms('Тореро', morphos\RussianNamesDeclension::WOMAN));
var_dump($dec->hasForms('Айбу', morphos\RussianNamesDeclension::WOMAN));
var_dump($dec->hasForms('Хосе', morphos\RussianNamesDeclension::WOMAN));
var_dump($dec->hasForms('Каншау', morphos\RussianNamesDeclension::WOMAN));
var_dump($dec->hasForms('Франсуа', morphos\RussianNamesDeclension::WOMAN));
var_dump($dec->hasForms('Тойбухаа', morphos\RussianNamesDeclension::WOMAN));
var_dump($dec->hasForms('Качаа', morphos\RussianNamesDeclension::WOMAN));
var_dump($dec->hasForms('Зиа', morphos\RussianNamesDeclension::WOMAN));
var_dump($dec->hasForms('Хожулаа', morphos\RussianNamesDeclension::WOMAN));
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
