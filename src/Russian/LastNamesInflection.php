<?php

namespace morphos\Russian;

use morphos\S;

/**
 * Rules are from http://gramma.ru/SPR/?id=2.8
 */
class LastNamesInflection extends \morphos\NamesInflection implements Cases
{
    /** @var string[] */
    protected static $womenPostfixes = ['ва', 'на', 'ая', 'яя'];
    /** @var string[] */
    protected static $menPostfixes = ['ов', 'ев', 'ин', 'ын', 'ой', 'ий', 'ый', 'ич'];

    /**
     * @param string $name
     * @param string $case
     * @param null $gender
     * @return string
     * @throws \Exception
     */
    public static function getCase($name, $case, $gender = null)
    {
        if (!static::isMutable($name, $gender)) {
            return $name;
        } else {
            $case  = RussianCasesHelper::canonizeCase($case);
            $forms = static::getCases($name, $gender);
            return $forms[$case];
        }
    }

    /**
     * @param string $name
     * @param string|null $gender
     * @return bool
     */
    public static function isMutable($name, $gender = null)
    {
        if (S::length($name) === 1) {
            return false;
        }

        $name = S::lower($name);

        if ($gender === null) {
            $gender = static::detectGender($name);
        }
        // составная фамилия - разбить на части и проверить по отдельности
        if (strpos($name, '-') !== false) {
            foreach (explode('-', $name) as $part) {
                if (static::isMutable($part, $gender)) {
                    return true;
                }
            }
            return false;
        }

        if (in_array(S::slice($name, -1), ['а', 'я'], true)) {
            return true;
        }

        // Несклоняемые фамилии независимо от пола (Токаревских)
        if (in_array(S::slice($name, -2), ['их'], true)) {
            return false;
        }

        if ($gender == static::MALE) {
            // Несклоняемые фамилии (Фоминых, Седых / Стецко, Писаренко)
            if (in_array(S::slice($name, -2), ['ых', 'ко'], true)) {
                return false;
            }

            // Несклоняемые, образованные из родительного падежа личного или прозвищного имени главы семьи
            // суффиксы: ово, аго
            if (in_array(S::slice($name, -3), ['ово', 'аго'], true)) {
                return false;
            }

            // Типичные суффикс мужских фамилий
            if (in_array(S::slice($name, -2), ['ов', 'ев', 'ин', 'ын', 'ий', 'ой'], true)) {
                return true;
            }

            // Согласная на конце
            if (RussianLanguage::isConsonant(S::slice($name, -1))) {
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
     * @param string $name
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
     * @param string $name
     * @param null|string $gender
     * @return string[]
     * @phpstan-return array<string, string>
     * @throws \Exception
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

            return RussianCasesHelper::composeCasesFromWords($parts, '-');
        }

        if (static::isMutable($name, $gender)) {
            if ($gender == static::MALE) {
                if (in_array(S::slice($name, -2), ['ов', 'ев', 'ин', 'ын', 'ёв'], true)) {
                    $prefix = S::name($name);
                    return [
                        static::IMENIT  => $prefix,
                        static::RODIT   => $prefix . 'а',
                        static::DAT     => $prefix . 'у',
                        static::VINIT   => $prefix . 'а',
                        static::TVORIT  => $prefix . 'ым',
                        static::PREDLOJ => $prefix . 'е',
                    ];
                }

                if (in_array(S::slice($name, -4), ['ский', 'ской', 'цкий', 'цкой'], true)) {
                    $prefix = S::name(S::slice($name, 0, -2));
                    return [
                        static::IMENIT  => S::name($name),
                        static::RODIT   => $prefix . 'ого',
                        static::DAT     => $prefix . 'ому',
                        static::VINIT   => $prefix . 'ого',
                        static::TVORIT  => $prefix . 'им',
                        static::PREDLOJ => $prefix . 'ом',
                    ];
                }

                // Толстой / Цой / Лукелий
                // Толстого / Цоя / Лукелия
                // Толстому / Цою / Лукелию
                // Толстым / Цоя / Лукелия
                // о Толстом / Цоем / Лукелием
                // о Толстом / о Цое / о Лукелие
                // similar to next if
                if (in_array(S::slice($name, -2), ['ой', 'ый', 'ий'], true)) {
                    $last_consonant = S::slice($name, -3, -2);
                    $last_sonority = (RussianLanguage::isSonorousConsonant($last_consonant) &&
                            in_array($last_consonant, ['н', 'в'], true) === false) || $last_consonant === 'ц';

                    if ($last_sonority) {
                        $prefix = S::name(S::slice($name, 0, -1));
                        return [
                            static::IMENIT  => S::name($name),
                            static::RODIT   => $prefix . 'я',
                            static::DAT     => $prefix . 'ю',
                            static::VINIT   => $prefix . 'я',
                            static::TVORIT  => $prefix . 'ем',
                            static::PREDLOJ => $prefix . (in_array(S::slice($name, -2), ['ой', 'ей']) ? 'е' : 'и'),
                        ];
                    } else {
                        $prefix = S::name(S::slice($name, 0, -2));
                        return [
                            static::IMENIT  => S::name($name),
                            static::RODIT   => $prefix .  'ого',
                            static::DAT     => $prefix . 'ому',
                            static::VINIT   => $prefix . 'ого',
                            static::TVORIT  => $prefix . 'ым',
                            static::PREDLOJ => $prefix . 'ом',
                        ];
                    }
                }

                if (in_array(S::slice($name, -2), ['ей', 'ай'], true)) {
                    $prefix = S::name(S::slice($name, 0, -1));
                    return [
                        static::IMENIT  => S::name($name),
                        static::RODIT   => $prefix . 'я',
                        static::DAT     => $prefix . 'ю',
                        static::VINIT   => $prefix . 'я',
                        static::TVORIT  => $prefix . 'ем',
                        static::PREDLOJ => $prefix . 'е',
                    ];
                }

                if (S::length($name) > 3 && in_array(S::slice($name, -2), ['ок'], true)) {
                    $prefix = S::name(S::slice($name, 0, -2)) . S::slice($name, -1);

                    return [
                        static::IMENIT => S::name($name),
                        static::RODIT => $prefix . 'а',
                        static::DAT => $prefix . 'у',
                        static::VINIT => $prefix . 'а',
                        static::TVORIT => $prefix . 'ом',
                        static::PREDLOJ => $prefix . 'е',
                    ];
                }

                if (S::length($name) > 3 && in_array(S::slice($name, -2), ['ек', 'ец'], true)) {
                    $last_consonant = S::slice($name, -3, -2);
                    if (in_array($last_consonant, ['л'])) {
                        $prefix = S::name(S::slice($name, 0, -2)) . 'ь' . S::slice($name, -1);
                    } else {
                        $prefix = S::name(S::slice($name, 0, -2)) . S::slice($name, -1);
                    }

                    return [
                        static::IMENIT => S::name($name),
                        static::RODIT => $prefix . 'а',
                        static::DAT => $prefix . 'у',
                        static::VINIT => $prefix . 'а',
                        static::TVORIT => $prefix . 'ом',
                        static::PREDLOJ => $prefix . 'е',
                    ];
                }

            } else {
                if (in_array(S::slice($name, -3), ['ова', 'ева', 'ина', 'ына', 'ёва'], true)) {
                    $prefix = S::name(S::slice($name, 0, -1));
                    return [
                        static::IMENIT  => S::name($name),
                        static::RODIT   => $prefix . 'ой',
                        static::DAT     => $prefix . 'ой',
                        static::VINIT   => $prefix . 'у',
                        static::TVORIT  => $prefix . 'ой',
                        static::PREDLOJ => $prefix . 'ой',
                    ];
                }

                if (in_array(S::slice($name, -2), ['ая'], true)) {
                    $prefix = S::name(S::slice($name, 0, -2));
                    return [
                        static::IMENIT  => S::name($name),
                        static::RODIT   => $prefix . 'ой',
                        static::DAT     => $prefix . 'ой',
                        static::VINIT   => $prefix . 'ую',
                        static::TVORIT  => $prefix . 'ой',
                        static::PREDLOJ => $prefix . 'ой',
                    ];
                }

                if (in_array(S::slice($name, -2), ['яя'], true)) {
                    $prefix = S::name(S::slice($name, 0, -2));
                    return [
                        static::IMENIT  => S::name($name),
                        static::RODIT   => $prefix . 'ей',
                        static::DAT     => $prefix . 'ей',
                        static::VINIT   => $prefix . 'юю',
                        static::TVORIT  => $prefix . 'ей',
                        static::PREDLOJ => $prefix . 'ей',
                    ];
                }
            }

            if (S::slice($name, -1) == 'я') {
                $prefix = S::name(S::slice($name, 0, -1));
                return [
                    static::IMENIT  => S::name($name),
                    static::RODIT   => $prefix . 'и',
                    static::DAT     => $prefix . 'е',
                    static::VINIT   => $prefix . 'ю',
                    static::TVORIT  => $prefix . 'ей',
                    static::PREDLOJ => $prefix . 'е',
                ];
            }

            if (S::slice($name, -1) == 'а') {
                $prefix = S::name(S::slice($name, 0, -1));
                return [
                    static::IMENIT  => S::name($name),
                    static::RODIT   => $prefix . ((RussianLanguage::isDeafConsonant(S::slice($name, -2,
                                -1)) && S::slice($name, -2, -1) !== 'п')
                        || S::slice($name, -2) === 'га' ? 'и' : 'ы'),
                    static::DAT     => $prefix . 'е',
                    static::VINIT   => $prefix . 'у',
                    static::TVORIT  => $prefix . 'ой',
                    static::PREDLOJ => $prefix . 'е',
                ];
            }

            if (RussianLanguage::isConsonant(S::slice($name, -1)) && S::slice($name, -2) !== 'ых') {
                $prefix = S::name($name);
                return [
                    static::IMENIT  => S::name($name),
                    static::RODIT   => $prefix . 'а',
                    static::DAT     => $prefix . 'у',
                    static::VINIT   => $prefix . 'а',
                    static::TVORIT  => $prefix . 'ом',
                    static::PREDLOJ => $prefix . 'е',
                ];
            }

            if (S::slice($name, -1) == 'ь' && $gender == static::MALE) {
                $prefix = S::name(S::slice($name, 0, -1));
                return [
                    static::IMENIT  => S::name($name),
                    static::RODIT   => $prefix . 'я',
                    static::DAT     => $prefix . 'ю',
                    static::VINIT   => $prefix . 'я',
                    static::TVORIT  => $prefix . 'ем',
                    static::PREDLOJ => $prefix . 'е',
                ];
            }
        }

        $name = S::name($name);
        return array_fill_keys([
            static::IMENIT,
            static::RODIT,
            static::DAT,
            static::VINIT,
            static::TVORIT,
            static::PREDLOJ,
        ], $name);
    }
}
