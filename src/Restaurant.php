<?php

    class Restaurant {

            private $name;
            private $id;
            private $cuisine_id;

            function __construct($name, $id, $cuisine_id)
            {
                $this->name = $name;
                $this->id = $id;
                $this->cuisine_id = $cuisine_id;
            }

            function getName()
            {
                return $this->name;
            }

            function setName($new_name)
            {
                return $this->name = (string) $new_name;
            }

            function getId()
            {
                return $this->id;
            }

            function setId($new_id)
            {
                return $this->id = (int) $new_id;
            }

            function getCuisineId()
            {
                return $this->cuisine_id;
            }

            function setCuisineId($new_cuisine_id)
            {
                $this->cuisine_id = (int) $new_cuisine_id;
            }

            function save()
            {
                $statement = $GLOBALS['DB']->query("INSERT INTO restaurants (name, cuisine_id) VALUES ('{$this->getName()}', {$this->getCuisineId()}) RETURNING id;");
                $result = $statement->fetch(PDO::FETCH_ASSOC);
                $this->setId($result['id']);
            }

            static function getAll()
            {
                $returned_restaurant = $GLOBALS['DB']->query("SELECT * FROM restaurants;");
                $restaurants = array();
                foreach($returned_restaurant as $restaurant) {
                    $name = $restaurant['name'];
                    $id = $restaurant['id'];
                    $cuisine_id = $restaurant['cuisine_id'];
                    $new_restaurant = new Restaurant($name, $id, $cuisine_id);
                    array_push($restaurants, $new_restaurant);
                }
                return $restaurants;
            }

            static function deleteAll()
            {
                $GLOBALS['DB']->exec("DELETE FROM restaurants *;");
            }




    }

?>
