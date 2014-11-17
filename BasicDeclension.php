<?php
namespace morphos;

abstract class BasicDeclension implements BasicDeclensions {
	abstract public function hasForms($name, $animate = false);
	abstract public function getForms($name, $animate = false);
	abstract public function getForm($name, $animate = false, $form);
}
