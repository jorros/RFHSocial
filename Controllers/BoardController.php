<?php
class BoardController extends BaseController
{
	function Index($user = 0)
	{
		if($user > 0)
			$this->viewBag["user"] = $this->sqlConnector->getUser($user);
		else
			$this->viewBag["user"] = $this->user;
			
		if($user > 0 && in_array($user, $this->user->acceptedFriends))
			return $this->View("Board", array("pins" => $this->sqlConnector->getPinsFeed($this->sqlConnector->getUser($user), true), "friends" => $this->sqlConnector->getFriends($this->sqlConnector->getUser($user))));
		else if($user == 0 || $user == $this->user->id)
			return $this->View("Board", array("pins" => $this->sqlConnector->getPinsFeed($this->user, true), "friends" => $this->sqlConnector->getFriends($this->user)));
		else
			return $this->View("Board", array("friends" => $this->sqlConnector->getFriends($this->sqlConnector->getUser($user))));
	}
	
	function Edit()
	{
		$this->viewBag["user"] = $this->user;
			
		return $this->View("BoardEdit", array("pins" => $this->sqlConnector->getPinsFeed($this->user, true), "friends" => $this->sqlConnector->getFriends($this->user)));
	}
	
	function Save($gender, $firstname, $lastname, $location, $birthdate, $course, $type, $expectedGraduation, $favouriteBooks, $employer, $password, $password2)
	{
		if($statement = $this->mySQL->prepare("UPDATE user SET firstname = ?, lastname = ?, location = ?, gender = ?, birthdate = ?, course = ?, type = ?, expectedGraduation = ?, favouriteBooks = ?, employer = ? WHERE id = ?"))
		{
			$statement->bind_param("sssissiissi", $firstname, $lastname, $location, $gender, date("Y-m-d", strtotime($birthdate)), $course, $type, $expectedGraduation, $favouriteBooks, $employer, $this->user->id);
			$statement->execute();
		}
		
		if($password == $password2 && $password != "")
			$this->mySQL->query("UPDATE user SET password = '" . md5($password) . "' WHERE id = " . $this->user->id);
		
		$this->RedirectToAction("Board");
	}
	
	function SavePicture()
	{
		if(strpos($_FILES["picture"]["type"], "image") !== false)
		{
			echo "Test";
			// Konvertiere zu PNG und speicher ab
			if(file_exists("Resources/ProfilePics/" . $this->user->id . ".png"))
				unlink("Resources/ProfilePics/" . $this->user->id . ".png");
			imagepng(imagecreatefromstring(file_get_contents($_FILES["picture"]["tmp_name"])), "Resources/ProfilePics/" . $this->user->id . ".png");
		}
		
		$this->RedirectToAction("Board");
	}
	
	function PostPin($content, $user = 0)
	{
		if($user == 0)
			$user = $this->user->id;
			
		if($statement = $this->mySQL->prepare("INSERT INTO pins (fromUser, toUser, content, timestamp) VALUES (?, ?, ?, ?)"))
		{
			$statement->bind_param("iisi", $this->user->id, $user, $content, time());
			$statement->execute();
			
			if($user != $this->user->id)
				$this->sqlConnector->addNotification($this->user->id, $user, $statement->insert_id, 1);
		}
		
		$this->RedirectToAction("Board", NULL, array("user" => $user));
	}
	
	function Like($pin)
	{
		if($statement = $this->mySQL->prepare("INSERT INTO likes (pin, user, type, timestamp) VALUES (?, ?, 1, ?)"))
		{
			$statement->bind_param("iii", $pin, $this->user->id, time());
			$statement->execute();
		}
		
		$temp = $this->sqlConnector->getPin($pin);
		
		if($this->user->id != $temp->fromUser->id)
			$this->sqlConnector->addNotification($this->user->id, $temp->fromUser->id, $pin, 2);
			
		if($temp->fromUser->id != $temp->toUser->id && $temp->toUser->id != $this->user->id)
			$this->sqlConnector->addNotification($this->user->id, $temp->toUser->id, $pin, 2);
		
		$countLikes = count($temp->likes);
		$countDislikes = count($temp->dislikes);
		
		return $this->JSON(array("likes" => $countLikes, "dislikes" => $countDislikes, "unliked" => false));
	}
	
