<?php
require_once dirname(__DIR__, 3) . "/vendor/autoload.php";
require_once dirname(__DIR__, 3) . "/php/Classes/autoload.php";
require_once dirname(__DIR__, 3) . "/php/lib/xsrf.php";
require_once dirname(__DIR__, 3) . "/php/lib/uuid.php";
require_once("/etc/apache2/capstone-mysql/Secrets.php");

use FamConn\FamilyConnect\{User};

/**
 * api for the user class
 *
 * @author Anthony Garcia <antgarcia014@gmail.com>
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
	// grab mySQL connection
	$secrets = new \Secrets("/etc/apache2/capstone-mysql/cohort22/familyconnect");
	$pdo = $secrets->getPdoObject();

	//determine which HTTP method was used
	$method = $_SERVER["HTTP_X_HTTP_METHOD"] ?? $_SERVER["REQUEST_METHOD"];

	//sanitize input
	$id = filter_input(INPUT_GET, "id", FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES);
	$userFamilyId = filter_input(INPUT_GET, "userFamilyId", FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES);
	$userAvatar = filter_input(INPUT_GET, "userAvatar", FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES);
	$userDisplayName = filter_input(INPUT_GET, "userDisplayName", FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES);
	$userEmail = filter_input(INPUT_GET, "userEmail", FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES);

	//make sure the id is valid for methods that require it
	if(($method === "DELETE" || $method === "PUT") && (empty($id) === true)) {
		throw(new InvalidArgumentException("id cannot be empty or negative", 405));
	}

	if($method === "GET") {
		//set XSRF cookie
		setXsrfCookie();

		if(empty($id) === false) {
			$reply->data = User::getUserByUserId($pdo, $id);
		} else if(empty($userFamilyId) === false) {
			$reply->data = User::getUserByUserFamilyId($pdo, $userFamilyId)->toArray();
		} else if(empty($userEmail) === false) {
			$reply->data = User::getUserByUserEmail($pdo, $userEmail);
		}
		} else if($method === "PUT") {

			// enforce the user has a XSRF token
			verifyXsrf();

			//  Retrieves the JSON package that the front end sent, and stores it in $requestContent. Here we are using file_get_contents("php://input") to get the request from the front end. file_get_contents() is a PHP function that reads a file into a string. The argument for the function, here, is "php://input". This is a read only stream that allows raw data to be read from the front end request which is, in this case, a JSON package.

		$requestContent = file_get_contents("php://input");

			// This Line Then decodes the JSON package and stores that result in $requestObject
			$requestObject = json_decode($requestContent);
			var_dump($id,$requestObject);

			//make sure user email is available
			if(empty($requestObject->userEmail) === true) {
				throw(new \InvalidArgumentException ("No email for user.", 405));
			}
			//make sure user display name is available
			if(empty($requestObject->userDisplayName) === true) {
				throw(new \InvalidArgumentException ("No display name.", 405));
			}
			//make sure user phone number is available
			if(empty($requestObject->userPhoneNumber) === true) {
				throw(new \InvalidArgumentException ("No phone number for user.", 405));
			}
			//make sure user phone number is available
			if(empty($requestObject->userPrivilege) === true) {
			throw(new \InvalidArgumentException ("No privilege for user.", 405));
			}

			//perform the actual put
			if($method === "PUT") {

				// retrieve the user to update
				$user = User::getUserByUserId($pdo, $id);
				if($user === null) {
					throw(new RuntimeException("User does not exist", 404));
				}

				//enforce the user is signed in and only trying to edit their own user
				if(empty($_SESSION["family"]) === true || $_SESSION["family"]->getFamilyId()->toString() !== $user->getUserFamilyId()->toString()) {
				throw(new \InvalidArgumentException("You are not allowed to edit this family", 403));
			}
		}

			// update all attributes
			$user->setUserDisplayName($requestObject->userDisplayName);
			$user->setUserEmail($requestObject->userEmail);
			$user->setUserPrivilege($requestObject->userPrivilege);
			$user->setUserPhoneNumber($requestObject->userPhoneNumber);
			$user->update($pdo);

			// update reply
			$reply->message = "user updated OK";
		} else if($method === "DELETE") {

				//enforce that the end user has a XSRF token.
				verifyXsrf();

				// retrieve the User to be deleted
				$user = User::getUserByUserId($pdo, $id);
				if($user === null) {
					throw(new RuntimeException("User does not exist", 404));
				}

				//enforce the user is signed in and only trying to edit their own User
				if(empty($_SESSION["family"]) === true || $_SESSION["family"]->getFamilyId() !== $user->getUserFamilyId()) {
					throw(new \InvalidArgumentException("You are not allowed to delete this user", 403));
				}

				// delete the user
				$user->delete($pdo);
				// update reply
				$reply->message = "User has been deleted";
			}

}

	// update the $reply->status $reply->message
catch(\Exception | \TypeError $exception) {
		$reply->status = $exception->getCode();
		$reply->message = $exception->getMessage();
	}
	// encode and return reply to front end caller
		header("Content-type: application/json");

			echo json_encode($reply);


