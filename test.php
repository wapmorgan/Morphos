<?php
include 'vendor/autoload.php';
$dec = new morphos\RussianDeclension();
var_dump($dec->getForms('макасины', morphos\RussianDeclension::MAN));
