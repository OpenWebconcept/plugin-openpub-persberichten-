<?php

return [
    'models' => [
        /**
         * Custom field creators.
         *
         * [
         *      'creator'   => CreatesFields::class,
         *      'condition' => \Closure
         * ]
         */
        'persbericht'   => [
            'fields' => [
                'type' => OWC\OpenPub\Persberichten\RestAPI\ItemFields\TypeField::class,
            ],
        ]
    ],
];
