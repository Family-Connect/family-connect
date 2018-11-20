<?php
require_once dirname(__DIR__, 3) . "/vendor/autoload.php";
require_once dirname(__DIR__, 3) . "/php/classes/autoload.php";
require_once("/etc/apache2/capstone-mysql/encrypted-config.php");
require_once dirname(__DIR__, 3) . "/php/lib/xsrf.php";
require_once dirname(__DIR__, 3) . "/php/lib/uuid.php";
require_once dirname(__DIR__, 3) . "/php/lib/jwt.php";

use FamConn\FamilyConnect\{
			Event,
			//we only use the user class for testing purposes
			User
};

/**
 * api for Event class
 *
 * @author Sharon Romero <sromero130@cnm.edu>
 **/

//verify the session, start if not active
if(session_status() !== PHP_SESSION_ACTIVE) {
		session_start();
}

//prepare an empty reply
$reply = new stdClass();
$reply->status = 200;
$reply->data = null;

try {
		//grab the mySQL connection
		$pdo = connectToEncryptedMySQL("/etc/apache2/capstone-mysql/cohort22/familyconnect.ini");

		//determine which HTTP method was used
		$method = $_SERVER["HTTP_X_HTTP_METHOD"] ?? $_SERVER["REQUEST_METHOD"];

		//sanitize input
		$id = filter_input(INPUT_GET, "id", FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES);
		$eventUserId = filter_input(INPUT_GET, "eventUserId", FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES);
		$eventContent = filter_input(INPUT_GET, "eventContent", FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES);

		//make sure the id is valid for methods that require it
		if(($method === "DELETE" || $method === "PUT") && (empty($id) === true)) {
				throw(new InvalidArgumentException("id cannot be empty or negative", 402));
	}

	// handle GET request - if id is present, that event is returned, otherwise all events are returned
	if($method === "GET") {
			//set XSRF cookie
			setXsrfCookie();

			//get a specific event or all events and update reply
			if(empty($id) === false) {
					$reply->data = Event::getEventByEventId($pdo, $id);
			} else if(empty($eventUserId) === false) {
					//if the user is logged in grab all the events by that user based on who is logged in
					$reply->data = Event::getEventByEventUserId($pdo, $_SESSION["profile"]->getUserId())->toArray();
			} else if(empty($eventContent) === false) {
					$reply->data = Event::getEventByEventContent($pdo, $eventContent)->toArray();
			} else {
					$reply->data = Event::getAllEvents($pdo)->toArray();
			}
	} else if($method === "PUT" || $method === "POST") {
			//enforce the user has an XSRF token
			verifyXSRF();

			//enforce the user is signed in
			if(empty($_SESSION["user"]) === true) {
						throw(new \InvalidArgumentException("you must be logged in to add an event", 401));
			}

			$requestContent = file_get-contents("php://input");
			//Retrieves the JSON package that the front end sent and stores it in $requestContent. Here we are using
			// file_get_contents("php://input") to get the request from the front end. file_get_contents() is a PHP
			// function that reads a file into a string. The argument for the function, here, is "php://input". This is a
			// read only stream that allows raw data to be read from the front end request which is, in this case, a JSON
			// package.
			$requestObject = json_decode($requestContent);
			//This line then decodes the JSON package and stores that result in $requestObject
			//make sure event content is available (required field)
			if(empty($requestObject->requestContent) === true) {
						throw(new \InvalidArgumentException ("No content for Event.", 405));
			}

			//make sure event date is accurate (optional field)
			if(empty($requestObject->eventDate) === true) {
						$requestObject->eventDate = null;
			}

			//perform the actual put or post
		if($method === "PUT") {

				//retrieve the event to update
			$event = Event::getEventByEventId($pdo, $id);
			if($event === null) {
						throw(new RuntimeException("Event does not exist", 404));
			}

			//enforce the end user has a JWT Token

			//enforce the user is signed in and only trying to edit their own event
			if(empty($_SESSION["user"]) === true || $_SESSION["user"]->getUserId()->toString() !==
				$event->getEventUserId()->toString()) {
				throw(new \InvalidArgumentException("You are not allowed to edit this event", 403));
			}
		}
	}
	}

