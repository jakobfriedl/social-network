<?php
    //Other Class Includes
    require_once "./classes/User.class.php"; 
    require_once "./classes/Beitrag.class.php"; 
    require_once "./classes/Beitrag_Tag.class.php"; 
    require_once "./classes/Tag.class.php"; 
    require_once "./classes/Chat.class.php"; 
    require_once "./classes/Nachricht.class.php"; 
    require_once "./classes/Freundschaft.class.php"; 
    require_once "./classes/Like.class.php"; 
    require_once "./classes/Dislike.class.php"; 
    require_once "./classes/KOmmentar.class.php"; 

    //DB CLASS
    ///////////////////////////////////////////////////
    //Contains all SQL Queries for the project
    ///////////////////////////////////////////////////
    class DB
    {
        //Logindaten
        private $conn; 
        private $localhost = "localhost";
        private $un = "projekt2020";
        private $pw = "m0TIA5u7hYYxtEb7";
        private $dbname = "projekt2020"; 

        //DB-CONNECTION 
        private function connect()
        {
            $this->conn = new mysqli ($this->localhost, $this->un, $this->pw, $this->dbname); 
            if($this->conn->error)
                die($this->conn->error);
        }

        ////////////////////////////////////////////////////
        //USER FUNCTIONS
        //////////////////////////////////////////////////
        //Get UserObject (from Username)
        public function getUserFromName($username)
        {
            $this->connect(); 
            $stmt = $this->conn->prepare("SELECT * FROM user WHERE username=?");
            if(!$stmt)
                die($this->conn->error);
            $stmt->bind_param("s", $username);
            $stmt->execute(); 
            $stmt->bind_result($this->id, $this->anrede, $this->vorname, $this->nachname, $this->email, $this->username, $this->passwort, $this->farbe);
            $stmt->fetch(); 

            $user = new User($this->id, $this->anrede, $this->vorname, $this->nachname, $this->email, $this->username, $this->passwort, $this->farbe);
            return $user;

            $this->conn->close(); 
        }
        //Get UserObject (from ID)
        public function getUserFromID($id)
        {
            $this->connect(); 
            $stmt = $this->conn->prepare("SELECT * FROM user WHERE id=?");
            if(!$stmt)
                die($this->conn->error);
            $stmt->bind_param("i", $id);
            $stmt->execute(); 
            $stmt->bind_result($this->id, $this->anrede, $this->vorname, $this->nachname, $this->email, $this->username, $this->passwort, $this->farbe);
            $stmt->fetch(); 

            $user = new User($this->id, $this->anrede, $this->vorname, $this->nachname, $this->email, $this->username, $this->passwort, $this->farbe);
            return $user;

            $this->conn->close(); 
        }
        //Get Userlist
        public function getUserlist()
        {
            $this->connect();
            $userlist = array(); 
            //Admin soll nicht in der Liste angezeigt werden
            $stmt = $this->conn->prepare("SELECT * FROM user WHERE id > 0");
            if(!$stmt)
                die($this->conn->error);
            $stmt->execute();
            $stmt->bind_result($this->id, $this->anrede, $this->vorname, $this->nachname, $this->email, $this->username, $this->passwort, $this->farbe); 
            while($stmt->fetch())
            {
                $user = new User($this->id, $this->anrede, $this->vorname, $this->nachname, $this->email, $this->username, $this->passwort, $this->farbe); 
                array_push($userlist, $user);
            }
            return $userlist;

            $this->conn->close(); 
        }
        //Register User
        public function registerUser($userObject)
        {
            $this->connect(); 
            $stmt = $this->conn->prepare("INSERT INTO user (anrede, vorname, nachname, email, username, passwort) VALUES (?, ?, ?, ?, ?, ?)");
            if(!$stmt)
                die($this->conn->error);
            $stmt->bind_param("ssssss", $this->anrede, $this->vorname, $this->nachname, $this->email, $this->username, $this->passwort);

            $this->anrede = $userObject->getAnrede(); 
            $this->vorname = $userObject->getVorname(); 
            $this->nachname = $userObject->getNachname();
            $this->email = $userObject->getEmail();   
            $this->username = $userObject->getUsername(); 
            $this->passwort = $userObject->getPasswort(); 

            if($stmt->execute())
                return true; 
            
            $this->conn->close(); 
        }
        //Login User
        public function loginUser($username, $passwort)
        {
            $user = $this->getUserFromName($username);  
            //verify Password
            if(password_verify($passwort, $user->getPasswort()))
                return true; 
            else
                return false; 
        }
        //Update User
        public function updateUser($userObject)
        {
            $this->connect();
            $stmt = $this->conn->prepare("UPDATE user SET anrede=?, vorname=?, nachname=?, email=?, username=?, farbe =? WHERE id = ?");
            if(!$stmt)
                die($this->conn->error);
            $stmt->bind_param("ssssssi", $this->anrede, $this->vorname, $this->nachname, $this->email, $this->username, $this->farbe, $this->id);
            $this->anrede = $userObject->getAnrede();
            $this->vorname = $userObject->getVorname();
            $this->nachname = $userObject->getNachname();
            $this->email = $userObject->getEmail();
            $this->username = $userObject->getUsername();
            $this->farbe = $userObject->getFarbe(); 
            $this->id = $userObject->getId();

            if($stmt->execute())
                return true; 
            
            $this->conn->close(); 
        }
        //Update Password
        public function updatePassword($userObject, $newPw)
        {
            $this->connect();
            $stmt = $this->conn->prepare("UPDATE user SET passwort=? WHERE id=?");
            if(!$stmt)
                die($this->conn->error);
            $stmt->bind_param("si", $this->passwort, $this->id);
            
            $this->passwort = $newPw;
            $this->id = $userObject->getId(); 

            if($stmt->execute())
                return true; 
            
            $this->conn->close(); 
        }

        //////////////////////////////////////////////
        //FRIENDREQUEST FUNCTIONS
        /////////////////////////////////////////////
        //get Request 
        public function getRequest($sender, $receiver)
        {
            $this->connect();
            $stmt = $this->conn->prepare("SELECT * FROM freundschaft WHERE (user_id_fk_1 = ? AND user_id_fk_2 = ?) OR (user_id_fk_2 = ? AND user_id_fk_1 = ?)");
            if(!$stmt)
                die($this->conn->error);
            $stmt->bind_param("iiii", $sender, $receiver, $sender, $receiver);
            $stmt->execute();
            $stmt->bind_result($id, $timestamp, $status, $user1, $user2);
            $stmt->fetch(); 

            $request = new Freundschaft($id, $timestamp, $status, $user1, $user2); 
            return $request; 

            $this->conn->close(); 
        }
        //Search for Users
        public function searchUsers($search)
        {
            $this->connect(); 
            $userlist = array(); 
            $param = $search."%"; 
            $stmt = $this->conn->prepare("SELECT * FROM user WHERE (vorname LIKE ? OR nachname LIKE ? OR username LIKE ?) AND id > 0");
            if(!$stmt)
                die($this->conn->error);
            $stmt->bind_param("sss", $param, $param, $param); 
            $stmt->execute(); 
            $stmt->bind_result($this->id, $this->anrede, $this->vorname, $this->nachname, $this->email, $this->username, $this->passwort, $this->farbe); 
            while($stmt->fetch())
            {
                $user = new User($this->id, $this->anrede, $this->vorname, $this->nachname, $this->email, $this->username, $this->passwort, $this->farbe);
                array_push($userlist, $user);
            }
            return $userlist; 
            $this->conn->close();
        }
        //Send Friendrequest
        public function sendRequest($friendObject)
        {
            $this->connect(); 
            $stmt = $this->conn->prepare("INSERT INTO freundschaft(user_id_fk_1, user_id_fk_2, status) VALUES (?, ?, ?)");
            if(!$stmt)
                die($this->conn->error);
            $stmt->bind_param("iis", $this->user1, $this->user2, $this->status);
            
            $this->user1 = $friendObject->getUser1(); 
            $this->user2 = $friendObject->getUser2(); 
            $this->status = $friendObject->getStatus();

            if($stmt->execute())
                return true; 
            
            $this->conn->close(); 
        }
        //List Friendrequests
        public function listRequests($id)
        {
            $this->connect();
            $userlist = array(); 
            $status = "requested"; 
            $stmt = $this->conn->prepare("SELECT user.* from user join freundschaft on (user.id=freundschaft.user_id_fk_1) WHERE (freundschaft.user_id_fk_2 = ?) && status=?");
            if(!$stmt)
                die($this->conn->error);
            $stmt->bind_param("is", $id, $status);
            $stmt->execute(); 
            $stmt->bind_result($this->id, $this->anrede, $this->vorname, $this->nachname, $this->email, $this->username, $this->passwort, $this->farbe); 
            while($stmt->fetch())
            {
                $user = new User($this->id, $this->anrede, $this->vorname, $this->nachname, $this->email, $this->username, $this->passwort, $this->farbe);
                array_push($userlist, $user);
            }
            return $userlist; 

            $this->conn->close(); 
        }
        //get Number of Friendrequests
        public function nrRequests($id)
        {
            $this->connect();
            $status = "requested"; 
            $stmt = $this->conn->prepare("SELECT count(*) from freundschaft where user_id_fk_2=? and status = ?");
            if(!$stmt)
                die($this->conn->error); 
            $stmt->bind_param("is", $id, $status);
            $stmt->execute(); 
            $stmt->bind_result($nrRequests);
            $stmt->fetch(); 
            return $nrRequests; 

            $this->conn->close(); 
        }
        //Accept FriendRequest
        public function acceptRequest($id)
        {
            $this->connect(); 
            $stmt = $this->conn->prepare("UPDATE freundschaft SET status=?, timestamp=? WHERE id = ?"); 
            if(!$stmt)
                die($this->conn->error);
            $stmt->bind_param("ssi", $this->status, $this->timestamp, $id);

            $this->status = "accepted"; 
            $this->timestamp = date("d.m.Y - H:i:s");

            if($stmt->execute())
                return true;
            
            $this->conn->close(); 
        }
        //Deny FriendRequest 
        //Also used to unfriend someone!
        public function denyRequest($id) 
        {
            $this->connect();
            $stmt = $this->conn->prepare("DELETE FROM freundschaft WHERE id=?");
            if(!$stmt)
                die($this->conn->error);
            $stmt->bind_param("i", $id);
            if($stmt->execute())
                return true; 
            
            $this->conn->close(); 
        }

        /////////////////////////////////////////////////////
        //FRIEND FUNCTIONS
        ////////////////////////////////////////////////////
        //Get Friendlist
        public function listFriends($userObject)
        {
            $this->connect();
            $userlist = array(); 
            $status = "accepted"; 
            $stmt = $this->conn->prepare("SELECT user.* FROM user JOIN freundschaft ON (user.id=freundschaft.user_id_fk_2 OR user.id=freundschaft.user_id_fk_1) WHERE (freundschaft.user_id_fk_1 = ? OR freundschaft.user_id_fk_2=?) && status=?");
            if(!$stmt)
                die($this->conn->error);
            $stmt->bind_param("iis", $this->id, $this->id, $status);
            $stmt->execute(); 
            $stmt->bind_result($this->id, $this->anrede, $this->vorname, $this->nachname, $this->email, $this->username, $this->passwort, $this->farbe); 
            while($stmt->fetch())
            {
                $user = new User($this->id, $this->anrede, $this->vorname, $this->nachname, $this->email, $this->username, $this->passwort, $this->farbe);
                array_push($userlist, $user);
            }
            return $userlist; 

            $this->conn->close(); 
        }
        //Get Friendship
        public function getFriendship($sender, $receiver)
        {
            $this->connect();
            $accepted = "accepted"; 
            $stmt = $this->conn->prepare("SELECT * FROM freundschaft WHERE ((user_id_fk_1 = ? AND user_id_fk_2 = ?) OR (user_id_fk_2 = ? AND user_id_fk_1 = ?)) AND status=?");
            if(!$stmt)
                die($this->conn->error);
            $stmt->bind_param("iiiis", $sender, $receiver, $sender, $receiver, $accepted);
            $stmt->execute();
            $stmt->bind_result($id, $timestamp, $status, $user1, $user2);
            $stmt->fetch(); 

            $friendship = new Freundschaft($id, $timestamp, $status, $user1, $user2); 
            return $friendship; 

            $this->conn->close(); 
        } 

        ///////////////////////////////////////////
        //BEITRAGS FUNCTIONS
        ///////////////////////////////////////////
        //Create new Post
        public function createPost($postObject)
        {
            $this->connect();
            $stmt = $this->conn->prepare("INSERT INTO beitrag(titel, inhalt, timestamp, freigabestatus, pfad_original, pfad_thumbnail, user_id_fk) VALUES (?, ?, ?, ?, ?, ?, ?)");
            if(!$stmt)
                die($this->conn->error);
            $stmt->bind_param("ssssssi", $this->titel, $this->inhalt, $this->timestamp, $this->freigabestatus, $this->pfad_original, $this->pfad_thumbnail, $this->creator);
            
            $this->titel = $postObject->getTitel();
            $this->inhalt = $postObject->getInhalt();
            $this->timestamp = $postObject->getTimestamp();
            $this->freigabestatus = $postObject->getFreigabestatus();
            $this->pfad_original = $postObject->getPfad_original();
            $this->pfad_thumbnail = $postObject->getPfad_thumbnail();
            $this->creator = $postObject->getCreator();

            if($stmt->execute())
                return true; 
            else
                return $this->conn->error; 
            
            $this->conn->close(); 
        }
        //Get Postlist
        public function getPostlist()
        {
            $this->connect();
            $postlist = array(); 
            $stmt = $this->conn->prepare("SELECT * FROM beitrag ORDER BY timestamp desc");
            if(!$stmt)
                die($this->conn->error);
            $stmt->execute();
            $stmt->bind_result($this->id, $this->titel, $this->inhalt, $this->timestamp, $this->freigabestatus, $this->pfad_original, $this->pfad_thumbnail, $this->creator);
            while($stmt->fetch())
            {
                $post = new Beitrag($this->id, $this->titel, $this->inhalt, $this->timestamp, $this->freigabestatus, $this->pfad_original, $this->pfad_thumbnail, $this->creator);
                array_push($postlist, $post);
            }
            return $postlist;

            $this->conn->close(); 
        }
        //Delete Post
        public function deletePost($id)
        {
            $this->connect(); 
            $stmt = $this->conn->prepare("DELETE FROM beitrag WHERE id=?");
            if(!$stmt)
                die($this->conn->error);
            $stmt->bind_param("i", $id); 
            if($stmt->execute())
                return true; 
            
            $this->conn->close(); 
        }
        //Change Access to Post (Freigabestatus)
        public function changeAccess($id, $newStatus)
        {
            $this->connect(); 
            $stmt = $this->conn->prepare("UPDATE beitrag SET freigabestatus = ? WHERE id = ?");
            if(!$stmt)
                die($this->conn->error);
            $stmt->bind_param("si", $newStatus, $id); 
            if($stmt->execute())
                return true;

            $this->conn->close(); 
        }
        //Get Post from PostID
        public function getPost($id)
        {
            $this->connect();
            $stmt = $this->conn->prepare("SELECT * FROM beitrag WHERE id=?");
            if(!$stmt)
                die($this->conn->error);
            $stmt->bind_param("i", $id);
            $stmt->execute(); 
            $stmt->bind_result($this->id, $this->titel, $this->inhalt, $this->timestamp, $this->freigabestatus, $this->pfad_original, $this->pfad_thumbnail, $this->creator);
            $stmt->fetch();
            
            $post = new Beitrag($this->id, $this->titel, $this->inhalt, $this->timestamp, $this->freigabestatus, $this->pfad_original, $this->pfad_thumbnail, $this->creator);
            return $post; 

            $this->conn->close(); 
        }
        //Count Likes
        public function countLikes($id)
        {
            $this->connect();
            $stmt = $this->conn->prepare("SELECT count(*) FROM likes WHERE beitrag_id_fk=?");
            if(!$stmt)
                die($this->conn->error);
            $stmt->bind_param("i", $id);
            $stmt->execute(); 
            $stmt->bind_result($likeCount);
            $stmt->fetch(); 

            return $likeCount;

            $this->conn->close(); 
        }
        //Count Dislikes
        public function countDislikes($id)
        {
            $this->connect();
            $stmt = $this->conn->prepare("SELECT count(*) FROM dislikes WHERE beitrag_id_fk=?");
            if(!$stmt)
                die($this->conn->error);
            $stmt->bind_param("i", $id);
            $stmt->execute(); 
            $stmt->bind_result($dislikeCount);
            $stmt->fetch(); 

            return $dislikeCount;

            $this->conn->close(); 
        }
        //Count Comments
        public function countComments($id)
        {
            $this->connect();
            $stmt = $this->conn->prepare("SELECT count(*) FROM kommentar WHERE beitrag_id_fk=?");
            if(!$stmt)
                die($this->conn->error);
            $stmt->bind_param("i", $id);
            $stmt->execute(); 
            $stmt->bind_result($commentCount);
            $stmt->fetch(); 

            return $commentCount;

            $this->conn->close(); 
        }
        //Search in POSTS
        public function searchForPosts($search)
        {
            $this->connect(); 
            $searchTerm = "%".$search."%"; 
            $postlist=array(); 
            $stmt = $this->conn->prepare("SELECT * FROM beitrag WHERE titel LIKE ? OR inhalt LIKE ? OR pfad_original LIKE ? ORDER BY timestamp desc");
            if(!$stmt)
                die($this->conn->error);
            $stmt->bind_param("sss", $searchTerm, $searchTerm, $searchTerm); 
            $stmt->execute(); 
            $stmt->bind_result($this->id, $this->titel, $this->inhalt, $this->timestamp, $this->freigabestatus, $this->pfad_original, $this->pfad_thumbnail, $this->user);
            while($stmt->fetch())
            {
                $post = new Beitrag($this->id, $this->titel, $this->inhalt, $this->timestamp, $this->freigabestatus, $this->pfad_original, $this->pfad_thumbnail, $this->user);
                array_push($postlist, $post);
            }
            return $postlist;
        
            $this->conn->close(); 
        }
        //Get Latest POST
        public function getLatestPost()
        {
            $this->connect();
            $stmt = $this->conn->prepare("SELECT id FROM beitrag ORDER BY timestamp desc LIMIT 1");
            if(!$stmt)
                die($this->conn->error);
            $stmt->execute(); 
            $stmt->bind_result($id); 
            $stmt->fetch();
            return $id; 
            $this->conn->close();  
        }
        
        ///////////////////////////////////////////////////////
        //LIKE AND DISLIKE FUNCTIONS
        /////////////////////////////////////////////////////////
        //Check if Like exists
        public function checkForLike($user, $beitrag)
        {
            $this->connect();
            $stmt = $this->conn->prepare("SELECT id FROM likes WHERE (user_id_fk=? AND beitrag_id_fk=?)");
            if(!$stmt)
                die($this->conn->error);
            $stmt->bind_param("ii", $user, $beitrag);
            $stmt->execute();
            $stmt->bind_result($id);
            $stmt->fetch(); 

            return $id; 

            $this->conn->close(); 
        }
        //Add new Like
        public function likePost($likeObject)
        {
            $this->connect();
            $stmt = $this->conn->prepare("INSERT INTO likes(id, user_id_fk, beitrag_id_fk) VALUES (?,?,?)");
            if(!$stmt)
                die($this->conn->error);
            $stmt->bind_param("iii", $this->id, $this->user, $this->beitrag);

            $this->id = $likeObject->getId();
            $this->user = $likeObject->getUser(); 
            $this->beitrag = $likeObject->getBeitrag(); 

            if($stmt->execute())
                return true;

            $this->conn->close(); 
        }
        //Remove Like
        public function removeLike($id)
        {
            $this->connect();
            $stmt = $this->conn->prepare("DELETE FROM likes WHERE id=?");
            if(!$stmt)
                die($this->conn->error);
            $stmt->bind_param("i", $id); 
            if($stmt->execute())
                return true; 
            
            $this->conn->close(); 
        }
        //Delete All Likes from one Post
        public function deleteLikes($beitrag)
        {
            $this->connect();
            $stmt = $this->conn->prepare("DELETE FROM likes WHERE beitrag_id_fk=?");
            if(!$stmt)
                die($this->conn->error);
            $stmt->bind_param("i", $beitrag); 
            if($stmt->execute())
                return true; 
            
            $this->conn->close(); 
        }
        //Check if Dislike exists
        public function checkForDislike($user, $beitrag)
        {
            $this->connect();
            $stmt = $this->conn->prepare("SELECT id FROM dislikes WHERE (user_id_fk=? AND beitrag_id_fk=?)");
            if(!$stmt)
                die($this->conn->error);
            $stmt->bind_param("ii", $user, $beitrag);
            $stmt->execute();
            $stmt->bind_result($id);
            $stmt->fetch(); 

            return $id; 

            $this->conn->close(); 
        }
        //Add new Dislike
        public function dislikePost($dislikeObject)
        {
            $this->connect();
            $stmt = $this->conn->prepare("INSERT INTO dislikes(id, user_id_fk, beitrag_id_fk) VALUES (?,?,?)");
            if(!$stmt)
                die($this->conn->error);
            $stmt->bind_param("iii", $this->id, $this->user, $this->beitrag);

            $this->id = $dislikeObject->getId();
            $this->user = $dislikeObject->getUser(); 
            $this->beitrag = $dislikeObject->getBeitrag(); 

            if($stmt->execute())
                return true;

            $this->conn->close(); 
        }
        //Remove Dislike
        public function removeDislike($id)
        {
            $this->connect();
            $stmt = $this->conn->prepare("DELETE FROM dislikes WHERE id=?");
            if(!$stmt)
                die($this->conn->error);
            $stmt->bind_param("i", $id); 
            if($stmt->execute())
                return true; 
            
            $this->conn->close(); 
        }
        //Delete All Dislikes from one Post
        public function deleteDislikes($beitrag)
        {
            $this->connect();
            $stmt = $this->conn->prepare("DELETE FROM dislikes WHERE beitrag_id_fk=?");
            if(!$stmt)
                die($this->conn->error);
            $stmt->bind_param("i", $beitrag); 
            if($stmt->execute())
                return true; 
            
            $this->conn->close(); 
        }

        //////////////////////////////////////////////////////////
        //COMMENT FUNCTIONS
        /////////////////////////////////////////////////////////
        //add comment
        public function addComment($commentObject)
        {
            $this->connect();
            $stmt = $this->conn->prepare("INSERT INTO kommentar(inhalt, timestamp, user_id_fk, beitrag_id_fk) VALUES (?, ?, ?, ?)");
            if(!$stmt)
                die($this->conn->error);
            $stmt->bind_param("ssii", $this->inhalt, $this->timestamp, $this->user, $this->beitrag);

            $this->inhalt = $commentObject->getInhalt();
            $this->timestamp = $commentObject->getTimestamp();
            $this->user = $commentObject->getUser();
            $this->beitrag = $commentObject->getBeitrag(); 

            if($stmt->execute())
                return true;

            $this->conn->close(); 
        }
        //Get All comments of a post
        public function getComments($beitrag)
        {
            $this->connect(); 
            $commentlist = array(); 
            $stmt = $this->conn->prepare("SELECT * FROM kommentar WHERE beitrag_id_fk = ? ORDER BY timestamp desc");
            if(!$stmt)
                die($this->conn->error);
            $stmt->bind_param("i", $beitrag); 
            $stmt->execute();
            $stmt->bind_result($this->id, $this->inhalt, $this->timestamp, $this->user, $this->beitrag); 
            while($stmt->fetch())
            {
                $comment = new Kommentar($this->id, $this->inhalt, $this->timestamp, $this->user, $this->beitrag); 
                array_push($commentlist, $comment); 
            }
            return $commentlist;

            $this->conn->close(); 
        }
        //delete all comments from post
        public function deleteComments($beitrag)
        {
            $this->connect();
            $stmt = $this->conn->prepare("DELETE FROM kommentar WHERE beitrag_id_fk = ?");
            if(!$stmt)
                die($this->conn->error);
            $stmt->bind_param("i", $beitrag); 
            if($stmt->execute())
                return true; 
            
            $this->conn->close(); 
        }

        ////////////////////////////////////////////////////////////////
        //TAG FUNCTIONS
        /////////////////////////////////////////////////////////
        //Add new Tag
        public function addTag($tagObject)
        {
            $this->connect();
            $stmt = $this->conn->prepare("INSERT INTO tag(bezeichnung, farbe) VALUES (?, ?)");
            if(!$stmt)
                die($this->conn->error);
            $stmt->bind_param("ss", $this->bezeichnung, $this->farbe); 
            $this->bezeichnung = $tagObject->getBezeichnung(); 
            $this->farbe = $tagObject->getFarbe(); 

            if($stmt->execute())
                return true; 
            
            $this->conn->close(); 
        }
        //Get TagID
        public function getTag($bezeichnung)
        {
            $this->connect();
            $stmt = $this->conn->prepare("SELECT id FROM tag WHERE bezeichnung=?"); 
            if(!$stmt)
                die($this->conn->error);
            $stmt->bind_param("s", $bezeichnung); 
            $stmt->execute(); 
            $stmt->bind_result($id);
            $stmt->fetch();
            return $id; 

            $this->conn->close(); 
        }
        //Get Tag Bezeichnung
        public function getTagName($id)
        {
            $this->connect();
            $stmt = $this->conn->prepare("SELECT * FROM tag WHERE id=?"); 
            if(!$stmt)
                die($this->conn->error);
            $stmt->bind_param("i", $id); 
            $stmt->execute(); 
            $stmt->bind_result($id, $bezeichnung, $farbe);
            $stmt->fetch();
            $returnTag = new Tag($id, $bezeichnung, $farbe); 
            return $returnTag; 

            $this->conn->close(); 
        }
        //Add Tag to Post
        public function tagPost($tagPostObject)
        {
            $this->connect(); 
            $stmt = $this->conn->prepare("INSERT INTO beitrag_tag(beitrag_id_fk, tag_id_fk) VALUES (?,?)");
            if(!$stmt)
                die($this->conn->error); 
            $stmt->bind_param("ii", $this->beitrag, $this->tag); 

            $this->beitrag = $tagPostObject->getBeitrag(); 
            $this->tag = $tagPostObject->getTag(); 

            if($stmt->execute())
                return true; 

            $this->conn->close(); 
        }
        //Get all Tags of Post
        public function getAllTags($post)
        {
            $this->connect();
            $taglist = array(); 
            $stmt = $this->conn->prepare("SELECT * FROM beitrag_tag WHERE beitrag_id_fk = ?");
            if(!$stmt)
                die($this->conn->error); 
            $stmt->bind_param("i", $post); 
            $stmt->execute(); 
            $stmt->bind_result($this->id, $this->beitrag_id_fk, $this->tag_id_fk);
            while($stmt->fetch())
            {
                $tag = new Beitrag_Tag($this->id, $this->beitrag_id_fk, $this->tag_id_fk);
                array_push($taglist, $tag); 
            }
            return $taglist;

            $this->conn-close(); 
        }
        //Delete All Tags from post
        public function deleteTags($post)
        {
            $this->connect();
            $stmt = $this->conn->prepare("DELETE FROM beitrag_tag WHERE beitrag_id_fk = ?");
            if(!$stmt)
                die($this->conn->error);
            $stmt->bind_param("i", $post);
            if($stmt->execute())
                return true; 
            
            $this->conn->close(); 
        }
        //get Taglist
        public function getTaglist()
        {
            $this->connect();
            $tags = array(); 
            $stmt = $this->conn->prepare("SELECT DISTINCT tag.* FROM tag join beitrag_tag on tag.id = beitrag_tag.tag_id_fk");
            if(!$stmt)
                die($this->conn->error);
            $stmt->execute();
            $stmt->bind_result($this->id, $this->bezeichnung, $this->farbe);
            while($stmt->fetch())
            {
                $tag = new Tag($this->id, $this->bezeichnung, $this->farbe); 
                array_push($tags, $tag); 
            }
            return $tags;

            $this->conn->close(); 
        }
        //Select All Posts with a specific Tag
        public function filterTags($tag)
        {
            $this->connect();
            $postlist = array(); 
            $stmt = $this->conn->prepare("SELECT beitrag.* FROM beitrag JOIN beitrag_tag on (beitrag.id=beitrag_tag.beitrag_id_fk) WHERE (beitrag_tag.tag_id_fk = ?) ORDER BY timestamp desc");
            if(!$stmt)
                die($this->conn->error);
            $stmt->bind_param("i", $tag);
            $stmt->execute(); 
            $stmt->bind_result($this->id, $this->titel, $this->inhalt, $this->timestamp, $this->freigabestatus, $this->pfad_original, $this->pfad_thumbnail, $this->creator);
            while($stmt->fetch())
            {
                $post = new Beitrag($this->id, $this->titel, $this->inhalt, $this->timestamp, $this->freigabestatus, $this->pfad_original, $this->pfad_thumbnail, $this->creator);
                array_push($postlist, $post);
            }
            return $postlist;
            $this->conn->close(); 
        }

        //////////////////////////////////////////////////
        //CHAT FUNCTIONS
        //////////////////////////////////////////////////
        //Start a new Chat
        public function startChat($chatObject)
        {
            $this->connect();
            $stmt = $this->conn->prepare("INSERT INTO chat(user_id_fk_1, user_id_fk_2) VALUES (?,?)");
            if(!$stmt)
                die($this->conn->error);
            $stmt->bind_param("ii", $this->user1, $this->user2);
            $this->user1 = $chatObject->getUser1();
            $this->user2 = $chatObject->getUser2(); 
            if($stmt->execute())
                return true;

            $this->conn->close(); 
        }
        //Check if Chat exists // Get Chat Object
        public function getChat($user1, $user2)
        {
            $this->connect();
            $stmt = $this->conn->prepare("SELECT * FROM chat WHERE (user_id_fk_1 = ? OR user_id_fk_1 = ?) AND (user_id_fk_2 = ? OR user_id_fk_2 = ?)");
            if(!$stmt)
                die($this->conn->error);
            $stmt->bind_param("iiii", $user1, $user2, $user1, $user2); 
            $stmt->execute(); 
            $stmt->bind_result($id, $user1, $user2); 
            $stmt->fetch(); 

            $chatObject = new Chat($id, $user1, $user2); 
            return $chatObject;

            $this->conn->close(); 
        }
        //Delete Chat of two Users
        public function deleteChat($chatID)
        {
            $this->connect(); 
            $stmt = $this->conn->prepare("DELETE FROM chat WHERE id = ?");
            if(!$stmt)
                die($this->conn->error);
            $stmt->bind_param("i", $chatID); 
            if($stmt->execute())
                return true; 
            
            $this->conn->close(); 
        }

        /////////////////////////////////////////////////////////////////
        //MESSAGE FUNCTIONS
        /////////////////////////////////////////////////////////////////
        //Create new Message
        public function newMessage($messageObject)
        {
            $this->connect();
            $stmt = $this->conn->prepare("INSERT INTO nachricht(nachricht, timestamp, status, user_id_fk, chat_id_fk) VALUES (?, ?, ?, ?, ?)"); 
            if(!$stmt)
                die($this->conn->error);
            $stmt->bind_param("sssii", $this->nachricht, $this->timestamp, $this->status, $this->user, $this->chat);
            
            $this->nachricht = $messageObject->getNachricht();
            $this->timestamp = $messageObject->GetTimestamp();
            $this->status = $messageObject->getStatus();
            $this->user = $messageObject->getVerfasser(); 
            $this->chat = $messageObject->getChat();
            
            if($stmt->execute())
                return true; 
            
            $this->conn->close(); 
        }
        //Get Messages From Chat
        public function getMessages($chatID)
        {
            $this->connect();
            $messagelist = array(); 
            $stmt = $this->conn->prepare("SELECT * FROM nachricht WHERE chat_id_fk = ?"); 
            if(!$stmt)
                die($this->conn->error); 
            $stmt->bind_param("i", $chatID); 
            $stmt->execute();
            $stmt->bind_result($this->id, $this->nachricht, $this->timestamp, $this->status, $this->user, $this->chat);
            while($stmt->fetch())
            {
                $message = new Nachricht($this->id, $this->nachricht, $this->timestamp, $this->status, $this->user, $this->chat);
                array_push($messagelist, $message); 
            }
            return $messagelist; 

            $this->conn->close(); 
        }
        //Get latest Message
        public function getLatestMessage($chatID)
        {
            $this->connect();
            $stmt = $this->conn->prepare("SELECT * FROM nachricht WHERE chat_id_fk = ? ORDER BY timestamp desc LIMIT 1");
            if(!$stmt)
                die($this->conn->error);
            $stmt->bind_param("i", $chatID); 
            $stmt->execute();
            $stmt->bind_result($this->id, $this->nachricht, $this->timestamp, $this->status, $this->user, $this->chat);
            $stmt->fetch(); 
            $message = new Nachricht($this->id, $this->nachricht, $this->timestamp, $this->status, $this->user, $this->chat);
            return $message; 

            $this->conn->close(); 
        }
        //Count New Messages of a User
        public function countMessages($userID)
        {
            $this->connect(); 
            $status = "sent"; 
            $stmt = $this->conn->prepare("SELECT count(*) FROM nachricht JOIN chat on (chat.id=nachricht.chat_id_fk) WHERE nachricht.user_id_fk <> ? AND (chat.user_id_fk_1 = ? OR chat.user_id_fk_2=?) AND nachricht.status = ?"); 
            if(!$stmt)
                die($this->conn->error); 
            $stmt->bind_param("iiis", $userID, $userID, $userID, $status); 
            $stmt->execute(); 
            $stmt->bind_result($count); 
            $stmt->fetch(); 
            return $count; 

            $this->conn->close(); 
        }
        //Update Status of Messages, sent --> read
        public function readMessage($messageObject)
        {
            $this->connect();
            $changeTo = "read"; 
            $stmt = $this->conn->prepare("UPDATE nachricht SET status=? WHERE id = ?");
            if(!$stmt)
                die($this->conn->error);
            $stmt->bind_param("si", $changeTo, $messageObject->id); 
            if($stmt->execute())
                return true; 

            $this->conn->close(); 
        }
        //Delete Messages of a Chat
        public function deleteMessages($chatID)
        {
            $this->connect();
            $stmt = $this->conn->prepare("DELETE FROM nachricht WHERE chat_id_fk = ?");
            if(!$stmt)
                die($this->conn->error);
            $stmt->bind_param("i", $chatID);
            if($stmt->execute())
                return true;

            $this->conn->close(); 
        }
    }
?>