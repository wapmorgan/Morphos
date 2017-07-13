# Contribution

`Morphos` is open for additions and improvements.

Addition a new language is simple: create the class inheriting one of basic classes and realize abstract methods from it.

Here is a list of basic abstract classes:

#### `morphos\NamesDeclensions`
Class for names declension.

* `public function isMutable($name, $gender)` - Checks, whether there are rules for this name.
* `public function getCases($name, $gender)` - Generates all cases of a name.
* `public function getCase($name, $form, $gender)` - Generates one case of a name.

#### `morphos\GeneralDeclension`
Class for general declension.

* `public function isMutable($word, $animate = false);` - Checks, whether there are rules for this word.
* `public function getCases($word, $animate = false);` - Generates all cases of a word.
* `public function getCase($word, $form, $animate = false);` - Generates one case of a word.

#### `morphos\NumeralCreation`
Class for numerals generation.

* `public function getCases($number)` - Generates all cases for a number.
* `public function getCase($number, $case)` - Generates one case for a number.

#### `morphos\MoneySpeller`
Class for spelling out money amounts.

* `public function spell($value, $currency)` - Spells money amount in natural language.

#### `morphos\TimeUnitSpeller`
Class for spelling out date intervals and time units.

* `public function spellUnit($count, $unit)` - Spells time unit in natural language.
* `public function spellInterval(DateInterval $interval)` - Spells date interval in natural language.

### String helper
Morphos distributed with a string helper supporting multibyte encodings. Class is `morphos\S`.

It has following static methods:

- `set_encoding($enc)` - Sets encoding for using in all functions.
- `length($string)` - Calculates count of characters in string.
- `slice($string, $start, $end = null)` - Slices string like "[:]" in python.
- `lower($string)` - Lower case.
- `upper($string)` - Upper case.
- `name($string)` - Name case. (ex: Thomas Lewis)
- `chars_count($string, array $chars)` - Count of few chars.
- `last_position_for_one_of_chars($string, array $chars)` - Finds last position for one of chars.
