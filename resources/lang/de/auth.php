<?php

return [

    'pages' => [
        'login' => [
            'title' => 'Bei deinem Account anmelden',
            'logged_out' => 'Du wurdest abgemeldet.',
            'remember' => 'Angemeldet bleiben',
            'forgot' => 'Passwort vergessen?',
            'login' => 'Anmelden',
        ],
        'reset_password' => [
            'title' => 'Passwort zurücksetzen',
            'error' => 'Ungültiger reset token.',
            'success' => 'Du solltest in Kürze eine E-Mail erhalten.',
            'reset' => 'Passwort zurücksetzen',
        ],
        'new_password' => [
            'title' => 'Dein neues Passwort',
            'text' => 'Kopiere es und gehe zur Anmeldeseite.',
            'goto' => 'Gehe zur Anmeldeseite',
        ],
    ],

    'mails' => [
        'salutation' => 'Hallo',
        'your_password' => [
            'text' => 'This is insecure and needs to be reimplemented :-)',
            'value_label' => 'Dein Passwort',
        ],
        'password_reset' => [
            'text' => 'Bitte folge dem Link um dein Passwort zurückzusetzen.',
        ],
    ],
    'logout' => 'Abmelden',
];
