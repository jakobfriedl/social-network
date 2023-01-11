<?php
    class Kommentar
    {
        public $id;
        public $inhalt;
        public $timestamp; 
        public $user;
        public $beitrag;

        public function __construct($id, $inhalt, $timestamp, $user, $beitrag)
        {
            $this->id = $id;
            $this->inhalt = $inhalt;
            $this->timestamp = $timestamp;
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

        public function getInhalt()
        {
                return $this->inhalt;
        }
        public function setInhalt($inhalt)
        {
                $this->inhalt = $inhalt;
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