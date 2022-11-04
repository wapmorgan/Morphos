<?php

namespace morphos\English;

use morphos\S;
use RuntimeException;

class NounPluralization extends \morphos\BasePluralization
{
    /** @var string[] */
    public static $consonants = [
        'b',
        'c',
        'd',
        'f',
        'g',
        'h',
        'j',
        'k',
        'l',
        'm',
        'n',
        'p',
        'q',
        'r',
        's',
        't',
        'v',
        'x',
        'z',
        'w',
    ];
    /**
     * @var string[]
     * @phpstan-var array<string, string>
     */
    private static $exceptions = [
        'chief'      => 'chiefs',
        'basis'      => 'bases',
        'crisis'     => 'crises',
        'radius'     => 'radii',
        'nucleus'    => 'nuclei',
        'curriculum' => 'curricula',
        'man'        => 'men',
        'woman'      => 'women',
        'child'      => 'children',
        'foot'       => 'feet',
        'tooth'      => 'teeth',
        'ox'         => 'oxen',
        'goose'      => 'geese',
        'mouse'      => 'mice',
    ];
    /** @var string[] */
    private static $without_paired_form = [
        'knowledge',
        'progress',
        'advice',
        'ink',
        'money',
        'scissors',
        'spectacles',
        'trousers',
    ];

    /**
     * @param string $word
     * @param int $count
     * @return string
     */
    public static function pluralize($word, $count = 2)
    {
        if ($count == 1) {
            return $word;
        }

        $word = S::lower($word);
        if (in_array($word, static::$without_paired_form)) {
            return $word;
        } elseif (isset(static::$exceptions[$word])) {
            return static::$exceptions[$word];
        }

        if (in_array(S::slice($word, -1), ['s', 'x']) || in_array(S::slice($word, -2), ['sh', 'ch'])) {
            return $word . 'es';
        } elseif (S::slice($word, -1) == 'o') {
            return $word . 'es';
        } elseif (S::slice($word, -1) == 'y' && in_array(S::slice($word, -2, -1), static::$consonants)) {
            return S::slice($word, 0, -1) . 'ies';
        } elseif (S::slice($word, -2) == 'fe' || S::slice($word, -1) == 'f') {
            if (S::slice($word, -1) == 'f') {
                return S::slice($word, 0, -1) . 'ves';
            } else {
                return S::slice($word, 0, -2) . 'ves';
            }
        } else {
            return $word . 's';
        }
    }

    public static function getCase($word, $case, $animateness = false)
    {
        throw new RuntimeException('Not implemented');
    }

    public static function getCases($word, $animateness = false)
    {
        throw new RuntimeException('Not implemented');
    }
}
