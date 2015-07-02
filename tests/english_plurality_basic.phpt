--TEST--
test for general plurality.
--FILE--
<?php
require dirname(__FILE__).'/../vendor/autoload.php';
$plu = new morphos\EnglishPlurality();
echo $plu->pluralize('ship', 2)."\n";
echo $plu->pluralize('gun', 2)."\n";
echo $plu->pluralize('boy', 2)."\n";
echo $plu->pluralize('class', 2)."\n";
echo $plu->pluralize('box', 2)."\n";
echo $plu->pluralize('torpedo', 2)."\n";
echo $plu->pluralize('army', 2)."\n";
echo $plu->pluralize('navy', 2)."\n";
echo $plu->pluralize('wolf', 2)."\n";
echo $plu->pluralize('knife', 2)."\n";
echo $plu->pluralize('chief', 2)."\n";
echo $plu->pluralize('basis', 2)."\n";
echo $plu->pluralize('crisis', 2)."\n";
echo $plu->pluralize('radius', 2)."\n";
echo $plu->pluralize('nucleus', 2)."\n";
echo $plu->pluralize('curriculum', 2)."\n";
echo $plu->pluralize('man', 2)."\n";
echo $plu->pluralize('woman', 2)."\n";
echo $plu->pluralize('child', 2)."\n";
echo $plu->pluralize('foot', 2)."\n";
echo $plu->pluralize('tooth', 2)."\n";
echo $plu->pluralize('ox', 2)."\n";
echo $plu->pluralize('goose', 2)."\n";
echo $plu->pluralize('mouse', 2)."\n";
echo $plu->pluralize('schoolboy', 2)."\n";
echo $plu->pluralize('knowledge', 2)."\n";
echo $plu->pluralize('progress', 2)."\n";
echo $plu->pluralize('advise', 2)."\n";
echo $plu->pluralize('ink', 2)."\n";
echo $plu->pluralize('money', 2)."\n";
echo $plu->pluralize('scissors', 2)."\n";
echo $plu->pluralize('spectacles', 2)."\n";
echo $plu->pluralize('trousers', 2)."\n";
?>
--EXPECT--
ships
guns
boys
classes
boxes
torpedoes
armies
navies
wolves
knives
chiefs
bases
crises
radii
nuclei
curricula
men
women
children
feet
teeth
oxen
geese
mice
schoolboys
knowledge
progress
advise
ink
money
scissors
spectacles
trousers
