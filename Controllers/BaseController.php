<?php
class BaseController
{
	protected $mySQL;
	protected $sqlConnector;
	protected $user;
	protected $viewBag = array();
	
	function __construct()
	{
		$this->mySQL = new mysqli("localhost", "root", "", "usr_web699_1");
		$this->mySQL->query("SET NAMES 'utf8'");
		$this->sqlConnector = new SQLConnector($this->mySQL);
		
		if(isset($_SESSION["userid"]))
		{			
			$this->user = $this->sqlConnector->getUser($_SESSION["userid"]);
			// Freundesliste generieren
			
			// Akzeptierte Freunde
			$this->user->acceptedFriends = array();
			$query = $this->mySQL->query("SELECT friend1, friend2 FROM friends WHERE (friend1 = " . $_SESSION["userid"] . " OR friend2 = " . $_SESSION["userid"] . ") AND accepted = 1");
			for($i = 0; $i < $query->num_rows; $i++)
			{
				$friendship = $query->fetch_assoc();
				
				if($friendship["friend1"] == $_SESSION["userid"])
					$this->user->acceptedFriends[] = $friendship["friend2"];
				else
					$this->user->acceptedFriends[] = $friendship["friend1"];
			}
			
			// Eigene Freundschaftsanfragen
			$this->user->yourRequests = array();
			$query = $this->mySQL->query("SELECT friend2 FROM friends WHERE friend1 = " . $_SESSION["userid"] . " AND accepted = 0");
			for($i = 0; $i < $query->num_rows; $i++)
			{
				$request = $query->fetch_assoc();
				
				$this->user->yourRequests[] = $request["friend2"];
			}
			
			// Andere Freundschaftsanfragen
			$this->user->otherRequests = array();
			$query = $this->mySQL->query("SELECT friend1 FROM friends WHERE friend2 = " . $_SESSION["userid"] . " AND accepted = 0");
			for($i = 0; $i < $query->num_rows; $i++)
			{
				$request = $query->fetch_assoc();
				
				$this->user->otherRequests[] = $request["friend1"];
			}
			
			$this->viewBag["notificationsCount"] = count($this->sqlConnector->getNotifications($this->user, true));
		}
	}
	
	public function Error404()
	{
		return $this->View("404");
	}
	
	protected function View($view, $model = NULL)
	{
		$viewBag = $this->viewBag;
		$user = $this->user;
		ob_start();
		include "Views/" . $view . ".php";
		return ob_get_clean();
	}
	
	protected function JSON($jsonArray)
	{
		return json_encode($jsonArray);
	}
	
	protected function RedirectToAction($controller, $action = NULL, $param = array())
	{
		$stringParam = "";
		
		if(count($param) > 0)
		{
			foreach($param as $type => $value)
				$stringParam .= "&" . $type . "=" . $value;
		}
		
		if(isset($action))
			header("Location: ?page=" . $controller . "&action=" . $action . $stringParam);
		else
			header("Location: ?page=" . $controller . $stringParam);
	}
}
?>