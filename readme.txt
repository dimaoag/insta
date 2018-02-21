AuthClient extension

https://github.com/yiisoft/yii2-authclient
composer require --prefer-dist yiisoft/yii2-authclient

return [
    'components' => [
        'authClientCollection' => [
            'class' => 'yii\authclient\Collection',
            'clients' => [
                'google' => [
                    'class' => 'yii\authclient\clients\Google',
                    'clientId' => 'google_client_id',
                    'clientSecret' => 'google_client_secret',
                ],
                'facebook' => [
                    'class' => 'yii\authclient\clients\Facebook',
                    'clientId' => 'facebook_client_id',
                    'clientSecret' => 'facebook_client_secret',
                ],
                // etc.
            ],
        ]
        // ...
    ],
    // ...
];

https://developers.facebook.com/

create new web site

setting > basic -> create new application add url

add component to app and create migration(read documentation)




