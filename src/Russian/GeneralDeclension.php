<?php
namespace morphos\Russian;

use morphos\S;

/**
 * Rules are from http://morpher.ru/Russian/Noun.aspx
 */
class GeneralDeclension extends \morphos\GeneralDeclension implements Cases {
	use RussianLanguage, CasesHelper;

	const FIRST_DECLENSION = 1;
	const SECOND_DECLENSION = 2;
	const THIRD_DECLENSION = 3;

	static protected $abnormalExceptions = array(
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
		'рубль',
	);

	static protected $immutableWords = array(
		'евро',
		'пенни',
	);

	static public function isMutable($word, $animateness = false) {
		$word = S::lower($word);
		if (in_array(S::slice($word, -1), array('у', 'и', 'е', 'о', 'ю')) || in_array($word, self::$immutableWords))
			return false;
		return true;
	}

	static public function getDeclension($word) {
		$word = S::lower($word);
		$last = S::slice($word, -1);
		if (in_array($last, ['а', 'я']) && S::slice($word, -2) != 'мя') {
			return 1;
		} else if (self::isConsonant($last) || in_array($last, ['о', 'е', 'ё']) || ($last == 'ь' && self::isConsonant(S::slice($word, -2, -1)) && !RussianLanguage::isHissingConsonant(S::slice($word, -2, -1)) && in_array($word, self::$masculineWithSoft))) {
			return 2;
		} else {
			return 3;
		}
	}

	static public function getCases($word, $animateness = false) {
		$word = S::lower($word);

		if (in_array($word, self::$immutableWords)) {
			return array(
				self::IMENIT => $word,
				self::RODIT => $word,
				self::DAT => $word,
				self::VINIT => $word,
				self::TVORIT => $word,
				self::PREDLOJ => self::choosePrepositionByFirstLetter($word, 'об', 'о').' '.$word,
			);
		} else if (isset(self::$abnormalExceptions[$word])) {
			$prefix = S::slice($word, -1);
			return array(
				self::IMENIT => $word,
				self::RODIT => $prefix.'и',
				self::DAT => $prefix.'и',
				self::VINIT => $word,
				self::TVORIT => $prefix,
				self::PREDLOJ => self::choosePrepositionByFirstLetter($prefix, 'об', 'о').' '.$prefix.'и',
			);
		}

		switch (self::getDeclension($word)) {
			case self::FIRST_DECLENSION:
				return self::declinateFirstDeclension($word);
			case self::SECOND_DECLENSION:
				return self::declinateSecondDeclension($word, $animateness);
			case self::THIRD_DECLENSION:
				return self::declinateThirdDeclension($word);
		}
	}

	static public function declinateFirstDeclension($word) {
		$word = S::lower($word);
		$prefix = S::slice($word, 0, -1);
		$last = S::slice($word, -1);
		$soft_last = self::checkLastConsonantSoftness($word);
		$forms =  array(
			Cases::IMENIT => $word,
		);

		// RODIT
		$forms[Cases::RODIT] = self::chooseVowelAfterConsonant($last, $soft_last || (in_array(S::slice($word, -2, -1), array('г', 'к', 'х'))), $prefix.'и', $prefix.'ы');

		// DAT
		$forms[Cases::DAT] = self::getPredCaseOf12Declensions($word, $last, $prefix);

		// VINIT
		$forms[Cases::VINIT] = self::chooseVowelAfterConsonant($last, $soft_last && S::slice($word, -2, -1) != 'ч', $prefix.'ю', $prefix.'у');

		// TVORIT
		if ($last == 'ь')
			$forms[Cases::TVORIT] = $prefix.'ой';
		else {
			$forms[Cases::TVORIT] = self::chooseVowelAfterConsonant($last, $soft_last, $prefix.'ей', $prefix.'ой');
		}

		// 	if ($last == 'й' || (self::isConsonant($last) && !RussianLanguage::isHissingConsonant($last)) || self::checkLastConsonantSoftness($word))
		// 	$forms[Cases::TVORIT] = $prefix.'ей';
		// else
		// 	$forms[Cases::TVORIT] = $prefix.'ой'; # http://morpher.ru/Russian/Spelling.aspx#sibilant

		// PREDLOJ the same as DAT
		$forms[Cases::PREDLOJ] = self::choosePrepositionByFirstLetter($forms[Cases::DAT], 'об', 'о').' '.$forms[Cases::DAT];
		return $forms;
	}

