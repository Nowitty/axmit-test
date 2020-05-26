<?php

namespace App;
use Psr\Container\ContainerInterface;

class CommentController
{
   protected $container;

   public function __construct(ContainerInterface $container) {
       $this->container = $container;
       $this->db = $container->get('App\Database');
       $this->db->table = 'comments';
   }

   public function create($request, $response) 
   {
        $params = $request->getParsedBody();
        $this->db->insert($params);
        return $response->withHeader('Location', '/articles/'.$params['article_id']);
   }
}