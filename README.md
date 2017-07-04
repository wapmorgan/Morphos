# Morphos
A morphological solution for Russian and English language written completely in PHP.

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
    1. Personal names
    2. Geographical names
    3. Nouns
    4. Numerals
        1. Cardinal
        2. Ordinal
    5. Cases
4. English
    1. Nouns
    2. Numerals
        1. Cardinal
5. Contibuting

## Installation

* Download library through composer:
```
composer require wapmorgan/morphos
```

Adapters:

- Adapter for Laravel (Blade): [wapmorgan/morphos-blade](https://github.com/wapmorgan/Morphos-Blade)
- Adapter for Symfony (Twig): [wapmorgan/morphos-twig](https://github.com/wapmorgan/Morphos-Twig)

## Quick Start
- Decline russian names:
  ```php
  morphos\Russian\name('Иванов Петр', 'родительный', morphos\Gender::MALE) => 'Иванова Петра'
  ```

- Pluralize russian nouns:
  ```php
  morphos\Russian\pluralize('дом', 10) => 'домов'
  ```

- Generate russian cardinal numerals:
  ```php
  morphos\Russian\CardinalNumeral::getCase(567, 'именительный') => 'пятьсот шестьдесят семь'
  ```

- Generate russian ordinal numerals:
  ```php
  morphos\Russian\OrdinalNumeral::getCase(961, 'именительный') => 'девятьсот шестьдесят первый'
  ```

- Pluralize english nouns:
  ```php
  morphos\English\pluralize('house') => 'houses'
  ```

- Generate english cardinal numerals:
  ```php
  morphos\English\CardinalNumeral::generate(567) => 'five hundred sixty-seven'
  ```

# Russian

Russian morphology shortcuts:

* `morphos\Russian\name($fullname, $case, $gender = AUTO)`
* `morphos\Russian\pluralize($noun, $count = 2, $animateness = false)`

Russian class hierarchy:

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
```

## Personal names

To compound all declension functionality in one call there is `name` function:

```php
string|array name($name, $case = null, $gender = null)
```

Arguments:

- `$name` - full name as `Фамилия Имя` or `Фамилия Имя Отчество`.
- `$case` - can be `null`, one of `Cases` constants, a string (described below). If not null, a string will be returned. If null, an array will be returned.
- `$gender` - one of `Gender` constants, a string (`"m"` for male name,  `"f"` for female name), `null` for autodetection.

There is three declension classes for partial declension:

- `FirstNamesDeclension` - declension of first names in russian language
- `MiddleNamesDeclension` - declension of middle names in russian language
- `LastNamesDeclension` - declension of last names in russian language

All declension classes are similar and have four common methods:

- `boolean isMutable($word, $gender = null)` - Check if name is mutable.
- `string getCase($word, $case, $gender = null)` - Declines name. `$case` is one constant of `morphos\Cases` or `morphos\Russian\Cases` class constants (described below).
- `array getCases($word, $gender = null)` - Declines name to all cases.
- `string detectGender($word)` - Tries to detect gender for given name.

`$gender` is `morphos\Gender::MALE` (or `"m"`) or `morphos\Gender::FEMALE` (or `"f"`) or `null` for autodetection. **Note that detection of middle name and last name can make right decision, but first names sometimes can not be used to determine gender of it's owner. Especially if name is not native Russian name.** So better to specify gender if you want to declinate first names.

Cases in russian language:

* Nominative case - `morphos\Russian\Cases::IMENIT` or `именительный`
* Genitive case - `morphos\Russian\Cases::RODIT` or `родительный`
* Dative case - `morphos\Russian\Cases::DAT` or `дательный`
* Accusative case - `morphos\Russian\Cases::VINIT` or `винительный`
* Ablative case - `morphos\Russian\Cases::TVORIT` or `творительный`
* Prepositional case - `morphos\Russian\Cases::PREDLOJ` or `предложный`

Examples:

**FirstNamesDeclension**

```php
use morphos\Russian\FirstNamesDeclension;
// Get any form of a name:
// for example, let it be Иван
$user_name = 'Иван';

FirstNamesDeclension::getCase($user_name, 'родительный') => 'Ивана'

// If you need all forms, you can get all forms of a name:
FirstNamesDeclension::getCases($user_name) => array(6) {
    "nominative" => "Иван",
    "genitive" => "Ивана",
    "dative" => "Ивану",
    "accusative" => "Ивана",
    "ablative" => "Иваном",
    "prepositional" => "об Иване"
}
```

**MiddleNamesDeclension**

```php
use morphos\Russian\MiddleNamesDeclension;
// Get any form of a name:
// for example, let it be Сергеевич
$user_name = 'Сергеевич';

MiddleNamesDeclension::getCase($user_name, 'родительный') => 'Сергеевича'

// If you need all forms, you can get all forms of a name:
MiddleNamesDeclension::getCases($user_name) => array(6) {
    "nominative" => "Сергеевич",
    "genitive" => "Сергеевича",
    "dative" => "Сергеевичу",
    "accusative" => "Сергеевича",
    "ablative" => "Сергеевичем",
    "prepositional" => "о Сергеевиче"
}
```

**LastNamesDeclension**

```php
use morphos\Russian\LastNamesDeclension;
// Get any case of a last name
$user_last_name = 'Иванов';

$dative_last_name = LastNamesDeclension::getCase($user_last_name, 'дательный'); // Иванову

echo 'Мы хотим подарить товарищу '.$dative_last_name.' небольшой презент.';

// If you need all forms, you can get all forms of a name:
LastNamesDeclension::getCases($user_last_name) => array(6) {
    "nominative" => "Иванов",
    "genitive" => "Иванова",
    "dative" => "Иванову",
    "accusative" => "Иванова",
    "ablative" => "Ивановым",
    "prepositional" => "об Иванове"
}
```

## Geographical names

You can decline geographical names like cities, countries, streets and so on. It has similar methods:

- `boolean isMutable($name)` - Check if name is mutable.
- `string getCase($name, $case)` - Declines name. `$case` is one constant of `morphos\Cases` or `morphos\Russian\Cases` class constants.
- `array getCases($word null)` - Declines name to all cases.

Example:

```php
use morphos\Russian\GeographicalNamesDeclension;

echo 'Пора бы поехать в '.GeographicalNamesDeclension::getCase('Москва', 'винительный'); // Москву
// If you need all forms, you can get all forms of a name:
GeographicalNamesDeclension::getCases('Саратов') => array(6) {
    "nominative" => "Саратов",
    "genitive" => "Саратова",
    "dative" => "Саратову",
    "accusative" => "Саратов",
    "ablative" => "Саратовом",
    "prepositional" => "о Саратове"
}
```

## Nouns

### Nouns declension

Nouns declension class also have few similar methods but arguments are different:

- `boolean isMutable($word, bool $animateness = false)` - Check if noun is mutable.
- `string getCase($word, $case, $animateness = false)` - Declines noun.
- `array getCases($word, $animateness = false)` - Declines noun to all cases.

Usage:

```php
use morphos\Russian\GeneralDeclension;
// Following code will return original word if it's immutable:
GeneralDeclension::getCase('поле', 'родительный') => 'поля'

// Get all forms of a word at once:
GeneralDeclension::getCases('линейка') => array(6) {
    "nominative" => "линейка",
    "genitive" => "линейки",
    "dative" => "линейке",
    "accusative" => "линейку",
    "ablative" => "линейкой",
    "prepositional" => "о линейке"
}
```

### Nouns pluralization

`Plurality` class have similar methods but not only:

- `string getCase($word, $case, $animateness = false)` - Pluralizes noun and declines.
- `array getCases($word, $animateness = false)` - Pluralizes noun and declines to all cases.
- `string pluralize($word, $count, $animateness = false)` - Pluralizes noun to coincide with numeral.

Usage:

```php
use morphos\Russian\Plurality;

$word = 'дом';
echo 'Множественное число для '.$word.' - '.Plurality::getCase($word, 'именительный'); // дома

// Pluralize word and get all forms:
Plurality::getCases('поле') => array(6) {
    "nominative" => "поля",
    "genitive" => "полей",
    "dative" => "полям",
    "accusative" => "поля",
    "ablative" => "полями",
    "prepositional" => "о полях"
}

// Also you can use shortcut
// Pluralize noun to use it with numeral

$count = 10;

echo $count.' '.morphos\Russian\pluralize('дом', $count, false); // result: 10 домов
```

## Numerals

All number creation classes are similar and have two common methods:

- `string getCase($number, $case, $gender = Gender::MALE)` - Get one case of a numeral for a number.
- `array getCases($number, $gender = Gender::MALE)` - Get all cases of a numeral for a number.

`$gender` is `morphos\Gender::MALE` (or `"m"`) or `morphos\Gender::FEMALE` (or `"f"`) or `morphos\Gender::NEUTER` (or `"n"`).

### Cardinal (`CardinalNumeral`)

_Creation of cardinal numerals (количественные числительные) in russian language._

Example:

```php
use morphos\Gender;
use morphos\Russian\CardinalNumeral;

// Get text representation of a number:
$number = 4351;

CardinalNumeral::getCase($number, 'именительный') => 'четыре тысячи триста пятьдесят один'
CardinalNumeral::getCase($number, 'именительный', Gender::FEMALE) => 'четыре тысячи триста пятьдесят одна'
```

If you need all forms, you can get all cases of a numeral:

```php
CardinalNumeral::getCases($number) => array(6) {
    "nominative" => "четыре тысячи триста пятьдесят один",
    "genitive" => "четырех тысяч трехсот пятидесяти одного",
    "dative" => "четырем тысячам тремстам пятидесяти одному",
    "accusative" => "четыре тысячи триста пятьдесят один",
    "ablative" => "четырьмя тысячами тремястами пятьюдесятью одним",
    "prepositional" => "о четырех тысячах трехстах пятидесяти одном"
}
```

### Ordinal (`OrdinalNumeral`)

_Creation of ordinal numerals (порядковые числительные) in russian language._

Example:

```php
use morphos\Gender;
use morphos\Russian\OrdinalNumeral;

// Get text representation of a number:
$number = 67945;

OrdinalNumeral::getCase($number, 'именительный') => 'шестьдесят семь тысяч девятьсот сорок пятый'
OrdinalNumeral::getCase($number, 'именительный', Gender::FEMALE) => 'шестьдесят семь тысяч девятьсот сорок пятая'
```

If you need all forms, you can get all cases of a numeral:

```php
OrdinalNumeral::getCases($number) => array(6) {
    "nominative" => "шестьдесят семь тысяч девятьсот сорок пятый",
    "genitive" => "шестьдесят семь тысяч девятьсот сорок пятого",
    "dative" => "шестьдесят семь тысяч девятьсот сорок пятому",
    "accusative" => "шестьдесят семь тысяч девятьсот сорок пятый",
    "ablative" => "шестьдесят семь тысяч девятьсот сорок пятым",
    "prepositional" => "о шестьдесят семь тысяч девятьсот сорок пятом"
}
```

# English

English morphology shortcuts:

- `morphos\English\pluralize($word, $count = 2)`
- `morphos\English\CardinalNumeral::generate($number)`

English class hierarchy:

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

echo '10 '.Plurality::pluralize('foot') => '10 feet'
```

## Numerals

All number creation classes are similar and have one common methods:

- `string generate($number)` - Generates a cardinal numeral for a number.

### Cardinal (`CardinalNumeral`)

_Creation of cardinal numerals in english language._

Create declension class object:

```php
use morphos\English\CardinalNumeral;
```

Get text representation of a number:

```php
$number = 4351;

CardinalNumeral::generate($number) => 'four thousand, three hundred fifty-one'
```

# Contibuting

See [CONTRIBUTING.md](CONTRIBUTING.md) for this.
