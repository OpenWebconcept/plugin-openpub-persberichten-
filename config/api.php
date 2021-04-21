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
                'connected'    => OWC\Persberichten\RestAPI\ItemFields\ConnectedField::class,
                'mailinglists' => OWC\Persberichten\RestAPI\ItemFields\TypeField::class,
            ],
        ]
    ],
];
