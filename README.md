[![Latest Stable Version](https://poser.pugx.org/wapmorgan/morphos/v/stable)](https://packagist.org/packages/wapmorgan/morphos)
[![Total Downloads](https://poser.pugx.org/wapmorgan/morphos/downloads)](https://packagist.org/packages/wapmorgan/morphos)
[![Latest Unstable Version](https://poser.pugx.org/wapmorgan/morphos/v/unstable)](https://packagist.org/packages/wapmorgan/morphos)

[![Build Status](https://travis-ci.org/wapmorgan/Morphos.svg)](https://travis-ci.org/wapmorgan/Morphos)
[![Scrutinizer Code Quality](https://scrutinizer-ci.com/g/wapmorgan/Morphos/badges/quality-score.png?b=master)](https://scrutinizer-ci.com/g/wapmorgan/Morphos/?branch=master) 
[![Code Coverage](https://scrutinizer-ci.com/g/wapmorgan/Morphos/badges/coverage.png?b=master)](https://scrutinizer-ci.com/g/wapmorgan/Morphos/?branch=master)

Morphos - a morphological solution written completely in PHP.

Supported languages:

* English - pluralization.
* Russian - pluralization and declension.

# Installation

* Download library through composer:
    `composer require "wapmorgan/morphos"`

# Declension
### Personal names
##### Declension of personal names in russian language:

1. Create declension class object:
    ```php
    $dec = new morphos\RussianNamesDeclension();
    ```

2. Check whether there are forms for this name:
    ```php
    var_dump($dec->hasForms('Иван', morphos\RussianNamesDeclension::MAN)); // true
    ```

3. Get all forms of a name:
    ```php
    var_dump($dec->getForms('Иван', morphos\RussianNamesDeclension::MAN)); // array[] {...}
    ```

4. Get one form of a name:
    ```php
    var_dump($dec->getForm('Иван', morphos\RussianCases::RODIT_2, morphos\RussianNamesDeclension::MAN)); // Ивана
    ```

5. All forms for this name:
    ```
    array(6) {
      ["nominativus"]=>
      string(8) "Иван"
      ["genetivus"]=>
      string(10) "Ивана"
      ["dativus"]=>
      string(10) "Ивану"
      ["accusative"]=>
      string(10) "Ивана"
      ["ablativus"]=>
      string(12) "Иваном"
      ["praepositionalis"]=>
      string(15) "об Иване"
    }
    ```

### General words
##### Declension of general words in russian language:

1. Create declension class object:
    ```php
    $dec = new morphos\RussianGeneralDeclension();
    ```

2. Check whether there are forms for this word (second arg is an animateness):
    ```php
    var_dump($dec->hasForms('поле', false));
    ```

3. Get all forms of a word:
    ```php
    var_dump($dec->getForms('поле', false)); // array[] {...}
    ```

4. Get one form of a word:
    ```php
    var_dump($dec->getForm('поле', false, morphos\RussianCases::RODIT_2)); // поля
    ```

5. All forms for this word:
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

6. Get all forms of a plural word:
    ```php
    var_dump($dec->pluralizeAllDeclensions('поле', false)); // array[] {...}
    ```

7. All forms for this plural word:
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

**Declension of general words is very complicated and may fail.**

### Cases

1. Cases in russian language:

    * morphos\RussianCases::IMENIT_1
    * morphos\RussianCases::RODIT_2
    * morphos\RussianCases::DAT_3
    * morphos\RussianCases::VINIT_4
    * morphos\RussianCases::TVORIT_5
    * morphos\RussianCases::PRODLOJ_6


# Pluralization

1. Pluralization a word in Russian:
    ```php
    $plu = new morphos\RussianPlurality();
    $word = 'дом';
    $count = 10;
    echo sprintf("%d %s", $count, $plu->pluralize($word, $count, false)); // last argument - animateness
    ```
    prints `10 домов`

2. Pluralization a word in English:
    ```php
    $plu = new morphos\EnglishPlurality();
    $word = 'foot';
    $count = 10;
    echo sprintf("%d %s", $count, $plu->pluralize($word, $count));
    ```
    prints `10 feet`

# Contributing / Addition of new languages.

Morphos are open for additions and improvements.

Addition a new language is simple: create the class inheriting one of basic classes and realize abstract methods from it.

Here is a list of basic classes:

### BasicNamesDeclension
Class for names declension.

* Checks, whether there are rules for this name.
  ```php
  abstract public function hasForms($name, $gender);
  ```

* Generates all forms of a name.
  ```php
  abstract public function getForms($name, $gender);
  ```

* Generates one form of a name.
  ```php
  abstract public function getForm($name, $form, $gender);
  ```

### BasicDeclension

* Checks, whether there are rules for this word.
  ```php
  public function hasForms($word, $animate = false);
  ```

* Generates all forms of a word.
  ```php
  public function getForms($word, $animate = false);
  ```

* Generates one form of a word.
  ```php
  public function getForm($word, $form, $animate = false);
  ```

### Useful functions in morphos namespace

For simple access to functions of string processing there are some functions in `morphos` namespace:

1. `set_encoding()` - Sets encoding for using in morphos/* functions.
2. `length()` - Calculates count of characters in string.
3. `slice()` - Slices string like python.
4. `lower()` - Lower case.
5. `upper()` - Upper case.
6. `name()` - Name case. (ex: Thomas Lewis)
