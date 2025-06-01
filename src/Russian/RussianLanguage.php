<?php

namespace morphos\Russian;

use morphos\Gender;
use morphos\S;

class RussianLanguage
{
    /**
     * @var string[] Все гласные
     */
    public static $vowels = [
        'а',
        'е',
        'ё',
        'и',
        'о',
        'у',
        'ы',
        'э',
        'ю',
        'я',
    ];

    /**
     * @var string[] Все согласные
     */
    public static $consonants = [
        'б',
        'в',
        'г',
        'д',
        'ж',
        'з',
        'й',
        'к',
        'л',
        'м',
        'н',
        'п',
        'р',
        'с',
        'т',
        'ф',
        'х',
        'ц',
        'ч',
        'ш',
        'щ',
    ];

    /**
     * @var string[] Пары согласных
     * @phpstan-var array<string, string>
     */
    public static $pairs = [
        'б' => 'п',
        'в' => 'ф',
        'г' => 'к',
        'д' => 'т',
        'ж' => 'ш',
        'з' => 'с',
    ];

    /**
     * @var string[] Звонкие согласные
     */
    public static $sonorousConsonants = ['б', 'в', 'г', 'д', 'з', 'ж', 'л', 'м', 'н', 'р'];
    /**
     * @var string[] Глухие согласные
     */
    public static $deafConsonants = ['п', 'ф', 'к', 'т', 'с', 'ш', 'х', 'ч', 'щ'];

    /**
     * @var string[] Союзы
     */
    public static $unions = ['и', 'или'];

    /**
     * @return string[]
     */
    public static function getVowels()
    {
        return self::$vowels;
    }

    /**
     * Щипящая ли согласная
     * @param string $consonant
     * @return bool
     */
    public static function isHissingConsonant($consonant)
    {
        return in_array(S::lower($consonant), ['ж', 'ш', 'ч', 'щ'], true);
    }

    /**
     * Проверка на велярность согласной
     * @param string $consonant
     * @return bool
     */
    public static function isVelarConsonant($consonant)
    {
        return in_array(S::lower($consonant), ['г', 'к', 'х'], true);
    }

    /**
     * Подсчет слогов
     * @param string $string
     * @return bool|int
     */
    public static function countSyllables($string)
    {
        return S::countChars($string, static::$vowels);
    }

    /**
     * Проверка парности согласной
     *
     * @param string $consonant
     * @return bool
     */
    public static function isPairedConsonant($consonant)
    {
        $consonant = S::lower($consonant);
        return array_key_exists($consonant, static::$pairs) || (array_search($consonant, static::$pairs) !== false);
    }

    /**
     * Проверка мягкости последней согласной
     * @param string $word
     * @return bool
     */
    public static function checkLastConsonantSoftness($word)
    {
        if (($substring = S::findLastPositionForOneOfChars(S::lower($word), static::$consonants)) !== false) {
            if (in_array(S::slice($substring, 0, 1), ['й', 'ч', 'щ', 'ш'], true)) { // always soft consonants
                return true;
            }

            if (
                S::length($substring) > 1
                && in_array(S::slice($substring, 1, 2), ['е', 'ё', 'и', 'ю', 'я', 'ь'], true) // consonants are soft if they are trailed with these vowels
            ) {
                return true;
            }
        }
        return false;
    }

    /**
     * Проверка мягкости последней согласной, за исключением Н
     * @param string $word
     * @return bool
     */
    public static function checkBaseLastConsonantSoftness($word)
    {
        $consonants = static::$consonants;
        unset($consonants[array_search('н', $consonants)]);
        unset($consonants[array_search('й', $consonants)]);

        if (($substring = S::findLastPositionForOneOfChars(S::lower($word), $consonants)) !== false) {
            if (in_array(S::slice($substring, 0, 1), ['й', 'ч', 'щ', 'ш'], true)) { // always soft consonants
                return true;
            }

            if (S::length($substring) > 1 && in_array(S::slice($substring, 1, 2), ['е', 'ё', 'и', 'ю', 'я', 'ь'],
                    true)) { // consonants are soft if they are trailed with these vowels
                return true;
            }
        }
        return false;
    }

    /**
     * Проверяет, что гласная образует два звука в словах
     * @param string $vowel
     * @return bool
     */
    public static function isBinaryVowel($vowel)
    {
        return in_array(S::lower($vowel), ['е', 'ё', 'ю', 'я'], true);
    }

    /**
     * Выбор предлога по первой букве
     *
     * @param string $word                 Слово
     * @param string $prepositionWithVowel Предлог, если слово начинается с гласной
     * @param string $preposition          Предлог, если слово не начинается с гласной
     *
     * @return string
     */
    public static function choosePrepositionByFirstLetter($word, $prepositionWithVowel, $preposition)
    {
        if (in_array(S::lower(S::slice($word, 0, 1)), ['а', 'о', 'и', 'у', 'э'], true)) {
            return $prepositionWithVowel;
        }

        return $preposition;
    }

