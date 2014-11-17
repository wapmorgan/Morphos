<?php
namespace morphos;

trait Russian {
	static public $vowels = array(
		'А',
		'Е',
		'Ё',
		'И',
		'О',
		'У',
		'Ы',
		'Э',
		'Ю',
		'Я',
	);

	static public $consonants = array(
		'Б',
		'В',
		'Г',
		'Д',
		'Ж',
		'З',
		'Й',
		'К',
		'Л',
		'М',
		'Н',
		'П',
		'Р',
		'С',
		'Т',
		'Ф',
		'Х',
		'Ц',
		'Ч',
		'Ш',
		'Щ',
	);

	static public $pairs = array(
		'Б' => 'П',
		'В' => 'Ф',
		'Г' => 'К',
		'Д' => 'Т',
		'Ж' => 'Ш',
		'З' => 'С',
	);

	private function isHissingConsonant($consonant) {
		return in_array(lower($consonant), array('ж', 'ш', 'ч', 'щ'));
	}

	private function isVelarConsonant($consonant) {
		return in_array(lower($consonant), array('г', 'к', 'х'));
	}

	private function isConsonant($consonant) {
		return in_array(upper($consonant), self::$consonants);
	}

	private function countSyllables($string) {
		return count_chars($string, array_map('lower', self::$vowels));
	}

	public function isPaired($consonant) {
		$consonant = lower($consonant);
		return array_key_exists($consonant, self::$pairs) || (array_search($consonant, self::$pairs) !== false);
	}
}
