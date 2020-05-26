<?php

namespace App;
use Psr\Container\ContainerInterface;

class ArticleController
{
   private $container;
   private $db;

   public function __construct(ContainerInterface $container) 
   {
       $this->container = $container;
       $this->db = $container->get('App\Database');
   }

   public function index($request, $response) 
   {
        $currentUser = $_SESSION['user'] ?? [];
        $articles = $this->db->selectAll('articles');
        $this->container->get('renderer')->render($response, 'index.phtml', compact('articles', 'currentUser'));
        return $response;
   }

   public function show($request, $response, $args) 
   {
        $currentUser = $_SESSION['user'] ?? [];
        $article = $this->db->selectBy('id', $args['id'], 'articles')[0];
        $comments = $this->db->selectBy('article_id', $article['id'], 'comments');
        $this->container->get('renderer')
        ->render($response, 'show.phtml', compact('article', 'currentUser', 'comments'));
        return $response;
   }

   public function create($request, $response) 
   {
        $currentUser = $_SESSION['user'] ?? [];
        $this->container->get('renderer')->render($response, 'create.phtml', compact('currentUser'));
        return $response;
   }

   public function store($request, $response) 
   {
        $params = $request->getParsedBody();
        $this->db->insert($params, 'articles');
        return $response->withHeader('Location', '/');
   }
}