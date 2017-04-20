<?php
namespace morphos;

abstract class GeneralDeclension implements Cases {
	static public function isMutable($name) {}
	static public function getCases($name) {}
	static public function getCase($name, $case) {}
}
