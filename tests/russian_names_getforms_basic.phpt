--TEST--
test for russian names declension. Part: getForms() method.
--FILE--
<?php
require dirname(__FILE__).'/../vendor/autoload.php';
$dec = new morphos\RussianNamesDeclension();
var_dump(implode(', ', $dec->getForms('Иван', morphos\RussianNamesDeclension::MAN)));
var_dump(implode(', ', $dec->getForms('Святослав', morphos\RussianNamesDeclension::MAN)));
var_dump(implode(', ', $dec->getForms('Тимур', morphos\RussianNamesDeclension::MAN)));
var_dump(implode(', ', $dec->getForms('Рем', morphos\RussianNamesDeclension::MAN)));
var_dump(implode(', ', $dec->getForms('Казбич', morphos\RussianNamesDeclension::MAN)));
var_dump(implode(', ', $dec->getForms('Игорь', morphos\RussianNamesDeclension::MAN)));
var_dump(implode(', ', $dec->getForms('Виль', morphos\RussianNamesDeclension::MAN)));
var_dump(implode(', ', $dec->getForms('Рауль', morphos\RussianNamesDeclension::MAN)));
var_dump(implode(', ', $dec->getForms('Шамиль', morphos\RussianNamesDeclension::MAN)));
var_dump(implode(', ', $dec->getForms('Петрусь', morphos\RussianNamesDeclension::MAN)));
echo "\n";
var_dump(implode(', ', $dec->getForms('Абай', morphos\RussianNamesDeclension::MAN)));
var_dump(implode(', ', $dec->getForms('Федяй', morphos\RussianNamesDeclension::MAN)));
var_dump(implode(', ', $dec->getForms('Андрей', morphos\RussianNamesDeclension::MAN)));
var_dump(implode(', ', $dec->getForms('Гарей', morphos\RussianNamesDeclension::MAN)));
var_dump(implode(', ', $dec->getForms('Джансуй', morphos\RussianNamesDeclension::MAN)));
var_dump(implode(', ', $dec->getForms('Ной', morphos\RussianNamesDeclension::MAN)));
echo "\n";
var_dump(implode(', ', $dec->getForms('Дмитрий', morphos\RussianNamesDeclension::MAN)));
var_dump(implode(', ', $dec->getForms('Гордий', morphos\RussianNamesDeclension::MAN)));
var_dump(implode(', ', $dec->getForms('Пий', morphos\RussianNamesDeclension::MAN)));
var_dump(implode(', ', $dec->getForms('Геннадий', morphos\RussianNamesDeclension::MAN)));
var_dump(implode(', ', $dec->getForms('Хаджибий', morphos\RussianNamesDeclension::MAN)));
echo "\n";
var_dump(implode(', ', $dec->getForms('Никита', morphos\RussianNamesDeclension::MAN)));
var_dump(implode(', ', $dec->getForms('Данила', morphos\RussianNamesDeclension::MAN)));
var_dump(implode(', ', $dec->getForms('Эйса', morphos\RussianNamesDeclension::MAN)));
var_dump(implode(', ', $dec->getForms('Кузьма', morphos\RussianNamesDeclension::MAN)));
var_dump(implode(', ', $dec->getForms('Мустафа', morphos\RussianNamesDeclension::MAN)));
echo "\n";
var_dump(implode(', ', $dec->getForms('Байхужа', morphos\RussianNamesDeclension::MAN)));
var_dump(implode(', ', $dec->getForms('Хасанша', morphos\RussianNamesDeclension::MAN)));
var_dump(implode(', ', $dec->getForms('Карча', morphos\RussianNamesDeclension::MAN)));
var_dump(implode(', ', $dec->getForms('Гыкга', morphos\RussianNamesDeclension::MAN)));
var_dump(implode(', ', $dec->getForms('Бетикка', morphos\RussianNamesDeclension::MAN)));
echo "\n";
var_dump(implode(', ', $dec->getForms('Анания', morphos\RussianNamesDeclension::MAN)));
var_dump(implode(', ', $dec->getForms('Неемия', morphos\RussianNamesDeclension::MAN)));
var_dump(implode(', ', $dec->getForms('Малахия', morphos\RussianNamesDeclension::MAN)));
var_dump(implode(', ', $dec->getForms('Осия', morphos\RussianNamesDeclension::MAN)));
var_dump(implode(', ', $dec->getForms('Иеремия', morphos\RussianNamesDeclension::MAN)));
var_dump(implode(', ', $dec->getForms('Илия', morphos\RussianNamesDeclension::MAN)));
echo "\n";
var_dump(implode(', ', $dec->getForms('Данило', morphos\RussianNamesDeclension::MAN)));
var_dump(implode(', ', $dec->getForms('Иванко', morphos\RussianNamesDeclension::MAN)));
echo "\n";
echo 'Woman'."\n";
var_dump(implode(', ', $dec->getForms('Анна', morphos\RussianNamesDeclension::WOMAN)));
var_dump(implode(', ', $dec->getForms('Эра', morphos\RussianNamesDeclension::WOMAN)));
var_dump(implode(', ', $dec->getForms('Асма', morphos\RussianNamesDeclension::WOMAN)));
var_dump(implode(', ', $dec->getForms('Хафиза', morphos\RussianNamesDeclension::WOMAN)));
echo "\n";
var_dump(implode(', ', $dec->getForms('Ольга', morphos\RussianNamesDeclension::WOMAN)));
var_dump(implode(', ', $dec->getForms('Моника', morphos\RussianNamesDeclension::WOMAN)));
var_dump(implode(', ', $dec->getForms('Голиндуха', morphos\RussianNamesDeclension::WOMAN)));
var_dump(implode(', ', $dec->getForms('Снежа', morphos\RussianNamesDeclension::WOMAN)));
var_dump(implode(', ', $dec->getForms('Гайша', morphos\RussianNamesDeclension::WOMAN)));
echo "\n";
var_dump(implode(', ', $dec->getForms('Милица', morphos\RussianNamesDeclension::WOMAN)));
var_dump(implode(', ', $dec->getForms('Ляуца', morphos\RussianNamesDeclension::WOMAN)));
var_dump(implode(', ', $dec->getForms('Куаца', morphos\RussianNamesDeclension::WOMAN)));
echo "\n";
var_dump(implode(', ', $dec->getForms('Олеся', morphos\RussianNamesDeclension::WOMAN)));
var_dump(implode(', ', $dec->getForms('Дарья', morphos\RussianNamesDeclension::WOMAN)));
var_dump(implode(', ', $dec->getForms('Майя', morphos\RussianNamesDeclension::WOMAN)));
var_dump(implode(', ', $dec->getForms('Моя', morphos\RussianNamesDeclension::WOMAN)));
var_dump(implode(', ', $dec->getForms('Пелагея', morphos\RussianNamesDeclension::WOMAN)));
echo "\n";
var_dump(implode(', ', $dec->getForms('Марция', morphos\RussianNamesDeclension::WOMAN)));
var_dump(implode(', ', $dec->getForms('Наталия', morphos\RussianNamesDeclension::WOMAN)));
var_dump(implode(', ', $dec->getForms('Армения', morphos\RussianNamesDeclension::WOMAN)));
echo "\n";
var_dump(implode(', ', $dec->getForms('Лия', morphos\RussianNamesDeclension::WOMAN)));
var_dump(implode(', ', $dec->getForms('Ия', morphos\RussianNamesDeclension::WOMAN)));
echo "\n";
var_dump(implode(', ', $dec->getForms('Любовь', morphos\RussianNamesDeclension::WOMAN)));
var_dump(implode(', ', $dec->getForms('Эсфирь', morphos\RussianNamesDeclension::WOMAN)));
var_dump(implode(', ', $dec->getForms('Нинель', morphos\RussianNamesDeclension::WOMAN)));
var_dump(implode(', ', $dec->getForms('Айгюль', morphos\RussianNamesDeclension::WOMAN)));
echo "\n";
var_dump(implode(', ', $dec->getForms('Вартануш', morphos\RussianNamesDeclension::WOMAN)));
var_dump(implode(', ', $dec->getForms('Катиш', morphos\RussianNamesDeclension::WOMAN)));
var_dump(implode(', ', $dec->getForms('Хуж', morphos\RussianNamesDeclension::WOMAN)));
var_dump(implode(', ', $dec->getForms('Гуащ', morphos\RussianNamesDeclension::WOMAN)));
var_dump(implode(', ', $dec->getForms('Карач', morphos\RussianNamesDeclension::WOMAN)));

