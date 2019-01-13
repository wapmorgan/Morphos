<?php
namespace morphos\Russian;

use morphos\S;

/**
 * Rules are from http://gramma.ru/SPR/?id=2.8
 */
class LastNamesInflection extends \morphos\NamesInflection implements Cases
{
    use RussianLanguage, CasesHelper;

    protected static $menPostfixes = ['ов', 'ев' ,'ин' ,'ын', 'ой', 'ий'];
    protected static $womenPostfixes = ['ва', 'на', 'ая', 'яя'];

    /**
     * @param $name
     * @param null $gender
     * @return bool
     */
    public static function isMutable($name, $gender = null)
    {
        $name = S::lower($name);
        if ($gender === null) {
            $gender = static::detectGender($name);
        }
        // составная фамилия - разбить на части и проверить по отдельности
        if (strpos($name, '-') !== false) {
            foreach (explode('-', $name) as $part) {
                if (static::isMutable($part, $gender))
                    return true;
            }
            return false;
        }

        if (in_array(S::slice($name, -1), ['а', 'я'], true)) {
            return true;
        }

        if ($gender == static::MALE) {
            // Несклоняемые фамилии (Фоминых, Седых / Стецко, Писаренко)
            if (in_array(S::slice($name, -2), ['ых', 'ко'], true))
                return false;

            // Несклоняемые, образованные из родительного падежа личного или прозвищного имени главы семьи
            // суффиксы: ово, аго
            if (in_array(S::slice($name, -3), ['ово', 'аго'], true))
                return false;

            // Типичные суффикс мужских фамилий
            if (in_array(S::slice($name, -2), ['ов', 'ев', 'ин', 'ын', 'ий', 'ой'], true)) {
                return true;
            }

            // Согласная на конце
            if (static::isConsonant(S::slice($name, -1))) {
                return true;
            }

            // Мягкий знак на конце
            if (S::slice($name, -1) == 'ь') {
                return true;
            }

        } else {
            // Типичные суффиксы женских фамилий
            if (in_array(S::slice($name, -2), ['ва', 'на', 'ая'], true)) {
                return true;
            }
        }

        return false;
    }

    /**
     * @param $name
     * @return null|string
     */
    public static function detectGender($name)
    {
        $name = S::lower($name);
        if (in_array(S::slice($name, -2), static::$menPostfixes, true)) {
            return static::MALE;
        }
        if (in_array(S::slice($name, -2), static::$womenPostfixes, true)) {
            return static::FEMALE;
        }

        return null;
    }

