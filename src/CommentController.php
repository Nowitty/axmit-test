<?php

namespace App;
use Psr\Container\ContainerInterface;

class CommentController
{
   protected $container;

   public function __construct(ContainerInterface $container) {
       $this->container = $container;
   }

   public function create($request, $response) 
   {
        $db = new Database('comments');
        $params = $request->getParsedBody();
        var_dump($params);
        $db->insert($params);
        return $response->withHeader('Location', '/articles/'.$params['article_id']);
   }
}