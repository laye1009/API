<?php

namespace App\Types;


use GraphQL\Type\Definition\ObjectType;
use GraphQL\Type\Definition\Type;

$queryType = new ObjectType([
    'name' => 'Query',
    'fields' => [
        'echo' => [
            'type' => Type::string(),
            'args' => [
                'message' => Type::nonNull(Type::string()),
            ],
            'resolve' => fn ($rootValue, array $args): string => $rootValue['prefix'] . $args['message'],
        ],
    ],
]);

