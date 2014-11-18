<?php
include 'vendor/autoload.php';
$dec = new morphos\RussianNamesDeclension();
var_dump($dec->getForms('Иван', morphos\RussianNamesDeclension::MAN));
