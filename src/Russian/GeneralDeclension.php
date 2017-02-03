<?php
namespace morphos\Russian;

/**
 * Rules are from http://morpher.ru/Russian/Noun.aspx
 */
class GeneralDeclension extends \morphos\GeneralDeclension implements Cases {
	use RussianLanguage;

	const FIRST_DECLENSION = 1;
	const SECOND_DECLENSION = 2;
	const THIRD_DECLENSION = 3;

	const FIRST_SCHOOL_DECLENSION = 2;
	const SECOND_SCHOOL_DECLENSION = 1;
	const THIRD_SCHOOL_DECLENSION = 3;

	protected $abnormalExceptions = array(
		'бремя',
		'вымя',
		'темя',
		'пламя',
		'стремя',
		'пламя',
		'время',
		'знамя',
		'имя',
		'племя',
		'семя',
	);

	static protected $masculineWithSoft = array(
		'камень',
		'олень',
		'конь',
		'ячмень',
		'путь',
		'парень',
		'зверь',
		'шкворень',
		'пень',
		'пельмень',
		'тюлень',
		'выхухоль',
		'табель',
		'рояль',
		'шампунь',
		'конь',
		'лось',
		'гвоздь',
		'медведь',
		'день',
	);

	public function hasForms($word, $animateness = false) {
		$word = lower($word);
		if (in_array(slice($word, -1), array('у', 'и', 'е', 'о', 'ю')))
			return false;
		return true;
	}

	static public function getDeclension($word) {
		$word = lower($word);
		$last = slice($word, -1);
		if (self::isConsonant($last) || in_array($last, ['о', 'е', 'ё']) || ($last == 'ь' && self::isConsonant(slice($word, -2, -1)) && !RussianLanguage::isHissingConsonant(slice($word, -2, -1)) && in_array($word, self::$masculineWithSoft))) {
			return  1;
		} else if (in_array($last, ['а', 'я']) && slice($word, -2) != 'мя') {
			return 2;
		} else {
			return 3;
		}
	}

	public function getForms($word, $animateness = false) {
		$word = lower($word);

		if (isset($this->abnormalExceptions[$word])) {
			$prefix = slice($word, -1);
			return array(
				self::IMENIT => $word,
				self::RODIT => $prefix.'и',
				self::DAT => $prefix.'и',
				self::VINIT => $word,
				self::TVORIT => $prefix,
				self::PREDLOJ => $this->choosePrepositionByFirstLetter($prefix, 'об', 'о').' '.$prefix.'и',
			);
		}

		switch (self::getDeclension($word)) {
			case self::FIRST_DECLENSION:
				return $this->declinateFirstDeclension($word, $animateness);
			case self::SECOND_DECLENSION:
				return $this->declinateSecondDeclension($word);
			case self::THIRD_DECLENSION:
				return $this->declinateThirdDeclension($word);
		}
	}

	public function declinateFirstDeclension($word, $animateness = false) {
		$word = lower($word);
		$last = slice($word, -1);
		$soft_last = $last == 'й' || (in_array($last, ['ь', 'е', 'ё', 'ю', 'я']) && self::isConsonant(slice($word, -2, -1)));
		$prefix = self::getPrefixOfFirstDeclension($word, $last);
		$forms =  array(
			Cases::IMENIT_1 => $word,
		);

		// RODIT_2
		$forms[Cases::RODIT_2] = $this->chooseVowelAfterConsonant($last, $soft_last, $prefix.'я', $prefix.'а');

		// DAT_3
		$forms[Cases::DAT_3] = $this->chooseVowelAfterConsonant($last, $soft_last, $prefix.'ю', $prefix.'у');

		// VINIT_4
		if (in_array($last, ['о', 'е', 'ё']))
			$forms[Cases::VINIT_4] = $word;
		else {
			$forms[Cases::VINIT_4] = self::getVinitCaseByAnimateness($forms, $animateness);
		}

		// TVORIT_5
		// if ($last == 'ь')
		// 	$forms[Cases::TVORIT_5] = $prefix.'ом';
		// else if ($last == 'й' || (self::isConsonant($last) && !RussianLanguage::isHissingConsonant($last)))
		// 	$forms[Cases::TVORIT_5] = $prefix.'ем';
		// else
		// 	$forms[Cases::TVORIT_5] = $prefix.'ом'; # http://morpher.ru/Russian/Spelling.aspx#sibilant
		if (RussianLanguage::isHissingConsonant($last) || $last == 'ц') {
			$forms[Cases::TVORIT_5] = $prefix.'ем';
		} else if (in_array($last, ['й'/*, 'ч', 'щ'*/]) || $soft_last) {
			$forms[Cases::TVORIT_5] = $prefix.'ем';
		} else {
			$forms[Cases::TVORIT_5] = $prefix.'ом';
		}

		// PREDLOJ_6
		$forms[Cases::PREDLOJ_6] = self::getPredCaseOf12Declensions($word, $last, $prefix);
		$forms[Cases::PREDLOJ_6] = $this->choosePrepositionByFirstLetter($forms[Cases::PREDLOJ_6], 'об', 'о').' '.$forms[Cases::PREDLOJ_6];

		return $forms;
	}

