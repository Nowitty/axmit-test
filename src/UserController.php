<?php

namespace App;
use Psr\Container\ContainerInterface;

class UserController
{
   protected $container;

   public function __construct(ContainerInterface $container) 
   {
       $this->container = $container;
   }

   public function create($request, $response) 
   {
        $this->container->get('renderer')->render($response, 'register.phtml');
        return $response;
   }

   public function store($request, $response, $args) 
   {
        $db = new Database('users');
        $params = $request->getParsedBody();
        $db->insert($params);
        return $response->withHeader('Location', '/login');
   }

   public function login($request, $response) 
    {
        $this->container->get('renderer')->render($response, 'login.phtml');
        return $response;
    }

    public function auth($request, $response)
    {
        $db = new Database('users');
        $params = $request->getParsedBody();
        $name = $params['name'];
        $password = $params['password'];
        $user = $db->selectBy('name', $name);
        if (empty($user)) {
            $errors = ['Неверный логин'];
        } elseif ($user[0]['password'] !== $password) {
            $errors = ['Неверный пароль'];
        }
        if (!empty($errors)){
            $this->container->get('renderer')->render($response, 'login.phtml', compact('errors'));
            return $response;
        } else {
            $_SESSION['user'] = [
                'name' => $name,
                'id' => $user[0]['id']
            ];
            return $response->withHeader('Location', '/');
        }
    }

    public function logout($request, $response)
    {
        $_SESSION = [];
        session_destroy();
        return $response->withHeader('Location', '/');
    }

}