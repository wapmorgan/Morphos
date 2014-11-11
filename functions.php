<?php
namespace morphos;

/**
 * Sets encoding for using in morphos/* functions.
 */
function set_encoding($encoding) {
	if (function_exists('mb_internal_encoding')) {
		mb_internal_encoding($encoding);
	} else if (function_exists('iconv_set_encoding')) {
		iconv_set_encoding('internal_encoding', $encoding);
	} else {
		return false;
	}
}
set_encoding('utf-8');

/**
 * Calcules count of characters in string.
 */
function length($string) {
	if (function_exists('mb_strlen')) {
		return mb_strlen($string);
	} else if (function_exists('iconv_strlen')) {
		return iconv_strlen($string);
	} else {
		return false;
	}
}

/**
 * Slices string like python.
 */
function slice($string, $start, $end = null) {
	if ($end != null) {
		$end -= $start;
	}

	if (function_exists('mb_substr')) {
		return $end === null ? mb_substr($string, $start) : mb_substr($string, $start, $end);
	} else if (function_exists('iconv_substr')) {
		return $end === null ? iconv_substr($string, $start) : iconv_substr($string, $start, $end);
	} else {
		return false;
	}
}

/**
 * Lower case.
 */
function lower($string) {
	if (function_exists('mb_strtolower')) {
		return mb_strtolower($string);
	} else {
		return false;
	}
}

/**
 * Upper case.
 */
function upper($string) {
	if (function_exists('mb_strtoupper')) {
		return mb_strtoupper($string);
	} else {
		return false;
	}
}

/**
 * Name case. (ex: Thomas Lewis)
 */
function name($string) {
	if (function_exists('mb_strtoupper')) {
		return upper(slice($string, 0, 1)).lower(slice($string, 1));
	} else {
		return false;
	}
}

/**
 * multiple substr_count().
 */
function count_chars($string, array $chars) {
	if (function_exists('mb_split')) {
		return count(mb_split('('.implode('|', $chars).')', $string)) - 1;
	} else {
		return false;
	}
}
