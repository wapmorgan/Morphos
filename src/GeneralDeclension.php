<?php
namespace morphos;

abstract class GeneralDeclension implements Cases {
	abstract public function hasForms($name, $animate = false);
	abstract public function getForms($name, $animate = false);
	abstract public function getForm($name, $animate = false, $form);
}
