<?php

namespace morphos\English;

/**
 * @param int $count
 * @param string $word
 * @return string
 */
function pluralize($count, $word)
{
    return $count . ' ' . NounPluralization::pluralize($word, $count);
}
