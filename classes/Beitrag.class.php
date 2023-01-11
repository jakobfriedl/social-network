<?php
    class Beitrag
    {
        public $id;
        public $titel;
        public $inhalt;
        public $timestamp;
        public $freigabestatus;
        public $pfad_original;
        public $pfad_thumbnail; 
        public $creator; 

        public $likes;
        public $dislikes;
        public $comments; 

        public function __construct($id, $titel, $inhalt, $timestamp, $freigabestatus, $pfad_original, $pfad_thumbnail, $creator)
        {
            $this->id = $id;
            $this->titel = $titel; 
            $this->inhalt = $inhalt; 
            $this->timestamp = $timestamp; 
            $this->freigabestatus = $freigabestatus; 
            $this->pfad_original = $pfad_original; 
            $this->pfad_thumbnail = $pfad_thumbnail; 
            $this->creator = $creator;
            //Count Likes, Dislikes, Comments
            $this->count(); 
        }

        //Zählen, der einzelnen Daten
        public function count()
        {
            $db = new DB(); 
            $this->likes = $db->countLikes($this->id);
            $this->dislikes = $db->countDislikes($this->id);
            $this->comments = $db->countComments($this->id); 
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

        public function getTitel()
        {
                return $this->titel;
        }
        public function setTitel($titel)
        {
                $this->titel = $titel;
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

        public function getFreigabestatus()
        {
                return $this->freigabestatus;
        }
        public function setFreigabestatus($freigabestatus)
        {
                $this->freigabestatus = $freigabestatus;
                return $this;
        }

        public function getPfad_original()
        {
                return $this->pfad_original;
        }
        public function setPfad_original($pfad_original)
        {
                $this->pfad_original = $pfad_original;
                return $this;
        }

        public function getPfad_thumbnail()
        {
                return $this->pfad_thumbnail;
        }
        public function setPfad_thumbnail($pfad_thumbnail)
        {
                $this->pfad_thumbnail = $pfad_thumbnail;
                return $this;
        }

        public function getCreator()
        {
                return $this->creator;
        }
        public function setCreator($creator)
        {
                $this->creator = $creator;
                return $this;
        }
    }
?>