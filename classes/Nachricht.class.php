<?php
    class Nachricht
    {
        public $id;
        public $nachricht;
        public $timestamp; 
        public $status;
        public $verfasser;
        public $chat; 

        public function __construct($id, $nachricht, $timestamp, $status, $verfasser, $chat)
        {
            $this->id = $id;
            $this->nachricht = $nachricht; 
            $this->timestamp = $timestamp;
            $this->status = $status;
            $this->verfasser = $verfasser; 
            $this->chat = $chat; 
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

        public function getNachricht()
        {
                return $this->nachricht;
        }
        public function setNachricht($nachricht)
        {
                $this->nachricht = $nachricht;
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

        public function getStatus()
        {
                return $this->status;
        }
        public function setStatus($status)
        {
                $this->status = $status;
                return $this;
        }

        public function getVerfasser()
        {
                return $this->verfasser;
        }
        public function setVerfasser($verfasser)
        {
                $this->verfasser = $verfasser;
                return $this;
        }

        public function getChat()
        {
                return $this->chat;
        }
        public function setChat($chat)
        {
                $this->chat = $chat;
                return $this;
        }
    }
?>