<?php
namespace morphos;

abstract class NamesDeclension implements Cases, Gender {
	static public function isMutable($name, $gender) {}
	static public function getCases($name, $gender) {}
	static public function getCase($name, $case, $gender) {}
}
