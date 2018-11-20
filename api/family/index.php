<?php

require_once(dirname(__DIR__, 3). "/vendor/autoload.php");
require_once(dirname(__DIR__, 3). "/php/classes/autoload.php");
require_once(dirname(__DIR__, 3). "/php/lib/jwt.php");
require_once(dirname(__DIR__, 3). "/php/lib/xsrf.php");
require_once(dirname(__DIR__, 3). "/php/lib/uuid.php");

require_once ("/etc/apache2/capstone-mysql/Secrets.php");

use FamConn\FamilyConnect\{Family};

/**
 * API for Family
 *
 * @author Michael Bovee
 */

// verify session / start session if not active
if(session_status() !== PHP_SESSION_ACTIVE) {
	session_start();
}

// prepare empty reply
$reply = new stdClass();
$reply->status = 200;
$reply->data = null;

try {
	// grab mySQL connection
	$pdo = connectToEncryptedMySQL("/etc/apache2/capstone-mysql/cohort22/familyconnect");

	// determine which HTTP method was used
	$method = $_SERVER["HTTP_X_HTTP_METHOD"] ?? $_SERVER["REQUEST_METHOD"];

	// sanitize input
	$id = filter_input(INPUT_GET, "id", FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES);
	$familyName = filter_input(INPUT_GET, "familyName", FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES);

	// verify id is valid for methods requiring it
	if(($method === "DELETE" || $method === "PUT") && (empty($id) === true)) {
		throw(new InvalidArgumentException("id cannot be empty or negative", 405));
	}

	if($method === "GET") {
		// set XSRF cookie
		setXsrfCookie();

		//gets family by content
		if(empty($id) === false) {
			$reply->data = Family::getFamilyByFamilyId($pdo, $id);
		} else if(empty($familyName) === false) {
			$reply->data = Family::getFamilyByFamilyName($pdo, $familyName);
		}
	} elseif($method === "PUT") {

	}


}

