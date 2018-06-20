<?php
namespace morphos;

/**
 * Multibyte string helper
 */
class S
{
    /**
     * Sets encoding for using in morphos/* functions.
     * @param string $encoding
     * @return bool
     */
    public static function setEncoding($encoding)
    {
        if (function_exists('mb_internal_encoding')) {
            mb_internal_encoding($encoding);
        } elseif (function_exists('iconv_set_encoding')) {
            iconv_set_encoding('internal_encoding', $encoding);
        } else {
            return false;
        }
    }

    /**
     * Calculates count of characters in string.
     * @param $string
     * @return bool|int
     */
    public static function length($string)
    {
        if (function_exists('mb_strlen')) {
            return mb_strlen($string);
        }

        if (function_exists('iconv_strlen')) {
            return iconv_strlen($string);
        }

        return false;
    }

    /**
     * Slices string like python.
     * @param string $string
     * @param int $start
     * @param int|null $end
     * @return bool|string
     */
    public static function slice($string, $start, $end = null)
    {
        if ($end != null) {
            $end -= $start;
        }

        if (function_exists('mb_substr')) {
            return $end === null ? mb_substr($string, $start) : mb_substr($string, $start, $end);
        }

        if (function_exists('iconv_substr')) {
            return $end === null ? iconv_substr($string, $start) : iconv_substr($string, $start, $end);
        }

        return false;
    }

    /**
     * Lower case.
     * @param $string
     * @return bool|string
     */
    public static function lower($string)
    {
        if (function_exists('mb_strtolower')) {
            return mb_strtolower($string);
        }

        return false;
    }

    /**
     * Upper case.
     * @param $string
     * @return bool|string
     */
    public static function upper($string)
    {
        if (function_exists('mb_strtoupper')) {
            return mb_strtoupper($string);
        }

        return false;
    }

    /**
     * Name case. (ex: Thomas, Lewis)
     * @param $string
     * @return bool|string
     */
    public static function name($string)
    {
        if (function_exists('mb_strtoupper')) {
            return implode('-', array_map(function ($word) {
                return self::upper(self::slice($word, 0, 1)).self::lower(self::slice($word, 1));
            }, explode('-', $string)));
        }

        return false;
    }

    /**
     * multiple substr_count().
     * @param $string
     * @param array $chars
     * @return bool|int
     */
    public static function countChars($string, array $chars)
    {
        if (function_exists('mb_split')) {
            return count(mb_split('('.implode('|', $chars).')', $string)) - 1;
        }

        return false;
    }

    /**
     * @param string $string
     * @param string $char
     * @return bool|string
     */
    public static function findFirstPosition($string, $char)
    {
        if (function_exists('mb_strpos')) {
            return mb_strpos($string, $char, 0);
        }

        return strpos($string, $char);
    }

    /**
     * @param string $string
     * @param string $char
     * @return bool|string
     */
    public static function findLastPosition($string, $char)
    {
        if (function_exists('mb_strrpos')) {
            return mb_strrpos($string, $char, 0);
        }

        return strrpos($string, $char);
    }

    /**
     * @param $string
     * @param array $chars
     * @return bool|string
     */
    public static function findLastPositionForOneOfChars($string, array $chars)
    {
        if (function_exists('mb_strrpos')) {
            $last_position = false;
            foreach ($chars as $char) {
                if (($pos = mb_strrpos($string, $char)) !== false) {
                    if ($pos > $last_position) {
                        $last_position = $pos;
                    }
                }
            }
            if ($last_position !== false) {
                return mb_substr($string, $last_position);
            }
            return false;
        }

        return false;
    }

    /**
     * @param $string
     * @param $substring
     * @param bool $caseSensetive
     * @param int $startOffset
     * @return string|false
     */
    public static function indexOf($string, $substring, $caseSensetive = false, $startOffset = 0)
    {
        if (function_exists('mb_stripos')) {
            return $caseSensetive ? mb_strpos($string, $substring, $startOffset) : mb_stripos($string, $substring, $startOffset);
        }

        return false;
    }
}
