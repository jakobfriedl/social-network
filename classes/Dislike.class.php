<?php
    class Dislike
    {
        public $id;
        public $user;
        public $beitrag; 

        public function __construct($id, $user, $beitrag)
        {
            $this->id = $id;
            $this->user = $user;
            $this->beitrag = $beitrag; 
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

        public function getUser()
        {
                return $this->user;
        }
        public function setUser($user)
        {
                $this->user = $user;
                return $this;
        }

        public function getBeitrag()
        {
                return $this->beitrag;
        }
        public function setBeitrag($beitrag)
        {
                $this->beitrag = $beitrag;
                return $this;
        }
    }
?>