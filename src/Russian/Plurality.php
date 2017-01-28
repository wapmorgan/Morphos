<?php
namespace morphos\Russian;

class Plurality extends \morphos\Plurality implements Cases {
	public function pluralize($word, $count, $animateness = false) {
		static $plu;
		if ($plu === null)
			$plu = new GeneralDeclension();
		$ending = $count % 10;
		if (($count > 20 && $ending == 1) || $count == 1) {
			return $word;
		} else if (($count > 20 && in_array($ending, range(2, 4))) || in_array($count, range(2, 4))) {
			return $plu->getForm($word, $animateness, self::RODIT_2);
		} else {
			$forms = $plu->pluralizeAllDeclensions($word, $animateness);
			return $forms[self::RODIT_2];
		}
	}
}