?>
--EXPECT--
string(75) "Иван, Ивана, Ивану, Ивана, Иваном, об Иване"
string(133) "Святослав, Святослава, Святославу, Святослава, Святославом, о Святославе"
string(85) "Тимур, Тимура, Тимуру, Тимура, Тимуром, о Тимуре"
string(61) "Рем, Рема, Рему, Рема, Ремом, о Реме"
string(97) "Казбич, Казбича, Казбичу, Казбича, Казбичем, о Казбиче"
string(77) "Игорь, Игоря, Игорю, Игоря, Игорем, об Игоре"
string(63) "Виль, Виля, Вилю, Виля, Вилем, о Виле"
string(75) "Рауль, Рауля, Раулю, Рауля, Раулем, о Рауле"
string(87) "Шамиль, Шамиля, Шамилю, Шамиля, Шамилем, о Шамиле"
string(99) "Петрусь, Петруся, Петрусю, Петруся, Петрусем, о Петрусе"

string(65) "Абай, Абая, Абаю, Абая, Абаем, об Абае"
string(75) "Федяй, Федяя, Федяю, Федяя, Федяем, о Федяе"
string(89) "Андрей, Андрея, Андрею, Андрея, Андреем, об Андрее"
string(75) "Гарей, Гарея, Гарею, Гарея, Гареем, о Гарее"
string(99) "Джансуй, Джансуя, Джансую, Джансуя, Джансуем, о Джансуе"
string(51) "Ной, Ноя, Ною, Ноя, Ноем, о Ное"

