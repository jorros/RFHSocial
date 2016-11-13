<?php
class FriendsController extends BaseController
{
	function Index($g = NULL, $l = NULL, $c = NULL)
	{
		$friends = $this->sqlConnector->getFriends($this->user);
		$filteredFriends = array();
		
		foreach($friends as $friend)
		{
			if(isset($g) && $g != "" && $friend->gender != $g)
				continue;
			
			if(isset($l) && $l != "" && $friend->location != $l)
				continue;
				
			if(isset($c) && $c != "" && $friend->course != $c)
				continue;
				
			$filteredFriends[] = $friend;
		}
		
		$this->viewBag["filter"] = array("gender" => $g, "location" => $l, "course" => $c);
		return $this->View("Friends", $filteredFriends);
	}
	
	function RemoveFriend($who, $g, $l, $c)
	{
		$this->mySQL->query("DELETE FROM friends WHERE (friend1 = " . $who . " AND friend2 = " . $this->user->id . ") OR (friend1 = " . $this->user->id . " AND friend2 = " . $who . ")");
		
		$this->RedirectToAction("Friends", NULL, array("g" => $g, "l" => $l, "c" => $c));
	}
}
?>