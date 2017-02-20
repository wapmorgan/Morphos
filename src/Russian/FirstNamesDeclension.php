<?php
namespace morphos\Russian;

/**
 * Rules are from: http://www.imena.org/decl_mn.html
 * and http://www.imena.org/decl_fn.html
 */
class FirstNamesDeclension extends \morphos\NamesDeclension implements Cases {
	use RussianLanguage, CasesHelper;

	protected $exceptions = array(
		'лев' => array(
			self::IMENIT => 'Лев',
			self::RODIT => 'Льва',
			self::DAT => 'Льву',
			self::VINIT => 'Льва',
			self::TVORIT => 'Львом',
			self::PREDLOJ => 'о Льве',
		),
		'павел' => array(
			self::IMENIT => 'Павел',
			self::RODIT => 'Павла',
			self::DAT => 'Павлу',
			self::VINIT => 'Павла',
			self::TVORIT => 'Павлом',
			self::PREDLOJ => 'о Павле',
		)
	);

	static protected $menNames = array(
		'абрам',
		'аверьян',
		'авраам',
		'агафон',
		'адам',
		'азар',
		'акакий',
		'аким',
		'аксён',
		'александр',
		'алексей',
		'альберт',
		'анатолий',
		'андрей',
		'андрон',
		'антип',
		'антон',
		'аполлон',
		'аристарх',
		'аркадий',
		'арнольд',
		'арсений',
		'арсентий',
		'артем',
		'артём',
		'артемий',
		'артур',
		'аскольд',
		'афанасий',
		'богдан',
		'борис',
		'борислав',
		'бронислав',
		'вадим',
		'валентин',
		'валерий',
		'варлам',
		'василий',
		'венедикт',
		'вениамин',
		'веньямин',
		'венцеслав',
		'виктор',
		'вилен',
		'виталий',
		'владилен',
		'владимир',
		'владислав',
		'владлен',
		'всеволод',
		'всеслав',
		'вячеслав',
		'гавриил',
		'геннадий',
		'георгий',
		'герман',
		'глеб',
		'григорий',
		'давид',
		'даниил',
		'данил',
		'данила',
		'демьян',
		'денис',
		'димитрий',
		'дмитрий',
		'добрыня',
		'евгений',
		'евдоким',
		'евсей',
		'егор',
		'емельян',
		'еремей',
		'ермолай',
		'ерофей',
		'ефим',
		'захар',
		'иван',
		'игнат',
		'игорь',
		'илларион',
		'иларион',
		'илья',
		'иосиф',
		'казимир',
		'касьян',
		'кирилл',
		'кондрат',
		'константин',
		'кузьма',
		'лавр',
		'лаврентий',
		'лазарь',
		'ларион',
		'лев',
		'леонард',
		'леонид',
		'лука',
		'максим',
		'марат',
		'мартын',
		'матвей',
		'мефодий',
		'мирон',
		'михаил',
		'моисей',
		'назар',
		'никита',
		'николай',
		'олег',
		'осип',
		'остап',
		'павел',
		'панкрат',
		'пантелей',
		'парамон',
		'пётр',
		'петр',
		'платон',
		'потап',
		'прохор',
		'роберт',
		'ростислав',
		'савва',
		'савелий',
		'семён',
		'семен',
		'сергей',
		'сидор',
		'спартак',
		'тарас',
		'терентий',
		'тимофей',
		'тимур',
		'тихон',
		'ульян',
		'фёдор',
		'федор',
		'федот',
		'феликс',
		'фирс',
		'фома',
		'харитон',
		'харлам',
		'эдуард',
		'эммануил',
		'эраст',
		'юлиан',
		'юлий',
		'юрий',
		'яков',
		'ян',
		'ярослав',
	);

