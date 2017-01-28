# Contribution

`Morphos` are open for additions and improvements.

Addition a new language is simple: create the class inheriting one of basic classes and realize abstract methods from it.

Here is a list of basic abstract classes:

#### `morphos\NamesDeclensions`
Class for names declension.

* ```php
  abstract public function hasForms($name, $gender);
  ```
  Checks, whether there are rules for this name.

* ```php
  abstract public function getForms($name, $gender);
  ```
  Generates all forms of a name.

* ```php
  abstract public function getForm($name, $form, $gender);
  ```
  Generates one form of a name.

#### `morphos\GeneralDeclension`

* ```php
  public function hasForms($word, $animate = false);
  ```
  Checks, whether there are rules for this word.

* ```php
  public function getForms($word, $animate = false);
  ```
  Generates all forms of a word.

* ```php
  public function getForm($word, $form, $animate = false);
  ```
  Generates one form of a word.

### Useful functions

For simple access to string processing Morphos creates few functions in global namespace:

1. `set_encoding()` - Sets encoding for using in morphos/* functions.
2. `length()` - Calculates count of characters in string.
3. `slice()` - Slices string like python.
4. `lower()` - Lower case.
5. `upper()` - Upper case.
6. `name()` - Name case. (ex: Thomas Lewis)
7. `chars_count()` - Count of few chars.
8. `last_position_for_one_of_chars()` - Finds last position for one of chars.
