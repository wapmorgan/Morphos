<?php

namespace morphos\Russian;

use morphos\CasesHelper;
use morphos\S;

class RussianCasesHelper extends CasesHelper
{
    /**
     * @param string $case
     * @return string
     * @throws \Exception
     */
    public static function canonizeCase($case)
    {
        $case = S::lower($case);
        switch ($case) {
            case Cases::IMENIT:
            case 'именительный':
            case 'именит':
            case 'и':
                return Cases::IMENIT;

            case Cases::RODIT:
            case 'родительный':
            case 'родит':
            case 'р':
                return Cases::RODIT;

            case Cases::DAT:
            case 'дательный':
            case 'дат':
            case 'д':
                return Cases::DAT;

            case Cases::VINIT:
            case 'винительный':
            case 'винит':
            case 'в':
                return Cases::VINIT;

            case Cases::TVORIT:
            case 'творительный':
            case 'творит':
            case 'т':
                return Cases::TVORIT;

            case Cases::PREDLOJ:
            case 'предложный':
            case 'предлож':
            case 'п':
                return Cases::PREDLOJ;

            case Cases::LOCATIVE:
                return Cases::LOCATIVE;

            default:
                return CasesHelper::canonizeCase($case);
        }
    }
}