	static protected $womenNames = array(
		'авдотья',
		'аврора',
		'агата',
		'агния',
		'агриппина',
		'ада',
		'аксинья',
		'алевтина',
		'александра',
		'алёна',
		'алена',
		'алина',
		'алиса',
		'алла',
		'альбина',
		'амалия',
		'анастасия',
		'ангелина',
		'анжела',
		'анжелика',
		'анна',
		'антонина',
		'анфиса',
		'арина',
		'белла',
		'божена',
		'валентина',
		'валерия',
		'ванда',
		'варвара',
		'василина',
		'василиса',
		'вера',
		'вероника',
		'виктория',
		'виола',
		'виолетта',
		'вита',
		'виталия',
		'владислава',
		'власта',
		'галина',
		'глафира',
		'дарья',
		'диана',
		'дина',
		'ева',
		'евгения',
		'евдокия',
		'евлампия',
		'екатерина',
		'елена',
		'елизавета',
		'ефросиния',
		'ефросинья',
		'жанна',
		'зиновия',
		'злата',
		'зоя',
		'ивонна',
		'изольда',
		'илона',
		'инга',
		'инесса',
		'инна',
		'ирина',
		'ия',
		'капитолина',
		'карина',
		'каролина',
		'кира',
		'клавдия',
		'клара',
		'клеопатра',
		'кристина',
		'ксения',
		'лада',
		'лариса',
		'лиана',
		'лидия',
		'лилия',
		'лина',
		'лия',
		'лора',
		'любава',
		'любовь',
		'людмила',
		'майя',
		'маргарита',
		'марианна',
		'мариетта',
		'марина',
		'мария',
		'марья',
		'марта',
		'марфа',
		'марьяна',
		'матрёна',
		'матрена',
		'матрона',
		'милена',
		'милослава',
		'мирослава',
		'муза',
		'надежда',
		'настасия',
		'настасья',
		'наталия',
		'наталья',
		'нелли',
		'ника',
		'нина',
		'нинель',
		'нонна',
		'оксана',
		'олимпиада',
		'ольга',
		'пелагея',
		'полина',
		'прасковья',
		'раиса',
		'рената',
		'римма',
		'роза',
		'роксана',
		'руфь',
		'сарра',
		'светлана',
		'серафима',
		'снежана',
		'софья',
		'софия',
		'стелла',
		'степанида',
		'стефания',
		'таисия',
		'таисья',
		'тамара',
		'татьяна',
		'ульяна',
		'устиния',
		'устинья',
		'фаина',
		'фёкла',
		'фекла',
		'феодора',
		'хаврония',
		'христина',
		'эвелина',
		'эдита',
		'элеонора',
		'элла',
		'эльвира',
		'эмилия',
		'эмма',
		'юдифь',
		'юлиана',
		'юлия',
		'ядвига',
		'яна',
		'ярослава',
	);

	public function isMutable($name, $gender) {
		//var_dump(upper(slice($name, -1)));
		$name = lower($name);
		// man rules
		if ($gender === self::MAN) {
			// soft consonant
			if (lower(slice($name, -1)) == 'ь' && in_array(upper(slice($name, -2, -1)), self::$consonants)) {
				return true;
			} else if (in_array(upper(slice($name, -1)), array_diff(self::$consonants, array('Й', /*'Ч', 'Щ'*/)))) { // hard consonant
				return true;
			} else if (slice($name, -1) == 'й') {
				return true;
			}
		}

		// common rules
		if ((in_array(slice($name, -1), array('а', 'я')) && !in_array(upper(slice($name, -2, -1)), self::$vowels)) || in_array(slice($name, -2), array('ия', 'ья', 'ея'))) {
			return true;
		}

		return false;
	}



	public function detectGender($name) {
		$name = lower($name);
		if (in_array($name, self::$menNames))
			return self::MAN;
		else if (in_array($name, self::$womenNames))
			return self::WOMAN;

		return null;
	}