    /**
     * @param $name
     * @param null|string $gender
     * @return array
     */
    public static function getCases($name, $gender = null)
    {
        $name = S::lower($name);
        if ($gender === null) {
            $gender = static::detectGender($name);
        }

        // составная фамилия - разбить на части и склонять по отдельности
        if (strpos($name, '-') !== false) {
            $parts = explode('-', $name);
            $cases = [];
            foreach ($parts as $i => $part) {
                $parts[$i] = static::getCases($part, $gender);
            }

            return static::composeCasesFromWords($parts, '-');
        }

        if (static::isMutable($name, $gender)) {
            if ($gender == static::MALE) {
                if (in_array(S::slice($name, -2), ['ов', 'ев', 'ин', 'ын'], true)) {
                    $prefix = S::name($name);
                    return [
                        static::IMENIT => $prefix,
                        static::RODIT => $prefix.'а',
                        static::DAT => $prefix.'у',
                        static::VINIT => $prefix.'а',
                        static::TVORIT => $prefix.'ым',
                        static::PREDLOJ => $prefix.'е'
                    ];
                } elseif (in_array(S::slice($name, -4), ['ский', 'ской', 'цкий', 'цкой'], true)) {
                    $prefix = S::name(S::slice($name, 0, -2));
                    return [
                        static::IMENIT => S::name($name),
                        static::RODIT => $prefix.'ого',
                        static::DAT => $prefix.'ому',
                        static::VINIT => $prefix.'ого',
                        static::TVORIT => $prefix.'им',
                        static::PREDLOJ => $prefix.'ом'
                    ];
                // Верхний / Убогий / Толстой
                // Верхнего / Убогого / Толстого
                // Верхнему / Убогому / Толстому
                // Верхним / Убогим / Толстым
                // О Верхнем / Об Убогом / О Толстом
                } else if (in_array(S::slice($name, -2), ['ой', 'ый', 'ий'], true)) {
                    $prefix = S::name(S::slice($name, 0, -2));
                    return [
                        static::IMENIT => S::name($name),
                        static::RODIT => $prefix.'ого',
                        static::DAT => $prefix.'ому',
                        static::VINIT => $prefix.'ого',
                        static::TVORIT => $prefix.'ым',
                        static::PREDLOJ => $prefix.'ом'
                    ];
                }

            } else {
                if (in_array(S::slice($name, -3), ['ова', 'ева', 'ина', 'ына'], true)) {
                    $prefix = S::name(S::slice($name, 0, -1));
                    return [
                        static::IMENIT => S::name($name),
                        static::RODIT => $prefix.'ой',
                        static::DAT => $prefix.'ой',
                        static::VINIT => $prefix.'у',
                        static::TVORIT => $prefix.'ой',
                        static::PREDLOJ => $prefix.'ой'
                    ];
                }

                if (in_array(S::slice($name, -2), ['ая'], true)) {
                    $prefix = S::name(S::slice($name, 0, -2));
                    return [
                        static::IMENIT => S::name($name),
                        static::RODIT => $prefix.'ой',
                        static::DAT => $prefix.'ой',
                        static::VINIT => $prefix.'ую',
                        static::TVORIT => $prefix.'ой',
                        static::PREDLOJ => $prefix.'ой'
                    ];
                }
            }

            if (S::slice($name, -1) == 'я') {
                $prefix = S::name(S::slice($name, 0, -1));
                return [
                    static::IMENIT => S::name($name),
                    static::RODIT => $prefix.'и',
                    static::DAT => $prefix.'е',
                    static::VINIT => $prefix.'ю',
                    static::TVORIT => $prefix.'ей',
                    static::PREDLOJ => $prefix.'е'
                ];
            } elseif (S::slice($name, -1) == 'а') {
                $prefix = S::name(S::slice($name, 0, -1));
                return [
                    static::IMENIT => S::name($name),
                    static::RODIT => $prefix.(static::isDeafConsonant(S::slice($name, -2, -1)) ? 'и' : 'ы'),
                    static::DAT => $prefix.'е',
                    static::VINIT => $prefix.'у',
                    static::TVORIT => $prefix.'ой',
                    static::PREDLOJ => $prefix.'е'
                ];
            } elseif (static::isConsonant(S::slice($name, -1)) && S::slice($name, -2) != 'ых') {
                $prefix = S::name($name);
                return [
                    static::IMENIT => S::name($name),
                    static::RODIT => $prefix.'а',
                    static::DAT => $prefix.'у',
                    static::VINIT => $prefix.'а',
                    static::TVORIT => $prefix.'ом',
                    static::PREDLOJ => $prefix.'е'
                ];
            } elseif (S::slice($name, -1) == 'ь' && $gender == static::MALE) {
                $prefix = S::name(S::slice($name, 0, -1));
                return [
                    static::IMENIT => S::name($name),
                    static::RODIT => $prefix.'я',
                    static::DAT => $prefix.'ю',
                    static::VINIT => $prefix.'я',
                    static::TVORIT => $prefix.'ем',
                    static::PREDLOJ => $prefix.'е'
                ];
            }
        }

        $name = S::name($name);
        return array_fill_keys([static::IMENIT, static::RODIT, static::DAT, static::VINIT, static::TVORIT, static::PREDLOJ], $name);
    }

    /**
     * @param $name
     * @param $case
     * @param null $gender
     * @return string
     * @throws \Exception
     */
    public static function getCase($name, $case, $gender = null)
    {
        if (!static::isMutable($name, $gender)) {
            return $name;
        } else {
            $case = static::canonizeCase($case);
            $forms = static::getCases($name, $gender);
            return $forms[$case];
        }
    }
}
