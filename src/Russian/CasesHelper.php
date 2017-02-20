<?php
namespace morphos\Russian;

trait CasesHelper {
    use \morphos\CasesHelper;

    static public function canonizeCase($case) {
        $case = lower($case);
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

            default:
                return parent::canonizeCase($case);
        }
    }
}