	public function getCases($name, $gender) {
		$name = lower($name);
		if ($gender == self::MAN) {
			if (in_array(upper(slice($name, -1)), array_diff(self::$consonants, array('Й', /*'Ч', 'Щ'*/)))) { // hard consonant
				$prefix = name($name);
				// special cases for Лев, Павел
				if (isset($this->exceptions[$name]))
					return $this->exceptions[$name];
				else {
					return array(
						self::IMENIT => $prefix,
						self::RODIT => $prefix.'а',
						self::DAT => $prefix.'у',
						self::VINIT => $prefix.'а',
						self::TVORIT => RussianLanguage::isHissingConsonant(slice($name, -1)) || slice($name, -1) == 'ц' ? $prefix.'ем' : $prefix.'ом',
						self::PREDLOJ => $this->choosePrepositionByFirstLetter($prefix, 'об', 'о').' '.$prefix.'е',
					);
				}
			} else if (slice($name, -1) == 'ь' && in_array(upper(slice($name, -2, -1)), self::$consonants)) { // soft consonant
				$prefix = name(slice($name, 0, -1));
				return array(
					self::IMENIT => $prefix.'ь',
					self::RODIT => $prefix.'я',
					self::DAT => $prefix.'ю',
					self::VINIT => $prefix.'я',
					self::TVORIT => $prefix.'ем',
					self::PREDLOJ => $this->choosePrepositionByFirstLetter($prefix, 'об', 'о').' '.$prefix.'е',
				);
			} else if (in_array(slice($name, -2), array('ай', 'ей', 'ой', 'уй', 'яй', 'юй', 'ий'))) {
				$prefix = name(slice($name, 0, -1));
				$postfix = slice($name, -2) == 'ий' ? 'и' : 'е';
				return array(
					self::IMENIT => $prefix.'й',
					self::RODIT => $prefix.'я',
					self::DAT => $prefix.'ю',
					self::VINIT => $prefix.'я',
					self::TVORIT => $prefix.'ем',
					self::PREDLOJ => $this->choosePrepositionByFirstLetter($prefix, 'об', 'о').' '.$prefix.$postfix,
				);
			} else if (slice($name, -1) == 'а' && ($before = slice($name, -2, -1)) && self::isConsonant($before) && !in_array($before, array(/*'г', 'к', 'х', */'ц'))) {
				$prefix = name(slice($name, 0, -1));
				$postfix = (RussianLanguage::isHissingConsonant($before) || in_array($before, array('г', 'к', 'х'))) ? 'и' : 'ы';
				return array(
					self::IMENIT => $prefix.'а',
					self::RODIT => $prefix.$postfix,
					self::DAT => $prefix.'е',
					self::VINIT => $prefix.'у',
					self::TVORIT => $prefix.'ой',
					self::PREDLOJ => $this->choosePrepositionByFirstLetter($prefix, 'об', 'о').' '.$prefix.'е',
				);
			} else if (slice($name, -2) == 'ия') {
				$prefix = name(slice($name, 0, -1));
				return array(
					self::IMENIT => $prefix.'я',
					self::RODIT => $prefix.'и',
					self::DAT => $prefix.'и',
					self::VINIT => $prefix.'ю',
					self::TVORIT => $prefix.'ей',
					self::PREDLOJ => $this->choosePrepositionByFirstLetter($prefix, 'об', 'о').' '.$prefix.'и',
				);
			} else if (slice($name, -2) == 'ло' || slice($name, -2) == 'ко') {
				$prefix = name(slice($name, 0, -1));
				$postfix = slice($name, -2, -1) == 'к' ? 'и' : 'ы';
				return array(
					self::IMENIT => $prefix.'о',
					self::RODIT =>  $prefix.$postfix,
					self::DAT => $prefix.'е',
					self::VINIT => $prefix.'у',
					self::TVORIT => $prefix.'ой',
					self::PREDLOJ => $this->choosePrepositionByFirstLetter($prefix, 'об', 'о').' '.$prefix.'е',
				);
			}
		} else if ($gender == self::WOMAN) {
			if (slice($name, -1) == 'а' && !in_array(upper($before = (slice($name, -2, -1))), self::$vowels)) {
				$prefix = name(slice($name, 0, -1));
				if ($before != 'ц') {
					$postfix = (RussianLanguage::isHissingConsonant($before) || in_array($before, array('г', 'к', 'х'))) ? 'и' : 'ы';
					return array(
						self::IMENIT => $prefix.'а',
						self::RODIT => $prefix.$postfix,
						self::DAT => $prefix.'е',
						self::VINIT => $prefix.'у',
						self::TVORIT => $prefix.'ой',
						self::PREDLOJ => $this->choosePrepositionByFirstLetter($prefix, 'об', 'о').' '.$prefix.'е',
					);
				} else {
					return array(
						self::IMENIT => $prefix.'а',
						self::RODIT => $prefix.'ы',
						self::DAT => $prefix.'е',
						self::VINIT => $prefix.'у',
						self::TVORIT => $prefix.'ей',
						self::PREDLOJ => $this->choosePrepositionByFirstLetter($prefix, 'об', 'о').' '.$prefix.'е',
					);
				}
			} else if (slice($name, -1) == 'ь' && self::isConsonant(slice($name, -2, -1))) {
				$prefix = name(slice($name, 0, -1));
				return array(
					self::IMENIT => $prefix.'ь',
					self::RODIT => $prefix.'и',
					self::DAT => $prefix.'и',
					self::VINIT => $prefix.'ь',
					self::TVORIT => $prefix.'ью',
					self::PREDLOJ => $this->choosePrepositionByFirstLetter($prefix, 'об', 'о').' '.$prefix.'и',
				);
			} else if (RussianLanguage::isHissingConsonant(slice($name, -1))) {
				$prefix = name($name);
				return array(
					self::IMENIT => $prefix,
					self::RODIT => $prefix.'и',
					self::DAT => $prefix.'и',
					self::VINIT => $prefix,
					self::TVORIT => $prefix.'ью',
					self::PREDLOJ => $this->choosePrepositionByFirstLetter($prefix, 'об', 'о').' '.$prefix.'и',
				);
			}
		}

		// common rules for ия and я
		if (slice($name, -1) == 'я' && slice($name, -2, -1) != 'и') {
			$prefix = name(slice($name, 0, -1));
			return array(
				self::IMENIT => $prefix.'я',
				self::RODIT => $prefix.'и',
				self::DAT => $prefix.'е',
				self::VINIT => $prefix.'ю',
				self::TVORIT => $prefix.'ей',
				self::PREDLOJ => $this->choosePrepositionByFirstLetter($prefix, 'об', 'о').' '.$prefix.'е',
			);
		} else if (slice($name, -2) == 'ия') {
			$prefix = name(slice($name, 0, -1));
			return array(
				self::IMENIT => $prefix.'я',
				self::RODIT => $prefix.'и',
				self::DAT => $prefix.'и',
				self::VINIT => $prefix.'ю',
				self::TVORIT => $prefix.'ей',
				self::PREDLOJ => $this->choosePrepositionByFirstLetter($prefix, 'об', 'о').' '.$prefix.'и',
			);
		}

		$name = name($name);
        return array_fill_keys(array(self::IMENIT, self::RODIT, self::DAT, self::VINIT, self::TVORIT), $name) + array(self::PREDLOJ => $this->choosePrepositionByFirstLetter($name, 'об', 'о').' '.$name);
	}

	public function getCase($name, $case, $gender) {
		$case = self::canonizeCase($case);
		$forms = $this->getCases($name, $gender);
		if ($forms !== false)
			if (isset($forms[$case]))
				return $forms[$case];
			else
				return $name;
		else
			return $name;
	}
}
