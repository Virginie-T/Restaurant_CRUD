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
            Restaurant::deleteAll();
        }

        function test_getType()
        {
            //Arrange
            $type = "italian";
            $id = null;
            $test_cuisine = new Cuisine($type, $id);

            //Act
            $result = $test_cuisine->getType();

            //Assert
            $this->assertEquals($type, $result);
        }

        function test_getId()
        {
            //arrange
            $type = "American";
            $id = 1;
            $test_cuisine = new Cuisine($type, $id);

            //act
            $result = $test_cuisine->getId();

            //assert
            $this->assertEquals(1, $result);
        }

        function test_setId()
        {
            //Arrange
            $type = "british";
            $id = null;
            $test_cuisine = new Cuisine($type, $id);

            //Act
            $test_cuisine->setId(2);

            //Assert
            $result = $test_cuisine->getId();
            $this->assertEquals(2, $result);
        }

        function test_save()
        {
            //arrange
            $type = "Chinese";
            $id = null;
            $test_cuisine = new Cuisine($type, $id);
            $test_cuisine->save();

            //act
            $result = Cuisine::getAll();

            //assert
            $this->assertEquals($test_cuisine, $result[0]);
        }

        function test_getAll()
        {
            //Arrange
            $type = "Ethiopian";
            $id = null;
            $type2 = "Spanish";
            $id2 = null;
            $test_cuisine = new Cuisine($type, $id);
            $test_cuisine->save();
            $test_cuisine2 = new Cuisine($type2, $id2);
            $test_cuisine2->save();

            //Act
            $result = Cuisine::getAll();

            //Assert
            $this->assertEquals([$test_cuisine, $test_cuisine2], $result);
        }

        function test_deleteAll()
        {
            //arrange
            $type = 'Romanian';
            $id = null;
            $test_cuisine = new Cuisine($type, $id);
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
            $type = "Armenian";
            $id = null;
            $test_cuisine = new Cuisine($type, $id);
            $test_cuisine->save();

            $new_type = "Icelandic";

            //Act
            $test_cuisine->update($new_type);

            //Assert
            $this->assertEquals("Icelandic", $test_cuisine->getType());
        }

        // function testDeleteCuisineRestaurant()
        // {
        //     //arrange
        //     $type = "Arabic";
        //     $id = null;
        //     $test_cuisine = new Cuisine($type, $id);
        //     $test_cuisine->save();
        //
        //     //act
        //     $test_cuisine->delete();
        //
        //     //assert
        //     $this->assertEquals([], Restaurant::getAll());
        // }
    }

 ?>
