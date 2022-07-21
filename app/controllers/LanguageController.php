<?php

namespace app\controllers;

use wfm\App;

class LanguageController extends AppController
{
    public function changeAction()
    {
        $lang = $_GET['lang'] ?? null;
        if ($lang) {
            if (array_key_exists($lang, App::$app->getProperty('languages'))) {
                // отрезаем базовый url
                $url = trim(str_replace(PATH, '', $_SERVER['HTTP_REFERER']), '/');
                // разбивам на две части 
                //1. Возможный бывший язык 
                $url_parts = explode('/', $url, 2);
                // ищем первую часть (бывший язык) в массиве языков
                if (array_key_exists($url_parts[0], App::$app->getProperty('languages'))) {
                    // присваиваем первой части новый язык, если он не является базовым
                    if ($lang != App::$app->getProperty('language')['code']) {
                        $url_parts[0] = $lang;
                    } else {
                        // если это базовый язык - удалим язык из url
                        array_shift($url_parts);
                    }
                } else {
                    // присваиваем первой части новый язык, если он не является базовым
                    if ($lang != App::$app->getProperty('language')['code']) {
                        array_unshift($url_parts, $lang);
                    }
                }
                $url = PATH . '/' . implode('/', $url_parts);
            }
        }
        redirect($url);
    }
}
