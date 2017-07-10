# English

* [Pluralization](#Pluralization)
* [Numerals](#Numerals)

English morphology shortcuts:

- `morphos\English\pluralize($word, $count = 2)`
- `morphos\English\CardinalNumeral::generate($number)`
- `morphos\English\OrdinalNumeral::generate($number)`

English class hierarchy:

```php
morphos\
        English\
                CardinalNumeral
                OrdinalNumeral
                Plurality
```

## Pluralization (`Plurality`)
Pluralization a word in English:

```php
use morphos\English\Plurality;

echo '10 '.Plurality::pluralize('foot') => '10 feet'
// or if you don't know count of objects

$n = 1;
echo $n.' '.Plurality::pluralize('foot', $n) => '1 foot'
```

## Numerals

All number creation classes are similar and have one common methods:

- `string generate($number)` - Generates a cardinal numeral for a number.

### Cardinal (`CardinalNumeral`)

_Creation of cardinal numerals in english language._


```php
use morphos\English\CardinalNumeral;
```

Get text representation of a number:

```php
$number = 4351;

CardinalNumeral::generate($number) => 'four thousand, three hundred fifty-one'
```

### Ordinal (`OrdinalNumeral`)

_Creation of ordinal numerals in english language._


```php
use morphos\English\OrdinalNumeral;
```

Get text representation of a number or short form:

```php
$number = 4351;

OrdinalNumeral::generate($number) => 'four thousand, three hundred fifty-first'
OrdinalNumeral::generate($number, true) => '4351st'
```
