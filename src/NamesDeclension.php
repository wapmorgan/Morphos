<?php
namespace morphos;

class NamesDeclension implements Cases {
	const MAN = 'm';
	const WOMAN = 'w';

	public function isMutable($name, $gender) {}
	public function getCases($name, $gender) {}
	public function getCase($name, $case, $gender) {}
}
