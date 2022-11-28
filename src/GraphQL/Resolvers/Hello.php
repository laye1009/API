<?php

namespace App\GraphQL\Resolvers;

use Overblog\GraphQLBundle\Definition\Resolver\QueryInterface;
use Overblog\GraphQLBundle\Definition\Resolver\AliasedInterface;


class Hello implements QueryInterface, AliasedInterface{

    public function sayHello(){
        $hello = [
            'message' => 'I said hello'
        ];
        return json_encode($hello,true);
    }

    public static function getAliases(): array
    {
        return [
            'sayHello' => 'sayHello',
        ];
    }
}