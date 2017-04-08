<?php
namespace morphos;

abstract class NumeralCreation implements Cases, Gender {
    abstract static public function getCases($number);
    abstract static public function getCase($number, $case);
}
