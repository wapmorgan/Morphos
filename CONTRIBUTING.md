# Contribution

`Morphos` are open for additions and improvements.

Addition a new language is simple: create the class inheriting one of basic classes and realize abstract methods from it.

Here is a list of basic abstract classes:

#### `morphos\NamesDeclensions`
Class for names declension.

* `abstract public function isMutable($name, $gender)` - Checks, whether there are rules for this name.
* `abstract public function getCases($name, $gender)` - Generates all cases of a name.
* `abstract public function getCase($name, $form, $gender)` - Generates one case of a name.

#### `morphos\GeneralDeclension`

* `public function isMutable($word, $animate = false);` - Checks, whether there are rules for this word.
* `public function getCases($word, $animate = false);` - Generates all cases of a word.
* `public function getCase($word, $form, $animate = false);` - Generates one case of a word.

#### `morphos\NumeralCreation`

* `public function getCases($number)` - Generates all cases for a number.
* `public function getCase($number, $case)` - Generates one case for a number.
* `static public function generate($number)` - Generates nominative numeral for a number.

### String helper
Morphos distributed with a string helper supporting multibyte encodings. Class is `morphos\S`.

It has following static methods:

1. `set_encoding()` - Sets encoding for using in all functions.
2. `length()` - Calculates count of characters in string.
3. `slice()` - Slices string like python.
4. `lower()` - Lower case.
5. `upper()` - Upper case.
6. `name()` - Name case. (ex: Thomas Lewis)
7. `chars_count()` - Count of few chars.
8. `last_position_for_one_of_chars()` - Finds last position for one of chars.
