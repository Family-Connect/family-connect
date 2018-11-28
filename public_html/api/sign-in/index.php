<?php
require_once dirname(__DIR__, 3) . "/php/Classes/autoload.php";
require_once dirname(__DIR__, 3) . "/php/lib/xsrf.php";
require_once dirname(__DIR__, 3) . "/php/lib/jwt.php";
require_once ("/etc/apache2/capstone-mysql/encrypted-config.php");
use FamConn\FamilyConnect\User;

/**
 * api for handling sign-in
 *
 * @author sromero130
 **/
//prepare and empty reply
$reply = new stdClass();
$reply->status = 200;
$reply->data = null;
try {

		//start session
		if(session_status() !== PHP_SESSION_ACTIVE) {
				session_start();
		}
		//grab mySQL statement
		$pdo = connectToEncryptedMySQL("/etc/apache2/capstone-mysql/cohort22/familyconnect.ini");

		//determine which HTTP method is being used
		$method = array_key_exists("HTTP_X_HTTP_METHOD", $_SERVER) ? $_SERVER["HTTP_X_HTTP_METHOD"] : 		  			$_SERVER["REQUEST_METHOD"];

		//If method is post handle the sign in logic
		if($method === "POST") {

				//make sure the XSRF Token is valid
				verifyXsrf();

				//process the request content and decode the json object into a php object
				$requestContent = file_get_contents("php://input");
				$requestObject = json_decode($requestContent);

				//check to make sure the password and email field is not empty.s
				if(empty($requestObject->userEmail) === true) {
					throw(new \InvalidArgumentException("Wrong email address.", 401));
				} else {
							$userEmail = filter_var($requestObject->userEmail, FILTER_SANITIZE_EMAIL);
				}

				if(empty($requestObject->userPassword) === true) {
							throw(new \InvalidArgumentException("Must enter a password.", 401));
				} else {
							$userPassword = $requestObject->userPassword;
				}

				//grab the user from the database by the email provided
				$user = User::getUserByUserEmail($pdo, $userEmail);
				if(empty($user) === true) {
							throw(new \InvalidArgumentException("Invalid Email", 401));
				}
				$user->setUserActivationToken(null);
				$user->update($pdo);

				//if the user activation token is not null throw an error
				if($user->getUserActivationToken() !== null) {
						throw (new \InvalidArgumentException ("you are not allowed to sign in unless you have 						activated your account", 403));
				}

				//verify hash is correct
				if(password_verify($requestObject->userPassword, $user->getUserHash()) === false) {
						throw(new \InvalidArgumentException("Password or email is incorrect.", 401));
				}

				//grab user from database and put into a session
				$user = User::getUserByUserId($pdo, $user->getUserId());

				$_SESSION["user"] = $user;

				//create the Auth payload
				$authObject = (object)[
						"userId" => $user->getUserId(),
						"userDisplayName" => $user->getUserDisplayName()
				];

				//create and set the JWT TOKEN
				setJWTAndAuthHeader("auth", $authObject);

				$reply->message = "Sign in was successful.";
		} else {
				throw(new \InvalidArgumentException("Invalid HTTP method request", 418));
		}

		//if an exception is thrown update the
} catch(Exception | TypeError $exception) {
	$reply->status = $exception->getCode();
	$reply->message = $exception->getMessage();
}
header("Content-type: application/json");
echo json_encode($reply);