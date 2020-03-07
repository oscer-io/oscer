<?php

return [


    'pages' => [
        'login' => [
            'title' => 'Sign in to your account',
            'logged_out' => 'You\'ve been logged out.',
            'remember' => 'Remember me',
            'forgot' => 'Forgot your password?',
            'login' => 'Sign in',
        ],
        'reset_password' => [
            'title' => 'Reset your password',
            'error' => 'Invalid reset token.',
            'success' => 'You should receive an email in a bit.',
            'reset' => 'Reset Password',
        ],
        'new_password' => [
            'title' => 'Your new Password',
            'text' =>'Copy it and head to the login page.',
            'goto' => 'Go To Login Page'
        ],
    ],

    'mails' => [
        'salutation' => 'Hello',
        'your_password' => [
            'text' => 'THis is insecure and needs to be reimplemented :-)',
            'value_label' => 'Your password',
        ],
        'password_reset' => [
            'text' => 'Please follow this link to reset your password',
        ],
    ],


];
