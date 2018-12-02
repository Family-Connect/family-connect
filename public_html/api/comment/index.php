<?php
/**
 * Created by PhpStorm.
 * User: felizmunoz
 * Date: 11/26/18
 * Time: 10:30 AM
 */
require_once dirname(__DIR__, 3) . "/vendor/autoload.php";
require_once dirname(__DIR__, 3) . "/php/Classes/autoload.php";
require_once dirname(__DIR__, 3) . "/php/lib/xsrf.php";
require_once dirname(__DIR__, 3) . "/php/lib/uuid.php";
require_once("/etc/apache2/capstone-mysql/Secrets.php");

use FamConn\FamilyConnect\{Comment};

/**
 * API for Comment class
 *
 * @author Feliz Munoz
 */

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
	$secrets =  new \Secrets("/etc/apache2/capstone-mysql/cohort22/familyconnect");
	$pdo = $secrets->getPdoObject();

	//determine which HTTP method was used
	$method = $_SERVER["HTTP_X_HTTP_METHOD"] ?? $_SERVER["REQUEST_METHOD"];

	//sanitize input
	$id = filter_input(INPUT_GET, "id", FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES);
	$commentEventId = filter_input(INPUT_GET, "commentEventId", FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES);
	$commentTaskId = filter_input(INPUT_GET, "commentTaskId", FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES);
	$commentUserId = filter_input(INPUT_GET, "commentUserId", FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES);

	//make sure the id is valid for methods that require it
	if(($method === "DELETE" || $method === "PUT") && (empty($id) === true)) {
		throw(new InvalidArgumentException("id cannot be empty or negative", 405));
	}

if($method === "GET") {
	//set XSRF cookie
	setXsrfCookie();

	//get a specific comment based on arguments provided or all the comments and update reply
	if(empty($id) === false) {
		$reply->data = Comment::getCommentByCommentId($pdo, $id);
	} else if(empty($commentEventId) === false) {
		$reply->data = Comment::getCommentByCommentEventId($pdo, $commentEventId)->toArray();
	} else if(empty($commentTaskId) === false) {
		$reply->data = Comment::getCommentByCommentTaskId($pdo, $commentTaskId)->toArray();
	} else if(empty($commentUserId) === false) {
		$reply->data = Comment::getCommentByCommentUserId($pdo, $commentUserId)->toArray();
	}
}

else if($method === "PUT" || $method === "POST") {
	// enforce the user has a XSRF token
	//verifyXsrf();

	//  Retrieves the JSON package that the front end sent, and stores it in $requestContent. Here we are using file_get_contents("php://input") to get the request from the front end. file_get_contents() is a PHP function that reads a file into a string. The argument for the function, here, is "php://input". This is a read only stream that allows raw data to be read from the front end request which is, in this case, a JSON package.
	$requestContent = file_get_contents("php://input");

	// This Line Then decodes the JSON package and stores that result in $requestObject
	$requestObject = json_decode($requestContent);

	//  make sure commentId is available
	/*if(empty($requestObject->commentId) === true) {
		throw(new \InvalidArgumentException ("No comment ID.", 405));
	}

	//  make sure commentEventId is available
	if(empty($requestObject->commentEventId) === true) {
		throw(new \InvalidArgumentException ("No comment Event ID.", 405));
	}

	//  make sure commentTaskId is available
	if(empty($requestObject->commentTaskId) === true) {
		throw(new \InvalidArgumentException ("No comment Task ID.", 405));
	}*/

	//  make sure commentUserId is available
	if(empty($requestObject->commentUserId) === true) {
		throw(new \InvalidArgumentException ("No comment User ID.", 405));
	}

	//make sure comment content is available (required field)
	if(empty($requestObject->commentContent) === true) {
		throw(new \InvalidArgumentException ("No content for Comment.", 405));
	}

	// make sure comment date is accurate (optional field)
	if(empty($requestObject->commentDate) === true) {
		$requestObject->commentDate = null;
	} else {
		// if the date exists, Angular's milliseconds since the beginning of time MUST be converted
		$commentDate = DateTime::createFromFormat("U.u", $requestObject->commentDate / 1000);
		if($commentDate === false) {
			throw(new RuntimeException("invalid comment date", 400));
		}
		$requestObject->commentDate = $commentDate;
	}

	//perform the actual put or post
	if($method === "PUT") {

		// retrieve the comment to update
		$comment = Comment::getCommentByCommentId($pdo, $id);
		if($comment === null) {
			throw(new RuntimeException("Comment does not exist", 404));
		}

		//enforce the user is signed in and only trying to edit their own comment
		if(empty($_SESSION["profile"]) === true || $_SESSION["profile"]->getProfileId()->toString() !== $comment->getCommentProfileId()->toString()) {
			throw(new \InvalidArgumentException("You are not allowed to edit this comment", 403));
		}

		// update all attributes
		$comment->setCommentEventId($requestObject->commentEventId);
		$comment->setCommentTaskId($requestObject->commentTaskId);
		$comment->setCommentUserId($requestObject->commentUserId);
		$comment->setCommentContent($requestObject->commentContent);
		$comment->setCommentDate($requestObject->commentDate);
		$comment->update($pdo);

		// update reply
		$reply->message = "Comment updated OK";

	} else if($method === "POST") {

		// enforce the user is signed in
		/*if(empty($_SESSION["comment"]) === true) {
			throw(new \InvalidArgumentException("you must be logged in to post comments", 403));
		}*/

		// create new comment and insert into the database
		$commentId = generateUuidV4();
		$comment = new Comment($commentId, $this->event->getEventId(), $this->task->getTaskId(), $_SESSION ["user"]->getUserId(), $this->commentContent, $this->commentDate);
		$comment->insert($this->getPDO());

		// update reply
		$reply->message = "Comment created OK";
	}

}

else if($method === "DELETE") {
	//enforce that the end user has a XSRF token.
	verifyXsrf();

	// retrieve the Comment to be deleted
	$comment = Comment::getCommentByCommentId($pdo, $id);
	if($comment === null) {
		throw(new RuntimeException("Comment does not exist", 404));
	}

	//enforce the user is signed in and only trying to edit their own comment
	if(empty($_SESSION["comment"]) === true || $_SESSION["comment"]->getCommentId() !== $comment->getCommentId()) {
		throw(new \InvalidArgumentException("You are not allowed to delete this comment", 403));
	}

	// delete comment
	$comment->delete($pdo);
	// update reply
	$reply->message = "Comment deleted OK";
}
} catch(\Exception | \TypeError $exception) {
	$reply->status = $exception->getCode();
	$reply->message = $exception->getMessage();
}

// encode and return to front end
header("Content-type: application/json");
echo json_encode($reply);



