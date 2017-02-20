<?php
namespace morphos;

abstract class GeneralDeclension implements Cases {
	abstract public function isMutable($name, $animate = false);
	abstract public function getCases($name, $animate = false);
	abstract public function getCase($name, $animate = false, $case);
}
