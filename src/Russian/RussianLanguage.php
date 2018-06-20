<?php
namespace morphos\Russian;

use morphos\Gender;
use morphos\S;

trait RussianLanguage
{
    /**
     * @var array Все гласные
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
     * @var array Все согласные
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
     * @var array Пары согласных
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
     * @var array Звонкие согласные
     */
    public static $sonorousConsonants = ['б', 'в', 'г', 'д', 'з', 'ж', 'л', 'м', 'н', 'р'];
    /**
     * @var array Глухие согласные
     */
    public static $deafConsonants = ['п', 'ф', 'к', 'т', 'с', 'ш', 'х', 'ч', 'щ'];

    /**
     * Проверка гласной
     */
    public static function isVowel($char)
    {
        return in_array($char, self::$vowels, true);
    }

    /**
     * Проверка согласной
     */
    public static function isConsonant($char)
    {
        return in_array($char, self::$consonants, true);
    }

    /**
     * Проверка звонкости согласной
     */
    public static function isSonorousConsonant($char)
    {
        return in_array($char, self::$sonorousConsonants, true);
    }

    /**
     * Проверка глухости согласной
     */
    public static function isDeafConsonant($char)
    {
        return in_array($char, self::$deafConsonants, true);
    }

    /**
     * Щипящая ли согласная
     */
    public static function isHissingConsonant($consonant)
    {
        return in_array(S::lower($consonant), ['ж', 'ш', 'ч', 'щ'], true);
    }

    /**
     *
     */
    protected static function isVelarConsonant($consonant)
    {
        return in_array(S::lower($consonant), ['г', 'к', 'х'], true);
    }

    /**
     * Подсчет слогов
     */
    public static function countSyllables($string)
    {
        return S::countChars($string, self::$vowels);
    }

    /**
     * Проверка парности согласной
     */
    public static function isPaired($consonant)
    {
        $consonant = S::lower($consonant);
        return array_key_exists($consonant, self::$pairs) || (array_search($consonant, self::$pairs) !== false);
    }

    /**
     * Проверка мягкости последней согласной
     */
    public static function checkLastConsonantSoftness($word)
    {
        if (($substring = S::findLastPositionForOneOfChars(S::lower($word), self::$consonants)) !== false) {
            if (in_array(S::slice($substring, 0, 1), ['й', 'ч', 'щ'], true)) { // always soft consonants
                return true;
            } elseif (S::length($substring) > 1 && in_array(S::slice($substring, 1, 2), ['е', 'ё', 'и', 'ю', 'я', 'ь'], true)) { // consonants are soft if they are trailed with these vowels
                return true;
            }
        }
        return false;
    }

    /**
     * Проверяет, что гласная образует два звука в словах
     * @param $vowel
     * @return bool
     */
    public static function isBinaryVowel($vowel)
    {
        return in_array(S::lower($vowel), ['е', 'ё', 'ю', 'я'], true);
    }

    /**
     * Выбор предлога по первой букве
     */
    public static function choosePrepositionByFirstLetter($word, $prepositionWithVowel, $preposition)
    {
        if (in_array(S::lower(S::slice($word, 0, 1)), ['а', 'о', 'и', 'у', 'э'], true)) {
            return $prepositionWithVowel;
        } else {
            return $preposition;
        }
    }

    /**
     * Выбор окончания в зависимости от мягкости
     */
    public static function chooseVowelAfterConsonant($last, $soft_last, $after_soft, $after_hard)
    {
        if ((RussianLanguage::isHissingConsonant($last) && !in_array($last, ['ж', 'ч'], true)) || /*self::isVelarConsonant($last) ||*/ $soft_last) {
            return $after_soft;
        } else {
            return $after_hard;
        }
    }

    /**
     * @param string $verb Verb to modify if gender is female
     * @param string $gender If not `m`, verb will be modified
     * @return string Correct verb
     */
    public static function verb($verb, $gender)
    {
        $verb = S::lower($verb);
        // возвратный глагол
        if (S::slice($verb, -2) == 'ся') {
            return ($gender == Gender::MALE ? $verb : mb_substr($verb, 0, -2).'ась');
        }

        // обычный глагол
        return ($gender == Gender::MALE ? $verb : $verb.'а');
    }

    /**
     * Add 'в' or 'во' prepositional before the word
     * @param string $word
     * @return string
     */
    public static function in($word)
    {
        $normalized = trim(S::lower($word));
        if (in_array(S::slice($normalized, 0, 1), ['в', 'ф'], true))
            return 'во '.$word;
        return 'в '.$word;
    }

    /**
     * Add 'с' or 'со' prepositional before the word
     * @param string $word
     * @return string
     */
    public static function with($word)
    {
        $normalized = trim(S::lower($word));
        if (in_array(S::slice($normalized, 0, 1), ['c', 'з', 'ш', 'ж'], true) && static::isConsonant(S::slice($normalized, 1, 2)) || S::slice($normalized, 0, 1) == 'щ')
            return 'со '.$word;
        return 'с '.$word;
    }

    /**
     * Add 'о' or 'об' or 'обо' prepositional before the word
     * @param string $word
     * @return string
     */
    public static function about($word)
    {
        $normalized = trim(S::lower($word));
        if (static::isVowel(S::slice($normalized, 0, 1)) && !in_array(S::slice($normalized, 0, 1), ['е', 'ё', 'ю', 'я'], true))
            return 'об '.$word;

        if (in_array(S::slice($normalized, 0, 3), ['все', 'всё', 'всю', 'что', 'мне'], true))
            return 'обо '.$word;

        return 'о '.$word;
    }

    /**
     * Выбирает первое или второе окончание в зависимости от звонкости/глухости в конце слова.
     * @param string $word Слово (или префикс), на основе звонкости которого нужно выбрать окончание
     * @param string $ifSonorous Окончание, если слово оканчивается на звонкую согласную
     * @param string $ifDeaf Окончание, если слово оканчивается на глухую согласную
     * @return string Первое или второе окончание
     * @throws \Exception
     */
    public static function chooseEndingBySonority($word, $ifSonorous, $ifDeaf)
    {
        $last = S::slice($word, -1);
        if (self::isSonorousConsonant($last))
            return $ifSonorous;
        if (self::isDeafConsonant($last))
            return $ifDeaf;

        throw new \Exception('Not implemented');
    }

    /**
     * Проверяет, является ли существительно адъективным существительным
     * @param string $noun Существительное
     * @return bool
     */
    public static function isAdjectiveNoun($noun)
    {
        return in_array(S::slice($noun, -2), ['ой', 'ий', 'ый', 'ая', 'ое', 'ее'])
            && $noun != 'гений';
    }
}
