<?php
namespace morphos;

use Exception;

trait CasesHelper {
    static public function canonizeCase($case) {
        $case = lower($case);
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
            case 'a':
                return Cases::ACCUSATIVE;

            case Cases::ABLATIVE:
            case 'ablativus':
            case 'a':
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
