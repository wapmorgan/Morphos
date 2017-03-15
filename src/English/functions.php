<?php
namespace morphos\English;

function pluralize($word, $count = 2) {
    return Plurality::pluralize($word, $count);
}
