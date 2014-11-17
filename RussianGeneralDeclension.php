<?php
namespace morphos;

class RussianGeneralDeclension extends BasicDeclension implements RussianDeclensions {
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
				break;
			case self::SECOND_DECLENSION:
				return $this->declinateSecondDeclension($word);
				break;
			case self::THIRD_DECLENSION:
				return $this->declinateThirdDeclension($word);
				break;
		}
	}

	public function declinateFirstDeclension($word, $animate = false) {
		$word = lower($word);
		$last = slice($word, -1);
		$soft_last = in_array($last, ['ь', 'е', 'ё', 'ю', 'я']) && $this->isConsonant(slice($word, -2, -1));
		if (in_array($last, ['о', 'е', 'ё', 'ь']))
			$prefix = slice($word, 0, -1);
		else
			$prefix = $word;

		$forms =  array(
			RussianDeclensions::IMENIT_1 => $word,
		);

		// RODIT_2
		if ($this->isHissingConsonant($last) || $this->isVelarConsonant($last) || $soft_last) {
			$forms[RussianDeclensions::RODIT_2] = $prefix.'я';
		} else {
			$forms[RussianDeclensions::RODIT_2] = $prefix.'а';
		}

		//  DAT_3
		if ($this->isHissingConsonant($last) || $this->isVelarConsonant($last) || $soft_last) {
			$forms[RussianDeclensions::DAT_3] = $prefix.'ю';
		} else {
			$forms[RussianDeclensions::DAT_3] = $prefix.'у';
		}

		// VINIT_4
		if (in_array($last, ['о', 'е', 'ё']))
			$forms[RussianDeclensions::VINIT_4] = $word;
		else {
			if ($animate)
				$forms[RussianDeclensions::VINIT_4] = $forms[RussianDeclensions::RODIT_2];
			else
				$forms[RussianDeclensions::VINIT_4] = $forms[RussianDeclensions::IMENIT_1];
		}

		// TVORIT_5
		// if ($last == 'ь')
		// 	$forms[RussianDeclensions::TVORIT_5] = $prefix.'ом';
		// else if ($last == 'й' || ($this->isConsonant($last) && !$this->isHissingConsonant($last)))
		// 	$forms[RussianDeclensions::TVORIT_5] = $prefix.'ем';
		// else
		// 	$forms[RussianDeclensions::TVORIT_5] = $prefix.'ом'; # http://morpher.ru/Russian/Spelling.aspx#sibilant
		if ($this->isHissingConsonant($last) || $last == 'ц') {
			$forms[RussianDeclensions::TVORIT_5] = $prefix.'ем';
		} else if (in_array($last, ['й'/*, 'ч', 'щ'*/]) || $soft_last) {
			$forms[RussianDeclensions::TVORIT_5] = $prefix.'ем';
		} else {
			$forms[RussianDeclensions::TVORIT_5] = $prefix.'ом';
		}

		// PREDLOJ_6
		if (slice($word, -2) == 'ий') {
			if ($last == 'ё')
				$forms[RussianDeclensions::PREDLOJ_6] = $prefix.'е';
			else
				$forms[RussianDeclensions::PREDLOJ_6] = $prefix.'и';
		} else {
			$forms[RussianDeclensions::PREDLOJ_6] = $prefix.'е';
		}
		return $forms;
	}

	public function declinateSecondDeclension($word, $animate = false) {
		$word = lower($word);
		$prefix = slice($word, 0, -1);
		$last = slice($word, -1);
		$forms =  array(
			RussianDeclensions::IMENIT_1 => $word,
		);

		// RODIT_2
		if ($this->isHissingConsonant($last) || $this->isVelarConsonant($last)) {
			$forms[RussianDeclensions::RODIT_2] = $prefix.'и';
		} else {
			$forms[RussianDeclensions::RODIT_2] = $prefix.'ы';
		}

		// DAT_3
		if (slice($word, -2) == 'ий') {
			if ($last == 'ё')
				$forms[RussianDeclensions::DAT_3] = $prefix.'е';
			else
				$forms[RussianDeclensions::DAT_3] = $prefix.'и';
		} else {
			$forms[RussianDeclensions::DAT_3] = $prefix.'е';
		}

		// VINIT_4
		if ($this->isHissingConsonant($last) || $this->isVelarConsonant($last)) {
			$forms[RussianDeclensions::VINIT_4] = $prefix.'ю';
		} else {
			$forms[RussianDeclensions::VINIT_4] = $prefix.'у';
		}

		// TVORIT_5
		if (slice($word, -2) == 'ий') {
			if ($last == 'ё')
				// $forms[RussianDeclensions::TVORIT_5] = $prefix.'ой';
				if ($last == 'ь')
					$forms[RussianDeclensions::TVORIT_5] = $prefix.'ой';
				else if ($last == 'й' || ($this->isConsonant($last) && !$this->isHissingConsonant($last)))
					$forms[RussianDeclensions::TVORIT_5] = $prefix.'ей';
				else
					$forms[RussianDeclensions::TVORIT_5] = $prefix.'ой'; # http://morpher.ru/Russian/Spelling.aspx#sibilant

			else
				// $forms[RussianDeclensions::TVORIT_5] = $prefix.'ою';
				if ($last == 'ь')
					$forms[RussianDeclensions::TVORIT_5] = $prefix.'ою';
				else if ($last == 'й' || ($this->isConsonant($last) && !$this->isHissingConsonant($last)))
					$forms[RussianDeclensions::TVORIT_5] = $prefix.'ею';
				else
					$forms[RussianDeclensions::TVORIT_5] = $prefix.'ою'; # http://morpher.ru/Russian/Spelling.aspx#sibilant
		} else {
			// $forms[RussianDeclensions::TVORIT_5] = $prefix.'ой';
			if ($last == 'ь')
				$forms[RussianDeclensions::TVORIT_5] = $prefix.'ой';
			else if ($last == 'й' || ($this->isConsonant($last) && !$this->isHissingConsonant($last)))
				$forms[RussianDeclensions::TVORIT_5] = $prefix.'ей';
			else
				$forms[RussianDeclensions::TVORIT_5] = $prefix.'ой'; # http://morpher.ru/Russian/Spelling.aspx#sibilant
		}

		// PREDLOJ_6 same DAT_3
		$forms[RussianDeclensions::PREDLOJ_6] = $forms[RussianDeclensions::DAT_3];
		return $forms;
	}

	public function declinateThirdDeclension($word, $animate = false) {
		$word = lower($word);
		$prefix = slice($word, 0, -1);
		$last = slice($word, -1);
		return array(
			RussianDeclensions::IMENIT_1 => $word,
			RussianDeclensions::RODIT_2 => $prefix.'и',
			RussianDeclensions::DAT_3 => $prefix.'и',
			RussianDeclensions::VINIT_4 => $word,
			RussianDeclensions::TVORIT_5 => $prefix.'ью',
			RussianDeclensions::PREDLOJ_6 => $prefix.'и',
		);
	}

	public function pluralizeAllDeclensions($word, $animate = false) {
		$word = lower($word);
		$prefix = slice($word, 0, -1);
		$last = slice($word, -1);

		if (($declension = $this->getDeclension($word, $animate)) == self::FIRST_DECLENSION) {
			$soft_last = in_array($last, ['ь', 'е', 'ё', 'ю', 'я']) && $this->isConsonant(slice($word, -2, -1));
			if (in_array($last, ['о', 'е', 'ё', 'ь']))
				$prefix = slice($word, 0, -1);
			else
				$prefix = $word;

		} else {
			$soft_last = false;
		}

		$forms =  array(
			RussianDeclensions::IMENIT_1 => ($this->isHissingConsonant($last) || $this->isVelarConsonant($last) || $soft_last) ? $prefix.'я' : $prefix.'а',
		);


		// RODIT_2
		if ($this->isHissingConsonant($last) || $soft_last)
			$forms[RussianDeclensions::RODIT_2] = $prefix.'ей';
		else if ($last == 'й')
			$forms[RussianDeclensions::RODIT_2] = $prefix.'ев';
		else // ($this->isConsonant($last) && !$this->isHissingConsonant($last))
			$forms[RussianDeclensions::RODIT_2] = $prefix.'ов';

		// DAT_3
		if ($this->isHissingConsonant($last) || $this->isVelarConsonant($last) || $soft_last) {
			$forms[RussianDeclensions::DAT_3] = $prefix.'ям';
		} else {
			$forms[RussianDeclensions::DAT_3] = $prefix.'ам';
		}

		// VINIT_4
		if ($animate)
			$forms[RussianDeclensions::VINIT_4] = $forms[RussianDeclensions::RODIT_2];
		else
			$forms[RussianDeclensions::VINIT_4] = $forms[RussianDeclensions::IMENIT_1];

		// TVORIT_5
		// my personal rule
		if ($last == 'ь' && $declension == self::THIRD_DECLENSION) {
			$forms[RussianDeclensions::TVORIT_5] = $prefix.'ми';
		} else if ($this->isHissingConsonant($last) || $this->isVelarConsonant($last) || $soft_last) {
			$forms[RussianDeclensions::TVORIT_5] = $prefix.'ями';
		} else {
			$forms[RussianDeclensions::TVORIT_5] = $prefix.'ами';
		}

		// PREDLOJ_6
		if ($this->isHissingConsonant($last) || $this->isVelarConsonant($last) || $soft_last) {
			$forms[RussianDeclensions::PREDLOJ_6] = $prefix.'ях';
		} else {
			$forms[RussianDeclensions::PREDLOJ_6] = $prefix.'ах';
		}
		return $forms;
	}

	public function getForm($word, $animate = false, $form) {
		$forms = $this->getForms($word, $animate);
		return $forms[$form];
	}
}
