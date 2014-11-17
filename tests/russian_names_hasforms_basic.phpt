--TEST--
test for russian names declension. Part: hasForms() method.
--FILE--
<?php
require dirname(__FILE__).'/../vendor/autoload.php';
$dec = new morphos\RussianNamesDeclension();
echo 'Russian names'."\n";
var_dump($dec->hasForms('Иван', morphos\RussianNamesDeclension::MAN));
var_dump($dec->hasForms('Игорь', morphos\RussianNamesDeclension::MAN));
var_dump($dec->hasForms('Андрей', morphos\RussianNamesDeclension::MAN));
var_dump($dec->hasForms('Фома', morphos\RussianNamesDeclension::MAN));
var_dump($dec->hasForms('Никита', morphos\RussianNamesDeclension::MAN));
var_dump($dec->hasForms('Илья', morphos\RussianNamesDeclension::MAN));
var_dump($dec->hasForms('Анна', morphos\RussianNamesDeclension::WOMAN));
var_dump($dec->hasForms('Наталья', morphos\RussianNamesDeclension::WOMAN));
var_dump($dec->hasForms('Виринея', morphos\RussianNamesDeclension::WOMAN));

// foreign names
echo 'Foreign names'."\n";
var_dump($dec->hasForms('Айдын', morphos\RussianNamesDeclension::MAN));
var_dump($dec->hasForms('Наиль', morphos\RussianNamesDeclension::MAN));
var_dump($dec->hasForms('Тукай', morphos\RussianNamesDeclension::MAN));
var_dump($dec->hasForms('Мустафа', morphos\RussianNamesDeclension::MAN));
var_dump($dec->hasForms('Нафиса', morphos\RussianNamesDeclension::WOMAN));
var_dump($dec->hasForms('Асия', morphos\RussianNamesDeclension::WOMAN));
var_dump($dec->hasForms('Лючия', morphos\RussianNamesDeclension::WOMAN));
?>
--EXPECT--
Russian names
bool(true)
bool(true)
bool(true)
bool(true)
bool(true)
bool(true)
bool(true)
bool(true)
bool(true)
Foreign names
bool(true)
bool(true)
bool(true)
bool(true)
bool(true)
bool(true)
bool(true)
