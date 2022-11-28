<?php

namespace App\Controller;

use Exception;
use GraphQL\GraphQL;
use GraphQL\Type\Schema;
use App\Types\HelloQuery;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class ApiController extends AbstractController
{
    #[Route('/hello', name: 'app_hello')]
    public function index(HelloQuery $query): JsonResponse
    {
        $schema = new Schema([
            query => $query
        ]);
        $rawInput = \file_get_contents('php://input');
        $query = $rawInput['query'];
        $rootValue = ['prefix' => 'Yo, you said: '];
        $variables = isset($rawInput['variables']) ? $rawInput['variables'] : null;
        try {
            $result = GraphQL::excuteQuery($schema, $query, $rootValue, null, $variableValues);
            $output = $result->toArray();
        } catch(Exception $e){
            $output = [
                'error' => [
                    'message' => $e->getMessage()
                ]
            ];
        }
        echo json_encode($output,true);
        //var_dump(json_encode($output,true));
    }
}
