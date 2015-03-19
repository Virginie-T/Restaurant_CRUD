<?php

    require_once __DIR__."/../vendor/autoload.php";
    require_once __DIR__."/../src/Restaurant.php";
    require_once __DIR__."/../src/Cuisine.php";

    $app = new Silex\Application();
    $app['debug'] = true;

    $DB = new PDO('pgsql:host=localhost;dbname=food');

    $app->register(new Silex\Provider\TwigServiceProvider(), array(
        'twig.path' => __DIR__.'/../views'
    ));

    use Symfony\Component\HttpFoundation\Request;
    Request::enableHttpMethodParameterOverride();

    $app->get("/", function() use ($app) {
        return $app['twig']->render('index.twig', array('cuisines' => Cuisine::getAll()));
    });


    $app->post("/cuisines", function() use ($app) {
        $cuisine = new Cuisine($_POST['type']);
        $cuisine->save();
        return $app['twig']->render('index.twig', array('cuisines' => Cuisine::getAll()));
    });

    $app->get("/cuisines/{id}", function($id) use ($app) {
        $cuisine = Cuisine::find($id);
        return $app['twig']->render('cuisines_id.twig', array('cuisine' => $cuisine, 'restaurants' => $cuisine->getRestaurants()));
    });

    $app->post("/delete_cuisines", function() use ($app) {
        Cuisine::deleteAll();
        return $app['twig']->render('index.twig', array('cuisines' => Cuisine::getAll()));
    });

    $app->post("/restaurant", function() use ($app) {
        $name = $_POST['name'];
        $cuisine_id = $_POST['cuisine_id'];
        $restaurant = new Restaurant($name, $id = null, $cuisine_id);
        $restaurant->save();
        $cuisine = Cuisine::find($cuisine_id);

        return $app['twig']->render('cuisines_id.twig', array('cuisine' => $cuisine, 'restaurants' => $cuisine->getRestaurants()));
    });

    $app->get("/cuisines/{id}/edit", function($id) use ($app) {
        $cuisine = Cuisine::find($id);
        return $app['twig']->render('cuisine_edit.twig', array('cuisine' => $cuisine));
    });

    $app->patch("/cuisines/{id}", function($id) use ($app) {
        $type = $_POST['type'];
        $cuisine = Cuisine::find($id);
        $cuisine->update($type);
        return $app['twig']->render('cuisines_id.twig', array('cuisine' => $cuisine, 'restaurants' => $cuisine->getRestaurants()));
    });


    $app->delete("/cuisines/{id}/deleterestaurants", function($id) use ($app) {
//        $cuisine_id = $_GET['cuisine_id'];
        $cuisine = Cuisine::find($id);
        $restaurant = $cuisine->getRestaurants();
        $single_restaurant = $restaurant[0];
        $single_restaurant->deleteRestaurants();

        // $cuisine_id = $_GET['cuisine_id'];
        //
        // $cuisine = Cuisine::find($cuisine_id);
        return $app['twig']->render('cuisines_id.twig', array('cuisine' => $cuisine, 'restaurants' => $cuisine->getRestaurants()));
    });

    $app->post("/delete_restaurant", function() use ($app) {
    });

    return $app;

 ?>
