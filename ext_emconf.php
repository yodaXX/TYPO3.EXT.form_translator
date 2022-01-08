<?php

$EM_CONF[$_EXTKEY] = [
    'title' => 'Form Translator',
    'description' => 'Backend module for translate forms.',
    'category' => 'module',
    'author' => 'R3 H6',
    'author_email' => 'r3h6@outlook.com',
    'state' => 'beta',
    'clearCacheOnLoad' => 0,
    'version' => '1.0.0',
    'constraints' => [
        'depends' => [
            'typo3' => '11.5.0-11.5.99',
            'form' => '11.5.0-11.5.99',
        ],
        'conflicts' => [],
        'suggests' => [],
    ],
];
