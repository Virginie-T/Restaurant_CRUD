<?php
    class Review
    {
        private $id;
        private $entry;
        private $rest_id;

        function __construct($id, $entry, $rest_id)
        {
            $this->id = $id;
            $this->entry = $entry;
            $this->rest_id = $rest_id;
        }

        function getEntry()
        {
            return $this->entry;
        }

        function setEntry($new_entry)
        {
            return $this->entry = (string) $new_entry;
        }

        function getId()
        {
            return $this->id;
        }

        function setId($new_id)
        {
            return $this->id = (int) $new_id;
        }

        function getRestId()
        {
            return $this->rest_id;
        }

        function setRestId($new_rest_id)
        {
            $this->rest_id = (int) $new_rest_id;
        }

        function save()
        {
            $statement = $GLOBALS['DB']->query("INSERT INTO reviews (id, entry, rest_id) VALUES ({$this->getId()}, '{$this->getEntry()}', {$this->getRestId()}) RETURNING id;");
            $result = $statement->fetch(PDO::FETCH_ASSOC);
            $this->setId($result['id']);
        }

        static function getAll()
        {
            $returned_reviews = $GLOBALS['DB']->query("SELECT * FROM reviews;");
            $reviews = array();
            foreach($returned_reviews as $review) {
                $entry = $review['entry'];
                $id = $review['id'];
                $rest_id = $review['rest_id'];
                $new_review = new Review($id, $entry, $rest_id);
                array_push($reviews, $new_review);
            }
            return $reviews;
        }
    }

 ?>
