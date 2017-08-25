<?php
namespace morphos\English;

function pluralize($count, $word)
{
    return $count.' '.NounPluralization::pluralize($word, $count);
}
