<?php
namespace morphos;

class RussianGeneralDeclension extends BasicDeclension implements RussianCases {
	use Russian;

	const FIRST_DECLENSION = 1;
	const SECOND_DECLENSION = 2;
	const THIRD_DECLENSION = 3;

	const FIRST_SCHOOL_DECLENSION = 2;
	const SECOND_SCHOOL_DECLENSION = 1;
	const THIRD_SCHOOL_DECLENSION = 3;

	// public function getForms($word) {
	// 	$word = lower($word);
	// 	$prefix = slice($word, 0, -1);
	// 	$last = slice($word, -1);
	// 	if (in_array($last, array('а', 'я'))) {
	// 		return array($word, ($last == 'а') ? $prefix.'ы' : $prefix.'и', ($last == 'а') ? $prefix : $prefix.'й');
	// 	} else if (($last == 'ь' && $this->isConsonant(slice($word, -2, -2))) || $this->isConsonant($last) || in_array($last, array('о', 'е'))) {
	// 		if ($last == 'ь')
	// 			$prefix = slice($word, -2, -1);
	// 		else if (in_array(slice($word, -2), array('ец', 'йк', 'йн')))
	// 		var_dump($prefix);
	// 		return array($word, $this->isConsonant($last) ? $prefix.'а' : $prefix.'я', $this->isConsonant($last) ? $prefix.'ов' : $prefix.'ей');
	// 	} else {
	// 		return array($word, $prefix.'и', $prefix.'ей');
	// 	}
	// }

	public function hasForms($word, $animate = false) {
		return true;
	}

	public function getDeclension($word) {
		$word = lower($word);
		$last = slice($word, -1);
		if ($this->isConsonant($last) || in_array($last, ['о', 'е', 'ё']) || ($last == 'ь' && $this->isConsonant(slice($word, -2, -1)) && !$this->isHissingConsonant(slice($word, -2, -1)))) {
			$declension = 1;
		} else if (in_array($last, ['а', 'я']) && slice($word, -2) != 'мя') {
			$declension = 2;
		} else {
			$declension = 3;
		}
		return $declension;
	}

	public function getForms($word, $animate = false) {
		$word = lower($word);
		switch ($this->getDeclension($word)) {
			case self::FIRST_DECLENSION:
				return $this->declinateFirstDeclension($word);
			case self::SECOND_DECLENSION:
				return $this->declinateSecondDeclension($word);
			case self::THIRD_DECLENSION:
				return $this->declinateThirdDeclension($word);
		}
	}

	public function declinateFirstDeclension($word, $animate = false) {
		$word = lower($word);
		$last = slice($word, -1);
		$soft_last = in_array($last, ['ь', 'е', 'ё', 'ю', 'я']) && $this->isConsonant(slice($word, -2, -1));
		$prefix = $this->getPrefixOfFirstDeclension($word, $last);
		$forms =  array(
			RussianCases::IMENIT_1 => $word,
		);

		// RODIT_2
		if ($this->isHissingConsonant($last) || $this->isVelarConsonant($last) || $soft_last) {
			$forms[RussianCases::RODIT_2] = $prefix.'я';
		} else {
			$forms[RussianCases::RODIT_2] = $prefix.'а';
		}

		//  DAT_3
		if ($this->isHissingConsonant($last) || $this->isVelarConsonant($last) || $soft_last) {
			$forms[RussianCases::DAT_3] = $prefix.'ю';
		} else {
			$forms[RussianCases::DAT_3] = $prefix.'у';
		}

		// VINIT_4
		if (in_array($last, ['о', 'е', 'ё']))
			$forms[RussianCases::VINIT_4] = $word;
		else {
			$forms[RussianCases::VINIT_4] = $this->getVinitCaseByAnimateness($forms, $animate);
		}

		// TVORIT_5
		// if ($last == 'ь')
		// 	$forms[RussianCases::TVORIT_5] = $prefix.'ом';
		// else if ($last == 'й' || ($this->isConsonant($last) && !$this->isHissingConsonant($last)))
		// 	$forms[RussianCases::TVORIT_5] = $prefix.'ем';
		// else
		// 	$forms[RussianCases::TVORIT_5] = $prefix.'ом'; # http://morpher.ru/Russian/Spelling.aspx#sibilant
		if ($this->isHissingConsonant($last) || $last == 'ц') {
			$forms[RussianCases::TVORIT_5] = $prefix.'ем';
		} else if (in_array($last, ['й'/*, 'ч', 'щ'*/]) || $soft_last) {
			$forms[RussianCases::TVORIT_5] = $prefix.'ем';
		} else {
			$forms[RussianCases::TVORIT_5] = $prefix.'ом';
		}

		// PREDLOJ_6
		$forms[RussianCases::PREDLOJ_6] = $this->getPredCaseOf12Declensions($word, $last, $prefix);

		return $forms;
	}

