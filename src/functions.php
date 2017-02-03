<?php
namespace {
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
	function chars_count($string, array $chars) {
		if (function_exists('mb_split')) {
			return count(mb_split('('.implode('|', $chars).')', $string)) - 1;
		} else {
			return false;
		}
	}

	function last_position_for_one_of_chars($string, array $chars) {
		if (function_exists('mb_strrpos')) {
			$last_position = false;
			foreach ($chars as $char) {
				if (($pos = mb_strrpos($string, $char)) !== false) {
					if ($pos > $last_position)
						$last_position = $pos;
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
}

namespace morphos\Russian {
	function nameCase($fullname, $case = null, $gender = null) {
		static $first, $middle, $last;
		if ($first === null) $first = new FirstNamesDeclension();
		if ($middle === null) $middle = new MiddleNamesDeclension();
		if ($last === null) $last = new LastNamesDeclension();

		if ($gender === null) $gender = detectGender($fullname);

		$name = explode(' ', $fullname);
		if ($case === null) {
			$result = array();
			if (count($name) == 2) {
				$name[0] = $last->getForms($name[0], $gender);
				$name[1] = $first->getForms($name[1], $gender);
			} else if (count($name) == 3) {
				$name[0] = $last->getForms($name[0], $gender);
				$name[1] = $first->getForms($name[1], $gender);
				$name[2] = $middle->getForms($name[2], $gender);
			}
			foreach (array(Cases::IMENIT, Cases::RODIT, Cases::DAT, Cases::VINIT, Cases::TVORIT, Cases::PREDLOJ) as $case) {
				foreach ($name as $partNum => $namePart) {
					if ($case == Cases::PREDLOJ && $partNum > 0) list(, $namePart[$case]) = explode(' ', $namePart[$case]);
					$result[$case][] = $namePart[$case];
				}
				$result[$case] = implode(' ', $result[$case]);
			}
			return $result;
		} else {
			if (count($name) == 2) {
				$name[0] = $last->getForm($name[0], $case, $gender);
				$name[1] = $first->getForm($name[1], $case, $gender);
				if ($case == Cases::PREDLOJ) list(, $name[1]) = explode(' ', $name[1]);
			} else if (count($name) == 3) {
				$name[0] = $last->getForm($name[0], $case, $gender);
				$name[1] = $first->getForm($name[1], $case, $gender);
				if ($case == Cases::PREDLOJ) list(, $name[1]) = explode(' ', $name[1]);
				$name[2] = $middle->getForm($name[2], $case, $gender);
				if ($case == Cases::PREDLOJ) list(, $name[2]) = explode(' ', $name[2]);
			}
		}
		return implode(' ', $name);
	}

	function detectGender($fullname) {
		static $first, $middle, $last;
		if ($first === null) $first = new FirstNamesDeclension();
		if ($middle === null) $middle = new MiddleNamesDeclension();
		if ($last === null) $last = new LastNamesDeclension();

		$name = explode(' ', lower($fullname));

		return (isset($name[2]) ? $middle->detectGender($name[2]) : null) ?:
			$first->detectGender($name[1]) ?:
			$last->detectGender($name[0]);
	}
}
