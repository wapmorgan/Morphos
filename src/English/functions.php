<?php
namespace morphos\English;

function pluralize($word, $count = 2)
{
    return NounPluralization::pluralize($word, $count);
}
