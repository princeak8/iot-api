<?php

namespace App;

class Helpers
{
    public static function formatTopic($topic)
    {
        return str_replace('/', '-', $topic);
    }
}