	public function declinateSecondDeclension($word) {
		$word = lower($word);
		$prefix = slice($word, 0, -1);
		$last = slice($word, -1);
		$soft_last = $this->checkLastConsonantSoftness($word);
		$forms =  array(
			Cases::IMENIT_1 => $word,
		);

		// RODIT_2
		$forms[Cases::RODIT_2] = $this->chooseVowelAfterConsonant($last, $soft_last || (in_array(slice($word, -2, -1), array('г', 'к', 'х'))), $prefix.'и', $prefix.'ы');

		// DAT_3
		$forms[Cases::DAT_3] = self::getPredCaseOf12Declensions($word, $last, $prefix);

		// VINIT_4
		$forms[Cases::VINIT_4] = $this->chooseVowelAfterConsonant($last, $soft_last && slice($word, -2, -1) != 'ч', $prefix.'ю', $prefix.'у');

		// TVORIT_5
		if ($last == 'ь')
			$forms[Cases::TVORIT_5] = $prefix.'ой';
		else {
			$forms[Cases::TVORIT_5] = $this->chooseVowelAfterConsonant($last, $soft_last, $prefix.'ей', $prefix.'ой');
		}

		// 	if ($last == 'й' || (self::isConsonant($last) && !RussianLanguage::isHissingConsonant($last)) || $this->checkLastConsonantSoftness($word))
		// 	$forms[Cases::TVORIT_5] = $prefix.'ей';
		// else
		// 	$forms[Cases::TVORIT_5] = $prefix.'ой'; # http://morpher.ru/Russian/Spelling.aspx#sibilant

		// PREDLOJ_6 the same as DAT_3
		$forms[Cases::PREDLOJ_6] = $this->choosePrepositionByFirstLetter($forms[Cases::DAT_3], 'об', 'о').' '.$forms[Cases::DAT_3];
		return $forms;
	}

	public function declinateThirdDeclension($word) {
		$word = lower($word);
		$prefix = slice($word, 0, -1);
		return array(
			Cases::IMENIT_1 => $word,
			Cases::RODIT_2 => $prefix.'и',
			Cases::DAT_3 => $prefix.'и',
			Cases::VINIT_4 => $word,
			Cases::TVORIT_5 => $prefix.'ью',
			Cases::PREDLOJ_6 => $this->choosePrepositionByFirstLetter($prefix, 'об', 'о').' '.$prefix.'и',
		);
	}

	public function getForm($word, $form, $animateness = false) {
		$forms = $this->getForms($word, $animateness);
		return $forms[$form];
	}

	static public function getPrefixOfFirstDeclension($word, $last) {
		if ($word == 'день')
			$prefix = 'дн';
		else if (in_array($last, ['о', 'е', 'ё', 'ь', 'й']))
			$prefix = slice($word, 0, -1);
		else
			$prefix = $word;
		return $prefix;
	}

	static public function getVinitCaseByAnimateness(array $forms, $animate) {
		if ($animate)
			return $forms[Cases::RODIT_2];
		else
			return $forms[Cases::IMENIT_1];
	}

	static public function getPredCaseOf12Declensions($word, $last, $prefix) {
		if (slice($word, -2) == 'ий') {
			if ($last == 'ё')
				return $prefix.'е';
			else
				return $prefix.'и';
		} else {
			return $prefix.'е';
		}
	}
}
