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
                'connected'    => OWC\OpenPub\Persberichten\RestAPI\ItemFields\ConnectedField::class,
                'mailinglists' => OWC\OpenPub\Persberichten\RestAPI\ItemFields\TypeField::class,
            ],
        ]
    ],
];
