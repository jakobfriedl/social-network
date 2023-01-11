<?php
    class Freundschaft
    {
        public $id;
        public $user1; 
        public $user2;
        public $status;
        public $timestamp; 
    
        public function __construct($id, $timestamp, $status, $user1, $user2, )
        {
            $this->id = $id;
            $this->user1 = $user1;
            $this->user2 = $user2; 
            $this->status = $status; 
            $this->timestamp = $timestamp; 
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

        public function getStatus()
        {
                return $this->status;
        }
        public function setStatus($status)
        {
                $this->status = $status;
                return $this;
        }

        public function getTimestamp()
        {
                return $this->timestamp;
        }
        public function setTimestamp($timestamp)
        {
                $this->timestamp = $timestamp;
                return $this;
        }
    }
?>