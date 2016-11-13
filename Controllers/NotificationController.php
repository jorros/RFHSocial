<?php
class NotificationController extends BaseController
{
	function Index()
	{
		return $this->View("Notification", $this->sqlConnector->getNotifications($this->user, false));
	}
	
	function AcceptRequest($id)
	{
		$this->mySQL->query("UPDATE friends SET accepted = 1 WHERE id = " . $id);
		$this->RedirectToAction("Notification");
	}
	
	function DeclineRequest($id)
	{
		$this->mySQL->query("DELETE FROM friends WHERE id = " . $id);
		$this->RedirectToAction("Notification");
	}
	
	function Pin($id)
	{
		return $this->View("Pin", $this->sqlConnector->getPin($id));
	}
}
?>