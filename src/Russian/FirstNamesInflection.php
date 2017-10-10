<?php
namespace morphos\Russian;

use morphos\S;

/**
 * Rules are from: http://www.imena.org/decl_mn.html
 * and http://www.imena.org/decl_fn.html
 */
class FirstNamesInflection extends \morphos\NamesInflection implements Cases
{
    use RussianLanguage, CasesHelper;

    protected static $exceptions = array(
        'лев' => array(
            self::IMENIT => 'Лев',
            self::RODIT => 'Льва',
            self::DAT => 'Льву',
            self::VINIT => 'Льва',
            self::TVORIT => 'Львом',
            self::PREDLOJ => 'Льве',
        ),
        'павел' => array(
            self::IMENIT => 'Павел',
            self::RODIT => 'Павла',
            self::DAT => 'Павлу',
            self::VINIT => 'Павла',
            self::TVORIT => 'Павлом',
            self::PREDLOJ => 'Павле',
        )
    );

    protected static $menNames = array(
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
        'виген',
        'вилен',
        'виталий',
        'владилен',
        'владимир',
        'владислав',
        'владлен',
        'вова',
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

    protected static $womenNames = array(
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

    public static function isMutable($name, $gender = null)
    {
        //var_dump(S::upper(S::slice($name, -1)));
        $name = S::lower($name);
        if ($gender === null) {
            $gender = self::detectGender($name);
        }
        // man rules
        if ($gender === self::MALE) {
            // soft consonant
            if (S::lower(S::slice($name, -1)) == 'ь' && self::isConsonant(S::slice($name, -2, -1))) {
                return true;
            } elseif (in_array(S::slice($name, -1), array_diff(self::$consonants, array('й', /*'Ч', 'Щ'*/)))) { // hard consonant
                return true;
            } elseif (S::slice($name, -1) == 'й') {
                return true;
            }
        }

        // common rules
        if ((in_array(S::slice($name, -1), array('а', 'я')) && !self::isVowel(S::slice($name, -2, -1))) || in_array(S::slice($name, -2), array('ия', 'ья', 'ея'))) {
            return true;
        }

        return false;
    }

    public static function detectGender($name)
    {
        $name = S::lower($name);
        if (in_array($name, self::$menNames)) {
            return self::MALE;
        } elseif (in_array($name, self::$womenNames)) {
            return self::FEMALE;
        }

        $man = $woman = 0;
        $last1 = S::slice($name, -1);
        $last2 = S::slice($name, -2);
        $last3 = S::slice($name, -3);

        // try to detect gender by some statistical rules
        //
        if ($last1 == 'й') {
            $man += 0.9;
        }
        if ($last1 == 'ь') {
            $man += 0.02;
        }
        if (in_array($last1, self::$consonants)) {
            $man += 0.01;
        }
        if (in_array($last2, array('он', 'ов', 'ав', 'ам', 'ол', 'ан', 'рд', 'мп'))) {
            $man += 0.3;
        }
        if (in_array($last2, array('вь', 'фь', 'ль'))) {
            $woman += 0.1;
        }
        if (in_array($last2, array('ла'))) {
            $woman += 0.04;
        }
        if (in_array($last2, array('то', 'ма'))) {
            $man += 0.01;
        }
        if (in_array($last3, array('лья', 'вва', 'ока', 'ука', 'ита'))) {
            $man += 0.2;
        }
        if (in_array($last3, array('има'))) {
            $woman += 0.15;
        }
        if (in_array($last3, array('лия', 'ния', 'сия', 'дра', 'лла', 'кла', 'опа'))) {
            $woman += 0.5;
        }
        if (in_array(S::slice($name, -4), array('льда', 'фира', 'нина', 'лита', 'алья'))) {
            $woman += 0.5;
        }

        return $man == $woman ? null
            : ($man > $woman ? self::MALE : self::FEMALE);
    }

    public static function getCases($name, $gender = null)
    {
        $name = S::lower($name);

        // common rules for ия and я
        if (S::slice($name, -2) == 'ия') {
            $prefix = S::name(S::slice($name, 0, -1));
            return array(
                self::IMENIT => $prefix.'я',
                self::RODIT => $prefix.'и',
                self::DAT => $prefix.'и',
                self::VINIT => $prefix.'ю',
                self::TVORIT => $prefix.'ей',
                self::PREDLOJ => $prefix.'и',
            );
        } elseif (S::slice($name, -1) == 'я') {
            $prefix = S::name(S::slice($name, 0, -1));
            return array(
                self::IMENIT => $prefix.'я',
                self::RODIT => $prefix.'и',
                self::DAT => $prefix.'е',
                self::VINIT => $prefix.'ю',
                self::TVORIT => $prefix.'ей',
                self::PREDLOJ => $prefix.'е',
            );
        }

        if ($gender === null) {
            $gender = self::detectGender($name);
        }
        if ($gender == self::MALE) {
            if (($result = self::getCasesMan($name)) !== null) {
                return $result;
            }
        } elseif ($gender == self::FEMALE) {
            if (($result = self::getCasesWoman($name)) !== null) {
                return $result;
            }
        }

        $name = S::name($name);
        return array_fill_keys(array(self::IMENIT, self::RODIT, self::DAT, self::VINIT, self::TVORIT, self::PREDLOJ), $name);
    }

    protected static function getCasesMan($name)
    {
        // special cases for Лев, Павел
        if (isset(self::$exceptions[$name])) {
            return self::$exceptions[$name];
        } elseif (in_array(S::slice($name, -1), array_diff(self::$consonants, array('й', /*'Ч', 'Щ'*/)))) { // hard consonant
			if (in_array(S::slice($name, -2), ['ек', 'ёк'])) { // Витек, Санек
                // case for foreign names like Салмонбек
                if (self::isConsonant(S::slice($name, -4, -3)))
                    $prefix = S::name(S::slice($name, 0, -2)).'ек';
                else
				    $prefix = S::name(S::slice($name, 0, -2)).'ьк';
			} else
				$prefix = S::name($name);
            return array(
                self::IMENIT => S::name($name),
                self::RODIT => $prefix.'а',
                self::DAT => $prefix.'у',
                self::VINIT => $prefix.'а',
                self::TVORIT => RussianLanguage::isHissingConsonant(S::slice($name, -1)) || S::slice($name, -1) == 'ц' ? $prefix.'ем' : $prefix.'ом',
                self::PREDLOJ => $prefix.'е',
            );
        } elseif (S::slice($name, -1) == 'ь' && self::isConsonant(S::slice($name, -2, -1))) { // soft consonant
            $prefix = S::name(S::slice($name, 0, -1));
            return array(
                self::IMENIT => $prefix.'ь',
                self::RODIT => $prefix.'я',
                self::DAT => $prefix.'ю',
                self::VINIT => $prefix.'я',
                self::TVORIT => $prefix.'ем',
                self::PREDLOJ => $prefix.'е',
            );
        } elseif (in_array(S::slice($name, -2), array('ай', 'ей', 'ой', 'уй', 'яй', 'юй', 'ий'))) {
            $prefix = S::name(S::slice($name, 0, -1));
            $postfix = S::slice($name, -2) == 'ий' ? 'и' : 'е';
            return array(
                self::IMENIT => $prefix.'й',
                self::RODIT => $prefix.'я',
                self::DAT => $prefix.'ю',
                self::VINIT => $prefix.'я',
                self::TVORIT => $prefix.'ем',
                self::PREDLOJ => $prefix.$postfix,
            );
        } elseif (S::slice($name, -1) == 'а' && self::isConsonant($before = S::slice($name, -2, -1)) && !in_array($before, array(/*'г', 'к', 'х', */'ц'))) {
            $prefix = S::name(S::slice($name, 0, -1));
            $postfix = (RussianLanguage::isHissingConsonant($before) || in_array($before, array('г', 'к', 'х'))) ? 'и' : 'ы';
            return array(
                self::IMENIT => $prefix.'а',
                self::RODIT => $prefix.$postfix,
                self::DAT => $prefix.'е',
                self::VINIT => $prefix.'у',
                self::TVORIT => $prefix.'ой',
                self::PREDLOJ => $prefix.'е',
            );
        } elseif (S::slice($name, -2) == 'ло' || S::slice($name, -2) == 'ко') {
            $prefix = S::name(S::slice($name, 0, -1));
            $postfix = S::slice($name, -2, -1) == 'к' ? 'и' : 'ы';
            return array(
                self::IMENIT => $prefix.'о',
                self::RODIT =>  $prefix.$postfix,
                self::DAT => $prefix.'е',
                self::VINIT => $prefix.'у',
                self::TVORIT => $prefix.'ой',
                self::PREDLOJ => $prefix.'е',
            );
        }

        return null;
    }

    protected static function getCasesWoman($name)
    {
        if (S::slice($name, -1) == 'а' && !self::isVowel($before = (S::slice($name, -2, -1)))) {
            $prefix = S::name(S::slice($name, 0, -1));
            if ($before != 'ц') {
                $postfix = (RussianLanguage::isHissingConsonant($before) || in_array($before, array('г', 'к', 'х'))) ? 'и' : 'ы';
                return array(
                    self::IMENIT => $prefix.'а',
                    self::RODIT => $prefix.$postfix,
                    self::DAT => $prefix.'е',
                    self::VINIT => $prefix.'у',
                    self::TVORIT => $prefix.'ой',
                    self::PREDLOJ => $prefix.'е',
                );
            } else {
                return array(
                    self::IMENIT => $prefix.'а',
                    self::RODIT => $prefix.'ы',
                    self::DAT => $prefix.'е',
                    self::VINIT => $prefix.'у',
                    self::TVORIT => $prefix.'ей',
                    self::PREDLOJ => $prefix.'е',
                );
            }
        } elseif (S::slice($name, -1) == 'ь' && self::isConsonant(S::slice($name, -2, -1))) {
            $prefix = S::name(S::slice($name, 0, -1));
            return array(
                self::IMENIT => $prefix.'ь',
                self::RODIT => $prefix.'и',
                self::DAT => $prefix.'и',
                self::VINIT => $prefix.'ь',
                self::TVORIT => $prefix.'ью',
                self::PREDLOJ => $prefix.'и',
            );
        } elseif (RussianLanguage::isHissingConsonant(S::slice($name, -1))) {
            $prefix = S::name($name);
            return array(
                self::IMENIT => $prefix,
                self::RODIT => $prefix.'и',
                self::DAT => $prefix.'и',
                self::VINIT => $prefix,
                self::TVORIT => $prefix.'ью',
                self::PREDLOJ => $prefix.'и',
            );
        }
        return null;
    }

    public static function getCase($name, $case, $gender = null)
    {
        $case = self::canonizeCase($case);
        $forms = self::getCases($name, $gender);
        return $forms[$case];
    }
}
