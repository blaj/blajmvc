<?php

namespace Blaj\BlajMVC\Core\Utils;

class Translations
{
    //TODO: przerobic ze statycznych na obiektowe

    /**
     * @var string
     */
    private static $lang;

    /**
     * @var array
     */
    private static $translations;

    /**
     * @param string $toTranslate
     * @param array $toChanges
     * @return mixed|null
     */
    public static function translate(string $toTranslate, array $toChanges = [])
    {
        if (!isset(self::$lang))
            self::setLang(DEFAULT_LANG);

        foreach (self::$translations as $translationsKeys => $translationsValues) {
            if ($translationsKeys == self::$lang) {
                foreach ($translationsValues as $translationskey => $translationValue) {
                    if ($translationskey == $toTranslate) {
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

        return self::Translate('not_exist', ['translation' => $toTranslate]);
    }

    /**
     * @param string $lang
     */
    public static function setLang(string $lang)
    {
        self::$lang = $lang;
    }

    /**
     * @return string
     */
    public static function getLang(): string
    {
        return self::$lang;
    }

    /**
     * @param array $translations
     */
    public static function setTranslations(array $translations)
    {
        self::$translations = $translations;
    }

    /**
     * @return array
     */
    public static function getTranslations(): array
    {
        return self::$translations;
    }
}