	static public function declinateSecondDeclension($word, $animateness = false) {
		$word = S::lower($word);
		$last = S::slice($word, -1);
		$soft_last = $last == 'й' || (in_array($last, ['ь', 'е', 'ё', 'ю', 'я']) && (self::isConsonant(S::slice($word, -2, -1)) || S::slice($word, -2, -1) == 'и'));
		$prefix = self::getPrefixOfFirstDeclension($word, $last);
		$forms =  array(
			Cases::IMENIT => $word,
		);

		// RODIT
		$forms[Cases::RODIT] = self::chooseVowelAfterConsonant($last, $soft_last, $prefix.'я', $prefix.'а');

		// DAT
		$forms[Cases::DAT] = self::chooseVowelAfterConsonant($last, $soft_last, $prefix.'ю', $prefix.'у');

		// VINIT
		if (in_array($last, ['о', 'е', 'ё']))
			$forms[Cases::VINIT] = $word;
		else {
			$forms[Cases::VINIT] = self::getVinitCaseByAnimateness($forms, $animateness);
		}

		// TVORIT
		// if ($last == 'ь')
		// 	$forms[Cases::TVORIT] = $prefix.'ом';
		// else if ($last == 'й' || (self::isConsonant($last) && !RussianLanguage::isHissingConsonant($last)))
		// 	$forms[Cases::TVORIT] = $prefix.'ем';
		// else
		// 	$forms[Cases::TVORIT] = $prefix.'ом'; # http://morpher.ru/Russian/Spelling.aspx#sibilant
		if (RussianLanguage::isHissingConsonant($last) || $last == 'ц') {
			$forms[Cases::TVORIT] = $prefix.'ем';
		} else if (in_array($last, ['й'/*, 'ч', 'щ'*/]) || $soft_last) {
			$forms[Cases::TVORIT] = $prefix.'ем';
		} else {
			$forms[Cases::TVORIT] = $prefix.'ом';
		}

		// PREDLOJ
		$forms[Cases::PREDLOJ] = self::getPredCaseOf12Declensions($word, $last, $prefix);
		$forms[Cases::PREDLOJ] = self::choosePrepositionByFirstLetter($forms[Cases::PREDLOJ], 'об', 'о').' '.$forms[Cases::PREDLOJ];

		return $forms;
	}

	static public function declinateThirdDeclension($word) {
		$word = S::lower($word);
		$prefix = S::slice($word, 0, -1);
		return array(
			Cases::IMENIT => $word,
			Cases::RODIT => $prefix.'и',
			Cases::DAT => $prefix.'и',
			Cases::VINIT => $word,
			Cases::TVORIT => $prefix.'ью',
			Cases::PREDLOJ => self::choosePrepositionByFirstLetter($prefix, 'об', 'о').' '.$prefix.'и',
		);
	}

	static public function getCase($word, $case, $animateness = false) {
		$case = self::canonizeCase($case);
		$forms = self::getCases($word, $animateness);
		return $forms[$case];
	}

	static public function getPrefixOfFirstDeclension($word, $last) {
		if ($word == 'день')
			$prefix = 'дн';
		else if (in_array($last, ['о', 'е', 'ё', 'ь', 'й']))
			$prefix = S::slice($word, 0, -1);
		else
			$prefix = $word;
		return $prefix;
	}

	static public function getVinitCaseByAnimateness(array $forms, $animate) {
		if ($animate)
			return $forms[Cases::RODIT];
		else
			return $forms[Cases::IMENIT];
	}

	static public function getPredCaseOf12Declensions($word, $last, $prefix) {
		if (S::slice($word, -2) == 'ий') {
			if ($last == 'ё')
				return $prefix.'е';
			else
				return $prefix.'и';
		} else {
			return $prefix.'е';
		}
	}
}
