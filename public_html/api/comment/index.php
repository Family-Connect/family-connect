<?php
/**
 * Created by PhpStorm.
 * User: felizmunoz
 * Date: 11/26/18
 * Time: 10:30 AM
 */
require_once dirname(__DIR__, 3) . "/vendor/autoload.php";
require_once dirname(__DIR__, 3) . "/php/classes/autoload.php";
require_once dirname(__DIR__, 3) . "/php/lib/xsrf.php";
require_once dirname(__DIR__, 3) . "/php/lib/uuid.php";
require_once("/etc/apache2/capstone-mysql/encrypted-config.php");

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
	$pdo = connectToEncryptedMySQL("/etc/apache2/capstone-mysql/ddctwitter.ini");

	//grab the mySQL connection
	$pdo = connectToEncryptedMySQL("/etc/apache2/capstone-mysql/ddctwitter.ini");

	//determine which HTTP method was used
	$method = $_SERVER["HTTP_X_HTTP_METHOD"] ?? $_SERVER["REQUEST_METHOD"];

	//sanitize input
	$id = filter_input(INPUT_GET, "id", FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES);
	$commentId = filter_input(INPUT_GET, "commentId", FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES);
	$commentEventId = filter_input(INPUT_GET, "commentEventId", FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES);
	$commentTaskId = filter_input(INPUT_GET, "commentTaskId", FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES);
	$commentUserId = filter_input(INPUT_GET, "commentUserId", FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES);
	$commentContent = filter_input(INPUT_GET, "commentContent", FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES);
	$commentDate = filter_input(INPUT_GET, "commentDate", FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES);

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
	verifyXsrf();

	//  make sure commentId is available
	if(empty($requestObject->commentId) === true) {
		throw(new \InvalidArgumentException ("No comment ID.", 405));
	}

	//  make sure commentEventId is available
	if(empty($requestObject->commentEventId) === true) {
		throw(new \InvalidArgumentException ("No comment Event ID.", 405));
	}

	//  make sure commentTaskId is available
	if(empty($requestObject->commentTaskId) === true) {
		throw(new \InvalidArgumentException ("No comment Task ID.", 405));
	}

	//  make sure commentUserId is available
	if(empty($requestObject->commentUserId) === true) {
		throw(new \InvalidArgumentException ("No comment User ID.", 405));
	}

	//perform the actual put or post
	if($method === "PUT") {

		// retrieve the comment to update
		$comment = Comment::getCommentByCommentId($pdo, $id);
		if($comment === null) {
			throw(new RuntimeException("Comment does not exist", 404));
		}

		//enforce the user is signed in and only trying to edit their own comment
		if(empty($_SESSION["comment"]) === true || $_SESSION["comment"]->getcommentId()->toString() !== $comment->getCommentId()->toString()) {
			throw(new \InvalidArgumentException("You are not allowed to edit this comment", 403));
		}

		// update all attributes
		$comment->setCommentEventId($requestObject->commentEventId);
		$comment->setCommentTaskId($requestObject->commentTaskId);
		$comment->setCommentUserId($requestObject->commentUserId);
		$comment->update($pdo);

		// update reply
		$reply->message = "Comment updated OK";
	} else if($method === "POST") {
		// enforce the user is signed in
		if(empty($_SESSION["comment"]) === true) {
			throw(new \InvalidArgumentException("you must be logged in to post comments", 403));
		}

		// create new comment and insert into the database
		$comment = new Comment(generateUuidV4(), $_SESSION["comment"]->getCommentId, $requestObject->commentId, null);
		$comment->insert($pdo);

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
}


