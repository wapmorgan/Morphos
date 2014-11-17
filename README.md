[![Build Status](https://travis-ci.org/wapmorgan/Morphos.svg)](https://travis-ci.org/wapmorgan/Morphos)

Morphos - a morphological decision written completely in PHP.

Supported languages:

* English - pluralization.
* Russian - pluralization and declension.

# Installation

* Download library through composer:
    `composer require "wapmorgan/morphos"`

# Declension
## Personal names

1. Declension of personal names in russian language / *Склонение имен собственных в русском языке*:
    ```php
    $array = array('Иван', 'Игорь', 'Андрей', 'Фома', 'Никита', 'Илья'');
    $dec = new morphos\RussianNamesDeclension();
    foreach ($array as $name) {
        if ($dec->hasForms($name)) {
            // Получить имя во всех падежах
            $forms = $dec->getForms($name, morphos\RussianNamesDeclension::MAN); // вместо длинной константы можно использовать 'm' или 'w'
            // Получить имя в родительном падеже
            $form = $dec->getForms($name, morphos\RussianCases::RODIT_3, 'm');
        }
    }
    ```

## Other words

1. Declension of general words in russian language / Склонение произвольных существительных в русском языке:
    ```php
    $word = 'поле';
    $dec = new morphos\RussianGeneralDeclension();
    if ($dec->hasForms($word)) {// this methods always returns true at this moment / на данный момент эта функция всегда возвращает true
        # Singular declension / Склонение в единственном числе
        {
            // Get all forms of a word / Получить слово во всех падежах
            $forms = $dec->getForms($word, false); // second argument is an animateness / второй аргумент в этих функиях - это одушевленность предмета
            // Get genetive form of a word / Получить слово в родительном падеже
            $form = $dec->getForm($word, false, morphos\RussianCases::RODIT_3);
        }
        # Plural declension / Склонение во множественном числе
        {
            // Get all forms of a word / Получить слово во всех падежах
            $forms = $dec->pluralizeAllDeclensions($word, false);
            // There's no method for getting one form / Метода для получения одной формы пока не реализовано
        }
    }
    ```

    **Declension of general words can not work properly. / Склонение произвольных существительных может работать некорректно.**

## Cases

1. Cases in russian language / Падежи в русском языке:

    * morphos\RussianCases::IMENIT_1
    * morphos\RussianCases::RODIT_2
    * morphos\RussianCases::DAT_3
    * morphos\RussianCases::VINIT_4
    * morphos\RussianCases::TVORIT_5
    * morphos\RussianCases::PRODLOJ_6


# Pluralization

1. Pluralization a word in Russian / *Получение существительного в правильном падеже и числе для согласования с числительным в русском языке*:
    ```php
    $plu = new morphos\RussianPlurality();
    $word = 'дом';
    $count = 10;
    echo sprintf("%d %s", $count, $plu->pluralize($word, $count, false)); // последний аргумент - также одушевленность
    // Выведет: 10 домов
    ```

2. Pluralization a word in English:
    ```php
    $plu = new morphos\EnglishPlurality();
    $word = 'foot';
    $count = 10;
    echo sprintf("%d %s", $count, $plu->pluralize($word));
    // output: 10 feet
    ```


For simple access to functions of string processing there are some functions in `morphos` namespace:

1. `set_encoding()` - Sets encoding for using in morphos/* functions.
2. `length()` - Calculates count of characters in string.
3. `slice()` - Slices string like python.
4. `lower()` - Lower case.
5. `upper()` - Upper case.
6. `name()` - Name case. (ex: Thomas Lewis)


# Addition of new languages.

Morphos are open for additions and improvements.

Addition a new language is simple: create the class inheriting one of basic classes and realize abstract methods from it.

Here is a list of basic classes:

### BasicNamesDeclension
Class for names declension.

* Checks, whether there are rules for this name.
  ```php
  abstract public function hasForms($name, $gender);
  ```

* Generates all forms of a name.
  ```php
  abstract public function getForms($name, $gender);
  ```

* Generates one form of a name.
  ```php
  abstract public function getForm($name, $form, $gender);
  ```

  ### BasicDeclension

* Checks, whether there are rules for this word.
  ```php
  public function hasForms($word, $animate = false);
  ```

* Generates all forms of a word.
  ```php
  public function getForms($word, $animate = false);
  ```

* Generates one form of a word.
  ```php
  public function getForm($word, $form, $animate = false);
  ```
