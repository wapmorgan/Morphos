[![Build Status](https://travis-ci.org/wapmorgan/Morphos.svg)](https://travis-ci.org/wapmorgan/Morphos)

Morphos - a morphological decision written completely in PHP.

At the moment the main functionality is declension of personal names.
Total supported languages: 1 (Russian).

## Tutorial.

* Download library through composer:
    `composer require "wapmorgan/morphos"`

* Create an instance of declension class:
    ```php
    $dec = new morphos\RussianDeclension();
    ```

* Check whether there are forms for this name (need to know a gender)
    ```php
    var_dump($dec->hasForms('Иоанн', morphos\RussianDeclension::MAN))); //true
    ```

* Get one of forms:
    ```php
    var_dump($dec->getForm('Иоанн', morphos\RussianDeclension::DAT_3, morphos\RussianDeclension::MAN)); // Иоанна
    ```

* Get all forms:
    ```php
    var_dump($dec->getForms('Иоанн', morphos\RussianDeclension::MAN));
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
To add a new language simply: create the class inheriting BasicDeclension and realize three abstract methods from BasicDeclension:

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
#### Class: BasicDeclension

1. NOMINATIVE
2. GENETIVE
3. DATIVE
4. ACCUSATIVE
5. ABLATIVE
6. PREPOSITIONAL

#### Language: Russian, Class: RussianDeclension

1. IMENIT_1
2. RODIT_2
3. DAT_3
4. VINIT_4
5. TVORIT_5
6. PREDLOJ_6
