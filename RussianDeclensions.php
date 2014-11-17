<?php
namespace morphos;

interface RussianDeclensions extends BasicDeclensions {
	const IMENIT_1 = self::NOMINATIVE;
	const RODIT_2 = self::GENETIVE;
	const DAT_3 = self::DATIVE;
	const VINIT_4 = self::ACCUSATIVE;
	const TVORIT_5 = self::ABLATIVE;
	const PREDLOJ_6 = self::PREPOSITIONAL;
}
