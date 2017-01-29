<?php
namespace morphos\Russian;

/**
 * Rules are from http://morpher.ru/Russian/Noun.aspx
 */
class Plurality extends \morphos\Plurality implements Cases {
	use RussianLanguage;

	protected $neuterExceptions = array(
		'поле',
		'море',
	);

	static public function pluralize($word, $count, $animateness = false) {
		static $dec, $plu;
		if ($dec === null) $dec = new GeneralDeclension();
		if ($plu === null) $plu = new self();

		$ending = $count % 10;
		if (($count > 20 && $ending == 1) || $count == 1) {
			return $word;
		} else if (($count > 20 && in_array($ending, range(2, 4))) || in_array($count, range(2, 4))) {
			return $dec->getForm($word, self::RODIT_2, $animateness);
		} else {
			$forms = $plu->getForms($word, $animateness);
			return $forms[self::RODIT_2];
		}
	}

	public function getForm($word, $form, $animateness = false) {
		$forms = $this->getForms($word, $animateness);
		return $forms[$form];
	}

	public function getForms($word, $animateness = false) {
		$word = lower($word);
		$prefix = slice($word, 0, -1);
		$last = slice($word, -1);

		if (($declension = GeneralDeclension::getDeclension($word)) == GeneralDeclension::FIRST_DECLENSION) {
			$soft_last = $last == 'й' || (in_array($last, ['ь', 'е', 'ё', 'ю', 'я']) && self::isConsonant(slice($word, -2, -1)));
			$prefix = GeneralDeclension::getPrefixOfFirstDeclension($word, $last);
		} else if ($declension == GeneralDeclension::SECOND_DECLENSION) {
			 $soft_last = $this->checkLastConsonantSoftness($word);
		} else {
			$soft_last = false;
		}

		$forms = array();

		if ($last == 'ч' || slice($word, -2) == 'чь')
			$forms[Cases::IMENIT_1] = $prefix.'и';
		else
			$forms[Cases::IMENIT_1] = $this->chooseVowelAfterConsonant($last, $soft_last, $prefix.'я', $prefix.'а');


		// RODIT_2
		if (in_array($last, array('о', 'е'))) {
			// exceptions
			if (in_array($word, $this->neuterExceptions))
				$forms[Cases::RODIT_2] = $prefix.'ей';
			else
				$forms[Cases::RODIT_2] = $prefix;
		}
		else if (in_array($last, array('а'))) // обида, ябеда
			$forms[Cases::RODIT_2] = $prefix;
		else if (in_array($last, array('я'))) // молния
			$forms[Cases::RODIT_2] = $prefix.'й';
		else if (RussianLanguage::isHissingConsonant($last) || ($soft_last && $last != 'й') || slice($word, -2) == 'чь')
			$forms[Cases::RODIT_2] = $prefix.'ей';
		else if ($last == 'й')
			$forms[Cases::RODIT_2] = $prefix.'ев';
		else // (self::isConsonant($last) && !RussianLanguage::isHissingConsonant($last))
			$forms[Cases::RODIT_2] = $prefix.'ов';

		// DAT_3
		$forms[Cases::DAT_3] = $this->chooseVowelAfterConsonant($last, $soft_last, $prefix.'ям', $prefix.'ам');

		// VINIT_4
		$forms[Cases::VINIT_4] = GeneralDeclension::getVinitCaseByAnimateness($forms, $animateness);

		// TVORIT_5
		// my personal rule
		if ($last == 'ь' && $declension == GeneralDeclension::THIRD_DECLENSION && slice($word, -2) != 'чь') {
			$forms[Cases::TVORIT_5] = $prefix.'ми';
		} else {
			$forms[Cases::TVORIT_5] = $this->chooseVowelAfterConsonant($last, $soft_last, $prefix.'ями', $prefix.'ами');
		}

		// PREDLOJ_6
		$forms[Cases::PREDLOJ_6] = $this->chooseVowelAfterConsonant($last, $soft_last, $prefix.'ях', $prefix.'ах');
		$forms[Cases::PREDLOJ_6] = $this->choosePrepositionByFirstLetter($forms[Cases::PREDLOJ_6], 'об', 'о').' '.$forms[Cases::PREDLOJ_6];
		return $forms;
	}
}
