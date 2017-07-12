# Русский язык

* [Имена собственные](#Имена-собственные)
* [Географические названия](#Географические-названия)
* [Существительные](#Существительные)
* [Числительные](#Числительные)
  * [Количественные числительные](#Количественные-числительные)
  * [Порядковые числительные](#Порядковые-числительные)
* [Валюты](#Валюты)
* [Окончание глаголов](#Окончание-глаголов)

Для русского языка доступны следующие функции:

* `morphos\Russian\name($fullname, $case, $gender = AUTO)`
* `morphos\Russian\pluralize($noun, $count = 2, $animateness = false)`
* `morphos\Russian\verb($verb, $gender)`

и следующие классы:

```php
morphos\
        Russian\
                CardinalNumeral
                Cases
                GeneralDeclension
                FirstNamesDeclension
                LastNamesDeclension
                MoneySpeller
                MiddleNamesDeclension
                OrdinalNumeral
                Plurality
```

## Имена собственные

Чтобы просклонять все части имени можно использовать следующую функцию:

```php
string|array name($name, $case = null, $gender = null)
```

Аргументы:
- `$name` - полное имя в формате `Фамилия Имя` или `Фамилия Имя Отчество`.
- `$case` - может быть `null`, одной из констант `Cases` или строкой. Если `null`, тогда будут возвращены все падежи имени. Если нет, будет вовзращено имя в определенном падеже.
- `$gender` - одна из констант `Gender`, строка (`"m"` для мужского имени,  `"f"` для женского имени), `null` для автоматического определения.

Для склонения отдельных частей имени есть три класса:

- `FirstNamesDeclension` - класс для склонения имён.
- `MiddleNamesDeclension` - класс для склонения отчеств.
- `LastNamesDeclension` - класс для склонения фамилий.

Все классы похожи друг на друга и имеют следующие методы:

- `boolean isMutable($word, $gender = null)` - проверяет, что часть имени склоняема.
- `string getCase($word, $case, $gender = null)` - склоняет часть имени и возвращает результат. `$case` - это одна из констант `morphos\Cases` или `morphos\Russian\Cases`.
- `array getCases($word, $gender = null)` - склоняет имя во всех падежах и возвращает результат в виде массива.
- `string detectGender($word)` - пытается определить пол по части имени.

`$gender` может быть `morphos\Gender::MALE` (или просто `"m"`) или `morphos\Gender::FEMALE` (или просто `"f"`) или же `null` для автоматического определения.
**Важно отметить, что определение пола по отчеству и фамилии почти всегда даёт правильный результат, но определение только лишь по имени может дать неверный результат, особенно если имя не русское.** Так что если вы хотите просклонять только имя, то лучше будет указать пол при склонение имени.

Падежи в русском языке:

* Именительный - `morphos\Russian\Cases::IMENIT` or `именительный`
* Родительный - `morphos\Russian\Cases::RODIT` or `родительный`
* Дательный - `morphos\Russian\Cases::DAT` or `дательный`
* Винительный - `morphos\Russian\Cases::VINIT` or `винительный`
* Творительный - `morphos\Russian\Cases::TVORIT` or `творительный`
* Предложный - `morphos\Russian\Cases::PREDLOJ` or `предложный`

_Примеры_

**FirstNamesDeclension**

```php
use morphos\Russian\FirstNamesDeclension;
// Возьмем имя Иван
$user_name = 'Иван';

FirstNamesDeclension::getCase($user_name, 'родительный') => 'Ивана'

// получаем имя во всех падежах
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
$user_name = 'Сергеевич';

MiddleNamesDeclension::getCase($user_name, 'родительный') => 'Сергеевича'

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
$user_last_name = 'Иванов';

$dative_last_name = LastNamesDeclension::getCase($user_last_name, 'дательный'); // Иванову

echo 'Мы хотим подарить товарищу '.$dative_last_name.' небольшой презент.';

LastNamesDeclension::getCases($user_last_name) => array(6) {
    "nominative" => "Иванов",
    "genitive" => "Иванова",
    "dative" => "Иванову",
    "accusative" => "Иванова",
    "ablative" => "Ивановым",
    "prepositional" => "об Иванове"
}
```

## Географические названия

Вы можете склонять географические названия, такие как названия городов, стран, улиц и так далее. Класс для склонения имеет похожие методы:

- `boolean isMutable($name)` - проверяет, что имя склоняемо.
- `string getCase($name, $case)` - склоняет имя и возвращает результат.`$case` - это одна из констант `morphos\Cases` или `morphos\Russian\Cases`.
- `array getCases($word null)` - склоняет имя во всех падежах и возвращает результат в виде массива.

_Пример_

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

## Существительные

### Склонение в единственном числе

Функциональность по склонению имени существительных (а также существительных, перешедших из прилагательных/причастий) определена в классе `GeneralDeclension`:

- `boolean isMutable($word, bool $animateness = false)` - Check if noun is mutable.
- `string getCase($word, $case, $animateness = false)` - Declines noun.
- `array getCases($word, $animateness = false)` - Declines noun to all cases.

_Пример_

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

### Склонение во множественном числе

Обеспечивается классом `Plurality`, который имеет похожие методы:

- `string getCase($word, $case, $animateness = false)` - получает один из падежей слова во множественном числе.
- `array getCases($word, $animateness = false)` - склоняет слово во множественном числе.
- `string pluralize($word, $count, $animateness = false)` - возвращает правильную форму слова для сопряжения с числом.

_Пример_

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

$count = 10;

echo $count.' '.morphos\Russian\pluralize('дом', $count, false); // result: 10 домов
```

## Числительные

Все классы по генерации числительных из чисел имеют два похожих метода:

- `string getCase($number, $case, $gender = Gender::MALE)` - получить одну форму числительного
- `array getCases($number, $gender = Gender::MALE)` - получить все формы числительного.

`$gender` может быть `morphos\Gender::MALE` (или просто `"m"`) или `morphos\Gender::FEMALE` (или просто `"f"`) or `morphos\Gender::NEUTER` (или просто `"n"`).

### Количественные числительные (`CardinalNumeral`)

Генерация количественных числительных:

```php
use morphos\Gender;
use morphos\Russian\CardinalNumeral;

$number = 4351;

CardinalNumeral::getCase($number, 'именительный') => 'четыре тысячи триста пятьдесят один'
CardinalNumeral::getCase($number, 'именительный', Gender::FEMALE) => 'четыре тысячи триста пятьдесят одна'
```

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

### Порядковые числительные (`OrdinalNumeral`)

Генерация порядковых числительных:

```php
use morphos\Gender;
use morphos\Russian\OrdinalNumeral;

$number = 67945;

OrdinalNumeral::getCase($number, 'именительный') => 'шестьдесят семь тысяч девятьсот сорок пятый'
OrdinalNumeral::getCase($number, 'именительный', Gender::FEMALE) => 'шестьдесят семь тысяч девятьсот сорок пятая'
```

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

## Валюты
Вы можете генерировать значения денежных сумм, записанных в виде текста с помощью класса `MoneySpeller`.

_Пример_

```php
use morphos\Russian\MoneySpeller;

MoneySpeller::spell(123.45, 'RUB') => 'сто двадцать три рубля сорок пять копеек'
MoneySpeller::spell(123.45, 'RUB', MoneySpeller::CLARIFICATION_FORMAT) => '123 (сто двадцать три) рубля 45 (сорок пять) копеек'
```

Все доступные форматы вывода:

| Формат                                 | Формат вывода                                                            | Пример                               |
|----------------------------------------|--------------------------------------------------------------------------|--------------------------------------|
| `MoneySpeller::SHORT_FORMAT`         | Сумма записывается цифрами, а валюта словами                             | 1 рубль 50 копеек                    |
| `MoneySpeller::NORMAL_FORMAT`        | Сумма и валюта записываются словами                                      | один рубль пятьдесят копеек          |
| `MoneySpeller::DUPLICATION_FORMAT`   | Сумма и валюта записываются словами. Сумма дублируется цифрами в скобках | один (1) рубль пятьдесят (50) копеек |
| `MoneySpeller::CLARIFICATION_FORMAT` | Сумма записывается словами и цифрами (в скобках), валюта - словами.      | 1 (один) рубль 50 (пятьдесят) копеек |

При указании валюты используйте знак валюты или трехзначный код валюты.

Доступные валюты:

| Знак | Валюта |
|------|--------|
| $    | доллар |
| €    | евро   |
| ¥    | иена   |
| £    | фунт   |
| Fr   | франк  |
| 元   | юань   |
| Kr   | крона  |
| MXN  | песо   |
| ₩    | вон    |
| ₺    | лира   |
| ₽    | рубль  |
| ₹    | рупия  |
| R$   | реал   |
| R    | рэнд   |
| ₴    | гривна |

## Окончание глаголов

Глаголы в прошедшем времени в русском языке имеют признак рода. Чтобы упростить подбор правильной формы глаголы используйте функцию:

```php
string verb($verb, $gender)
```

Аргументы:
- `$verb` - глагол в мужском роде и прошедшем времени.
- `$gender` - необходимый род глагола. Если указано не `Gender::MALE`, то будет произведено преобразование в женский род.

_Пример_

```php
$name = 'Анастасия';
$gender = morphos\Gender::FEMALE;

$name.' '.morphos\Russian\verb('добавил', $gender) => 'Анастасия добавила'
$name.' '.morphos\Russian\verb('поделился', $gender).' публикацией' => 'Анастасия поделилась публикацией'
```
