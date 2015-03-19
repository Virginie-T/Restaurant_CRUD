<?php

    class Restaurant {

            private $name;
            private $id;
            private $cuisine_id;
            private $rating;
            private $review;

            function __construct($name, $id, $cuisine_id, $rating, $review)
            {
                $this->name = $name;
                $this->id = $id;
                $this->cuisine_id = $cuisine_id;
                $this->rating = $rating;
                $this->review = $review;
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

            function getRating()
            {
                return $this->rating;
            }

            function setRating($new_rating)
            {
                return $this->rating = (int) $new_rating;
            }

            function getReview()
            {
                return $this->review;
            }

            function setReview($new_review)
            {
                return $this->review = (string) $new_review;
            }

            function save()
            {
                $statement = $GLOBALS['DB']->query("INSERT INTO restaurants (name, cuisine_id, rating, review) VALUES ('{$this->getName()}', {$this->getCuisineId()}, {$this->getRating()}, '{$this->getReview()}') RETURNING id;");
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
                    $rating = $restaurant['rating'];
                    $review = $restaurant['review'];
                    $new_restaurant = new Restaurant($name, $id, $cuisine_id, $rating, $review);
                    array_push($restaurants, $new_restaurant);
                }
                return $restaurants;
            }

            static function deleteAll()
            {
                $GLOBALS['DB']->exec("DELETE FROM restaurants *;");
            }

            function deleteRestaurants()
            {
                $GLOBALS['DB']->exec("DELETE FROM restaurants WHERE cuisine_id = {$this->getCuisineId()};");
            }

            function update($new_name)
            {
                $GLOBALS['DB']->exec("UPDATE restaurants SET name = '{$new_name}' WHERE id = {$this->getId()};");
                $this->setName($new_name);
            }

            function deleteSingle()
            {
                $GLOBALS['DB']->exec("DELETE FROM restaurants WHERE id = {$this->getId()};");
            }

            static function find($cuisine_id)
            {
                $found_restaurant = null;
                $restaurants = Restaurant::getAll();
                foreach($restaurants as $restaurant) {
                    $restaurant_id = $restaurant->getId();
                    if ($restaurant_id == $cuisine_id) {
                        $found_restaurant = $restaurant;
                    }
                  }
                    return $found_restaurant;
            }

    }

?>
