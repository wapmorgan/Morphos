<?php
namespace morphos;

abstract class GeneralDeclension implements Cases {
	abstract static public function isMutable($name);
	abstract static public function getCases($name);
	abstract static public function getCase($name, $case);
}
