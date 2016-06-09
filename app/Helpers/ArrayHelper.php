<?php

function cleanEmptyValues($values)
{
        return array_filter($values, function($element) {
                    return ! is_null($element) && ! empty($element);
        });
}