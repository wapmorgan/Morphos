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
2. Quick start
3. Russian
    1. Declension
        1. First names
        2. Middle names
        3. Last names
        4. Nouns
    2. Pluralization
    3. Numeral creation
    4. Cases
4. English
    1. Pluralization
5. Addition of new languages

## Installation

* Download library through composer:
```
composer require wapmorgan/morphos
```

Adapters:

- Adapter for Laravel (Blade): [wapmorgan/morphos-blade](https://github.com/wapmorgan/Morphos-Blade)
- Adapter for Symfony (Twig): [wapmorgan/morphos-twig](https://github.com/wapmorgan/Morphos-Twig)

## Quick Start
Decline russian names:

```php
var_dump(morphos\Russian\nameCase('Иванов Петр', morphos\Cases::GENETIVE, morphos\NamesDeclension::MAN)); // Иванова Петра
var_dump(morphos\Russian\nameCase('Кулаков Святослав Матвеевич', morphos\Cases::GENETIVE, morphos\NamesDeclension::MAN)); // Кулакова Святослава Матвеевича
```

Pluralize russian nouns:

```php
var_dump(morphos\Russian\Plurality::pluralize('дом', 10)); // домов
var_dump(morphos\Russian\Plurality::pluralize('гидродендрариум', 2)); // гидродендрариума
```

Generate russian cardinal numerals:

```php
var_dump(morphos\Russian\CardinalNumeral::generate(567)); // пятьсот шестьдесят семь
```

Pluralize english nouns:

```php
var_dump(morphos\English\Plurality::pluralize('house', 10)); // houses
```

# Russian

Russian morphology:

```php
morphos\
        Russian\
                nameCase()
                detectGender()
                Cases
                FirstNamesDeclension
                LastNamesDeclension
                GeneralDeclension
                Plurality
                CardinalNumeral
```

## Declension

To compound all declension functionality in one call there is `nameCase` function:

```php
string|array nameCase($name, $case = null, $gender = null)
```

Arguments:

- `$name` - full name as `Фамилия Имя` or `Фамилия Имя Отчество`.
- `$case` - can be `null` or one of `Cases` constants. If constant, a string will be returned. If null, an array will be returned.
- `$gender` - `NamesDeclension::MAN` or `NamesDeclension::WOMAN` or `null`.

### Declension classes

All declension classes are similar and have three common methods:

- `boolean hasForms($word, $gender)` - Check if name is mutable.
- `string getForm($word, $case, $gender)` - Declines name.
- `array getForms($word, $gender)` - Declines name to all cases.
- `string detectGender($word)` - Tries to detect gender for given name.

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
if ($dec->hasForms($user_name, $dec->detectGender($user_name))) {
    $name = $dec->getForm($user_name, Cases::RODIT, $dec->detectGender($user_name));
} else { // immutable name
    $name = $user_name;
}
```

If you need all forms, you can get all forms of a name:

```php
var_dump($dec->getForms($user_name, $dec->detectGender($user_name)));
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

#### Middle names (`MiddleNamesDeclension`)
_Declension of middle names in russian language._

Create declension class object:

```php
use morphos\NamesDeclension;
use morphos\Russian\Cases;
use morphos\Russian\MiddleNamesDeclension;

$dec = new MiddleNamesDeclension();
```

Check whether there are forms for this name and if they exist get it:

```php
// for example, let it be Иван
$user_name = 'Сергеевич';

$name = $dec->getForm($user_name, Cases::RODIT, $dec->detectGender($user_name));
```

If you need all forms, you can get all forms of a name:

```php
var_dump($dec->getForms($user_name, $dec->detectGender($user_name)));
/* Will produce something like
  array(6) {
    ["nominativus"]=>
    string(18) "Сергеевич"
    ["genetivus"]=>
    string(20) "Сергеевича"
    ["dativus"]=>
    string(20) "Сергеевичу"
    ["accusative"]=>
    string(20) "Сергеевича"
    ["ablativus"]=>
    string(22) "Сергеевичем"
    ["praepositionalis"]=>
    string(23) "о Сергеевиче"
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

if ($dec->hasForms($user_last_name, $dec->detectGender($user_last_name))) {
    $dativus_last_name = $dec->getForm($user_last_name, Cases::RODIT, $dec->detectGender($user_last_name));
} else { // immutable last name
    $dativus_last_name = $user_last_name;
}

echo 'Мы хотим подарить товарищу '.$dativus_last_name.' небольшой презент.';
```

If you need all forms, you can get all forms of a name:

```php
var_dump($dec->getForms($user_last_name, $dec->detectGender($user_last_name)));
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
var_dump($dec->getForms('линейка', false));
/* Will produce something like
  array(6) {
    ["nominativus"]=>
    string(14) "линейка"
    ["genetivus"]=>
    string(14) "линейкы"
    ["dativus"]=>
    string(14) "линейке"
    ["accusative"]=>
    string(14) "линейку"
    ["ablativus"]=>
    string(16) "линейкой"
    ["praepositionalis"]=>
    string(17) "о линейке"
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

## Numeral creation

All number creation classes are similar and have two common methods:

- `string getForm($number, $case, $gender = NumeralCreation::MALE)` - Get one form of a number.
- `array getForms($number, $gender = NumeralCreation::MALE)` - Get all forms of a number.
- `string #generate($number, $gender = NumeralCreation::MALE)` - Generates a cardinal numeral for a number.

`$gender` is one of `morphos\NumeralCreation` constants: `MALE` or `FEMALE` or `NEUTER`.

### Cardinal numbers (`CardinalNumeral`)

_Creation of cardinal numerals in russian language._

Create declension class object:

```php
use morphos\NumeralCreation;
use morphos\Russian\CardinalNumeral;
use morphos\Russian\Cases;

$cardinal = new CardinalNumeral();
```

Get text representation of a number:

```php
$number = 4351;

$numeral = $cardinal->getForm($number, Cases::IMENIT); // четыре тысячи триста пятьдесят один
$numeral = $cardinal->getForm($number, Cases::IMENIT, NumeralCreation::FEMALE); // четыре тысячи триста пятьдесят одна
```

If you need all forms, you can get all forms of a name:

```php
var_dump($cardinal->getForms($number));
/* Will produce something like
  array(6) {
    ["nominativus"]=>
    string(66) "четыре тысячи триста пятьдесят один"
    ["genetivus"]=>
    string(74) "четырех тысяч трехсот пятидесяти одного"
    ["dativus"]=>
    string(80) "четырем тысячам тремстам пятидесяти одному"
    ["accusative"]=>
    string(66) "четыре тысячи триста пятьдесят один"
    ["ablativus"]=>
    string(90) "четырьмя тысячами тремястами пятьюдесятью одним"
    ["praepositionalis"]=>
    string(81) "о четырех тысячах трехстах пятидесяти одном"
  }
*/
```

Generate numeral of a number:

```php
use morphos\Russian\CardinalNumeral;

$number = 4351;

echo CardinalNumeral::generate($number);
// result: четыре тысячи триста пятьдесят один
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
