<?php

namespace Ip\Internal\Pages;

class UrlAllocator
{
    public static function slugify($string)
    {
        $string = mb_strtolower($string);
        $string = \Ip\Internal\Text\Transliteration::transform($string);

        $replace = array(
            " " => "-",
            "/" => "-",
            "\\" => "-",
            "\"" => "-",
            "\'" => "-",
            "„" => "-",
            "“" => "-",
            "&" => "-",
            "%" => "-",
            "`" => "-",
            "!" => "-",
            "@" => "-",
            "#" => "-",
            "$" => "-",
            "^" => "-",
            "*" => "-",
            "(" => "-",
            ")" => "-",
            "{" => "-",
            "}" => "-",
            "[" => "-",
            "]" => "-",
            "|" => "-",
            "~" => "-",
            "." => "-",
            "'" => "",
            "?" => "",
            ":" => "",
            ";" => "",
        );
        $string = strtr($string, $replace);

        $string = preg_replace('/-+/', '-', $string);

        return $string;
    }

    public static function allocatePathForNewPage(array $page)
    {
        if (array_key_exists('urlPath', $page)) {
            $path = $page['urlPath'];
        } elseif (!empty($page['title'])) {
            $path = $page['title'];
        } else {
            $path = 'page';
        }

        $path = static::slugify($path);

        return static::allocatePath($page['languageCode'], $path);
    }

    public static function allocatePath($languageCode, $path)
    {
        if (self::isPathAvailable($languageCode, $path)) {
            return $path;
        }

        $i = 2;
        while (!self::isPathAvailable($languageCode, $path . '-' . $i)) {
            $i++;
        }

        return $path . '-' . $i;
    }

    /**
     * @parem string $languageCode
     * @param string $urlPath
     * @returns bool true if url is available
     */
    public static function isPathAvailable($languageCode, $urlPath)
    {
        $pageId = ipDb()->selectValue('page', '`id`', array('languageCode' => $languageCode, 'urlPath' => $urlPath, 'isDeleted' => 0));

        if (!$pageId) {
            return true;
        }

        return false;
    }
}
