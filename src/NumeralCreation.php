<?php
namespace morphos;

class NumeralCreation implements Cases {
    const MALE = 'm';
    const FEMALE = 'f';
    const NEUTER = 'n';

    public function getCases($number) {}
    public function getCase($number, $case) {}
    static public function generate($number) {}
}
