[![Build Status](https://travis-ci.org/wapmorgan/Morphos.svg)](https://travis-ci.org/wapmorgan/Morphos)

Morphos - a morphological decision written completely in PHP.

At the moment the main functionality is declension of nouns and personal names in Russian language.

# Personal names declension
## Tutorial.

* Download library through composer:
    `composer require "wapmorgan/morphos"`

* Create an instance of declension class:
    ```php
    $dec = new morphos\RussianNamesDeclension();
    ```

* Check whether there are forms for this name (need to know a gender)
    ```php
    var_dump($dec->hasForms('Иоанн', morphos\RussianNamesDeclension::MAN))); //true
    ```

* Get one of forms:
    ```php
    var_dump($dec->getForm('Иоанн', morphos\RussianNamesDeclension::DAT_3, morphos\RussianNamesDeclension::MAN)); // Иоанна
    ```

* Get all forms:
    ```php
    var_dump($dec->getForms('Иоанн', morphos\RussianNamesDeclension::MAN));
    ```

    ```
    array(6) {
      ["nominativus"]=>
      string(10) "Иоанн"
      ["genetivus"]=>
      string(12) "Иоанна"
      ["dativus"]=>
      string(12) "Иоанну"
      ["accusative"]=>
      string(12) "Иоанна"
      ["ablativus"]=>
      string(14) "Иоанном"
      ["praepositionalis"]=>
      string(17) "об Иоанне"
    }
    ```

### Addition of new languages.
To add a new language simply: create the class inheriting BasicNamesDeclension and realize three abstract methods from BasicNamesDeclension:

* Checks, whether there are rules for this name.
  ```php
  public function hasForms($name, $gender);
  ```

* Generates all forms of a name.
  ```php
  public function getForms($name, $gender);
  ```

* Generates one form of a name.
  ```php
  public function getForm($name, $form, $gender);
  ```

For simple access to functions of string processing there are some functions in `morphos` namespace:

1. `set_encoding()` - Sets encoding for using in morphos/* functions.
2. `length()` - Calculates count of characters in string.
3. `slice()` - Slices string like python.
4. `lower()` - Lower case.
5. `upper()` - Upper case.
6. `name()` - Name case. (ex: Thomas Lewis)

## Forms
#### Class: BasicNamesDeclension

1. NOMINATIVE
2. GENETIVE
3. DATIVE
4. ACCUSATIVE
5. ABLATIVE
6. PREPOSITIONAL

#### Language: Russian, Class: BasicNamesDeclension

1. IMENIT_1
2. RODIT_2
3. DAT_3
4. VINIT_4
5. TVORIT_5
6. PREDLOJ_6

# Nouns declension
## Tutorial

* Download library through composer:
    `composer require "wapmorgan/morphos"`

* Create an instance of declension class:
    ```php
    $dec = new morphos\RussianGeneralDeclension();
    ```

#### Singular

  * How to get all forms:
    ```php
    $forms = $dec->getForms('поле', false);
    ```
    If word is animate, set true instead of false.

  * How to get one form:
    ```php
    $form = $dec->getForm('поле', false, morphos\RussianDeclensions::PREDLOJ_6);
    ```

#### Plural

  * How to get all plural forms:

    ```php
    $forms = $dec->pluralizeAllDeclensions('поле', false);
    ```

#### Examples
  *Singular*
  ```
  array(6) {
    ["nominativus"]=>
    string(6) "дом"
    ["genetivus"]=>
    string(8) "дома"
    ["dativus"]=>
    string(8) "дому"
    ["accusative"]=>
    string(6) "дом"
    ["ablativus"]=>
    string(10) "домом"
    ["praepositionalis"]=>
    string(8) "доме"
  }
  ```

  *Plural*
  ```
  array(6) {
    ["nominativus"]=>
    string(8) "дома"
    ["genetivus"]=>
    string(10) "домов"
    ["dativus"]=>
    string(10) "домам"
    ["accusative"]=>
    string(8) "дома"
    ["ablativus"]=>
    string(12) "домами"
    ["praepositionalis"]=>
    string(10) "домах"
  }
  ```

  *Singular*
  ```
  array(6) {
    ["nominativus"]=>
    string(8) "поле"
    ["genetivus"]=>
    string(8) "поля"
    ["dativus"]=>
    string(8) "полю"
    ["accusative"]=>
    string(8) "поле"
    ["ablativus"]=>
    string(10) "полем"
    ["praepositionalis"]=>
    string(8) "поле"
  }
  ```

  *Plural*
  ```
    array(6) {
    ["nominativus"]=>
    string(8) "поля"
    ["genetivus"]=>
    string(10) "полей"
    ["dativus"]=>
    string(10) "полям"
    ["accusative"]=>
    string(8) "поля"
    ["ablativus"]=>
    string(12) "полями"
    ["praepositionalis"]=>
    string(10) "полях"
  }
  ```

### Addition of new languages.
To add a new language simply: create the class inheriting BasicDeclension and realize three abstract methods from BasicDeclension:

* Checks, whether there are rules for this noun.
  ```php
  public function hasForms($word, $animate = false);
  ```

* Generates all forms of a noun.
  ```php
  public function getForms($word, $animate = false);
  ```

* Generates one form of a noun.
  ```php
  public function getForm($word, $form, $animate = false);
  ```

**This part (general declension) is a proof of concept "a morphological decision without a dictionary" and is not proposed to be used in production.**
