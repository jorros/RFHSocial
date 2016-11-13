<?php
class StartController extends BaseController
{
	function Index()
	{
		// Ist der Benutzer eingeloggt
		if(isset($this->user))
		{
			return $this->View("Feed", $this->sqlConnector->getPinsFeed($this->user, false));
		}
		else
		{
			return $this->View("Welcome");
		}
	}
	
	function Login($email, $password)
	{
		if($statement = $this->mySQL->prepare("SELECT id FROM user WHERE email = ? AND password = ?"))
		{
			$statement->bind_param("ss", $email, md5($password));
			$statement->execute();
			$statement->bind_result($userid);
			$statement->fetch();
			$statement->close();
			
			$this->viewBag["login_error"] = "E-Mail oder Passwort falsch";
			
			if($userid > 0)
			{
				$_SESSION["userid"] = $userid;
				$this->RedirectToAction("Start");
			}
			else
				return $this->View("Welcome");
		}
	}
	
	function PostPin($content)
	{			
		if($statement = $this->mySQL->prepare("INSERT INTO pins (fromUser, toUser, content, timestamp) VALUES (?, ?, ?, ?)"))
		{
			$statement->bind_param("iisi", $this->user->id, $this->user->id, $content, time());
			$statement->execute();
		}
		
		$this->RedirectToAction("Start");
	}
	
	function Logout()
	{
		session_destroy();
		$this->RedirectToAction("Start");
	}
	
	function Search($search)
	{
		$results = array();
		
		if(isset($search))
		{
			$search = "%" . $search . "%";
			$query = $this->mySQL->query("SELECT id FROM user WHERE (firstname LIKE '" . $search . "' OR lastname LIKE '" . $search . "') AND NOT id = " . $this->user->id);
			
			for($i = 0; $i < $query->num_rows; $i++)
			{
				$user = $query->fetch_array();
				$results[] = $this->sqlConnector->getUser($user[0]);
			}
		}
		
		return $this->View("Search", $results);
	}
	
	function Register($firstname, $lastname, $register_email, $register_password, $retry_password)
	{
		// Passwörter vergleichen
		if($register_password != $retry_password)
		{
			$this->viewBag["register_error"] = "Passwörter stimmen nicht überein!";
			return $this->View("Welcome");
		}
		
		// Leere Felder überprüfen
		if($firstname == "" || $lastname == "" || $register_email == "" || $register_password == "")
		{
			$this->viewBag["register_error"] = "Es sind nicht alle Felder ausgefüllt!";
			return $this->View("Welcome");
		}
		
		// Existiert bereits Benutzer?
		if($statement = $this->mySQL->prepare("SELECT id FROM user WHERE email = ?"))
		{
			$statement->bind_param("s", $register_email);
			$statement->execute();
			$statement->bind_result($userid);
			$statement->fetch();
			
			if($userid > 0)
			{
				$this->viewBag["register_error"] = "Ein Benutzer mit dieser E-Mail Adresse existiert bereits!";
				return $this->View("Welcome");
			}
		}
		else
		{
			$this->viewBag["register_error"] = "Fehler in der Datenbank!";
			return $this->View("Welcome");
		}
		
		// Füge den Benutzer in die Datenbank hinzu
		if($statement = $this->mySQL->prepare("INSERT INTO user (firstname, lastname, email, password, created) VALUES (?, ?, ?, ?, ?)"))
		{
			$statement->bind_param("ssssi", $firstname, $lastname, $register_email, md5($register_password), time());
			$statement->execute();
		}
		else
		{
			$this->viewBag["register_error"] = "Fehler beim Anlegen des Benutzers!";
			return $this->View("Welcome");
		}
		
		$this->viewBag["register_error"] = "Benutzer angelegt!";
		return $this->View("Welcome");
	}
}
?>