<?php
    class Tag
    {
        public $id;
        public $bezeichnung; 
        public $farbe; 

        public function __construct($id, $bezeichnung, $farbe)
        {
            $this->id = $id;
            $this->bezeichnung = $bezeichnung;
            $this->farbe = $farbe;
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

        public function getBezeichnung()
        {
                return $this->bezeichnung;
        }
        public function setBezeichnung($bezeichnung)
        {
                $this->bezeichnung = $bezeichnung;
                return $this;
        }

        public function getFarbe()
        {
                return $this->farbe;
        }
        public function setFarbe($farbe)
        {
                $this->farbe = $farbe;
                return $this;
        }
    }

?>