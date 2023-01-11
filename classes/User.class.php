<?php
    class User
    {
        public $id; 
        public $anrede;
        public $vorname;
        public $nachname; 
        public $email; 
        public $username;
        public $passwort; 
        public $farbe; 

        public function __construct($id, $anrede, $vorname, $nachname, $email, $username, $passwort, $farbe)
        {
            $this->id = $id; 
            $this->anrede = $anrede;
            $this->vorname = $vorname;
            $this->nachname = $nachname;
            $this->email = $email;
            $this->username = $username;
            $this->passwort = $passwort;
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

        public function getAnrede()
        {
                return $this->anrede;
        }
        public function setAnrede($anrede)
        {
                $this->anrede = $anrede;
                return $this;
        }

        public function getVorname()
        {
                return $this->vorname;
        }
        public function setVorname($vorname)
        {
                $this->vorname = $vorname;
                return $this;
        }

        public function getNachname()
        {
                return $this->nachname;
        }
        public function setNachname($nachname)
        {
                $this->nachname = $nachname;
                return $this;
        }

        public function getEmail()
        {
                return $this->email;
        }
        public function setEmail($email)
        {
                $this->email = $email;
                return $this;
        }

        public function getUsername()
        {
                return $this->username;
        }
        public function setUsername($username)
        {
                $this->username = $username;
                return $this;
        }

        public function getPasswort()
        {
                return $this->passwort;
        }
        public function setPasswort($passwort)
        {
                $this->passwort = $passwort;
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