<?php

namespace morphos\Service;

use morphos\English\CardinalNumeralGenerator;
use morphos\English\OrdinalNumeralGenerator;
use function morphos\English\pluralize;

class English
{
    public function pluralize(array $args)
    {
        return pluralize($args['count'], $args['word']);
    }

    public function cardinal(array $args)
    {
        return \morphos\English\CardinalNumeralGenerator::generate($args['number']);
    }

    public function ordinal(array $args)
    {
        return \morphos\English\OrdinalNumeralGenerator::generate($args['number'], $args['short'] ?? false);
    }

    public function spellTimeDifference(array $args)
    {
        return \morphos\English\TimeSpeller::spellDifference($args['dateTime'], $args['options'] ?? 0, $args['limit'] ?? 0);
    }

    public function spellTimeInterval(array $args)
    {
        return \morphos\English\TimeSpeller::spellInterval(new \DateInterval($args['interval']), $args['options'] ?? 0, $args['limit'] ?? 0);
    }
}
