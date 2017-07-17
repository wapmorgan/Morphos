<?php
namespace morphos;

/**
 * Multibyte string helper
 */
class S
{
    /**
     * Sets encoding for using in morphos/* functions.
     */
    public static function set_encoding($encoding)
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
     * Calcules count of characters in string.
     */
    public static function length($string)
    {
        if (function_exists('mb_strlen')) {
            return mb_strlen($string);
        } elseif (function_exists('iconv_strlen')) {
            return iconv_strlen($string);
        } else {
            return false;
        }
    }

    /**
     * Slices string like python.
     */
    public static function slice($string, $start, $end = null)
    {
        if ($end != null) {
            $end -= $start;
        }

        if (function_exists('mb_substr')) {
            return $end === null ? mb_substr($string, $start) : mb_substr($string, $start, $end);
        } elseif (function_exists('iconv_substr')) {
            return $end === null ? iconv_substr($string, $start) : iconv_substr($string, $start, $end);
        } else {
            return false;
        }
    }

    /**
     * Lower case.
     */
    public static function lower($string)
    {
        if (function_exists('mb_strtolower')) {
            return mb_strtolower($string);
        } else {
            return false;
        }
    }

    /**
     * Upper case.
     */
    public static function upper($string)
    {
        if (function_exists('mb_strtoupper')) {
            return mb_strtoupper($string);
        } else {
            return false;
        }
    }

    /**
     * Name case. (ex: Thomas, Lewis)
     */
    public static function name($string)
    {
        if (function_exists('mb_strtoupper')) {
            return implode('-', array_map(function ($word) {
                return self::upper(self::slice($word, 0, 1)).self::lower(self::slice($word, 1));
            }, explode('-', $string)));
        } else {
            return false;
        }
    }

    /**
     * multiple substr_count().
     */
    public static function chars_count($string, array $chars)
    {
        if (function_exists('mb_split')) {
            return count(mb_split('('.implode('|', $chars).')', $string)) - 1;
        } else {
            return false;
        }
    }

    public static function last_position_for_one_of_chars($string, array $chars)
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
        } else {
            return false;
        }
    }

    public static function indexOf($string, $substring, $caseSensetive = false, $startOffset = 0)
    {
        if (function_exists('mb_stripos')) {
            return $caseSensetive ? mb_strpos($string, $substring, $startOffset) : mb_stripos($string, $substring, $startOffset);
        } else {
            return false;
        }
    }
}