string(99) "Дмитрий, Дмитрия, Дмитрию, Дмитрия, Дмитрием, о Дмитрии"
string(87) "Гордий, Гордия, Гордию, Гордия, Гордием, о Гордии"
string(51) "Пий, Пия, Пию, Пия, Пием, о Пии"
string(111) "Геннадий, Геннадия, Геннадию, Геннадия, Геннадием, о Геннадии"
string(111) "Хаджибий, Хаджибия, Хаджибию, Хаджибия, Хаджибием, о Хаджибии"

string(87) "Никита, Никиты, Никите, Никиту, Никитой, о Никите"
string(87) "Данила, Данилы, Даниле, Данилу, Данилой, о Даниле"
string(65) "Эйса, Эйсы, Эйсе, Эйсу, Эйсой, об Эйсе"
string(87) "Кузьма, Кузьмы, Кузьме, Кузьму, Кузьмой, о Кузьме"
string(99) "Мустафа, Мустафы, Мустафе, Мустафу, Мустафой, о Мустафе"

string(99) "Байхужа, Байхужи, Байхуже, Байхужу, Байхужой, о Байхуже"
string(99) "Хасанша, Хасанши, Хасанше, Хасаншу, Хасаншой, о Хасанше"
string(75) "Карча, Карчи, Карче, Карчу, Карчой, о Карче"
string(75) "Гыкга, Гыкги, Гыкге, Гыкгу, Гыкгой, о Гыкге"
string(99) "Бетикка, Бетикки, Бетикке, Бетикку, Бетиккой, о Бетикке"

string(89) "Анания, Анании, Анании, Ананию, Ананией, об Анании"
string(87) "Неемия, Неемии, Неемии, Неемию, Неемией, о Неемии"
string(99) "Малахия, Малахии, Малахии, Малахию, Малахией, о Малахии"
string(65) "Осия, Осии, Осии, Осию, Осией, об Осии"
string(101) "Иеремия, Иеремии, Иеремии, Иеремию, Иеремией, об Иеремии"
string(65) "Илия, Илии, Илии, Илию, Илией, об Илии"

string(87) "Данило, Данилы, Даниле, Данилу, Данилой, о Даниле"
string(89) "Иванко, Иванки, Иванке, Иванку, Иванкой, об Иванке"

Woman
string(65) "Анна, Анны, Анне, Анну, Анной, об Анне"
string(53) "Эра, Эры, Эре, Эру, Эрой, об Эре"
string(65) "Асма, Асмы, Асме, Асму, Асмой, об Асме"
string(87) "Хафиза, Хафизы, Хафизе, Хафизу, Хафизой, о Хафизе"

string(77) "Ольга, Ольги, Ольге, Ольгу, Ольгой, об Ольге"
string(87) "Моника, Моники, Монике, Монику, Моникой, о Монике"
string(123) "Голиндуха, Голиндухи, Голиндухе, Голиндуху, Голиндухой, о Голиндухе"
string(75) "Снежа, Снежи, Снеже, Снежу, Снежой, о Снеже"
string(75) "Гайша, Гайши, Гайше, Гайшу, Гайшой, о Гайше"

string(87) "Милица, Милицы, Милице, Милицу, Милицей, о Милице"
string(75) "Ляуца, Ляуцы, Ляуце, Ляуцу, Ляуцей, о Ляуце"
string(75) "Куаца, Куацы, Куаце, Куацу, Куацей, о Куаце"

string(77) "Олеся, Олеси, Олесе, Олесю, Олесей, об Олесе"
string(75) "Дарья, Дарьи, Дарье, Дарью, Дарьей, о Дарье"
string(63) "Майя, Майи, Майе, Майю, Майей, о Майе"
string(51) "Моя, Мои, Мое, Мою, Моей, о Мое"
string(99) "Пелагея, Пелагеи, Пелагее, Пелагею, Пелагеей, о Пелагее"

string(87) "Марция, Марции, Марции, Марцию, Марцией, о Марции"
string(99) "Наталия, Наталии, Наталии, Наталию, Наталией, о Наталии"
string(101) "Армения, Армении, Армении, Армению, Арменией, об Армении"

string(51) "Лия, Лии, Лии, Лию, Лией, о Лии"
string(41) "Ия, Ии, Ии, Ию, Ией, об Ии"

string(87) "Любовь, Любови, Любови, Любовь, Любовью, о Любови"
string(89) "Эсфирь, Эсфири, Эсфири, Эсфирь, Эсфирью, об Эсфири"
string(87) "Нинель, Нинели, Нинели, Нинель, Нинелью, о Нинели"
string(89) "Айгюль, Айгюли, Айгюли, Айгюль, Айгюлью, об Айгюли"

string(119) "Вартануш, Вартануши, Вартануши, Вартануш, Вартанушью, о Вартануши"
string(83) "Катиш, Катиши, Катиши, Катиш, Катишью, о Катиши"
string(59) "Хуж, Хужи, Хужи, Хуж, Хужью, о Хужи"
string(71) "Гуащ, Гуащи, Гуащи, Гуащ, Гуащью, о Гуащи"
string(83) "Карач, Карачи, Карачи, Карач, Карачью, о Карачи"
