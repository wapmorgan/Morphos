<?php
namespace morphos\Russian;

use morphos\S;

/**
 * Rules are from http://morpher.ru/Russian/Noun.aspx
 */
class Plurality extends \morphos\Plurality implements Cases {
	use RussianLanguage, CasesHelper;

	const ONE = 1;
	const TWO_FOUR = 2;
	const FIVE_OTHER = 3;

	protected $neuterExceptions = array(
		'поле',
		'море',
	);

	static protected $immutableWords = array(
		'евро',
		'пенни',
	);

	static public function pluralize($word, $count = 2, $animateness = false) {
		static $dec, $plu;
		if ($dec === null) $dec = new GeneralDeclension();
		if ($plu === null) $plu = new self();

		switch (self::getNumeralForm($count)) {
			case self::ONE:
				return $word;
			case self::TWO_FOUR:
				return $dec->getCase($word, self::RODIT, $animateness);
			case self::FIVE_OTHER:
				$forms = $plu->getCases($word, $animateness);
				return $forms[self::RODIT];
		}
	}

	static public function getNumeralForm($count) {
		$ending = $count % 10;
		if (($count > 20 && $ending == 1) || $count == 1)
			return self::ONE;
		else if (($count > 20 && in_array($ending, range(2, 4))) || in_array($count, range(2, 4)))
			return self::TWO_FOUR;
		else
			return self::FIVE_OTHER;
	}

	public function getCase($word, $case, $animateness = false) {
		$case = self::canonizeCase($case);
		$forms = $this->getCases($word, $animateness);
		return $forms[$case];
	}

	public function getCases($word, $animateness = false) {
		$word = S::lower($word);
		$prefix = S::slice($word, 0, -1);
		$last = S::slice($word, -1);

		if (in_array($word, self::$immutableWords)) {
			return array(
				self::IMENIT => $word,
				self::RODIT => $word,
				self::DAT => $word,
				self::VINIT => $word,
				self::TVORIT => $word,
				self::PREDLOJ => $this->choosePrepositionByFirstLetter($word, 'об', 'о').' '.$word,
			);
		}

		if (($declension = GeneralDeclension::getDeclension($word)) == GeneralDeclension::SECOND_DECLENSION) {
			$soft_last = $last == 'й' || (in_array($last, ['ь', 'е', 'ё', 'ю', 'я']) && (self::isConsonant(S::slice($word, -2, -1)) || S::slice($word, -2, -1) == 'и'));
			$prefix = GeneralDeclension::getPrefixOfFirstDeclension($word, $last);
		} else if ($declension == GeneralDeclension::FIRST_DECLENSION) {
			$soft_last = $this->checkLastConsonantSoftness($word);
		} else {
			$soft_last = false;
		}

		$forms = array();

		if ($last == 'ч' || S::slice($word, -2) == 'чь' || ($this->isVowel($last) && in_array(S::slice($word, -2, -1), array('ч', 'к')))) // before ч, чь, ч+vowel, к+vowel
			$forms[Cases::IMENIT] = $prefix.'и';
		else if ($last == 'н')
			$forms[Cases::IMENIT] = $prefix.'ы';
		else
			$forms[Cases::IMENIT] = $this->chooseVowelAfterConsonant($last, $soft_last, $prefix.'я', $prefix.'а');


		// RODIT
		if (in_array($last, array('о', 'е'))) {
			// exceptions
			if (in_array($word, $this->neuterExceptions))
				$forms[Cases::RODIT] = $prefix.'ей';
			else if (S::slice($word, -2, -1) == 'и')
				$forms[Cases::RODIT] = $prefix.'й';
			else
				$forms[Cases::RODIT] = $prefix;
		}
		else if (S::slice($word, -2) == 'ка') { // words ending with -ка: чашка, вилка, ложка, тарелка, копейка, батарейка
			if (S::slice($word, -3, -2) == 'л') $forms[Cases::RODIT] = S::slice($word, 0, -2).'ок';
			else if (S::slice($word, -3, -2) == 'й') $forms[Cases::RODIT] = S::slice($word, 0, -3).'ек';
			else $forms[Cases::RODIT] = S::slice($word, 0, -2).'ек';
		}
		else if (in_array($last, array('а'))) // обида, ябеда
			$forms[Cases::RODIT] = $prefix;
		else if (in_array($last, array('я'))) // молния
			$forms[Cases::RODIT] = $prefix.'й';
		else if (RussianLanguage::isHissingConsonant($last) || ($soft_last && $last != 'й') || S::slice($word, -2) == 'чь')
			$forms[Cases::RODIT] = $prefix.'ей';
		else if ($last == 'й')
			$forms[Cases::RODIT] = $prefix.'ев';
		else // (self::isConsonant($last) && !RussianLanguage::isHissingConsonant($last))
			$forms[Cases::RODIT] = $prefix.'ов';

		// DAT
		$forms[Cases::DAT] = $this->chooseVowelAfterConsonant($last, $soft_last && S::slice($word, -2, -1) != 'ч', $prefix.'ям', $prefix.'ам');

		// VINIT
		$forms[Cases::VINIT] = GeneralDeclension::getVinitCaseByAnimateness($forms, $animateness);

		// TVORIT
		// my personal rule
		if ($last == 'ь' && $declension == GeneralDeclension::THIRD_DECLENSION && S::slice($word, -2) != 'чь') {
			$forms[Cases::TVORIT] = $prefix.'ми';
		} else {
			$forms[Cases::TVORIT] = $this->chooseVowelAfterConsonant($last, $soft_last && S::slice($word, -2, -1) != 'ч', $prefix.'ями', $prefix.'ами');
		}

		// PREDLOJ
		$forms[Cases::PREDLOJ] = $this->chooseVowelAfterConsonant($last, $soft_last && S::slice($word, -2, -1) != 'ч', $prefix.'ях', $prefix.'ах');
		$forms[Cases::PREDLOJ] = $this->choosePrepositionByFirstLetter($forms[Cases::PREDLOJ], 'об', 'о').' '.$forms[Cases::PREDLOJ];
		return $forms;
	}
}
