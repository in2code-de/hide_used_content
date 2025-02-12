<?php

$EM_CONF[$_EXTKEY] = [
    'title' => 'Hide used content elements',
    'description' => 'Removes used content elements with own colPos configuration from "Unused" column',
    'category' => 'misc',
    'author' => 'Nicole Cordes',
    'author_email' => 'typo3@cordes.co',
    'author_company' => 'biz-design',
    'state' => 'stable',
    'version' => '2.0.0',
    'constraints' => [
        'depends' => [
            'typo3' => '12.0.0-13.4.99',
        ],
        'conflicts' => [],
        'suggests' => [],
    ],
];