	public function declinateSecondDeclension($word) {
		$word = lower($word);
		$prefix = slice($word, 0, -1);
		$last = slice($word, -1);
		$forms =  array(
			RussianCases::IMENIT_1 => $word,
		);

		// RODIT_2
		if ($this->isHissingConsonant($last) || $this->isVelarConsonant($last)) {
			$forms[RussianCases::RODIT_2] = $prefix.'и';
		} else {
			$forms[RussianCases::RODIT_2] = $prefix.'ы';
		}

		// DAT_3
		$forms[RussianCases::DAT_3] = $this->getPredCaseOf12Declensions($word, $last, $prefix);

		// VINIT_4
		if ($this->isHissingConsonant($last) || $this->isVelarConsonant($last)) {
			$forms[RussianCases::VINIT_4] = $prefix.'ю';
		} else {
			$forms[RussianCases::VINIT_4] = $prefix.'у';
		}

		// TVORIT_5
		if (slice($word, -2) == 'ий') {
			if ($last == 'ё')
				// $forms[RussianCases::TVORIT_5] = $prefix.'ой';
				if ($last == 'ь')
					$forms[RussianCases::TVORIT_5] = $prefix.'ой';
				else if ($last == 'й' || ($this->isConsonant($last) && !$this->isHissingConsonant($last)))
					$forms[RussianCases::TVORIT_5] = $prefix.'ей';
				else
					$forms[RussianCases::TVORIT_5] = $prefix.'ой'; # http://morpher.ru/Russian/Spelling.aspx#sibilant

			else
				// $forms[RussianCases::TVORIT_5] = $prefix.'ою';
				if ($last == 'ь')
					$forms[RussianCases::TVORIT_5] = $prefix.'ою';
				else if ($last == 'й' || ($this->isConsonant($last) && !$this->isHissingConsonant($last)))
					$forms[RussianCases::TVORIT_5] = $prefix.'ею';
				else
					$forms[RussianCases::TVORIT_5] = $prefix.'ою'; # http://morpher.ru/Russian/Spelling.aspx#sibilant
		} else {
			// $forms[RussianCases::TVORIT_5] = $prefix.'ой';
			if ($last == 'ь')
				$forms[RussianCases::TVORIT_5] = $prefix.'ой';
			else if ($last == 'й' || ($this->isConsonant($last) && !$this->isHissingConsonant($last)))
				$forms[RussianCases::TVORIT_5] = $prefix.'ей';
			else
				$forms[RussianCases::TVORIT_5] = $prefix.'ой'; # http://morpher.ru/Russian/Spelling.aspx#sibilant
		}

		// PREDLOJ_6 the same as DAT_3
		$forms[RussianCases::PREDLOJ_6] = $forms[RussianCases::DAT_3];
		return $forms;
	}

	public function declinateThirdDeclension($word) {
		$word = lower($word);
		$prefix = slice($word, 0, -1);
		return array(
			RussianCases::IMENIT_1 => $word,
			RussianCases::RODIT_2 => $prefix.'и',
			RussianCases::DAT_3 => $prefix.'и',
			RussianCases::VINIT_4 => $word,
			RussianCases::TVORIT_5 => $prefix.'ью',
			RussianCases::PREDLOJ_6 => $prefix.'и',
		);
	}

	public function pluralizeAllDeclensions($word, $animate = false) {
		$word = lower($word);
		$prefix = slice($word, 0, -1);
		$last = slice($word, -1);

		if (($declension = $this->getDeclension($word)) == self::FIRST_DECLENSION) {
			$soft_last = in_array($last, ['ь', 'е', 'ё', 'ю', 'я']) && $this->isConsonant(slice($word, -2, -1));
			$prefix = $this->getPrefixOfFirstDeclension($word, $last);
		} else {
			$soft_last = false;
		}

		$forms =  array(
			RussianCases::IMENIT_1 => ($this->isHissingConsonant($last) || $this->isVelarConsonant($last) || $soft_last) ? $prefix.'я' : $prefix.'а',
		);


		// RODIT_2
		if ($this->isHissingConsonant($last) || $soft_last)
			$forms[RussianCases::RODIT_2] = $prefix.'ей';
		else if ($last == 'й')
			$forms[RussianCases::RODIT_2] = $prefix.'ев';
		else // ($this->isConsonant($last) && !$this->isHissingConsonant($last))
			$forms[RussianCases::RODIT_2] = $prefix.'ов';

		// DAT_3
		if ($this->isHissingConsonant($last) || $this->isVelarConsonant($last) || $soft_last) {
			$forms[RussianCases::DAT_3] = $prefix.'ям';
		} else {
			$forms[RussianCases::DAT_3] = $prefix.'ам';
		}

		// VINIT_4
		$forms[RussianCases::VINIT_4] = $this->getVinitCaseByAnimateness($forms, $animate);

		// TVORIT_5
		// my personal rule
		if ($last == 'ь' && $declension == self::THIRD_DECLENSION) {
			$forms[RussianCases::TVORIT_5] = $prefix.'ми';
		} else if ($this->isHissingConsonant($last) || $this->isVelarConsonant($last) || $soft_last) {
			$forms[RussianCases::TVORIT_5] = $prefix.'ями';
		} else {
			$forms[RussianCases::TVORIT_5] = $prefix.'ами';
		}

		// PREDLOJ_6
		if ($this->isHissingConsonant($last) || $this->isVelarConsonant($last) || $soft_last) {
			$forms[RussianCases::PREDLOJ_6] = $prefix.'ях';
		} else {
			$forms[RussianCases::PREDLOJ_6] = $prefix.'ах';
		}
		return $forms;
	}

	public function getForm($word, $animate = false, $form) {
		$forms = $this->getForms($word, $animate);
		return $forms[$form];
	}

	protected function getPrefixOfFirstDeclension($word, $last) {
		if (in_array($last, ['о', 'е', 'ё', 'ь']))
			$prefix = slice($word, 0, -1);
		else
			$prefix = $word;
		return $prefix;
	}

	protected function getVinitCaseByAnimateness(array $forms, $animate) {
		if ($animate)
			return $forms[RussianCases::RODIT_2];
		else
			return $forms[RussianCases::IMENIT_1];
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
}
