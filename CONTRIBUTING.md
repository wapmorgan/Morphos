# Contribution

`Morphos` is open for additions and improvements.

Addition a new language is simple: create the class inheriting one of basic classes and realize implement methods.

Here is a list of basic abstract classes and their methods:

#### `morphos\NamesInflection`
Class for names inflection.

* `public function isMutable($name, $gender)` - Checks, whether there are rules for this name.
* `public function getCases($name, $gender)` - Generates all cases of a name.
* `public function getCase($name, $form, $gender)` - Generates one case of a name.

#### `morphos\BaseInflection`
Class for general inflection.

* `public function isMutable($word, $animate = false);` - Checks, whether there are rules for this word.
* `public function getCases($word, $animate = false);` - Generates all cases of a word.
* `public function getCase($word, $form, $animate = false);` - Generates one case of a word.

#### `morphos\NumeralGenerator`
Class for numerals generation.

* `public function getCases($number)` - Generates all cases for a number.
* `public function getCase($number, $case)` - Generates one case for a number.

#### `morphos\MoneySpeller`
Class for spelling out money amounts.

* `public function spell($value, $currency)` - Spells money amount in natural language.

#### `morphos\TimeSpeller`
Class for spelling out date intervals and time units.

* `public function spellUnit($count, $unit)` - Spells time unit in natural language.
* `public function spellInterval(DateInterval $interval)` - Spells date interval in natural language.

### String helper
Morphos distributed with a string helper that supports multibyte encodings. Class is `morphos\S`.

It has following static methods:

- `S::setEncoding($enc)` - Sets encoding for using in all functions. By default, utf-8 is used.
- `S::length($string)` - Calculates count of characters in string.
- `S::slice($string, $start, $end = null)` - Slices string like "[:]" in python.
- `S::lower($string)` - Convert to lower case.
- `S::upper($string)` - Convert to upper case.
- `S::name($string)` - Convert to name case. (ex: Thomas Lewis)
- `S::countChars($string, array $chars)` - Count of any of chars.
- `S::findLastPositionForOneOfChars($string, array $chars)` - Finds last position for one of chars.
- `S::indexOf($string, $substring, $caseSensetive = false, $startOffset = 0)` - Finds first position of substring in a string.
