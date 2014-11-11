--TEST--
test for russian declension. Part: hasForms() method.
--FILE--
<?php
require dirname(__FILE__).'/../vendor/autoload.php';
$dec = new morphos\RussianDeclension();
echo 'Russian names'."\n";
var_dump($dec->hasForms('Иван', morphos\RussianDeclension::MAN));
var_dump($dec->hasForms('Игорь', morphos\RussianDeclension::MAN));
var_dump($dec->hasForms('Андрей', morphos\RussianDeclension::MAN));
var_dump($dec->hasForms('Фома', morphos\RussianDeclension::MAN));
var_dump($dec->hasForms('Никита', morphos\RussianDeclension::MAN));
var_dump($dec->hasForms('Илья', morphos\RussianDeclension::MAN));
var_dump($dec->hasForms('Анна', morphos\RussianDeclension::WOMAN));
var_dump($dec->hasForms('Наталья', morphos\RussianDeclension::WOMAN));
var_dump($dec->hasForms('Виринея', morphos\RussianDeclension::WOMAN));

// foreign names
echo 'Foreign names'."\n";
var_dump($dec->hasForms('Айдын', morphos\RussianDeclension::MAN));
var_dump($dec->hasForms('Наиль', morphos\RussianDeclension::MAN));
var_dump($dec->hasForms('Тукай', morphos\RussianDeclension::MAN));
var_dump($dec->hasForms('Мустафа', morphos\RussianDeclension::MAN));
var_dump($dec->hasForms('Нафиса', morphos\RussianDeclension::WOMAN));
var_dump($dec->hasForms('Асия', morphos\RussianDeclension::WOMAN));
var_dump($dec->hasForms('Лючия', morphos\RussianDeclension::WOMAN));
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
