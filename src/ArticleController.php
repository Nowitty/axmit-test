<?php

namespace App;
use Psr\Container\ContainerInterface;

class ArticleController
{
   protected $container;

   public function __construct(ContainerInterface $container) {
       $this->container = $container;
   }

   public function index($request, $response) 
   {
        $db = new Database('articles');
        $currentUser = $_SESSION['user'] ?? [];
        $articles = $db->selectAll();
        $this->container->get('renderer')->render($response, 'index.phtml', compact('articles', 'currentUser'));
        return $response;
   }

   public function show($request, $response, $args) 
   {
        $db = new Database('articles');
        $currentUser = $_SESSION['user'] ?? [];
        $article = $db->selectBy('id', $args['id'])[0];
        $db = new Database('comments');
        $comments = $db->selectBy('article_id', $article['id']);
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
        $db = new Database('articles');
        $params = $request->getParsedBody();
        $db->insert($params);
        return $response->withHeader('Location', '/');
   }
}