<?php
namespace morphos\Russian;

use morphos\Gender;
use morphos\S;

trait RussianLanguage
{
    public static $vowels = array(
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
    );

    public static $consonants = array(
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
    );

    public static $pairs = array(
        'б' => 'п',
        'в' => 'ф',
        'г' => 'к',
        'д' => 'т',
        'ж' => 'ш',
        'з' => 'с',
    );

    public static $deafConsonants = ['х', 'ч', 'щ'];
    public static $sonorousConsonants = ['л', 'м', 'н', 'р'];

	public static function isVowel($char)
	{
		return in_array($char, self::$vowels);
	}

	public static function isConsonant($char)
	{
		return in_array($char, self::$consonants);
	}

	public static function isDeafConsonant($char)
	{
		return in_array($char, self::$deafConsonants);
	}

	public static function isSonorousConsonant($char)
	{
		return in_array($char, self::$sonorousConsonants);
	}

    public static function isHissingConsonant($consonant)
    {
        return in_array(S::lower($consonant), array('ж', 'ш', 'ч', 'щ'));
    }

    protected static function isVelarConsonant($consonant)
    {
        return in_array(S::lower($consonant), array('г', 'к', 'х'));
    }

    public static function countSyllables($string)
    {
        return S::chars_count($string, self::$vowels);
    }

    public static function isPaired($consonant)
    {
        $consonant = S::lower($consonant);
        return array_key_exists($consonant, self::$pairs) || (array_search($consonant, self::$pairs) !== false);
    }

    public static function checkLastConsonantSoftness($word)
    {
        if (($substring = S::last_position_for_one_of_chars(S::lower($word), self::$consonants)) !== false) {
            if (in_array(S::slice($substring, 0, 1), ['й', 'ч', 'щ'])) { // always soft consonants
                return true;
            } elseif (S::length($substring) > 1 && in_array(S::slice($substring, 1, 2), ['е', 'ё', 'и', 'ю', 'я', 'ь'])) { // consonants are soft if they are trailed with these vowels
                return true;
            }
        }
        return false;
    }

    public static function choosePrepositionByFirstLetter($word, $prepositionWithVowel, $preposition)
    {
        if (in_array(S::upper(S::slice($word, 0, 1)), array('А', 'О', 'И', 'У', 'Э'))) {
            return $prepositionWithVowel;
        } else {
            return $preposition;
        }
    }

    public static function chooseVowelAfterConsonant($last, $soft_last, $after_soft, $after_hard)
    {
        if ((RussianLanguage::isHissingConsonant($last) && !in_array($last, array('ж', 'ч'))) || /*self::isVelarConsonant($last) ||*/ $soft_last) {
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
		if (in_array(S::slice($normalized, 0, 1), ['в', 'ф']))
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
		if (in_array(S::slice($normalized, 0, 1), ['c', 'з', 'ш', 'ж']) && static::isConsonant(S::slice($normalized, 1, 2)) || S::slice($normalized, 0, 1) == 'щ')
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
		if (static::isVowel(S::slice($normalized, 0, 1)) && !in_array(S::slice($normalized, 0, 1), ['е', 'ё', 'ю', 'я']))
			return 'об '.$word;

		if (in_array(S::slice($normalized, 0, 3), ['все', 'всё', 'всю', 'что', 'мне']))
			return 'обо '.$word;

		return 'о '.$word;
	}
}
