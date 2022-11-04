<?php

namespace morphos\Russian;

use morphos\BasePluralization;
use morphos\S;
use RuntimeException;

class AdjectivePluralization extends BasePluralization implements Cases
{
    /**
     * @param string $adjective
     * @param int $count
     * @param bool $animateness
     * @param string|null $case
     *
     * @return string|void
     * @throws \Exception
     */
    public static function pluralize($adjective, $count = 2, $animateness = false, $case = null)
    {
        // меняем местами аргументы, если они переданы в старом формате
        // @phpstan-ignore-next-line
        if (is_string($count) && is_numeric($adjective)) {
            list($count, $adjective) = [$adjective, $count];
        }

        if ($case !== null) {
            $case = RussianCasesHelper::canonizeCase($case);
        }

        if ($case === null) {
            switch (NounPluralization::getNumeralForm($count)) {
                case NounPluralization::ONE:
                    return $adjective;
                case NounPluralization::TWO_FOUR:
//                    return AdjectiveDeclension::getCase($adjective, static::RODIT, $animateness);
                case NounPluralization::FIVE_OTHER:
                    return AdjectivePluralization::getCase($adjective, static::RODIT, $animateness);
            }
        }

        if (NounPluralization::getNumeralForm($count) == NounPluralization::ONE) {
            return AdjectiveDeclension::getCase($adjective, $case, $animateness);
        } else {
            return AdjectivePluralization::getCase($adjective, $case, $animateness);
        }
    }

    /**
     * @param string $adjective
     * @param string $case
     * @param bool $animateness
     *
     * @return string
     * @throws \Exception
     */
    public static function getCase($adjective, $case, $animateness = false)
    {
        $case  = RussianCasesHelper::canonizeCase($case);
        $forms = static::getCases($adjective, $animateness);
        return $forms[$case];
    }

    /**
     * @param string $adjective
     * @param bool $animateness
     *
     * @return string[]
     * @phpstan-return array<string, string>
     */
    public static function getCases($adjective, $animateness = false)
    {
        $type      = AdjectiveDeclension::getAdjectiveBaseType($adjective);
        $adjective = S::slice($adjective, 0, -2);
        switch ($type) {
            case AdjectiveDeclension::HARD_BASE:
                $cases = [
                    static::IMENIT => $adjective . 'ые',
                    static::RODIT  => $adjective . 'ых',
                    static::DAT    => $adjective . 'ым',
                ];

                $cases[static::VINIT] = RussianLanguage::getVinitCaseByAnimateness($cases, $animateness);

                $cases[static::TVORIT]  = $adjective . 'ыми';
                $cases[static::PREDLOJ] = $adjective . 'ых';

                return $cases;

            case AdjectiveDeclension::SOFT_BASE:
            case AdjectiveDeclension::MIXED_BASE:
                $cases = [
                    static::IMENIT => $adjective . 'ие',
                    static::RODIT  => $adjective . 'их',
                    static::DAT    => $adjective . 'им',
                ];

                $cases[static::VINIT] = RussianLanguage::getVinitCaseByAnimateness($cases, $animateness);

                $cases[static::TVORIT]  = $adjective . 'ими';
                $cases[static::PREDLOJ] = $adjective . 'их';

                return $cases;
        }

        throw new RuntimeException('Unreachable');
    }
}
