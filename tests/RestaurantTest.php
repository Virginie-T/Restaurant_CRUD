<?php

/**
* @backupGlobals disabled
* @backupStaticAttributes disabled
*/

    require_once 'src/Restaurant.php';
    require_once 'src/Cuisine.php';

    $DB = new PDO ('pgsql:host=localhost;dbname=food_test');


    class RestaurantTest extends PHPUnit_Framework_TestCase
    {

        protected function tearDown()
        {
            Restaurant::deleteAll();
            Cuisine::deleteAll();
        }

        function test_getName()
        {
            //Arrange
            $name = "italian";
            $id = null;
            $cuisine_id = 1;
            $test_restaurant = new Restaurant($name, $id, $cuisine_id);

            //Act
            $result = $test_restaurant->getName();

            //Assert
            $this->assertEquals($name, $result);
        }

        function test_getId()
        {
            //Arrange
            $type = "mexican";
            $id = null;
            $test_cuisine = new Cuisine($type, $id);
            $test_cuisine->save();

            $name = "Taco Bell";
            $cuisine_id = $test_cuisine->getId();
            $test_restaurant = new Restaurant($name, $id, $cuisine_id);
            $test_restaurant->save();

            //Act
            $result = $test_restaurant->getId();

            //Assert
            $this->assertEquals(true, is_numeric($result));
        }

        function test_save()
        {
            //Arrange
            $type = "french";
            $id = null;

            $test_cuisine = new Cuisine($type, $id);
            $test_cuisine->save();

            $name = "olive garden";
            $cuisine_id = $test_cuisine->getId();
            $test_restaurant = new Restaurant($name, $id, $cuisine_id);

            //Act
            $test_restaurant->save();

            //Assert
            $result = Restaurant::getAll();
            $this->assertEquals($test_restaurant, $result[0]);
        }

        function test_getAll()
        {
            //Arrange
            $name = "Burger king";
            $id = null;
            $name2 = "Mcdonalds";

            $type = "American";
            $test_cuisine = new Cuisine($type, $id);
            $test_cuisine->save();

            $cuisine_id = $test_cuisine->getId();

            $test_restaurant = new Restaurant($name, $id, $cuisine_id);
            $test_restaurant->save();
            $test_restaurant2 = new Restaurant($name2, $id, $cuisine_id);
            $test_restaurant2->save();

            //Act
            $result = Restaurant::getAll();

            //Assert
            $this->assertEquals([$test_restaurant, $test_restaurant2], $result);
        }

        function test_deleteAll()
        {
            //Arrange
            $name = "Burger king";
            $id = null;
            $name2 = "Mcdonalds";

            $type = "American";
            $test_cuisine = new Cuisine($type, $id);
            $test_cuisine->save();

            $cuisine_id = $test_cuisine->getId();

            $test_restaurant = new Restaurant($name, $id, $cuisine_id);
            $test_restaurant->save();
            $test_restaurant2 = new Restaurant($name2, $id, $cuisine_id);
            $test_restaurant2->save();

            //Act
            $result = Restaurant::deleteAll();

            //Assert
            $result = Restaurant::getAll();
            $this->assertEquals([], $result);
        }

        function testUpdateName()
        {
            //Arrange
            $type = "Armenian";
            $id = null;
            $test_cuisine = new Cuisine($type, $id);
            $test_cuisine->save();

            $cuisine_id = $test_cuisine->getId();
            $name = "fries";

            $test_restaurant = new Restaurant($name, $id, $cuisine_id);
            $test_restaurant->save();

            $new_name = "pizza";

            //Act
            $test_restaurant->update($new_name);

            //Assert
            $this->assertEquals("pizza", $test_restaurant->getName());
        }

        function testDeleteSingle()
        {
            //Arrange
            $type = "Polish";
            $id = null;
            $test_cuisine = new Cuisine($type, $id);
            $test_cuisine->save();

            $name = "Bratwurst Hut";
            $cuisine_id = $test_cuisine->getId();
            $test_restaurant = new Restaurant($name, $id, $cuisine_id);
            $test_restaurant->save();

            $name2 = "Sausage Hut";
            $test_restaurant2 = new Restaurant($name2, $id, $cuisine_id);
            $test_restaurant2->save();

            //Act
            $test_restaurant->deleteSingle();
            var_dump(Restaurant::getAll());

            //Assert
            $this->assertEquals([$test_restaurant2], Restaurant::getAll());
        }
    }

?>
