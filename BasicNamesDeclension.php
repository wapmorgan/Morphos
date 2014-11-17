<?php
namespace morphos;

class BasicNamesDeclension implements Cases {
	const MAN = 'm';
	const WOMAN = 'w';

	public function hasForms($name, $gender) {}
	public function getForms($name, $gender) {}
	public function getForm($name, $form, $gender) {}
}
