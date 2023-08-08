# English

* [Pluralization](#pluralization)
* [Numerals](#numerals)
	* [Cardinal](#cardinal)
	* [Ordinal](#ordinal)
* [Time units and intervals](#time-units-and-intervals)

English morphology shortcuts:

- `morphos\English\NounPluralization::pluralize($word, $count)`
- `morphos\English\CardinalNumeralGenerator::generate($number)`
- `morphos\English\OrdinalNumeralGenerator::generate($number)`
- `morphos\English\TimeSpeller::spellInterval(DateInterval $interval)`

English class hierarchy:

```php
morphos\
        English\
                CardinalNumeralGenerator
                OrdinalNumeralGenerator
                NounPluralization
                TimeSpeller
```

## Pluralization
Pluralization a word in English is possible with `NounPluralization` class:

```php
use function morphos\English\pluralize;
use morphos\English\NounPluralization;

echo '10 '.NounPluralization::pluralize('foot') => '10 feet'
// or if you don't know count of objects

// or you can use shortcut
$n = 1;
echo pluralize($n, 'foot') => '1 foot'
// or API: GET /en/pluralize?count=...&word=...
```

## Numerals

All number creation classes are similar and have one common methods:

- `OrdinalNumeralGenerator::generate($number, bool $short= false)` - Generates an ordinal numeral for a number.
  - API: `GET /en/ordinal?number=...`
- `CardinalNumeralGenerator::generate($number)` - Generates a cardinal numeral for a number.
  - API: `GET /en/cardinal?number=...`

### Cardinal

_Creation of cardinal numerals in english language (`CardinalNumeralGenerator`)._


```php
use morphos\English\CardinalNumeralGenerator;

// Get text representation of a number:
$number = 4351;

CardinalNumeralGenerator::generate($number) => 'four thousand, three hundred fifty-one'
```

### Ordinal

_Creation of ordinal numerals in english language (`OrdinalNumeralGenerator`)._


```php
use morphos\English\OrdinalNumeralGenerator;

// Get text representation of a number or short form:
$number = 4351;

OrdinalNumeralGenerator::generate($number) => 'four thousand, three hundred fifty-first'
// short form of ordinal numeral
OrdinalNumeralGenerator::generate($number, true) => '4351st'
```

## Time units and intervals

You can generate text representation of time interval with `TimeSpeller` class:

```php
use morphos\English\TimeSpeller;

// generate text representation of 5 years and 2 months
$interval = new DateInterval('P5Y2M');

TimeSpeller::spellInterval($interval) => '5 years 2 months'
TimeSpeller::spellInterval($interval, TimeSpeller::SEPARATE) => '5 years and 2 months'

// or with API: GET /en/time/spellDifference?dateTime=...&options=...&limit=...
// or with API: GET /en/time/spellInterval?interval=...&options=...&limit=...
```
