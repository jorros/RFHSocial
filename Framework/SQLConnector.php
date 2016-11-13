<?php
class SQLConnector
{
	private $mysqli;
	
	function __construct($mysqli)
	{
		$this->mysqli = $mysqli;
	}
	
	function getUser($id)
	{
		$user = NULL;
		if($statement = $this->mysqli->prepare("SELECT * FROM user WHERE id = ?"))
		{
			$statement->bind_param("i", $id);
			$statement->execute();
				
			$user = new UserModel();
			$statement->bind_result($user->id, $user->firstname, $user->lastname, $user->password, $user->email, $user->location, $user->gender, $user->birthdate, $user->course, $user->type, $user->expectedGraduation, $user->favouriteBooks, $user->employer, $user->created);
			$statement->fetch();
			$statement->close();
		}
		
		if(file_exists("Resources/ProfilePics/" . $user->id . ".png"))
			$user->picture = $user->id;
		else
			$user->picture = "Default";
		
		return $user;
	}
	
	function getPin($id)
	{
		if($statement = $this->mysqli->prepare("SELECT * FROM pins WHERE id = ?"))
		{
			$statement->bind_param("i", $id);
			$statement->execute();
			
			$pin = new PinModel();
			$statement->bind_result($pin->id, $pin->fromUser, $pin->toUser, $pin->content, $pin->timestamp);
			$statement->fetch();
			$statement->close();
		}
		
		$pin->fromUser = $this->getUser($pin->fromUser);
		$pin->toUser = $this->getUser($pin->toUser);
		$pin->likes = array();
		$pin->dislikes = array();
		
		$likeQuery = $this->mysqli->query("SELECT user, type FROM likes WHERE pin = " . $id);
		for($i = 0; $i < $likeQuery->num_rows; $i++)
		{
			$like = $likeQuery->fetch_row();
			if($like[1] == 1)
				$pin->likes[$like[0]] = $this->getUser($like[0]);
			else
				$pin->dislikes[$like[0]] = $this->getUser($like[0]);
		}
		
		return $pin;		
	}
	
	function getFriends($user)
	{
		$friends = array();
		$query = $this->mysqli->query("SELECT friend1, friend2 FROM friends WHERE (friend1 = " . $user->id . " OR friend2 = " . $user->id . ") AND accepted = 1");
		for($i = 0; $i < $query->num_rows; $i++)
		{
			$friendship = $query->fetch_assoc();
				
			if($friendship["friend1"] == $user->id)
				$friends[$friendship["friend2"]] = $this->getUser($friendship["friend2"]);
			else
				$friends[$friendship["friend1"]] = $this->getUser($friendship["friend1"]);
		}
		
		return $friends;
	}
	
	function getPinsFeed($user, $board)
	{
		$pins = array();
		
		if(!$board)
		{
			$optionalParam = array("", "");
			
			if(count($user->acceptedFriends) > 0)
			{
				$optionalParam[0] = "toUser IN (" . implode(",", $user->acceptedFriends) . ") OR";
				$optionalParam[1] = "fromUser IN (" . implode(",", $user->acceptedFriends) . ") OR";
			}
			
			// Pins aller Freunde die an deine Freunde oder dich gerichtet sind
			$pinsTowards = $this->mysqli->query("SELECT id, fromUser FROM pins WHERE (" . $optionalParam[0] . " toUser = " . $user->id . ") AND (" . $optionalParam[1] . " fromUser = " . $user->id . ") ORDER BY timestamp DESC");
		}
		else
		{
			$pinsTowards = $this->mysqli->query("SELECT id, fromUser FROM pins WHERE toUser = " . $user->id . " ORDER BY timestamp DESC");
		}
		
		if($pinsTowards != false)
		{
			for($i = 0; $i < $pinsTowards->num_rows; $i++)
			{
				$pin = $pinsTowards->fetch_assoc();
				$pins[] = $this->getPin($pin["id"]);
			}
		}
		
		return $pins;
	}
	
	function getNotifications($user, $onlyUnseen)
	{
		$notifications = array();
		
		if(!$onlyUnseen)
		{
			$query = $this->mysqli->query("SELECT * FROM notifications WHERE recipient = " . $user->id . " ORDER BY timestamp DESC");
			$this->mysqli->query("UPDATE notifications SET seen = 1 WHERE recipient = " . $user->id . " AND seen = 0");
		}
		else
			$query = $this->mysqli->query("SELECT * FROM notifications WHERE recipient = " . $user->id . " AND seen = 0 ORDER BY timestamp DESC");
		
		for($i = 0; $i < $query->num_rows; $i++)
		{
			$notification = new NotificationModel();
			$temp = $query->fetch_assoc();
			
			$notification->id = $temp["id"];
			$notification->type = $temp["type"];
			
			if($notification->type == 1)
				$notification->reference = $this->getPin($temp["reference"]);
			else if($notification->type == 2)
				$notification->reference = $this->getPin($temp["reference"]);
			else if($notification->type == 3)
				$notification->reference = $this->getPin($temp["reference"]);
			else
				$notification->reference = $temp["reference"];
			
			$notification->sender = $this->getUser($temp["sender"]);
			$notification->recipient = $user;
			$notification->seen = $temp["seen"];
			$notification->timestamp = $temp["timestamp"];
			
			$notifications[] = $notification;
		}
		
		return $notifications;
	}
	
	function addNotification($sender, $recipient, $reference, $type)
	{
		if($statement = $this->mysqli->prepare("INSERT INTO notifications (type, reference, sender, recipient, seen, timestamp) VALUES (?, ?, ?, ?, 0, ?)"))
		{
			$statement->bind_param("iiiii", $type, $reference, $sender, $recipient, time());
			$statement->execute();
		}
	}
}
?>