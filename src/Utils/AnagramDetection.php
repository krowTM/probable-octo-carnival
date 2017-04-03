<?php

namespace Tour\Utils;

class AnagramDetection
{
    /**
     * checks if 2 strings are anagrams
     *
     * @param $string1 string
     * @param $string2 string
     *
     * @return bool
     */
    public static function isAnagram($string1, $string2)
    {
        $string1 = str_replace(' ', '', $string1);
        $string2 = str_replace(' ', '', $string2);
        if (strlen($string1) != strlen($string2)) return false;

        $chars = [];
        for ($i = 97; $i <= 122; $i++) {
            $chars[chr($i)] = 0;
        }
        for ($i = 0; $i < strlen($string1); $i++) {
            $chars[strtolower($string1[$i])]++;
        }
        for ($i = 0; $i < strlen($string2); $i++) {
            if ($chars[strtolower($string2[$i])] == 0) return false;
            $chars[strtolower($string2[$i])]--;
        }

        return array_sum($chars) == 0;
    }
}