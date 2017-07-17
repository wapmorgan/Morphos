<?php
namespace morphos;

use Exception;

trait CasesHelper
{
    public static function canonizeCase($case)
    {
        $case = S::lower($case);
        switch ($case) {
            case Cases::NOMINATIVE:
            case 'nominativus':
            case 'n':
                return Cases::NOMINATIVE;

            case Cases::GENITIVE:
            case 'genetivus':
            case 'g':
                return Cases::GENITIVE;

            case Cases::DATIVE:
            case 'dativus':
            case 'd':
                return Cases::DATIVE;

            case Cases::ACCUSATIVE:
                return Cases::ACCUSATIVE;

            case Cases::ABLATIVE:
            case 'ablativus':
                return Cases::ABLATIVE;

            case Cases::PREPOSITIONAL:
            case 'praepositionalis':
            case 'p':
                return Cases::PREPOSITIONAL;

            default:
                throw new Exception('Invalid case: '.$case);
        }
    }
}
