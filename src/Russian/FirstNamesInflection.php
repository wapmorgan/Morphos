<?php
namespace morphos\Russian;

use morphos\S;

/**
 * Rules are from: http://www.imena.org/decl_mn.html / http://www.imena.org/decl_fn.html
 * and http://rus.omgpu.ru/2016/04/18/%D1%81%D0%BA%D0%BB%D0%BE%D0%BD%D0%B5%D0%BD%D0%B8%D0%B5-%D0%BB%D0%B8%D1%87%D0%BD%D1%8B%D1%85-%D0%B8%D0%BC%D1%91%D0%BD/
 */
class FirstNamesInflection extends \morphos\NamesInflection implements Cases
{
    use RussianLanguage, CasesHelper;

    protected static $exceptions = [
        'лев' => [
            self::IMENIT => 'Лев',
            self::RODIT => 'Льва',
            self::DAT => 'Льву',
            self::VINIT => 'Льва',
            self::TVORIT => 'Львом',
            self::PREDLOJ => 'Льве',
        ],
        'павел' => [
            self::IMENIT => 'Павел',
            self::RODIT => 'Павла',
            self::DAT => 'Павлу',
            self::VINIT => 'Павла',
            self::TVORIT => 'Павлом',
            self::PREDLOJ => 'Павле',
        ]
    ];

    protected static $menNames = [
        'абрам', 'аверьян', 'авраам', 'агафон', 'адам', 'азар', 'акакий', 'аким', 'аксён', 'александр', 'алексей',
        'альберт', 'анатолий', 'андрей', 'андрон', 'антип', 'антон', 'аполлон', 'аристарх', 'аркадий', 'арнольд',
        'арсений', 'арсентий', 'артем', 'артём', 'артемий', 'артур', 'аскольд', 'афанасий', 'богдан', 'борис',
        'борислав', 'бронислав', 'вадим', 'валентин', 'валерий', 'варлам', 'василий', 'венедикт', 'вениамин',
        'веньямин', 'венцеслав', 'виктор', 'виген', 'вилен', 'виталий', 'владилен', 'владимир', 'владислав', 'владлен',
        'вова', 'всеволод', 'всеслав', 'вячеслав', 'гавриил', 'геннадий', 'георгий', 'герман', 'глеб', 'григорий',
        'давид', 'даниил', 'данил', 'данила', 'демьян', 'денис', 'димитрий', 'дмитрий', 'добрыня', 'евгений', 'евдоким',
        'евсей', 'егор', 'емельян', 'еремей', 'ермолай', 'ерофей', 'ефим', 'захар', 'иван', 'игнат', 'игорь',
        'илларион', 'иларион', 'илья', 'иосиф', 'казимир', 'касьян', 'кирилл', 'кондрат', 'константин', 'кузьма',
        'лавр', 'лаврентий', 'лазарь', 'ларион', 'лев', 'леонард', 'леонид', 'лука', 'максим', 'марат', 'мартын',
        'матвей', 'мефодий', 'мирон', 'михаил', 'моисей', 'назар', 'никита', 'николай', 'олег', 'осип', 'остап',
        'павел', 'панкрат', 'пантелей', 'парамон', 'пётр', 'петр', 'платон', 'потап', 'прохор', 'роберт', 'ростислав',
        'савва', 'савелий', 'семён', 'семен', 'сергей', 'сидор', 'спартак', 'тарас', 'терентий', 'тимофей', 'тимур',
        'тихон', 'ульян', 'фёдор', 'федор', 'федот', 'феликс', 'фирс', 'фома', 'харитон', 'харлам', 'эдуард',
        'эммануил', 'эраст', 'юлиан', 'юлий', 'юрий', 'яков', 'ян', 'ярослав',
    ];

