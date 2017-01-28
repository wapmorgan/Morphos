<?php
namespace morphos\Russian;

class GeneralDeclension extends \morphos\GeneralDeclension implements Cases {
	use RussianLanguage;

	const FIRST_DECLENSION = 1;
	const SECOND_DECLENSION = 2;
	const THIRD_DECLENSION = 3;

	const FIRST_SCHOOL_DECLENSION = 2;
	const SECOND_SCHOOL_DECLENSION = 1;
	const THIRD_SCHOOL_DECLENSION = 3;

	public function hasForms($word, $animate = false) {
		return true;
	}

	public function getDeclension($word) {
		$word = lower($word);
		$last = slice($word, -1);
		if ($this->isConsonant($last) || in_array($last, ['о', 'е', 'ё']) || ($last == 'ь' && $this->isConsonant(slice($word, -2, -1)) && !$this->isHissingConsonant(slice($word, -2, -1)))) {
			return  1;
		} else if (in_array($last, ['а', 'я']) && slice($word, -2) != 'мя') {
			return 2;
		} else {
			return 3;
		}
	}

	public function getForms($word, $animate = false) {
		$word = lower($word);
		switch ($this->getDeclension($word)) {
			case self::FIRST_DECLENSION:
				return $this->declinateFirstDeclension($word, $animate);
			case self::SECOND_DECLENSION:
				return $this->declinateSecondDeclension($word);
			case self::THIRD_DECLENSION:
				return $this->declinateThirdDeclension($word);
		}
	}

	public function declinateFirstDeclension($word, $animate = false) {
		$word = lower($word);
		$last = slice($word, -1);
		$soft_last = $last == 'й' || (in_array($last, ['ь', 'е', 'ё', 'ю', 'я']) && $this->isConsonant(slice($word, -2, -1)));
		$prefix = $this->getPrefixOfFirstDeclension($word, $last);
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
			$forms[Cases::VINIT_4] = $this->getVinitCaseByAnimateness($forms, $animate);
		}

		// TVORIT_5
		// if ($last == 'ь')
		// 	$forms[Cases::TVORIT_5] = $prefix.'ом';
		// else if ($last == 'й' || ($this->isConsonant($last) && !$this->isHissingConsonant($last)))
		// 	$forms[Cases::TVORIT_5] = $prefix.'ем';
		// else
		// 	$forms[Cases::TVORIT_5] = $prefix.'ом'; # http://morpher.ru/Russian/Spelling.aspx#sibilant
		if ($this->isHissingConsonant($last) || $last == 'ц') {
			$forms[Cases::TVORIT_5] = $prefix.'ем';
		} else if (in_array($last, ['й'/*, 'ч', 'щ'*/]) || $soft_last) {
			$forms[Cases::TVORIT_5] = $prefix.'ем';
		} else {
			$forms[Cases::TVORIT_5] = $prefix.'ом';
		}

		// PREDLOJ_6
		$forms[Cases::PREDLOJ_6] = $this->getPredCaseOf12Declensions($word, $last, $prefix);
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
		$forms[Cases::RODIT_2] = $this->chooseVowelAfterConsonant($last, $soft_last, $prefix.'и', $prefix.'ы');

		// DAT_3
		$forms[Cases::DAT_3] = $this->getPredCaseOf12Declensions($word, $last, $prefix);

		// VINIT_4
		$forms[Cases::VINIT_4] = $this->chooseVowelAfterConsonant($last, $soft_last, $prefix.'ю', $prefix.'у');

		// TVORIT_5
		if ($last == 'ь')
			$forms[Cases::TVORIT_5] = $prefix.'ой';
		else {
			$forms[Cases::TVORIT_5] = $this->chooseVowelAfterConsonant($last, $soft_last, $prefix.'ей', $prefix.'ой');
		}

		// 	if ($last == 'й' || ($this->isConsonant($last) && !$this->isHissingConsonant($last)) || $this->checkLastConsonantSoftness($word))
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

	public function pluralizeAllDeclensions($word, $animate = false) {
		$word = lower($word);
		$prefix = slice($word, 0, -1);
		$last = slice($word, -1);

		if (($declension = $this->getDeclension($word)) == self::FIRST_DECLENSION) {
			$soft_last = $last == 'й' || (in_array($last, ['ь', 'е', 'ё', 'ю', 'я']) && $this->isConsonant(slice($word, -2, -1)));
			$prefix = $this->getPrefixOfFirstDeclension($word, $last);
		} else if ($declension == self::SECOND_DECLENSION) {
			 $soft_last = $this->checkLastConsonantSoftness($word);
		} else {
			$soft_last = false;
		}

		$forms =  array(
			Cases::IMENIT_1 => $this->chooseVowelAfterConsonant($last, $soft_last, $prefix.'я', $prefix.'а'),
		);

		// RODIT_2
		if ($this->isHissingConsonant($last) || ($soft_last && $last != 'й'))
			$forms[Cases::RODIT_2] = $prefix.'ей';
		else if ($last == 'й')
			$forms[Cases::RODIT_2] = $prefix.'ев';
		else // ($this->isConsonant($last) && !$this->isHissingConsonant($last))
			$forms[Cases::RODIT_2] = $prefix.'ов';

		// DAT_3
		$forms[Cases::DAT_3] = $this->chooseVowelAfterConsonant($last, $soft_last, $prefix.'ям', $prefix.'ам');

		// VINIT_4
		$forms[Cases::VINIT_4] = $this->getVinitCaseByAnimateness($forms, $animate);

		// TVORIT_5
		// my personal rule
		if ($last == 'ь' && $declension == self::THIRD_DECLENSION) {
			$forms[Cases::TVORIT_5] = $prefix.'ми';
		} else {
			$forms[Cases::TVORIT_5] = $this->chooseVowelAfterConsonant($last, $soft_last, $prefix.'ями', $prefix.'ами');
		}

		// PREDLOJ_6
		$forms[Cases::PREDLOJ_6] = $this->chooseVowelAfterConsonant($last, $soft_last, $prefix.'ях', $prefix.'ах');
		$forms[Cases::PREDLOJ_6] = $this->choosePrepositionByFirstLetter($forms[Cases::PREDLOJ_6], 'об', 'о').' '.$forms[Cases::PREDLOJ_6];
		return $forms;
	}

	public function getForm($word, $animate = false, $form) {
		$forms = $this->getForms($word, $animate);
		return $forms[$form];
	}

	protected function getPrefixOfFirstDeclension($word, $last) {
		if (in_array($last, ['о', 'е', 'ё', 'ь', 'й']))
			$prefix = slice($word, 0, -1);
		else
			$prefix = $word;
		return $prefix;
	}

	protected function getVinitCaseByAnimateness(array $forms, $animate) {
		if ($animate)
			return $forms[Cases::RODIT_2];
		else
			return $forms[Cases::IMENIT_1];
	}

	protected function getPredCaseOf12Declensions($word, $last, $prefix) {
		if (slice($word, -2) == 'ий') {
			if ($last == 'ё')
				return $prefix.'е';
			else
				return $prefix.'и';
		} else {
			return $prefix.'е';
		}
	}

	protected function chooseVowelAfterConsonant($last, $soft_last, $after_soft, $after_hard) {
		if ($this->isHissingConsonant($last) || $this->isVelarConsonant($last) || $soft_last) {
			return $after_soft;
		} else {
			return $after_hard;
		}
	}
}
