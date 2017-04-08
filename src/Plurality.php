<?php
namespace morphos;

abstract class Plurality {
    static public function pluralize($word, $count = 2) {}
    static public function getCase($word, $case, $animateness = false) {}
    static public function getCases($word, $animateness = false) {}
}
