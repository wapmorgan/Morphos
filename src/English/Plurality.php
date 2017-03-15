<?php
namespace morphos\English;

use morphos\S;

class Plurality extends \morphos\Plurality {

	static private $exceptions = array(
		'chief' => 'chiefs',
		'basis' => 'bases',
		'crisis' => 'crises',
		'radius' => 'radii',
		'nucleus' => 'nuclei',
		'curriculum' => 'curricula',
		'man' => 'men',
		'woman' => 'women',
		'child' => 'children',
		'foot' => 'feet',
		'tooth' => 'teeth',
		'ox' => 'oxen',
		'goose' => 'geese',
		'mouse' => 'mice'
	);

	static private $without_paired_form = array(
		'knowledge',
		'progress',
		'advise',
		'ink',
		'money',
		'scissors',
		'spectacles',
		'trousers',
	);

	static public $consonants = array('b', 'c', 'd', 'f', 'g', 'h', 'j', 'k', 'l', 'm', 'n', 'p', 'q', 'r', 's', 't', 'v', 'x', 'z', 'w');

	static public function pluralize($word, $count = 2) {
		if ($count == 1)
			return $word;

		$word = S::lower($word);
		if (in_array($word, self::$without_paired_form))
			return $word;
		else if (isset(self::$exceptions[$word]))
			return self::$exceptions[$word];

		if (in_array(S::slice($word, -1), array('s', 'x')) || in_array(S::slice($word, -2), array('sh', 'ch'))) {
			return $word.'es';
		} else if (S::slice($word, -1) == 'o') {
			return $word.'es';
		} else if (S::slice($word, -1) == 'y' && in_array(S::slice($word, -2, -1), self::$consonants)) {
			return S::slice($word, 0, -1).'ies';
		} else if (S::slice($word, -2) == 'fe' || S::slice($word, -1) == 'f') {
			if (S::slice($word, -1) == 'f') {
				return S::slice($word, 0, -1).'ves';
			} else {
				return S::slice($word, 0, -2).'ves';
			}
		} else {
			return $word.'s';
		}
	}
}
