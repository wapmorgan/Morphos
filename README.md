# Morphos
A morphological solution written completely in PHP.

[![Composer package](http://xn--e1adiijbgl.xn--p1acf/badge/wapmorgan/morphos)](https://packagist.org/packages/wapmorgan/morphos)
[![Latest Stable Version](https://poser.pugx.org/wapmorgan/morphos/v/stable)](https://packagist.org/packages/wapmorgan/morphos)
[![License](https://poser.pugx.org/wapmorgan/morphos/license)](https://packagist.org/packages/wapmorgan/morphos)
[![Total Downloads](https://poser.pugx.org/wapmorgan/morphos/downloads)](https://packagist.org/packages/wapmorgan/morphos)
[![Latest Unstable Version](https://poser.pugx.org/wapmorgan/morphos/v/unstable)](https://packagist.org/packages/wapmorgan/morphos)

Tests & Quality: [![Build Status](https://travis-ci.org/wapmorgan/Morphos.svg)](https://travis-ci.org/wapmorgan/Morphos)
[![Scrutinizer Code Quality](https://scrutinizer-ci.com/g/wapmorgan/Morphos/badges/quality-score.png?b=master)](https://scrutinizer-ci.com/g/wapmorgan/Morphos/?branch=master)

Supported languages:

* English - pluralization.
* Russian - pluralization and declension.

# Installation

* Download library through composer:
    `composer require "wapmorgan/morphos"`

# Declension

## Russian

### First names
Declension of first names in russian language:

1. Create declension class object:
    ```php
    use morphos\RussianCases;
    use morphos\RussianNamesDeclension;

    $dec = new RussianNamesDeclension();
    ```

2. Check whether there are forms for this name:
    ```php
    var_dump($dec->hasForms('Иван', RussianNamesDeclension::MAN)); // true
    ```

3. Get all forms of a name:
    ```php
    var_dump($dec->getForms('Иван', RussianNamesDeclension::MAN));
    /* Will produce something like
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
    */
    ```

4. Get one form of a name:
    ```php
    var_dump($dec->getForm('Иван', RussianCases::RODIT, RussianNamesDeclension::MAN)); // Ивана
    ```

### Last names
Declension of last names in russian language:

1. Create declension class object:
    ```php
    use morphos\RussianCases;
    use morphos\RussianLastNamesDeclension;

    $dec = new RussianLastNamesDeclension();
    ```

2. Check whether there are forms for this name:
    ```php
    var_dump($dec->hasForms('Иванов', RussianNamesDeclension::MAN)); // true
    ```

3. Get all forms of a name:
    ```php
    var_dump($dec->getForms('Иван', RussianNamesDeclension::MAN));
    /* Will produce something like
      array(6) {
      ["nominativus"]=>
      string(12) "Иванов"
      ["genetivus"]=>
      string(14) "Иванова"
      ["dativus"]=>
      string(14) "Иванову"
      ["accusative"]=>
      string(14) "Иванова"
      ["ablativus"]=>
      string(16) "Ивановым"
      ["praepositionalis"]=>
      string(19) "об Иванове"
    }
    */
    ```

4. Get one form of a name:
    ```php
    var_dump($dec->getForm('Иванов', RussianCases::RODIT, RussianNamesDeclension::MAN)); // Иванова
    ```

### General words
Declension of general words in russian language:

1. Create declension class object:
    ```php
    use morphos\RussianCases;
    use morphos\RussianGeneralDeclension;

    $dec = new RussianGeneralDeclension();
    ```

2. Check whether there are forms for this word (second arg is an animateness):
    ```php
    var_dump($dec->hasForms('поле', false));
    ```

3. Get all forms of a word:
    ```php
    var_dump($dec->getForms('поле', false));
    /* Will produce something like
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
    */
    ```

4. Get one form of a word:
    ```php
    var_dump($dec->getForm('поле', false, RussianCases::RODIT)); // поля
    ```

5. Get all forms of a plural word:
    ```php
    var_dump($dec->pluralizeAllDeclensions('поле', false));
    /* Result will be like
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
    */
    ```

**Declension of general words is very complicated and may fail.**

### Cases

1. Cases in russian language:

    * morphos\RussianCases::IMENIT
    * morphos\RussianCases::RODIT
    * morphos\RussianCases::DAT
    * morphos\RussianCases::VINIT
    * morphos\RussianCases::TVORIT
    * morphos\RussianCases::PRODLOJ


# Pluralization

1. Pluralization a word in Russian:
    ```php
    use morphos\RussianPlurality;

    $plu = new RussianPlurality();
    $word = 'дом';
    $count = 10;

    echo $count.' '.$plu->pluralize($word, $count, false));
    // result: 10 домов
    ```

2. Pluralization a word in English:

    ```php
    use morphos\EnglishPlurality;

    $plu = new EnglishPlurality();
    $word = 'foot';
    $count = 10;
    echo $count.' '.$plu->pluralize($word, $count));
    // result: 10 feet
    ```

## Contributing / Addition of new languages.

`Morphos` are open for additions and improvements.

Addition a new language is simple: create the class inheriting one of basic classes and realize abstract methods from it.

Here is a list of basic classes:

#### BasicNamesDeclension

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

#### BasicDeclension

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
