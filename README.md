Morphos - a morphological decision written completely in the PHP language.

At the moment the main functionality is declension of personal names.
Total supported languages: 1 (Russian).

## Tutorial.
* For declension of names you need download library through composer:
    `composer require "wapmorgan/morphos"`
* To create an instance of class for declension:
    ```php
    $dec = new morphos\RussianDeclension();
    ```

* To learn, whether there is a form for this name (important to know a name carrier gender)
    ```php
    var_dump($dec->hasForms('Иоанн', morphos\RussianDeclension::MAN))); //true
    ```

* To receive one concrete form:
    ```php
    var_dump($dec->getForm('Иоанн', morphos\RussianDeclension::DAT_3, morphos\RussianDeclension::MAN)); // Иоанна
    ```

* To receive at once all forms
    ```php
    var_dump($dec->getForms('Иоанн', morphos\RussianDeclension::MAN));
    ```

## Addition of new languages.
To add a new language quite simply: create the class inheriting BasicDeclension and realize three necessary methods:

* ```php
  public function hasForms($name, $gender);
  ```
  Checks, whether if rules of formation of forms for this name.

* ```php
  public function getForms($name, $gender);
  ```
  Generates all forms of a name.

* ```php
  public function getForm($name, $form, $gender);
  ```
  Generates one form of a name.

For simplification of access to functions of processing of lines there are some functions in morphos namespace:
1. set_encoding() - Sets encoding for using in morphos / * functions.
2. length() - Calcules count of characters in string.
3. slice() - Slices string like python.
4. lower() - Lower case.
5. upper() - Upper case.
6. name() - Name case. (ex: Thomas Lewis)

## Languages
### Russian
#### RussianDeclension
Forms:

1. IMENIT_1
2. RODIT_2
3. DAT_3
4. VINIT_4
5. TVORIT_5
6. PREDLOJ_6
