<?php
namespace morphos;

abstract class NumeralCreation implements Cases, Gender {
    static public function getCases($number) {}
    static public function getCase($number, $case) {}
}
