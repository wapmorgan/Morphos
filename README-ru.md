# Русский язык

Склонение частей речи:
* [Имена собственные](#Имена-собственные)
* [Географические названия](#Географические-названия) (названия городов, улиц, стран)
* [Существительные](#Существительные) (генерация множественного числа)

Трансформация в текст:
* [Числа](#Числа)
* [Валюты](#Валюты)
* [Временные интервалы](#Временные-интервалы)

Дополнительно:
* [Предлоги и окончания](#Предлоги-и-окончания)

Internals:
* [Склонение отдельных частей имени](#Склонение-отдельных-частей-имени)
* [Полное склонение существительных](#Полное-склонение-существительных)


## Краткий обзор
Для русского языка доступны следующие классы и функции из пространства имён `morphos\Russian\`:

**Классы**:
- для склонение личных имён:
    - `FirstNamesInflection`
    - `LastNamesInflection`
    - `MiddleNamesInflection`
- для склонения географических названий:
    - `GeographicalNamesInflection`
- для склонения и плюрализации существительных:
    - `NounDeclension`
    - `NounPluralization`
- для генерации количественных и порядковых числительных:
    - `CardinalNumeralGenerator`
    - `OrdinalNumeralGenerator`
- для генерации текстом различных данных:
    - `MoneySpeller`
    - `TimeSpeller`
- для добавления предлогов и окончаний:
    - `RussianLanguage`

**Функции:**
* `inflectName($fullname, $case, $gender = null): string` - возвращает имя в определенном падеже.
* `getNameCases($fullname, $gender = null): array` - возвращает массив со всеми склонениями имени.
* `detectGender($fullname)` - определяет пол владельца имени.
* `pluralize($count, $noun, $animateness = false): string` - ставит существительное в форму, согласуемую с количеством предметов, возвращает число предметов и существительное.

# Склонение частей речи

## Имена собственные

Чтобы просклонять все части имени можно использовать следующую функцию:

- `string inflectName($fullname, $case, $gender = null)`
  - API: `GET /ru/name?fullname=...&case=...&gender=...`

Аргументы:
- `$fullname` - имя в формате `Имя`, `Фамилия Имя` или `Фамилия Имя Отчество`.
- `$case` - нужный падеж. Одна из констант `morphos\Russian\Cases` ИЛИ строка (`родительный`, `дательный`, `винительный`, `творительный` или `предложный`).
- `$gender` - пол владельца имени. одна из констант `Gender` (`morphos\Gender::MALE` или `morphos\Gender::FEMALE`) ИЛИ строка (`m` для мужского имени,  `f` для женского имени). Если не указывать, будет прозведена попытка автоматического определения.

**Важно отметить, что определение пола по отчеству и фамилии почти всегда даёт правильный результат, но определение только лишь по имени может дать неверный результат, особенно если имя не русское.** Так что если вы хотите просклонять только имя, то лучше будет указать пол при склонении.

_Пример._
```php
use function morphos\Russian\inflectName;

inflectName('Базанов Иосиф Валерьянович', 'родительный') => 'Базанова Иосифа Валерьяновича'
inflectName('Базанов Иосиф', 'дательный') => 'Базанову Иосифу'
inflectName('Иосиф', 'творительный') => 'Иосифом'
```

Чтобы получить сразу все склонения для имени, используйте другую функцию (либо вызов API без указания `case`):

```php
array getNameCases($fullname, $gender = null)
```

Аргументы:
- `$fullname` - имя в формате `Имя`, `Фамилия Имя` или `Фамилия Имя Отчество`.
- `$gender` - пол владельца. Одна из констант `Gender` (`morphos\Gender::MALE` или `morphos\Gender::FEMALE`) ИЛИ строка (`m` для мужского имени,  `"f"` для женского имени) ИЛИ `null` для автоматического определения.

Возвращает массив, где ключи - константы класса `Cases`, а значения - имя в определенном падеже.

_Пример._
```php
use function morphos\Russian\getNameCases;

getNameCases('Базанов Иосиф Валерьянович') => array(6) {
  'nominative' => 'Базанов Иосиф Валерьянович',
  'genitive' => 'Базанова Иосифа Валерьяновича',
  'dative' => 'Базанову Иосифу Валерьяновичу',
  'accusative' => 'Базанова Иосифа Валерьяновича',
  'ablative' => 'Базановым Иосифом Валерьяновичем',
  'prepositional' => 'Базанове Иосифе Валерьяновиче'
}
```

Если есть необходимость определить пол по имени, воспользуйтесь функцией:

- `string|null detectGender($name)`
  - API: `GET /ru/detectGender?name=...`
  Если удалось определить пол, будет возвращена одна из констант класса `morphos\Gender`, `null` в ином случае.

## Географические названия

Вы можете склонять географические названия, такие как названия городов, стран, улиц и так далее. Класс для склонения `GeographicalNamesInflection` имеет похожие методы:

- `boolean isMutable($name)` - проверяет, что имя склоняемо.
  - API: `GET /ru/geo/isMutable?name=...`
- `string getCase($name, $case)` - склоняет имя и возвращает результат.`$case` - это одна из констант `morphos\Cases` или `morphos\Russian\Cases`.
- `array getCases($word)` - склоняет имя во всех падежах и возвращает результат в виде массива. В отличие от всех других склоняещих компонентов, `GeographicalNamesInflection` возвращает не 6, а 7 форм слова - с локативным падежом (вторым предложным) - `morphos\Russian\Cases::LOCATIVE`.
  - API: `GET /ru/geo/cases?word=...`

Что склоняется:
- Название населённого пункта, страны без приставки: `Москва`, `Россия`, `Франция`.
- Названия с приставкой или суффиксом: `город N`, `село N`, `пгт N`, `хутор N`, `N область`, `N край`.

_Пример._

```php
use morphos\Russian\GeographicalNamesInflection;

echo 'Пора бы поехать в '.GeographicalNamesInflection::getCase('Москва', 'винительный'); // Москву
// If you need all forms, you can get all forms of a name:
GeographicalNamesInflection::getCases('Саратов') => array(6) {
    "nominative" => "Саратов",
    "genitive" => "Саратова",
    "dative" => "Саратову",
    "accusative" => "Саратов",
    "ablative" => "Саратовом",
    "prepositional" => "Саратове",
    "locative" => "Саратове",
}
```

## Существительные

Для склонения существительных, используемых с количеством предметов/чего-либо предназначена функция `pluralize`:

- `pluralize($count, $noun, $animateness = false, $case = null)`
  - API: `GET /ru/pluralize?count=...&noun=...&animateness=...&case=...`

Аргументы:
- `$count` - количество предметов.
- `$noun` - существительное ИЛИ существительное с прилагательными.
    Примеры: "сообщение", "новое сообщение", "небольшая лампа", "новый и свободный дом".
- `bool $animateness` - флаг, указывающий на одушевленность существительного. Если получаемая форма неверная, попробуйте указать `true`.
- `$case` - если необходимо поставить фразу в определенный падеж, передаётся одна из констант `morphos\Cases` или
`morphos\Russian\Cases`. Если не указано, то падеж выбирается автоматически по правилам русского языка.

_Пример._

```php
use function morphos\Russian\pluralize;

echo pluralize(10, 'машина'); // => 10 машин
echo pluralize(10, 'новый и свободный дом', false, morphos\Russian\Cases::TVORIT); // => 10 новыми и свободными домами
```

Более подробное склонение существительных (по падежам и числам) описано в разделе [Internals](#Полное-склонение-существительных).

# Трансформация в текст

## Числа

Оба класса по генерации числительных (количественных и порядковых) из чисел имеют два похожих метода:

- `getCase($number, $case, $gender = Gender::MALE): string` - получить одну форму числительного
- `getCases($number, $gender = Gender::MALE): array` - получить все формы числительного.
  - API: `GET /ru/(cardinal|ordinal)/cases?number=...&gender=...`

`$gender` может быть `morphos\Gender::MALE` (или просто `m`) или `morphos\Gender::FEMALE` (или просто `f`) or `morphos\Gender::NEUTER` (средний род; или просто `n`).

**Количественные числительные**

Генерация количественных числительных производится с помощью класса `CardinalNumeralGenerator`:

```php
use morphos\Gender;
use morphos\Russian\CardinalNumeralGenerator;

$number = 4351;

CardinalNumeralGenerator::getCase($number, 'именительный') => 'четыре тысячи триста пятьдесят один'
CardinalNumeralGenerator::getCase($number, 'именительный', Gender::FEMALE) => 'четыре тысячи триста пятьдесят одна'
```

```php
CardinalNumeralGenerator::getCases($number) => array(6) {
    "nominative" => "четыре тысячи триста пятьдесят один",
    "genitive" => "четырех тысяч трехсот пятидесяти одного",
    "dative" => "четырем тысячам тремстам пятидесяти одному",
    "accusative" => "четыре тысячи триста пятьдесят один",
    "ablative" => "четырьмя тысячами тремястами пятьюдесятью одним",
    "prepositional" => "четырех тысячах трехстах пятидесяти одном"
}
```

**Порядковые числительные**

Генерация порядковых числительных производится с помощью класса `OrdinalNumeralGenerator`:

```php
use morphos\Gender;
use morphos\Russian\OrdinalNumeralGenerator;

$number = 67945;

OrdinalNumeralGenerator::getCase($number, 'именительный') => 'шестьдесят семь тысяч девятьсот сорок пятый'
OrdinalNumeralGenerator::getCase($number, 'именительный', Gender::FEMALE) => 'шестьдесят семь тысяч девятьсот сорок пятая'
```

```php
OrdinalNumeralGenerator::getCases($number) => array(6) {
    "nominative" => "шестьдесят семь тысяч девятьсот сорок пятый",
    "genitive" => "шестьдесят семь тысяч девятьсот сорок пятого",
    "dative" => "шестьдесят семь тысяч девятьсот сорок пятому",
    "accusative" => "шестьдесят семь тысяч девятьсот сорок пятый",
    "ablative" => "шестьдесят семь тысяч девятьсот сорок пятым",
    "prepositional" => "шестьдесят семь тысяч девятьсот сорок пятом"
}
```

## Валюты
Вы можете генерировать значения денежных сумм, записанных в виде текста с помощью класса `MoneySpeller`.

- `spell($value, $currency, $format = self::NORMAL_FORMAT, $case = null, $skipFractionalPartIfZero = null)`
  - API: `GET /ru/money/spell?value=...&currency=...&format=...&case=...&skipFractionalPartIfZero=...`

_Пример._

```php
use morphos\Russian\MoneySpeller;

MoneySpeller::spell(123.45, MoneySpeller::RUBLE) => 'сто двадцать три рубля сорок пять копеек'
MoneySpeller::spell(123.45, MoneySpeller::RUBLE, MoneySpeller::CLARIFICATION_FORMAT) => '123 (сто двадцать три) рубля 45 (сорок пять) копеек'
```

Все доступные форматы вывода:

| Формат                                 | Формат вывода                                                            | Пример                               |
|----------------------------------------|--------------------------------------------------------------------------|--------------------------------------|
| `MoneySpeller::SHORT_FORMAT`         | Сумма записывается цифрами, а валюта словами                             | 1 рубль 50 копеек                    |
| `MoneySpeller::NORMAL_FORMAT`        | Сумма и валюта записываются словами                                      | один рубль пятьдесят копеек          |
| `MoneySpeller::DUPLICATION_FORMAT`   | Сумма и валюта записываются словами. Сумма дублируется цифрами в скобках | один (1) рубль пятьдесят (50) копеек |
| `MoneySpeller::CLARIFICATION_FORMAT` | Сумма записывается словами и цифрами (в скобках), валюта - словами.      | 1 (один) рубль 50 (пятьдесят) копеек |

При указании валюты используйте знак валюты (например, ₽) или трехзначный код валюты (`\morphos\Currency::RUBLE`).

Также можно указать падеж для склонения четвёртым параметром:

```php
use morphos\Russian\MoneySpeller;

MoneySpeller::spell(123.45, MoneySpeller::RUBLE, MoneySpeller::NORMAL_FORMAT, 'родительный') => 'ста двадцати трех рублей сорока пяти копеек'
```

Доступные валюты:

| Знак | Идентификатор                | Валюта |
|------|------------------------------|--------|
| $    | `\morphos\Currency::DOLLAR`  | доллар |
| €    | `\morphos\Currency::EURO`    | евро   |
| ¥    | `\morphos\Currency::YEN`     | иена   |
| £    | `\morphos\Currency::POUND`   | фунт   |
| Fr   | `\morphos\Currency::FRANC`   | франк  |
| 元   | `\morphos\Currency::YUAN`    | юань   |
| Kr   | `\morphos\Currency::KRONA`   | крона  |
| MXN  | `\morphos\Currency::PESO`    | песо   |
| ₩    | `\morphos\Currency::WON`     | вон    |
| ₺    | `\morphos\Currency::LIRA`    | лира   |
| ₽    | `\morphos\Currency::RUBLE`   | рубль  |
| ₹    | `\morphos\Currency::RUPEE`   | рупия  |
| R$   | `\morphos\Currency::REAL`    | реал   |
| R    | `\morphos\Currency::RAND`    | рэнд   |
| ₴    | `\morphos\Currency::HRYVNIA` | гривна |
| ₸    | `\morphos\Currency::TENGE`   | тенге |

## Временные интервалы

Класс `TimeSpeller` позволяет генерировать временной интервал.
В классе есть методы для генерации:

- `TimeSpeller::spellDifference($dateTime, $options = 0, $limit = 0
)` - временной интервал между текущим временем и `$dateTime`. `$dateTime` может быть:
    - объектом `DateTime`
    - числом секунд с эпохи Unix (unix timestamp)
    - строкой с датой & временем (которую может прочитать `strtotime()`)
  - API: `GET /ru/time/spellDifference?dateTime=...&options=...&limit=...`
- `TimeSpeller::spellInterval(DateInterval $interval, $options = 0, $limit = 0)` - `$dateTime`, задаваемый объектом `DateInterval`
  - API: `GET /ru/time/spellInterval?interval=...&options=...&limit=...`

_Пример._

```php
use morphos\Russian\TimeSpeller;

TimeSpeller::spellDifference('+4 hours') => '4 часа'
TimeSpeller::spellDifference(time() + 14400) => '4 часа'
TimeSpeller::spellDifference('-2 minutes') => '2 минуты'
TimeSpeller::spellDifference(time() - 120) => '2 минуты'
``` 

_Пример._

```php
use morphos\Russian\TimeSpeller;

TimeSpeller::spellInterval(new DateInterval('P5YT2M')) => '5 лет 2 часа'
```

Также можно передать вторым аргументом в оба метода одну из следующих опций или их комбинацию (побитовое или `|`):

- `TimeSpeller::DIRECTION` - добавляет "назад" для положительных интвералов и "через" для отрицательных.
- `TimeSpeller::SEPARATE` - добавляет запятые между составными интервала и союз перед последней частью.

Третьим аргументом можно ограничить количество частей, которые будут сгенерированы.

```php
TimeSpeller::spellDifference(time() - 120, TimeSpeller::DIRECTION) => '2 минуты назад'
TimeSpeller::spellInterval(new DateInterval('P5YT2M'), TimeSpeller::DIRECTION) => '5 лет 2 часа назад'
TimeSpeller::spellInterval(new DateInterval('P5YT2M'), TimeSpeller::SEPARATE) => '5 лет и 2 часа'
TimeSpeller::spellInterval(new DateInterval('P5YT2M'), TimeSpeller::DIRECTION | TimeSpeller::SEPARATE) => '5 лет и 2 часа назад'
TimeSpeller::spellInterval(new DateInterval('P5YT2M'), TimeSpeller::DIRECTION) => '5 лет 2 часа назад'
TimeSpeller::spellInterval(new DateInterval('P5Y1DT10H2M'), TimeSpeller::SEPARATE, 2) => '5 лет и 1 день'
```

# Дополнительно

## Предлоги и окончания
В классе `morphos\Russian\RussianLanguage` есть следующие методы для добавления предлогов или изменения окончаний разных слов:

* `in($word)` - добавляет предлог `в` или `во` в зависимости от того, с каких букв начинается слово.
  * API: `GET /ru/prep/in?word=...`
* `with($word)` - добавляет предлог `с` или `со` в зависимости от того, с каких букв начинается слово.
  * API: `GET /ru/prep/with?word=...`
* `about($word)` - добавляет предлог `о`, `об` или `обо` в зависимости от того, с каких букв начинается слово.
  * API: `GET /ru/prep/about?word=...`
* `verb($verb, $gender)` - изменяет окончание глагола в прошедшем времени в зависимости от рода.
  * API: `GET /ru/verb/ending?verb=...&gender=...`

### Предлоги

Чтобы добавить предлог `о` или `об` в зависимости от того, с чего начинается следующее слово, используйте метод `about()`:
```php
use morphos\Russian\FirstNamesInflection;
use morphos\Russian\RussianLanguage;

RussianLanguage::about('Иване') => 'об Иване'
// или комбинируйте с другими функциями склонения
$name = 'Андрей';
RussianLanguage::about(FirstNamesInflection::getCase($name, 'п')) => 'об Андрее'
```

### Окончания глаголов

Глаголы в прошедшем времени в русском языке имеют признак рода. Чтобы упростить подбор правильной формы глаголы используйте функцию:

```php
string RussianLanguage::verb($verb, $gender)
```

Аргументы:
- `$verb` - глагол в мужском роде и прошедшем времени.
- `$gender` - необходимый род глагола. Если указано не `Gender::MALE`, то будет произведено преобразование в женский род.

_Пример._

```php
use morphos\Russian\RussianLanguage;

$name = 'Анастасия';
$gender = morphos\Gender::FEMALE;

$name.' '.RussianLanguage::verb('добавил', $gender) => 'Анастасия добавила'
$name.' '.RussianLanguage::verb('поделился', $gender).' публикацией' => 'Анастасия поделилась публикацией'
```

# Internals

Данная глава описывает ранее перечисленные функции и/или возможности более подробно.

## Склонение отдельных частей имени
Для склонения отдельных частей имени есть три класса:

- `FirstNamesInflection` - класс для склонения имён.
- `MiddleNamesInflection` - класс для склонения отчеств.
- `LastNamesInflection` - класс для склонения фамилий.

Все классы похожи друг на друга и имеют следующие методы:

- `boolean isMutable($word, $gender = null)` - проверяет, что часть имени склоняема.
- `string getCase($word, $case, $gender = null)` - склоняет часть имени и возвращает результат. `$case` - это одна из констант `morphos\Cases` или `morphos\Russian\Cases`.
- `array getCases($word, $gender = null)` - склоняет имя во всех падежах и возвращает результат в виде массива.
- `string detectGender($word)` - пытается определить пол по части имени.

_Примеры._

**FirstNamesInflection**

```php
use morphos\Russian\FirstNamesInflection;
// Возьмем имя Иван
$user_name = 'Иван';

FirstNamesInflection::getCase($user_name, 'родительный') => 'Ивана'

// получаем имя во всех падежах
FirstNamesInflection::getCases($user_name) => array(6) {
    "nominative" => "Иван",
    "genitive" => "Ивана",
    "dative" => "Ивану",
    "accusative" => "Ивана",
    "ablative" => "Иваном",
    "prepositional" => "Иване"
}
```

**MiddleNamesInflection**

```php
use morphos\Russian\MiddleNamesInflection;
$user_name = 'Сергеевич';

MiddleNamesInflection::getCase($user_name, 'родительный') => 'Сергеевича'

MiddleNamesInflection::getCases($user_name) => array(6) {
    "nominative" => "Сергеевич",
    "genitive" => "Сергеевича",
    "dative" => "Сергеевичу",
    "accusative" => "Сергеевича",
    "ablative" => "Сергеевичем",
    "prepositional" => "Сергеевиче"
}
```

**LastNamesInflection**

```php
use morphos\Russian\LastNamesInflection;
$user_last_name = 'Иванов';

$dative_last_name = LastNamesInflection::getCase($user_last_name, 'дательный'); // Иванову

echo 'Мы хотим подарить товарищу '.$dative_last_name.' небольшой презент.';

LastNamesInflection::getCases($user_last_name) => array(6) {
    "nominative" => "Иванов",
    "genitive" => "Иванова",
    "dative" => "Иванову",
    "accusative" => "Иванова",
    "ablative" => "Ивановым",
    "prepositional" => "Иванове"
}
```

## Полное склонение существительных

### Склонение в единственном числе

Функциональность по склонению имени существительных (а также существительных, перешедших из прилагательных/причастий) определена в классе `NounDeclension`:

- `boolean isMutable($word, bool $animateness = false)` - проверяет, изменяемо ли слово.
- `string getCase($word, $case, $animateness = false)` - склоняет слово в определённый падеж.
- `array getCases($word, $animateness = false)` - склоняет слово во всех падежах.
- `string detectGender($word)` - пытается определить пол существительного.

_Пример._

```php
use morphos\Russian\NounDeclension;
// Following code will return original word if it's immutable:
NounDeclension::getCase('поле', 'родительный') => 'поля'

// Get all forms of a word at once:
NounDeclension::getCases('линейка') => array(6) {
    "nominative" => "линейка",
    "genitive" => "линейки",
    "dative" => "линейке",
    "accusative" => "линейку",
    "ablative" => "линейкой",
    "prepositional" => "линейке"
}
```

### Склонение во множественном числе

Обеспечивается классом `NounPluralization`, который имеет похожие методы:

- `string getCase($word, $case, $animateness = false)` - получает один из падежей слова во множественном числе.
- `array getCases($word, $animateness = false)` - склоняет слово во множественном числе.
- `string pluralize($count, $word, $animateness = false)` - возвращает правильную форму существительного для сопряжения с числом.

_Пример._

```php
use morphos\Russian\NounPluralization;

$word = 'дом';
echo 'Множественное число для '.$word.' - '.NounPluralization::getCase($word, 'именительный'); // дома

// Pluralize word and get all forms:
NounPluralization::getCases('поле') => array(6) {
    "nominative" => "поля",
    "genitive" => "полей",
    "dative" => "полям",
    "accusative" => "поля",
    "ablative" => "полями",
    "prepositional" => "полях"
}
```
