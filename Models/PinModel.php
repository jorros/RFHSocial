<?php
class PinModel
{
	public $id;			// Pin ID
	public $fromUser;	// User ID des Posters
	public $toUser;		// User ID des Empfängers
	public $content;	// Inhalt als Text
	public $timestamp;	// Zeit der Erstellung im Unix Timestamp
	public $likes;		// Array mit ID => User, die geliked haben
	public $dislikes;	// Array mit ID => User, die disliked haben
}
?>