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
        1. Cardinal numerals
        2. Ordinal numerals
    4. Cases
4. English
    1. Pluralization
    2. Numeral creation
        1. Cardinal numerals
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
var_dump(morphos\Russian\nameCase('Иванов Петр', 'родительный', morphos\NamesDeclension::MAN)); // Иванова Петра
var_dump(morphos\Russian\nameCase('Кулаков Святослав Матвеевич', 'родительный', morphos\NamesDeclension::MAN)); // Кулакова Святослава Матвеевича
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

Generate russian ordinal numerals:

```php
var_dump(morphos\Russian\OrdinalNumeral::generate(961)); // девятьсот шестьдесят первый
```

Pluralize english nouns:

```php
var_dump(morphos\English\Plurality::pluralize('house')); // houses
```

Generate english cardinal numerals:

```php
var_dump(morphos\English\CardinalNumeral::generate(567)); // five hundred sixty-seven
```

# Russian

Russian morphology:

```php
morphos\
        Russian\
                CardinalNumeral
                Cases
                GeneralDeclension
                FirstNamesDeclension
                LastNamesDeclension
                MiddleNamesDeclension
                OrdinalNumeral
                Plurality

                nameCase()
```

## Declension

To compound all declension functionality in one call there is `nameCase` function:

```php
string|array nameCase($name, $case = null, $gender = null)
```

Arguments:

- `$name` - full name as `Фамилия Имя` or `Фамилия Имя Отчество`.
- `$case` - can be `null`, one of `Cases` constants, a string (described below in `Cases` section). If not null, a string will be returned. If null, an array will be returned.
- `$gender` - `NamesDeclension::MAN` or `NamesDeclension::WOMAN` or `null` for autodetection.

### Declension classes

All declension classes are similar and have four common methods:

- `boolean isMutable($word, $gender = null)` - Check if name is mutable.
- `string getCase($word, $case, $gender = null)` - Declines name. `$case` is one constant of `morphos\Cases` or `morphos\Russian\Cases` class constants (described below).
- `array getCases($word, $gender = null)` - Declines name to all cases.
- `string detectGender($word)` - Tries to detect gender for given name.

`$gender` is `NamesDeclension::MAN` or `NamesDeclension::WOMAN` or `null` for autodetection. **Note that detection of middle name and last name can make right decision, but first names sometimes can not be used to determine gender of it's owner. Especially if name is not native Russian name.** So just specify gender if you want to declinate first names.

#### First names (`FirstNamesDeclension`)
_Declension of first names in russian language._

Usage:

```php
use morphos\Russian\FirstNamesDeclension;

$dec = new FirstNamesDeclension();

// Get any form of a name:
// for example, let it be Иван
$user_name = 'Иван';

$name = $dec->getCase($user_name, 'родительный');

// If you need all forms, you can get all forms of a name:
var_dump($dec->getCases($user_name));
/* Will produce something like
  array(6) {
    ["nominative"]=>
    string(8) "Иван"
    ["genitive"]=>
    string(10) "Ивана"
    ["dative"]=>
    string(10) "Ивану"
    ["accusative"]=>
    string(10) "Ивана"
    ["ablative"]=>
    string(12) "Иваном"
    ["prepositional"]=>
    string(15) "об Иване"
  }
*/
```

#### Middle names (`MiddleNamesDeclension`)
_Declension of middle names in russian language._

Usage:

```php
use morphos\Russian\MiddleNamesDeclension;

$dec = new MiddleNamesDeclension();

// Get any form of a name:
// for example, let it be Сергеевич
$user_name = 'Сергеевич';

$name = $dec->getCase($user_name, 'родительный');

// If you need all forms, you can get all forms of a name:
var_dump($dec->getCases($user_name));
/* Will produce something like
  array(6) {
    ["nominative"]=>
    string(18) "Сергеевич"
    ["genitive"]=>
    string(20) "Сергеевича"
    ["dative"]=>
    string(20) "Сергеевичу"
    ["accusative"]=>
    string(20) "Сергеевича"
    ["ablative"]=>
    string(22) "Сергеевичем"
    ["prepositional"]=>
    string(23) "о Сергеевиче"
  }
*/
```

