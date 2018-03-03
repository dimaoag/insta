<?php


namespace frontend\components;

use yii\base\BootstrapInterface;

class LanguageSelector implements BootstrapInterface
{
    public $supportedLanguages = ['ru-RU', 'en-US'];

    public function bootstrap($app)
    {
        $cookieLanguage = $app->request->cookies['language'];
        if (isset($cookieLanguage) && in_array($cookieLanguage, $this->supportedLanguages)){
            $app->language = $cookieLanguage;
        }
    }
}