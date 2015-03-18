<?php

    /**
    * @backupGlobals disabled
    * @backupStaticAttributes disabled
    */

    require_once "src/Cuisine.php";

    $DB = new PDO ('pgsql:host=localhost;dbname=food_test');

    class CuisineTest extends PHPUnit_Framework_TestCase
    {
        protected function tearDown()
        {
            Cuisine::deleteAll();
        }

        function test_getName()
        {
            //Arrange
            $name = "italian";
            $id = null;
            $test_cuisine = new Cuisine($name, $id);

            //Act
            $result = $test_cuisine->getName();

            //Assert
            $this->assertEquals($name, $result);
        }

        function test_getId()
        {
            //arrange
            $name = "American";
            $id = 1;
            $test_cuisine = new Cuisine($name, $id);

            //act
            $result = $test_cuisine->getId();

            //assert
            $this->assertEquals(1, $result);
        }

        function test_setId()
        {
            //Arrange
            $name = "british";
            $id = null;
            $test_cuisine = new Cuisine($name, $id);

            //Act
            $test_cuisine->setId(2);

            //Assert
            $result = $test_cuisine->getId();
            $this->assertEquals(2, $result);
        }

        function test_save()
        {
            //arrange
            $name = "Chinese";
            $id = null;
            $test_cuisine = new Cuisine($name, $id);
            $test_cuisine->save();

            //act
            $result = Cuisine::getAll();

            //assert
            $this->assertEquals($test_cuisine, $result[0]);
        }

        function test_getAll()
        {
            //Arrange
            $name = "Ethiopian";
            $id = null;
            $name2 = "Spanish";
            $id2 = null;
            $test_cuisine = new Cuisine($name, $id);
            $test_cuisine->save();
            $test_cuisine2 = new Cuisine($name2, $id2);
            $test_cuisine2->save();

            //Act
            $result = Cuisine::getAll();

            //Assert
            $this->assertEquals([$test_cuisine, $test_cuisine2], $result);
        }

        function test_deleteAll()
        {
            //arrange
            $name = 'Romanian';
            $id = null;
            $test_cuisine = new Cuisine($name, $id);
            $test_cuisine->save();

            //act
            Cuisine::deleteAll();
            $result = Cuisine::getAll();

            //assert
            $this->assertEquals([], $result);

        }

        function testUpdate()
        {
            //Arrange
            $name = "Armenian";
            $id = null;
            $test_cuisine = new Cuisine($name, $id);
            $test_cuisine->save();

            $new_name = "Icelandic";

            //Act
            $test_cuisine->update($new_name);

            //Assert
            $this->assertEquals("Icelandic", $test_cuisine->getName());
        }
    }

 ?>