    /**
     * Выбор окончания в зависимости от мягкости
     *
     * @param string $last
     * @param bool $softLast
     * @param string $afterSoft
     * @param string $afterHard
     *
     * @return string
     */
    public static function chooseVowelAfterConsonant($last, $softLast, $afterSoft, $afterHard)
    {
        if ($last !== 'щ' && /*static::isVelarConsonant($last) ||*/ $softLast) {
            return $afterSoft;
        }

        return $afterHard;
    }

    /**
     * @param string $verb   Verb to modify if gender is female
     * @param string $gender If not `m`, verb will be modified
     * @return string Correct verb
     */
    public static function verb($verb, $gender)
    {
        $verb = S::lower($verb);
        // возвратный глагол
        if (S::slice($verb, -2) === 'ся') {

            return ($gender == Gender::MALE
                ? $verb
                : S::slice($verb, 0, -2) . (S::slice($verb, -3, -2) === 'л' ? null : 'л') . 'ась');
        }

        // обычный глагол
        return ($gender == Gender::MALE
            ? $verb
            : $verb . (S::slice($verb, -1) === 'л' ? null : 'л') . 'а');
    }

    /**
     * Add 'в' or 'во' prepositional before the word
     * @param string $word
     * @return string
     */
    public static function in($word)
    {
        $normalized = trim(S::lower($word));
        if (in_array(S::slice($normalized, 0, 1), ['в', 'ф'], true)
            && static::isConsonant(S::slice($normalized, 1, 2))) {
            return 'во ' . $word;
        }
        return 'в ' . $word;
    }

    /**
     * Проверка согласной
     * @param string $char
     * @return bool
     */
    public static function isConsonant($char)
    {
        return in_array($char, static::$consonants, true);
    }

    /**
     * Add 'с' or 'со' prepositional before the word
     * @param string $word
     * @return string
     */
    public static function with($word)
    {
        $normalized = trim(S::lower($word));
        if (in_array(S::slice($normalized, 0, 1), ['с', 'з', 'ш', 'ж'],
                true) && static::isConsonant(S::slice($normalized, 1, 2)) || S::slice($normalized, 0, 1) === 'щ') {
            return 'со ' . $word;
        }
        return 'с ' . $word;
    }

    /**
     * Add 'о' or 'об' or 'обо' prepositional before the word
     * @param string $word
     * @return string
     */
    public static function about($word)
    {
        $normalized = trim(S::lower($word));
        if (static::isVowel(S::slice($normalized, 0, 1)) && !in_array(S::slice($normalized, 0, 1), ['е', 'ё', 'ю', 'я'],
                true)) {
            return 'об ' . $word;
        }

        if (in_array(S::slice($normalized, 0, 3), ['все', 'всё', 'всю', 'что', 'мне'], true)) {
            return 'обо ' . $word;
        }

        return 'о ' . $word;
    }

    /**
     * Проверка гласной
     * @param string $char
     * @return bool
     */
    public static function isVowel($char)
    {
        return in_array($char, static::$vowels, true);
    }

    /**
     * Выбирает первое или второе окончание в зависимости от звонкости/глухости в конце слова.
     * @param string $word       Слово (или префикс), на основе звонкости которого нужно выбрать окончание
     * @param string $ifSonorous Окончание, если слово оканчивается на звонкую согласную
     * @param string $ifDeaf     Окончание, если слово оканчивается на глухую согласную
     * @return string Первое или второе окончание
     * @throws \Exception
     */
    public static function chooseEndingBySonority($word, $ifSonorous, $ifDeaf)
    {
        $last = S::lower(S::slice($word, -1));
        if (static::isSonorousConsonant($last)) {
            return $ifSonorous;
        }
        if (static::isDeafConsonant($last)) {
            return $ifDeaf;
        }

        throw new \Exception('Not implemented');
    }

    /**
     * Проверка звонкости согласной
     * @param string $char
     * @return bool
     */
    public static function isSonorousConsonant($char)
    {
        return in_array($char, static::$sonorousConsonants, true);
    }

    /**
     * Проверка глухости согласной
     * @param string $char
     * @return bool
     */
    public static function isDeafConsonant($char)
    {
        return in_array($char, static::$deafConsonants, true);
    }

    /**
     * Проверяет, является ли существительно адъективным существительным
     * @param string $noun Существительное
     * @return bool
     */
    public static function isAdjectiveNoun($noun)
    {
        return in_array(S::slice($noun, -2), ['ой', 'ий', 'ый', 'ая', 'ое', 'ее'])
            && !in_array($noun, ['гений', 'комментарий']);
    }

    /**
     * @param string[] $forms
     * @phpstan-param array<string, string> $forms
     * @param bool $animate
     * @return string
     */
    public static function getVinitCaseByAnimateness(array $forms, $animate)
    {
        if ($animate) {
            return $forms[Cases::RODIT];
        }

        return $forms[Cases::IMENIT];
    }
}
