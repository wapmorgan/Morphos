<?php

namespace morphos;

use RuntimeException;

/**
 * Multibyte string helper
 */
class S
{
    /** @var string Encoding used for string manipulations */
    static protected $encoding;

    /** @var string[][] */
    static protected $cyrillicAlphabet = [
        [
            'Ё',
            'Й',
            'Ц',
            'У',
            'К',
            'Е',
            'Н',
            'Г',
            'Ш',
            'Щ',
            'З',
            'Х',
            'Ъ',
            'Ф',
            'Ы',
            'В',
            'А',
            'П',
            'Р',
            'О',
            'Л',
            'Д',
            'Ж',
            'Э',
            'Я',
            'Ч',
            'С',
            'М',
            'И',
            'Т',
            'Ь',
            'Б',
            'Ю',
        ],
        [
            'ё',
            'й',
            'ц',
            'у',
            'к',
            'е',
            'н',
            'г',
            'ш',
            'щ',
            'з',
            'х',
            'ъ',
            'ф',
            'ы',
            'в',
            'а',
            'п',
            'р',
            'о',
            'л',
            'д',
            'ж',
            'э',
            'я',
            'ч',
            'с',
            'м',
            'и',
            'т',
            'ь',
            'б',
            'ю',
        ],
    ];

    /**
     * Calculates count of characters in string.
     * @param string $string
     * @return int|false
     */
    public static function length($string)
    {
        if (function_exists('mb_strlen')) {
            return mb_strlen($string, static::getEncoding());
        }

        if (function_exists('iconv_strlen')) {
            return iconv_strlen($string, static::getEncoding());
        }

        return false;
    }

    /**
     * Returns encoding used for all operations
     * @return string
     */
    public static function getEncoding()
    {
        return static::$encoding ?: 'utf-8';
    }

    /**
     * Sets encoding for all operations
     * @param string $encoding
     * @return void
     */
    public static function setEncoding($encoding)
    {
        static::$encoding = $encoding;
    }

    /**
     * Name case. (ex: Thomas, Lewis). Works properly with separated by '-' words
     * @param string $string
     * @return bool|string
     */
    public static function name($string)
    {
        if (strpos($string, '-') !== false) {
            return implode('-', array_map([__CLASS__, __FUNCTION__], explode('-', $string)));
        }

        return static::upper(static::slice($string, 0, 1)) . static::lower(static::slice($string, 1));
    }

    /**
     * Upper case.
     * @param string $string
     * @return bool|string
     */
    public static function upper($string)
    {
        if (function_exists('mb_strtoupper')) {
            return mb_strtoupper($string, static::getEncoding());
        }

        return static::replaceByMap($string, static::$cyrillicAlphabet[1], static::$cyrillicAlphabet[0]);
    }

    /**
     * @param string $string
     * @param string[] $fromMap
     * @param string[] $toMap
     * @return string
     */
    private static function replaceByMap($string, $fromMap, $toMap)
    {
        $encoding = static::getEncoding();
        if ($encoding !== 'utf-8') {
            $string = iconv($encoding, 'utf-8', $string);
        }

        $string = strtr($string, array_combine($fromMap, $toMap));

        if ($encoding !== 'utf-8') {
            $string = iconv('utf-8', $encoding, $string);
        }

        return $string;
    }

    /**
     * Slices string like python.
     * @param string $string
     * @param int $start
     * @param int|null $end
     * @return string
     */
    public static function slice($string, $start, $end = null)
    {
        if ($end !== null) {
            $end -= $start;
        }

        if (function_exists('mb_substr')) {
            return mb_substr($string, $start, $end, static::getEncoding());
        }

        if (function_exists('iconv_substr')) {
            return iconv_substr($string, $start, $end ?: iconv_strlen($string), static::getEncoding());
        }

        throw new RuntimeException('Unreachable');
    }

    /**
     * Lower case.
     * @param string $string
     * @return string
     */
    public static function lower($string)
    {
        if (function_exists('mb_strtolower')) {
            return mb_strtolower($string, static::getEncoding());
        }

        return static::replaceByMap($string, static::$cyrillicAlphabet[0], static::$cyrillicAlphabet[1]);
    }

    /**
     * multiple substr_count().
     * @param string $string
     * @param string[] $chars
     * @return int
     */
    public static function countChars($string, array $chars)
    {
        if (function_exists('mb_split')) {
            return count(mb_split('(' . implode('|', $chars) . ')', $string)) - 1;
        }

        $counter = 0;
        foreach ($chars as $char) {
            $counter += substr_count($string, $char);
        }
        return $counter;
    }

    /**
     * @param string $string
     * @param string $char
     * @return int|false
     */
    public static function findLastPosition($string, $char)
    {
        if (function_exists('mb_strrpos')) {
            return mb_strrpos($string, $char, 0, static::getEncoding());
        }

        return strrpos($string, $char);
    }

    /**
     * @param string $string
     * @param string[] $chars
     * @return string|false
     */
    public static function findLastPositionForOneOfChars($string, array $chars)
    {
        if (function_exists('mb_strrpos')) {
            $last_position = false;
            foreach ($chars as $char) {
                if (($pos = mb_strrpos($string, $char, 0, static::getEncoding())) !== false) {
                    if ($pos > $last_position) {
                        $last_position = $pos;
                    }
                }
            }
            if ($last_position !== false) {
                return mb_substr($string, $last_position, null, static::getEncoding());
            }
            return false;
        }

        return false;
    }

    /**
     * @param string $string
     * @param string $substring
     * @param bool $caseSensitive
     * @param int $startOffset
     * @return int|false
     */
    public static function indexOf($string, $substring, $caseSensitive = false, $startOffset = 0)
    {
        if (function_exists('mb_stripos')) {
            return $caseSensitive
                ? mb_strpos($string, $substring, $startOffset, static::getEncoding())
                : mb_stripos($string, $substring, $startOffset, static::getEncoding());
        }

        return false;
    }

    /**
     * Check that string has one of passed substrings
     * @param string $string
     * @param string[] $variants
     * @return bool
     */
    public static function stringContains($string, array $variants)
    {
        foreach ($variants as $variant) {
            if (static::findFirstPosition($string, $variant) !== false) {
                return true;
            }
        }
        return false;
    }

    /**
     * @param string $string
     * @param string $char
     * @return int|false
     */
    public static function findFirstPosition($string, $char)
    {
        if (function_exists('mb_strpos')) {
            return mb_strpos($string, $char, 0, static::getEncoding());
        }

        return strpos($string, $char);
    }
}
