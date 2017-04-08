<?php
namespace morphos;

abstract class NamesDeclension implements Cases, Gender {
	abstract static public function isMutable($name, $gender);
	abstract static public function getCases($name, $gender);
	abstract static public function getCase($name, $case, $gender);
}
