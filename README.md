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
    1. Declension
        1. First names
        2. Last names
        3. Nouns
    2. Pluralization
    3. Cases
3. English
    1. Pluralization
4. Addition of new languages

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

### Names declension
All declension classes are similar and have three common methods:

- `boolean hasForms($word, $gender)` - Check if name is mutable.
- `string getForm($word, $case, $gender)` - Declines name.
- `array getForms($word, $gender)` - Declines name to all cases.

`Gender` is one value of:
- `NamesDeclension::MAN` or `m`
- `NamesDeclension::WOMAN` or `w`

`Case` is one constant of `Cases` class constants (described below).

#### First names (`FirstNamesDeclension`)
_Declension of first names in russian language._

Create declension class object:

```php
use morphos\NamesDeclension;
use morphos\Russian\Cases;
use morphos\Russian\FirstNamesDeclension;

$dec = new FirstNamesDeclension();
```

Check whether there are forms for this name and if they exist get it:

```php
// for example, let it be Иван
$user_name = 'Иван';

// we want to get it's genetivus form
if ($dec->hasForms($user_name, NamesDeclension::MAN)) {
    $name = $dec->getForm($user_name, Cases::RODIT, NamesDeclension::MAN);
} else { // immutable name
    $name = $user_name;
}
```

If you need all forms, you can get all forms of a name:

```php
var_dump($dec->getForms($user_name, NamesDeclension::MAN));
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

#### Last names (`LastNamesDeclension`)
_Declension of last names in russian language._

Create declension class object:

```php
use morphos\NamesDeclension;
use morphos\Russian\Cases;
use morphos\Russian\LastNamesDeclension;

$dec = new LastNamesDeclension();
```

Check whether there are forms for this name and if they exist get it:

```php
$user_last_name = 'Иванов';

if ($dec->hasForms($user_last_name, NamesDeclension::MAN)) {
    $dativus_last_name = $dec->getForm($user_last_name, Cases::RODIT, NamesDeclension::MAN);
} else { // immutable last name
    $dativus_last_name = $user_last_name;
}

echo 'Мы хотим подарить товарищу '.$dativus_last_name.' небольшой презент.';
```

If you need all forms, you can get all forms of a name:

```php
var_dump($dec->getForms($user_last_name, NamesDeclension::MAN));
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

### General words (`GeneralDeclension`)
_Declension of nouns in russian language._

General declension class also have few similar methods but arguments are different:

- `boolean hasForms($word, bool $animateness = false)` - Check if noun is mutable.
- `string getForm($word, $case, $animateness = false)` - Declines noun.
- `array getForms($word, $animateness = false)` - Declines noun to all cases.

Create declension class object:

```php
use morphos\Russian\Cases;
use morphos\Russian\GeneralDeclension;

$dec = new GeneralDeclension();
```

Check whether there are forms for this word (second arg is an animateness) and get them:

```php
if ($dec->hasForms('поле', false)) {
    $form = $dec->getForm('поле', Cases::RODIT, false);
}
```

Get all forms of a word at once:

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


## Pluralization (`Plurality`)
_Pluralization nouns in Russian._

This class have similar methods but not only:

- `string getForm($word, $case, $animateness = false)` - Pluralizes noun and declines.
- `array getForms($word, $animateness = false)` - Pluralizes noun and declines to all cases.
- `string #pluralize($word, $count, $animateness = false)` - Pluralizes noun to coincide with numeral.

Get plural form of a noun:

```php
use morphos\Russian\Cases;
use morphos\Russian\Plurality;
$plu = new Plurality();

$word = 'дом';
$plural = $plu->getForm($word, Cases::IMENIT);
echo 'Множественное число для '.$word.' - '.$plural;
```

Pluralize word and get all forms:

```php
var_dump($plu->getForms('поле', false));
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

Pluralize noun to use it with numeral:

```php
use morphos\Russian\Plurality;

$word = 'дом';
$count = 10;

echo $count.' '.Plurality::pluralize($word, $count, false);
// result: 10 домов
```

## Cases (`Cases`)
Cases in russian language:

* `morphos\Russian\Cases::IMENIT` - nominative case
* `morphos\Russian\Cases::RODIT` - genetive case
* `morphos\Russian\Cases::DAT` - dative case
* `morphos\Russian\Cases::VINIT` - accusative case
* `morphos\Russian\Cases::TVORIT` - ablative case
* `morphos\Russian\Cases::PREDLOJ` - prepositional case

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
echo $count.' '.$plu->pluralize($word, $count);
// result: 10 feet
```

# Addition of new languages

See [CONTRIBUTING.md](CONTRIBUTING.md) for this.
