<?php

namespace Blaj\BlajMVC\Core\Utils;

class Translations
{
    private static $lang;

    private static $translations = [];

    public static function Translate($name, $toChanges = false)
    {
        if (!isset(self::$lang))
            self::$lang = DEFAULT_LANG;

        foreach (self::$translations as $translationsKeys => $translationsValues) {
            if ($translationsKeys == self::$lang) {
                foreach ($translationsValues as $translationskey => $translationValue) {
                    if ($translationskey == $name) {
                        if ($toChanges) {
                            $result = $translationValue;
                            foreach ($toChanges as $key => $value) {
                                $result = str_replace('{'.$key.'}', $value, $result);
                            }

                            return $result;
                        }

                        return $translationValue;
                    }
                }
            }
        }

        return null;
    }

    public static function setLang($lang)
    {
        self::$lang = $lang;
    }

    public static function getLang()
    {
        return self::$lang;
    }

    public static function setTranslations($translations)
    {
        self::$translations = $translations;
    }

    public static function getTranslations()
    {
        return self::$translations;
    }

    public static function setCurrentTranslations($currentTranslations)
    {
        self::$currentTranslations = $currentTranslations;
    }

    public static function getCurrentTranslations()
    {
        return self::$currentTranslations;
    }
}
