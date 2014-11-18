<?php
namespace morphos;

class RussianPlurality extends BasicPlurality implements RussianCases {
	public function pluralize($word, $count, $animate = false) {
		static $plu;
		if ($plu === null)
			$plu = new RussianGeneralDeclension();
		$ending = $count % 10;
		if (($count > 20 && $ending == 1) || $count == 1) {
			return $word;
		} else if (($count > 20 && in_array($ending, range(2, 4))) || in_array($count, range(2, 4))) {
			return $plu->getForm($word, $animate, self::RODIT_2);
		} else {
			$forms = $plu->pluralizeAllDeclensions($word, $animate);
			return $forms[self::RODIT_2];
		}
	}
}
