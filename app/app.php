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

    //symfony stuff goes here

    $app->get("/", function() use ($app) {
        return $app['twig']->render('index.twig', array('cuisines' => Cuisine::getAll()));
    });


    $app->post("/cuisines", function() use ($app) {
        $cuisine = new Cuisine($_POST['type']);
        $cuisine->save();
        return $app['twig']->render('index.twig', array('cuisines' => Cuisine::getAll()));
    });

    $app->post("/cuisines_added", function() use ($app) {

    });

    $app->post("/delete_cuisines", function() use ($app) {
    });

    $app->post("/restaurant", function() use ($app) {
    });

    $app->post("/restaurant_added", function() use ($app) {
    });

    $app->post("/delete_restaurants", function() use ($app) {
    });

    $app->post("/delete_restaurant", function() use ($app) {
    });

    return $app;

 ?>

-ish
