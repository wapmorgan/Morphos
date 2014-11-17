<?php
namespace morphos;

class RussianPlurality extends BasicPlurality implements RussianCases {
	public function pluralize($word, $count, $animate = false) {
		static $plu;
		if ($plu === null)
			$plu = new RussianGeneralDeclension();
		//$count = $count % 10;
		if (in_array($count, range(2, 4))) {
			return $plu->getForm($word, $animate, self::RODIT_2);
		} else if ($count == 1) {
			return $word;
		} else {
			$forms = $plu->pluralizeAllDeclensions($word, $animate);
			return $forms[self::RODIT_2];
		}
	}
}
