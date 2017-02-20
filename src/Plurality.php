<?php
namespace morphos;

abstract class Plurality {
    static public function pluralize($word, $count) {}
    public function getCase($word, $case, $animateness = false) {}
    public function getCases($word, $animateness = false) {}
}
