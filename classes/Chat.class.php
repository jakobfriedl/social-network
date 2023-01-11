<?php
    class Chat
    {
        public $id; 
        public $user1;
        public $user2; 

        public function __construct($id, $user1, $user2)
        {
            $this->id = $id; 
            $this->user1 = $user1;
            $this->user2 = $user2;
        }

        public function getId()
        {
                return $this->id;
        }
        public function setId($id)
        {
                $this->id = $id;
                return $this;
        }

        public function getUser1()
        {
                return $this->user1;
        }
        public function setUser1($user1)
        {
                $this->user1 = $user1;
                return $this;
        }

        public function getUser2()
        {
                return $this->user2;
        }
        public function setUser2($user2)
        {
                $this->user2 = $user2;
                return $this;
        }
    }
?>