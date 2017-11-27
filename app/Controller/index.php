<?php
// require_once __DIR__ . '/../Model/User.php';
use Model\User;
use \Symfony\Component\HttpFoundation\Request;

$controller = $app['controllers_factory'];

$controller->get('/', function () {
    return "Hello World!";
});

$controller->get('/hello/{name}', function ($name) use ($app) {
    return $app['twig']->render('hello.twig', array(
        'name' => $name
    ));
});

$controller->get('/user', function () use ($app) {

    $param = (new User($app['db']))->fetchByQueryBuilder();
    return $app['twig']->render('users.twig', array(
        'param' => $param
    ));
});

$controller->get('/user/{user_id}', function ($user_id) use ($app) {

    $param = (new User($app['db']))->fetchByUserId($user_id);

    return $app['twig']->render('user_detail.twig', $param);
});

$controller->match('/userentry', function () use ($app) {

    return $app['twig']->render('user_entry_form.twig', array());

})->method('GET');

$controller->match('/userentry', function (Request $request) use ($app) {

    $param = $request->get('user');
    $user = new User($app['db']);

    $message = $param['user_name'];

    if($user->insert($param) >= 1){
        $message = $message."を登録しました";
        return $app['twig']->render('user_entry_comp.twig', array(
            'message' => $message
        ));
    }

    $message = $message."の登録に失敗しました";
    return $app['twig']->render('user_entry_comp.twig', array(
        'message' => $message
    ));
})->bind('user_entry')->method('POST');

return $controller;