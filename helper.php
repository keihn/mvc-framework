<?php

if(!function_exists('dump'))
{
    function dump($value)
    {
        echo '<pre>';
        var_dump($value);
        echo '</pre>';
    }
}