#### Last names (`LastNamesDeclension`)
_Declension of last names in russian language._

Usage:

```php
use morphos\Russian\LastNamesDeclension;

$dec = new LastNamesDeclension();

// Get any case of a last name
$user_last_name = 'Иванов';

$dative_last_name = $dec->getCase($user_last_name, 'родительный');

echo 'Мы хотим подарить товарищу '.$dative_last_name.' небольшой презент.';

// If you need all forms, you can get all forms of a name:
var_dump($dec->getCases($user_last_name));
/* Will produce something like
  array(6) {
    ["nominative"]=>
    string(12) "Иванов"
    ["genitive"]=>
    string(14) "Иванова"
    ["dative"]=>
    string(14) "Иванову"
    ["accusative"]=>
    string(14) "Иванова"
    ["ablative"]=>
    string(16) "Ивановым"
    ["prepositional"]=>
    string(19) "об Иванове"
  }
*/
```

### General words (`GeneralDeclension`)
_Declension of nouns in russian language._

General declension class also have few similar methods but arguments are different:

- `boolean isMutable($word, bool $animateness = false)` - Check if noun is mutable.
- `string getCase($word, $case, $animateness = false)` - Declines noun.
- `array getCases($word, $animateness = false)` - Declines noun to all cases.

Create declension class object:

```php
use morphos\Russian\GeneralDeclension;

$dec = new GeneralDeclension();
```

Following code will return original word if it's immutable:

```php
$form = $dec->getCase('поле', 'родительный');
```

Get all forms of a word at once:

```php
var_dump($dec->getCases('линейка'));
/* Will produce something like
  array(6) {
    ["nominative"]=>
    string(14) "линейка"
    ["genitive"]=>
    string(14) "линейки"
    ["dative"]=>
    string(14) "линейке"
    ["accusative"]=>
    string(14) "линейку"
    ["ablative"]=>
    string(16) "линейкой"
    ["prepositional"]=>
    string(17) "о линейке"
  }
*/
```

## Pluralization (`Plurality`)
_Pluralization nouns in Russian._

This class have similar methods but not only:

- `string getCase($word, $case, $animateness = false)` - Pluralizes noun and declines.
- `array getCases($word, $animateness = false)` - Pluralizes noun and declines to all cases.
- `string @pluralize($word, $count, $animateness = false)` - Pluralizes noun to coincide with numeral.

Get plural form of a noun:

```php
use morphos\Russian\Plurality;

$plu = new Plurality();

$word = 'дом';
echo 'Множественное число для '.$word.' - '.$plu->getCase($word, 'именительный'); // дома
```

Pluralize word and get all forms:

```php
var_dump($plu->getCases('поле'));
/* Result will be like
  array(6) {
    ["nominative"]=>
    string(8) "поля"
    ["genitive"]=>
    string(10) "полей"
    ["dative"]=>
    string(10) "полям"
    ["accusative"]=>
    string(8) "поля"
    ["ablative"]=>
    string(12) "полями"
    ["prepositional"]=>
    string(13) "о полях"
  }
*/
```

Pluralize noun to use it with numeral:

```php
use morphos\Russian\Plurality;

$word = 'дом';
$count = 10;

echo $count.' '.Plurality::pluralize($word, $count, false); // result: 10 домов
```

## Numeral creation

All number creation classes are similar and have three common methods:

- `string getCase($number, $case, $gender = NumeralCreation::MALE)` - Get one case of a numeral for a number.
- `array getCases($number, $gender = NumeralCreation::MALE)` - Get all case of a numeral for a number.
- `string @generate($number, $gender = NumeralCreation::MALE)` - Generates a cardinal or ordinal numeral for a number.

`$gender` is one of `morphos\NumeralCreation` constants: `MALE` or `FEMALE` or `NEUTER`.

### Cardinal numbers (`CardinalNumeral`)

_Creation of cardinal numerals in russian language._

Create generation class object:

```php
use morphos\NumeralCreation;
use morphos\Russian\CardinalNumeral;

$cardinal = new CardinalNumeral();
```

Get text representation of a number:

