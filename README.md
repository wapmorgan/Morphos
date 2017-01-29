# Morphos
A morphological solution written completely in PHP.

[![Composer package](http://xn--e1adiijbgl.xn--p1acf/badge/wapmorgan/morphos)](https://packagist.org/packages/wapmorgan/morphos)
[![Latest Stable Version](https://poser.pugx.org/wapmorgan/morphos/v/stable)](https://packagist.org/packages/wapmorgan/morphos)
[![License](https://poser.pugx.org/wapmorgan/morphos/license)](https://packagist.org/packages/wapmorgan/morphos)
[![Total Downloads](https://poser.pugx.org/wapmorgan/morphos/downloads)](https://packagist.org/packages/wapmorgan/morphos)
[![Latest Unstable Version](https://poser.pugx.org/wapmorgan/morphos/v/unstable)](https://packagist.org/packages/wapmorgan/morphos)

Tests & Quality: [![Build Status](https://travis-ci.org/wapmorgan/Morphos.svg)](https://travis-ci.org/wapmorgan/Morphos)
[![Scrutinizer Code Quality](https://scrutinizer-ci.com/g/wapmorgan/Morphos/badges/quality-score.png?b=master)](https://scrutinizer-ci.com/g/wapmorgan/Morphos/?branch=master)

1. Installation
2. Russian
3. English
4. Contributing / Addition of new languages

## Installation

* Download library through composer:
    `composer require "wapmorgan/morphos"`

# Russian

Russian morphology:

```php
morphos\
        Russian\
                Cases
                FirstNamesDeclension
                LastNamesDeclension
                GeneralDeclension
                Plurality
```

## Declension

### First names (`FirstNamesDeclension`)
Declension of first names in russian language:

1. Create declension class object:

    ```php
    use morphos\Russian\Cases;
    use morphos\Russian\FirstNamesDeclension;

    $dec = new FirstNamesDeclension();
    ```

2. Check whether there are forms for this name:

    ```php
    var_dump($dec->hasForms('Иван', FirstNamesDeclension::MAN)); // true
    ```

3. Get all forms of a name:

    ```php
    var_dump($dec->getForms('Иван', FirstNamesDeclension::MAN));
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
    var_dump($dec->getForm('Иван', Cases::RODIT, FirstNamesDeclension::MAN)); // Ивана
    ```

### Last names (`LastNamesDeclension`)
Declension of last names in russian language:

1. Create declension class object:

    ```php
    use morphos\Russian\Cases;
    use morphos\Russian\LastNamesDeclension;

    $dec = new LastNamesDeclension();
    ```

2. Check whether there are forms for this name:

    ```php
    var_dump($dec->hasForms('Иванов', LastNamesDeclension::MAN)); // true
    ```

3. Get all forms of a name:

    ```php
    var_dump($dec->getForms('Иванов', LastNamesDeclension::MAN));
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
    var_dump($dec->getForm('Иванов', Cases::RODIT, LastNamesDeclension::MAN)); // Иванова
    ```

### General words (`GeneralDeclension`)
Declension of general words in russian language:

1. Create declension class object:

    ```php
    use morphos\Russian\Cases;
    use morphos\Russian\GeneralDeclension;

    $dec = new GeneralDeclension();
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
    var_dump($dec->getForm('поле', false, Cases::RODIT)); // поля
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

### Cases (`Cases`)
Cases in russian language:

* morphos\Russian\Cases::IMENIT
* morphos\Russian\Cases::RODIT
* morphos\Russian\Cases::DAT
* morphos\Russian\Cases::VINIT
* morphos\Russian\Cases::TVORIT
* morphos\Russian\Cases::PRODLOJ

## Pluralization (`Plurality`)
Pluralization a word in Russian:

```php
use morphos\Russian\Plurality;

$plu = new Plurality();
$word = 'дом';
$count = 10;

echo $count.' '.$plu->pluralize($word, $count, false));
// result: 10 домов
```

# English

English morphology:
```php
morphos\
        English\
                Plurality
```

## Pluralization (`Plurality`)
Pluralization a word in English:

```php
use morphos\English\Plurality;

$plu = new Plurality();
$word = 'foot';
$count = 10;
echo $count.' '.$plu->pluralize($word, $count));
// result: 10 feet
```

## Contributing / Addition of new languages

See [CONTRIBUTING.md](CONTRIBUTING.md) for this.
