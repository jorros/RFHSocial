<?php
class UserModel
{
	public $id;					// User ID
	public $firstname;			// User Vorname
	public $lastname;			// User Nachname
	public $password;			// User Passwort in MD5 gehashed
	public $email;				// User Email
	public $picture;			// Profilbild
	public $location;
	public $gender;
	public $birthdate;
	public $course;
	public $type;
	public $expectedGraduation;
	public $favouriteBooks;
	public $employer;
	public $created;
	public $acceptedFriends;	// Array mit User IDs
	public $otherRequests;		// Array mit User IDs von Empfänger der Freundschaftsanfrage 
	public $yourRequests;		// Array mit User IDs für Sender der Freundschaftsanfrage
}
?>