```php
$number = 4351;

$numeral = $cardinal->getCase($number, 'именительный'); // четыре тысячи триста пятьдесят один
$numeral = $cardinal->getCase($number, 'именительный', NumeralCreation::FEMALE); // четыре тысячи триста пятьдесят одна
```

If you need all forms, you can get all cases of a numeral:

```php
var_dump($cardinal->getCases($number));
/* Will produce something like
  array(6) {
    ["nominative"]=>
    string(66) "четыре тысячи триста пятьдесят один"
    ["genitive"]=>
    string(74) "четырех тысяч трехсот пятидесяти одного"
    ["dative"]=>
    string(80) "четырем тысячам тремстам пятидесяти одному"
    ["accusative"]=>
    string(66) "четыре тысячи триста пятьдесят один"
    ["ablative"]=>
    string(90) "четырьмя тысячами тремястами пятьюдесятью одним"
    ["prepositional"]=>
    string(81) "о четырех тысячах трехстах пятидесяти одном"
  }
*/
```

Generate numeral of a number:

```php
use morphos\Russian\CardinalNumeral;

echo CardinalNumeral::generate(4351);
// result: четыре тысячи триста пятьдесят один
```

### Ordinal numbers (`OrdinalNumeral`)

_Creation of ordinal numerals in russian language._

Create generation class object:

```php
use morphos\NumeralCreation;
use morphos\Russian\OrdinalNumeral;

$ordinal = new OrdinalNumeral();
```

Get text representation of a number:

```php
$number = 67945;

$numeral = $ordinal->getCase($number, 'именительный'); // шестьдесят семь тысяч девятьсот сорок пятый
$numeral = $ordinal->getCase($number, 'именительный', NumeralCreation::FEMALE); // шестьдесят семь тысяч девятьсот сорок пятая
```

If you need all forms, you can get all cases of a numeral:

```php
var_dump($ordinal->getCases($number));
/* Will produce something like
  array(6) {
      ["nominative"]=>
      string(81) "шестьдесят семь тысяч девятьсот сорок пятый"
      ["genitive"]=>
      string(83) "шестьдесят семь тысяч девятьсот сорок пятого"
      ["dative"]=>
      string(83) "шестьдесят семь тысяч девятьсот сорок пятому"
      ["accusative"]=>
      string(81) "шестьдесят семь тысяч девятьсот сорок пятый"
      ["ablative"]=>
      string(81) "шестьдесят семь тысяч девятьсот сорок пятым"
      ["prepositional"]=>
      string(84) "о шестьдесят семь тысяч девятьсот сорок пятом"
    }
*/
```

Generate numeral of a number:

```php
use morphos\Russian\OrdinalNumeral;

echo CardinalNumeral::generate(67945);
// result: шестьдесят семь тысяч девятьсот сорок пятый
```

## Cases (`Cases`)
Cases in russian language:

* `morphos\Russian\Cases::IMENIT` or `именительный` - nominative case
* `morphos\Russian\Cases::RODIT` or `родительный` - genitive case
* `morphos\Russian\Cases::DAT` or `дательный` - dative case
* `morphos\Russian\Cases::VINIT` or `винительный` - accusative case
* `morphos\Russian\Cases::TVORIT` or `творительный` - ablative case
* `morphos\Russian\Cases::PREDLOJ` or `предложный` - prepositional case

# English

English morphology:
```php
morphos\
        English\
                CardinalNumeral
                Plurality
```

## Pluralization (`Plurality`)
Pluralization a word in English:

```php
use morphos\English\Plurality;

echo '10 '.Plurality::pluralize('foot');
// result: 10 feet
```

## Numeral creation

All number creation classes are similar and have one common methods:

- `string @generate($number)` - Generates a cardinal numeral for a number.

### Cardinal numbers (`CardinalNumeral`)

_Creation of cardinal numerals in russian language._

Create declension class object:

```php
use morphos\English\CardinalNumeral;
```

Get text representation of a number:

```php
$number = 4351;

$numeral = CardinalNumeral::generate($number); // four thousand, three hundred fifty-one
```

# Addition of new languages

See [CONTRIBUTING.md](CONTRIBUTING.md) for this.
