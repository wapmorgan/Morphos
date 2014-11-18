--TEST--
test for general plurality.
--FILE--
<?php
require dirname(__FILE__).'/../vendor/autoload.php';
$plu = new morphos\EnglishPlurality();
echo $plu->pluralize('ship')."\n";
echo $plu->pluralize('gun')."\n";
echo $plu->pluralize('boy')."\n";
echo $plu->pluralize('class')."\n";
echo $plu->pluralize('box')."\n";
echo $plu->pluralize('torpedo')."\n";
echo $plu->pluralize('army')."\n";
echo $plu->pluralize('navy')."\n";
echo $plu->pluralize('wolf')."\n";
echo $plu->pluralize('knife')."\n";
echo $plu->pluralize('chief')."\n";
echo $plu->pluralize('basis')."\n";
echo $plu->pluralize('crisis')."\n";
echo $plu->pluralize('radius')."\n";
echo $plu->pluralize('nucleus')."\n";
echo $plu->pluralize('curriculum')."\n";
echo $plu->pluralize('man')."\n";
echo $plu->pluralize('woman')."\n";
echo $plu->pluralize('child')."\n";
echo $plu->pluralize('foot')."\n";
echo $plu->pluralize('tooth')."\n";
echo $plu->pluralize('ox')."\n";
echo $plu->pluralize('goose')."\n";
echo $plu->pluralize('mouse')."\n";
echo $plu->pluralize('schoolboy')."\n";
echo $plu->pluralize('knowledge')."\n";
echo $plu->pluralize('progress')."\n";
echo $plu->pluralize('advise')."\n";
echo $plu->pluralize('ink')."\n";
echo $plu->pluralize('money')."\n";
echo $plu->pluralize('scissors')."\n";
echo $plu->pluralize('spectacles')."\n";
echo $plu->pluralize('trousers')."\n";
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
