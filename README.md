# Morphos
A morphological solution for Russian and English language written completely in PHP and delivered as a PHP library or
docker image to integrate in non-PHP stack.

[![Latest Stable Version](https://poser.pugx.org/wapmorgan/morphos/v/stable)](https://packagist.org/packages/wapmorgan/morphos)
[![License](https://poser.pugx.org/wapmorgan/morphos/license)](https://packagist.org/packages/wapmorgan/morphos)
[![Total Downloads](https://poser.pugx.org/wapmorgan/morphos/downloads)](https://packagist.org/packages/wapmorgan/morphos)
[![Daily Downloads](https://poser.pugx.org/wapmorgan/morphos/d/daily)](https://packagist.org/packages/wapmorgan/morphos)
[![Latest Unstable Version](https://poser.pugx.org/wapmorgan/morphos/v/unstable)](https://packagist.org/packages/wapmorgan/morphos)

Tests & Quality: [![Build Status](https://app.travis-ci.com/wapmorgan/Morphos.svg?branch=master)](https://app.travis-ci.com/github/wapmorgan/Morphos)
[![Scrutinizer Code Quality](https://scrutinizer-ci.com/g/wapmorgan/Morphos/badges/quality-score.png?b=master)](https://scrutinizer-ci.com/g/wapmorgan/Morphos/?branch=master)
[![Code Coverage](https://scrutinizer-ci.com/g/wapmorgan/Morphos/badges/coverage.png?b=master)](https://scrutinizer-ci.com/g/wapmorgan/Morphos/?branch=master)

## Features

- [✓] Inflection of Personal names (Фамилия, Имя, Отчество) (Russian)
- [✓] Inflection of Geographical names (Страны/Города) (Russian)
- [✓] Declension/Pluralization of nouns and adjectives (Russian, English)
- [✓] Generation numerals of numbers (количественные и порядковые) (Russian, English)
- [✓] Spelling out amounts of money (Russian)
- [✓] Spelling out time units and intervals (Russian, English)

## Table of contents

1. Installation
2. Quick start
3. Documentation
4. Contributing

## Installation

### As PHP library

* Download library through composer:
```
composer require wapmorgan/morphos
```

or install via adapter:

- Adapter for Blade: [wapmorgan/morphos-blade](https://github.com/wapmorgan/Morphos-Blade)
- Adapter for Twig: [wapmorgan/morphos-twig](https://github.com/wapmorgan/Morphos-Twig)
- Adapter for Yii2: [wapmorgan/yii2-inflection](https://github.com/wapmorgan/yii2-inflection)

### As a separate service

The server starts in a container and listens 8080 port for GET-requests.

Integrate service into your stack (for example, docker compose)
```yaml
services:
  morphos:
    image: wapmorgan/morphos:3.2.28
    ports:
      - 8093:8080
```
or standalone container:
```bash
docker run --env NUM_WORKERS=4 --rm --publish 8093:8080 -v wapmorgan/morphos:3.2.28
```

_Tip_: adjust `NUM_WORKERS` env variable if you will send a lot of load to service. By default, it's 4.

There are **API:** marks in documentation for functions, that exposed as service endpoints. Just pass them the same 
arguments as to PHP-functions/methods.

## Quick Start

#### Russian
```php
// Inflect russian names:
morphos\Russian\inflectName('Иванов Петр', 'родительный') => 'Иванова Петра'

// Inflect geographical names:
morphos\Russian\GeographicalNamesInflection::getCase('Москва', 'родительный') => 'Москвы'

// Pluralize russian nouns and adjectives:
morphos\Russian\pluralize(10, 'новый дом') => '10 новых домов'

// Generate russian cardinal numerals:
morphos\Russian\CardinalNumeralGenerator::getCase(567, 'именительный') => 'пятьсот шестьдесят семь'

// Generate russian ordinal numerals:
morphos\Russian\OrdinalNumeralGenerator::getCase(961, 'именительный') => 'девятьсот шестьдесят первый'

// Generate russian time difference
morphos\Russian\TimeSpeller::spellDifference(time() + 3600, morphos\TimeSpeller::DIRECTION) => 'через 1 час'

// other functions described in README-ru.md
```

#### English
```php
// Pluralize english nouns:
morphos\English\pluralize(10, 'house') => '10 houses'

// Generate english cardinal numerals:
morphos\English\CardinalNumeralGenerator::generate(567) => 'five hundred sixty-seven'

// Generate english ordinal numerals:
morphos\English\OrdinalNumeralGenerator::generate(961) => 'nine hundred sixty-first'

// Generate english time difference
morphos\English\TimeSpeller::spellDifference(time() + 3600, morphos\TimeSpeller::DIRECTION) => 'in 1 hour'
```

# Documentation

- [Русская морфология](README-ru.md) в файле README-ru.md
- [English morphology](README-en.md) in file README-en.md

# Contributing

See [CONTRIBUTING.md](CONTRIBUTING.md) for this.
