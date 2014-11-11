<?php
namespace morphos;

abstract class BasicDeclension {
	const MAN = 'm';
	const WOMAN = 'w';
	const NOMINATIVE = 'nominativus';
	const GENETIVE = 'genetivus';
	const DATIVE = 'dativus';
	const ACCUSATIVE = 'accusative';
	const ABLATIVE = 'ablativus';
	const PREPOSITIONAL = 'praepositionalis';

	abstract public function hasForms($name, $gender);
	abstract public function getForms($name, $gender);
	abstract public function getForm($name, $form, $gender);
}
