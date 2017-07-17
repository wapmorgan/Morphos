# English

* [Pluralization](#pluralization)
* [Numerals](#numerals)

English morphology shortcuts:

- `morphos\English\pluralize($word, $count = 2)`
- `morphos\English\CardinalNumeralGenerator::generate($number)`
- `morphos\English\OrdinalNumeralGenerator::generate($number)`

English class hierarchy:

```php
morphos\
        English\
                CardinalNumeralGenerator
                OrdinalNumeralGenerator
                NounPluralization
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

### Cardinal (`CardinalNumeralGenerator`)

_Creation of cardinal numerals in english language._


```php
use morphos\English\CardinalNumeralGenerator;
```

Get text representation of a number:

```php
$number = 4351;

CardinalNumeralGenerator::generate($number) => 'four thousand, three hundred fifty-one'
```

### Ordinal (`OrdinalNumeralGenerator`)

_Creation of ordinal numerals in english language._


```php
use morphos\English\OrdinalNumeralGenerator;
```

Get text representation of a number or short form:

```php
$number = 4351;

OrdinalNumeralGenerator::generate($number) => 'four thousand, three hundred fifty-first'
OrdinalNumeralGenerator::generate($number, true) => '4351st'
```
