<?php

$EM_CONF[$_EXTKEY] = [
    'title' => 'Hide used content elements',
    'description' => 'Removes used content elements with own colPos configuration from "Unused" column',
    'category' => 'misc',
    'author' => 'Nicole Cordes',
    'author_email' => 'typo3@cordes.co',
    'author_company' => 'biz-design',
    'state' => 'stable',
    'uploadfolder' => 0,
    'createDirs' => '',
    'clearCacheOnLoad' => 0,
    'version' => '1.1.7',
    'constraints' => [
        'depends' => [
            'typo3' => '9.5.0-12.4.99',
        ],
        'conflicts' => [
        ],
        'suggests' => [
        ],
    ],
];
