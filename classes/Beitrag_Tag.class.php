<?php
    class Beitrag_Tag
    {
        public $id;
        public $beitrag;
        public $tag;

        public function __construct($id, $beitrag, $tag)
        {
            $this->id = $id;
            $this->beitrag = $beitrag;
            $this->tag = $tag; 
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

        public function getBeitrag()
        {
                return $this->beitrag;
        }
        public function setBeitrag($beitrag)
        {
                $this->beitrag = $beitrag;
                return $this;
        }

        public function getTag()
        {
                return $this->tag;
        }
        public function setTag($tag)
        {
                $this->tag = $tag;
                return $this;
        }
    }
?>