    protected static $womenNames = [
        'авдотья', 'аврора', 'агата', 'агния', 'агриппина', 'ада', 'аксинья', 'алевтина', 'александра', 'алёна',
        'алена', 'алина', 'алиса', 'алла', 'альбина', 'амалия', 'анастасия', 'ангелина', 'анжела', 'анжелика', 'анна',
        'антонина', 'анфиса', 'арина', 'белла', 'божена', 'валентина', 'валерия', 'ванда', 'варвара', 'василина',
        'василиса', 'вера', 'вероника', 'виктория', 'виола', 'виолетта', 'вита', 'виталия', 'владислава', 'власта',
        'галина', 'глафира', 'дарья', 'диана', 'дина', 'ева', 'евгения', 'евдокия', 'евлампия', 'екатерина', 'елена',
        'елизавета', 'ефросиния', 'ефросинья', 'жанна', 'зиновия', 'злата', 'зоя', 'ивонна', 'изольда', 'илона', 'инга',
        'инесса', 'инна', 'ирина', 'ия', 'капитолина', 'карина', 'каролина', 'кира', 'клавдия', 'клара', 'клеопатра',
        'кристина', 'ксения', 'лада', 'лариса', 'лиана', 'лидия', 'лилия', 'лина', 'лия', 'лора', 'любава', 'любовь',
        'людмила', 'майя', 'маргарита', 'марианна', 'мариетта', 'марина', 'мария', 'марья', 'марта', 'марфа', 'марьяна',
        'матрёна', 'матрена', 'матрона', 'милена', 'милослава', 'мирослава', 'муза', 'надежда', 'настасия', 'настасья',
        'наталия', 'наталья', 'нелли', 'ника', 'нина', 'нинель', 'нонна', 'оксана', 'олимпиада', 'ольга', 'пелагея',
        'полина', 'прасковья', 'раиса', 'рената', 'римма', 'роза', 'роксана', 'руфь', 'сарра', 'светлана', 'серафима',
        'снежана', 'софья', 'софия', 'стелла', 'степанида', 'стефания', 'таисия', 'таисья', 'тамара', 'татьяна',
        'ульяна', 'устиния', 'устинья', 'фаина', 'фёкла', 'фекла', 'феодора', 'хаврония', 'христина', 'эвелина',
        'эдита', 'элеонора', 'элла', 'эльвира', 'эмилия', 'эмма', 'юдифь', 'юлиана', 'юлия', 'ядвига', 'яна',
        'ярослава',
    ];

    protected static $immutableNames = [
        'николя',
    ];

    /**
     * Checks if name is mutable
     * @param string $name
     * @param null|string $gender
     * @return bool
     */
    public static function isMutable($name, $gender = null)
    {
        $name = S::lower($name);

        if (in_array($name, self::$immutableNames, true)) {
            return false;
        }

        if ($gender === null) {
            $gender = self::detectGender($name);
        }

        // man rules
        if ($gender === self::MALE) {
            // soft consonant
            if (S::lower(S::slice($name, -1)) == 'ь' && self::isConsonant(S::slice($name, -2, -1))) {
                return true;
            } elseif (in_array(S::slice($name, -1), array_diff(self::$consonants, ['й', /*'Ч', 'Щ'*/]), true)) { // hard consonant
                return true;
            } elseif (S::slice($name, -1) == 'й') {
                return true;
            } else if (in_array(S::slice($name, -2), ['ло', 'ко'], true)) {
                return true;
            }
        } else if ($gender === self::FEMALE) {
            // soft consonant
            if (S::lower(S::slice($name, -1)) == 'ь' && self::isConsonant(S::slice($name, -2, -1))) {
                return true;
            } else if (self::isHissingConsonant(S::slice($name, -1))) {
                return true;
            }
        }

        // common rules
        if ((in_array(S::slice($name, -1), ['а', 'я']) && !self::isVowel(S::slice($name, -2, -1))) || in_array(S::slice($name, -2), ['ия', 'ья', 'ея', 'оя'], true)) {
            return true;
        }

        return false;
    }