	function Dislike($pin)
	{
		if($statement = $this->mySQL->prepare("INSERT INTO likes (pin, user, type, timestamp) VALUES (?, ?, 2, ?)"))
		{
			$statement->bind_param("iii", $pin, $this->user->id, time());
			$statement->execute();
		}
		
		$temp = $this->sqlConnector->getPin($pin);
		
		if($this->user->id != $temp->fromUser->id)
			$this->sqlConnector->addNotification($this->user->id, $temp->fromUser->id, $pin, 3);
			
		if($temp->fromUser->id != $temp->toUser->id && $temp->toUser->id != $this->user->id)
			$this->sqlConnector->addNotification($this->user->id, $temp->toUser->id, $pin, 3);
				
		$countLikes = count($temp->likes);
		$countDislikes = count($temp->dislikes);
		
		return $this->JSON(array("likes" => $countLikes, "dislikes" => $countDislikes, "unliked" => false));
	}
	
	function Unlike($pin)
	{
		if($statement = $this->mySQL->prepare("DELETE FROM likes WHERE pin = ? AND user = ?"))
		{
			$statement->bind_param("ii", $pin, $this->user->id);
			$statement->execute();
		}
		
		$temp = $this->sqlConnector->getPin($pin);
		$countLikes = count($temp->likes);
		$countDislikes = count($temp->dislikes);
		
		return $this->JSON(array("likes" => $countLikes, "dislikes" => $countDislikes, "unliked" => true));
	}
	
	function WhoLiked($pin)
	{
		$temp = $this->sqlConnector->getPin($pin);
		
		return $this->JSON($temp->likes);
	}
	
	function WhoDisliked($pin)
	{
		$temp = $this->sqlConnector->getPin($pin);
		
		return $this->JSON($temp->dislikes);
	}
	
	function SetFriend($who)
	{
		$status = 0; // Anfrage angenommen
		// Überprüfen ob Anfrage bereits besteht
		$query = $this->mySQL->query("SELECT friend1, friend2, accepted FROM friends WHERE (friend1 = " . $who . " AND friend2 = " . $this->user->id . ") OR (friend1 = " . $this->user->id . " AND friend2 = " . $who . ")");
		
		if($query->num_rows > 0)
		{
			$friendship = $query->fetch_row();
			
			// Wenn Anfragenempfänger und nicht akzeptierte Freundschaft, dann annehmen
			if($friendship[1] == $this->user->id && $friendship[2] == 0)
				$this->mySQL->query("UPDATE friends SET accepted = 1 WHERE friend1 = " . $friendship[0] . " AND friend2 = " . $friendship[1]);
			else // Ansonsten Anfrage löschen
			{
				$this->mySQL->query("DELETE FROM friends WHERE (friend1 = " . $friendship[1] . " AND friend2 = " . $this->user->id . ") OR (friend1 = " . $this->user->id . " AND friend2 = " . $friendship[1] . ")");
				$this->mySQL->query("DELETE FROM notifications WHERE sender = " . $this->user->id . " AND recipient = " . $who . " AND type = 4");
				$status = 1; // Anfrage gelöscht
			}
		}
		else
		{
			// Anfrage abschicken
			$this->mySQL->query("INSERT INTO friends (friend1, friend2, accepted) VALUES (" . $this->user->id . ", " . $who . ", 0)");
			$this->sqlConnector->addNotification($this->user->id, $who, $this->mySQL->insert_id, 4);
			$status = 2; // Anfrage abgeschickt
		}
		
		return $this->JSON(array("status" => $status));
	}
}
?>