# Morphos
A morphological solution for Russian and English language written completely in PHP.

[![Composer package](http://xn--e1adiijbgl.xn--p1acf/badge/wapmorgan/morphos)](https://packagist.org/packages/wapmorgan/morphos)
[![Latest Stable Version](https://poser.pugx.org/wapmorgan/morphos/v/stable)](https://packagist.org/packages/wapmorgan/morphos)
[![License](https://poser.pugx.org/wapmorgan/morphos/license)](https://packagist.org/packages/wapmorgan/morphos)
[![Total Downloads](https://poser.pugx.org/wapmorgan/morphos/downloads)](https://packagist.org/packages/wapmorgan/morphos)
[![Latest Unstable Version](https://poser.pugx.org/wapmorgan/morphos/v/unstable)](https://packagist.org/packages/wapmorgan/morphos)

Tests & Quality: [![Build Status](https://travis-ci.org/wapmorgan/Morphos.svg)](https://travis-ci.org/wapmorgan/Morphos)
[![Scrutinizer Code Quality](https://scrutinizer-ci.com/g/wapmorgan/Morphos/badges/quality-score.png?b=master)](https://scrutinizer-ci.com/g/wapmorgan/Morphos/?branch=master)

## Features
- [✓] Declension of Personal names (Фамилия, Имя, Отчество) (Russian)
- [✓] Declension of Geographical names (Страны/Города) (Russian)
- [✓] Declension/Pluralization of nouns and adjectives (Russian, English)
- [✓] Generation numerals of numbers (количественные и порядковые) (Russian, English)
- [✓] Spelling out amounts of money (Russian)

## Table of contents

1. Installation
2. Quick start
3. Library documentation
4. Contibuting

## Installation

* Download library through composer:
```
composer require wapmorgan/morphos
```

- Adapter for Laravel (Blade): [wapmorgan/morphos-blade](https://github.com/wapmorgan/Morphos-Blade)
- Adapter for Symfony (Twig): [wapmorgan/morphos-twig](https://github.com/wapmorgan/Morphos-Twig)

## Quick Start
- Russian:
  ```php
  // Decline russian names:
  morphos\Russian\name('Иванов Петр', 'родительный', morphos\Gender::MALE) => 'Иванова Петра'

  // Decline geographical names:
  morphos\Russian\GeographicalNamesDeclension::getCase('Москва', 'родительный') => 'Москвы'

  // Pluralize russian nouns:
  morphos\Russian\pluralize('дом', 10) => 'домов'

  // Generate russian cardinal numerals:
  morphos\Russian\CardinalNumeral::getCase(567, 'именительный') => 'пятьсот шестьдесят семь'

  // Generate russian ordinal numerals:
  morphos\Russian\OrdinalNumeral::getCase(961, 'именительный') => 'девятьсот шестьдесят первый'

  // other functions described in README-ru.md
  ```

- English
  ```php
  // Pluralize english nouns:
  morphos\English\pluralize('house') => 'houses'

  // Generate english cardinal numerals:
  morphos\English\CardinalNumeral::generate(567) => 'five hundred sixty-seven'

  // Generate english ordinal numerals:
  morphos\English\OrdinalNumeral::generate(961) => 'nine hundred sixty-first'
  ```

# Library documentation

- [Русская морфология](README-ru.md) в файле README-ru.md
- [English morphology](README-en.md) in file README-en.md

# Contibuting

See [CONTRIBUTING.md](CONTRIBUTING.md) for this.