    /**
     * @param $name
     * @return string
     */
    public static function detectGender($name)
    {
        $name = S::lower($name);
        if (in_array($name, self::$menNames, true)) {
            return self::MALE;
        } elseif (in_array($name, self::$womenNames, true)) {
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
        if (in_array($last1, self::$consonants, true)) {
            $man += 0.01;
        }
        if (in_array($last2, ['он', 'ов', 'ав', 'ам', 'ол', 'ан', 'рд', 'мп'], true)) {
            $man += 0.3;
        }
        if (in_array($last2, ['вь', 'фь', 'ль'], true)) {
            $woman += 0.1;
        }
        if (in_array($last2, ['ла'], true)) {
            $woman += 0.04;
        }
        if (in_array($last2, ['то', 'ма'], true)) {
            $man += 0.01;
        }
        if (in_array($last3, ['лья', 'вва', 'ока', 'ука', 'ита'], true)) {
            $man += 0.2;
        }
        if (in_array($last3, ['има'], true)) {
            $woman += 0.15;
        }
        if (in_array($last3, ['лия', 'ния', 'сия', 'дра', 'лла', 'кла', 'опа'], true)) {
            $woman += 0.5;
        }
        if (in_array(S::slice($name, -4), ['льда', 'фира', 'нина', 'лита', 'алья'], true)) {
            $woman += 0.5;
        }

        return $man == $woman ? null
            : ($man > $woman ? self::MALE : self::FEMALE);
    }

    /**
     * @param string $name
     * @param null|string $gender
     * @return array
     */
    public static function getCases($name, $gender = null)
    {
        $name = S::lower($name);

        if (self::isMutable($name, $gender)) {
            // common rules for ия and я
            if (S::slice($name, -2) == 'ия') {
                $prefix = S::name(S::slice($name, 0, -1));
                return [
                    self::IMENIT => $prefix.'я',
                    self::RODIT => $prefix.'и',
                    self::DAT => $prefix.'и',
                    self::VINIT => $prefix.'ю',
                    self::TVORIT => $prefix.'ей',
                    self::PREDLOJ => $prefix.'и',
                ];
            } elseif (S::slice($name, -1) == 'я') {
                $prefix = S::name(S::slice($name, 0, -1));
                return [
                    self::IMENIT => $prefix.'я',
                    self::RODIT => $prefix.'и',
                    self::DAT => $prefix.'е',
                    self::VINIT => $prefix.'ю',
                    self::TVORIT => $prefix.'ей',
                    self::PREDLOJ => $prefix.'е',
                ];
            }

            if (!in_array($name, self::$immutableNames, true)) {
                if ($gender === null) {
                    $gender = self::detectGender($name);
                }
                if ($gender === self::MALE || $name === 'саша') {
                    if (($result = self::getCasesMan($name)) !== null) {
                        return $result;
                    }
                } elseif ($gender === self::FEMALE) {
                    if (($result = self::getCasesWoman($name)) !== null) {
                        return $result;
                    }
                }
            }
        }

        $name = S::name($name);
        return array_fill_keys(array(self::IMENIT, self::RODIT, self::DAT, self::VINIT, self::TVORIT, self::PREDLOJ), $name);
    }

    /**
     * @param string $name
     * @return array|null
     */
    protected static function getCasesMan($name)
    {
        // special cases for Лев, Павел
        if (isset(self::$exceptions[$name])) {
            return self::$exceptions[$name];
        } elseif (in_array(S::slice($name, -1), array_diff(self::$consonants, ['й', /*'Ч', 'Щ'*/]), true)) { // hard consonant
			if (in_array(S::slice($name, -2), ['ек', 'ёк'], true)) { // Витек, Санек
                // case for foreign names like Салмонбек
                if (self::isConsonant(S::slice($name, -4, -3)))
                    $prefix = S::name(S::slice($name, 0, -2)).'ек';
                else
				    $prefix = S::name(S::slice($name, 0, -2)).'ьк';
			} else {
                if ($name === 'пётр')
                    $prefix = S::name(str_replace('ё', 'е', $name));
                else
				    $prefix = S::name($name);
            }
            return [
                self::IMENIT => S::name($name),
                self::RODIT => $prefix.'а',
                self::DAT => $prefix.'у',
                self::VINIT => $prefix.'а',
                self::TVORIT => RussianLanguage::isHissingConsonant(S::slice($name, -1)) || S::slice($name, -1) == 'ц' ? $prefix.'ем' : $prefix.'ом',
                self::PREDLOJ => $prefix.'е',
            ];
        } elseif (S::slice($name, -1) == 'ь' && self::isConsonant(S::slice($name, -2, -1))) { // soft consonant
            $prefix = S::name(S::slice($name, 0, -1));
            return [
                self::IMENIT => $prefix.'ь',
                self::RODIT => $prefix.'я',
                self::DAT => $prefix.'ю',
                self::VINIT => $prefix.'я',
                self::TVORIT => $prefix.'ем',
                self::PREDLOJ => $prefix.'е',
            ];
        } elseif (in_array(S::slice($name, -2), ['ай', 'ей', 'ой', 'уй', 'яй', 'юй', 'ий'], true)) {
            $prefix = S::name(S::slice($name, 0, -1));
            $postfix = S::slice($name, -2) == 'ий' ? 'и' : 'е';
            return [
                self::IMENIT => $prefix.'й',
                self::RODIT => $prefix.'я',
                self::DAT => $prefix.'ю',
                self::VINIT => $prefix.'я',
                self::TVORIT => $prefix.'ем',
                self::PREDLOJ => $prefix.$postfix,
            ];
        } elseif (S::slice($name, -1) == 'а' && self::isConsonant($before = S::slice($name, -2, -1)) && !in_array($before, [/*'г', 'к', 'х', */'ц'], true)) {
            $prefix = S::name(S::slice($name, 0, -1));
            $postfix = (RussianLanguage::isHissingConsonant($before) || in_array($before, ['г', 'к', 'х'], true)) ? 'и' : 'ы';
            return [
                self::IMENIT => $prefix.'а',
                self::RODIT => $prefix.$postfix,
                self::DAT => $prefix.'е',
                self::VINIT => $prefix.'у',
                self::TVORIT => $prefix.($before === 'ш' ? 'е' : 'о').'й',
                self::PREDLOJ => $prefix.'е',
            ];
        } elseif (S::slice($name, -2) == 'ло' || S::slice($name, -2) == 'ко') {
            $prefix = S::name(S::slice($name, 0, -1));
            $postfix = S::slice($name, -2, -1) == 'к' ? 'и' : 'ы';
            return [
                self::IMENIT => $prefix.'о',
                self::RODIT =>  $prefix.$postfix,
                self::DAT => $prefix.'е',
                self::VINIT => $prefix.'у',
                self::TVORIT => $prefix.'ой',
                self::PREDLOJ => $prefix.'е',
            ];
        }

        return null;
    }

    /**
     * @param string $name
     * @return array|null
     */
    protected static function getCasesWoman($name)
    {
        if (S::slice($name, -1) == 'а' && !self::isVowel($before = (S::slice($name, -2, -1)))) {
            $prefix = S::name(S::slice($name, 0, -1));
            if ($before != 'ц') {
                $postfix = (RussianLanguage::isHissingConsonant($before) || in_array($before, ['г', 'к', 'х'], true)) ? 'и' : 'ы';
                return [
                    self::IMENIT => $prefix.'а',
                    self::RODIT => $prefix.$postfix,
                    self::DAT => $prefix.'е',
                    self::VINIT => $prefix.'у',
                    self::TVORIT => $prefix.'ой',
                    self::PREDLOJ => $prefix.'е',
                ];
            } else {
                return [
                    self::IMENIT => $prefix.'а',
                    self::RODIT => $prefix.'ы',
                    self::DAT => $prefix.'е',
                    self::VINIT => $prefix.'у',
                    self::TVORIT => $prefix.'ей',
                    self::PREDLOJ => $prefix.'е',
                ];
            }
        } elseif (S::slice($name, -1) == 'ь' && self::isConsonant(S::slice($name, -2, -1))) {
            $prefix = S::name(S::slice($name, 0, -1));
            return [
                self::IMENIT => $prefix.'ь',
                self::RODIT => $prefix.'и',
                self::DAT => $prefix.'и',
                self::VINIT => $prefix.'ь',
                self::TVORIT => $prefix.'ью',
                self::PREDLOJ => $prefix.'и',
            ];
        } elseif (RussianLanguage::isHissingConsonant(S::slice($name, -1))) {
            $prefix = S::name($name);
            return [
                self::IMENIT => $prefix,
                self::RODIT => $prefix.'и',
                self::DAT => $prefix.'и',
                self::VINIT => $prefix,
                self::TVORIT => $prefix.'ью',
                self::PREDLOJ => $prefix.'и',
            ];
        }
        return null;
    }

    /**
     * @param string $name
     * @param string $case
     * @param null|string $gender
     * @return string
     * @throws \Exception
     */
    public static function getCase($name, $case, $gender = null)
    {
        $case = self::canonizeCase($case);
        $forms = self::getCases($name, $gender);
        return $forms[$case];
    }
}
