<?php

namespace morphos\Service;

use morphos\English\CardinalNumeralGenerator;
use morphos\English\OrdinalNumeralGenerator;
use morphos\Russian\MoneySpeller;
use morphos\Russian\RussianLanguage;

class Russian {
    public function cases()
    {
        return \morphos\CasesHelper::getAllCases();
    }

    public function name(array $args)
    {
        return \morphos\Russian\inflectName($args['name'], $args['case'] ?? null, $args['gender'] ?? null);
    }

    public function detectGender(array $args)
    {
        return \morphos\Russian\detectGender($args['name']);
    }

    public function pluralize(array $args)
    {
        return \morphos\Russian\pluralize($args['count'], $args['word'], $args['animateness'] ?? false, $args['case'] ?? null);
    }

    public function nounDeclensionCases(array $args)
    {
        return \morphos\Russian\NounDeclension::getCases($args['word'], $args['animateness'] ?? false);
    }

    public function nounDeclensionDetectGender(array $args)
    {
        return \morphos\Russian\NounDeclension::detectGender($args['word']);
    }

    public function nounDeclensionDetect(array $args)
    {
        return \morphos\Russian\NounDeclension::getDeclension($args['word'], $args['animateness'] ?? false);
    }

    public function nounDeclensionIsMutable(array $args)
    {
        return \morphos\Russian\NounDeclension::isMutable($args['word'], $args['animateness'] ?? false);
    }

    public function nounPluralizationCases(array $args)
    {
        return \morphos\Russian\NounPluralization::getCases($args['word'], $args['animateness'] ?? false);
    }

    public function nounPluralizationNumeralForm(array $args)
    {
        return \morphos\Russian\NounPluralization::getNumeralForm($args['count']);
    }

    public function cardinalCases(array $args)
    {
        return \morphos\Russian\CardinalNumeralGenerator::getCases($args['number'], $args['gender'] ?? CardinalNumeralGenerator::MALE);
    }

    public function ordinalCases(array $args)
    {
        return \morphos\Russian\OrdinalNumeralGenerator::getCases($args['number'], $args['gender'] ?? OrdinalNumeralGenerator::MALE);
    }

    public function geoCases(array $args)
    {
        return \morphos\Russian\GeographicalNamesInflection::getCases($args['name']);
    }

    public function geoIsMutable(array $args)
    {
        return \morphos\Russian\GeographicalNamesInflection::isMutable($args['name']);
    }

    public function spellMoney(array $args)
    {
        return \morphos\Russian\MoneySpeller::spell(
            $args['value'],
            $args['currency'],
            $args['format'] ?? MoneySpeller::NORMAL_FORMAT,
            $args['case'] ?: null,
            match ($args['skipFractionalPartIfZero'] ?? null) {
                '', null => null,
                'true', '1' => true,
                'false', '0' => false,
                default => $args['skipFractionalPartIfZero']
            }
        );
    }

    public function spellTimeDifference(array $args)
    {
        return \morphos\Russian\TimeSpeller::spellDifference($args['dateTime'], $args['options'] ?? 0, $args['limit'] ?? 0);
    }

    public function spellTimeInterval(array $args)
    {
        return \morphos\Russian\TimeSpeller::spellInterval(new \DateInterval($args['interval']), $args['options'] ?? 0, $args['limit'] ?? 0);
    }

    public function prepIn(array $args)
    {
        return RussianLanguage::in($args['word']);
    }

    public function prepWith(array $args)
    {
        return RussianLanguage::with($args['word']);
    }

    public function prepAbout(array $args)
    {
        return RussianLanguage::about($args['word']);
    }

    public function verbEnding(array $args)
    {
        return RussianLanguage::verb($args['verb'], $args['gender']);
    }
}
