<?php

require_once(dirname(__DIR__, 3). "/vendor/autoload.php");
require_once(dirname(__DIR__, 3). "/php/Classes/autoload.php");
require_once(dirname(__DIR__, 3). "/php/lib/jwt.php");
require_once(dirname(__DIR__, 3). "/php/lib/xsrf.php");
require_once(dirname(__DIR__, 3). "/php/lib/uuid.php");

require_once ("/etc/apache2/capstone-mysql/Secrets.php");

use FamConn\FamilyConnect\{Task, Family, Event, User};

/**
 * API for Task
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
	$secrets = new \Secrets("/etc/apache2/capstone-mysql/cohort22/familyconnect");
	$pdo = $secrets->getPdoObject();

	// determine which HTTP method was used
	$method = $_SERVER["HTTP_X_HTTP_METHOD"] ?? $_SERVER["REQUEST_METHOD"];

	// sanitize input
	$id = filter_input(INPUT_GET, "id", FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES);
	$taskEventId = filter_input(INPUT_GET, "taskEventId", FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES);
	$taskUserId = filter_input(INPUT_GET, "taskUserId", FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES);
	$taskDescription = filter_input(INPUT_GET, "taskDescription", FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES);
	$taskDueDate = filter_input(INPUT_GET, "taskDueDate", FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES);
	$taskStartInterval = filter_input(INPUT_GET, "taskStartInterval", FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES);
	$taskEndInterval = filter_input(INPUT_GET, "taskEndInterval", FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES);
	$taskIsComplete = filter_input(INPUT_GET, "taskIsComplete", FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES);
	$taskName = filter_input(INPUT_GET, "taskName", FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES);



	// verify id is valid for methods requiring it
	if(($method === "DELETE" || $method === "PUT") && (empty($id) === true)) {
		throw(new \InvalidArgumentException("id cannot be empty or negative", 405));
	}

	if($method === "GET") {
		// set XSRF cookie
		setXsrfCookie();

		//gets task by content
		if(empty($id) === false) {
			$reply->data = Task::getTaskByTaskId($pdo, $id);
		} else if(empty($taskEventId) === false) {
			$reply->data = Task::getTaskByTaskEventId($pdo, $taskEventId)->toArray();
		} else if(empty($taskUserId) === false) {
			$reply->data = Task::getTaskByTaskUserId($pdo, $taskUserId)->toArray();
		} else if(empty($taskStartInterval) === false || empty($taskEndInterval) === false) {
			$reply->data = Task::getTaskByTaskDueDate($pdo, $taskStartInterval, $taskEndInterval);
		} else if(empty($taskIsComplete) === false) {
			$reply->data = Task::getTaskByTaskIsComplete($pdo, $taskIsComplete);
		} else if(empty($taskName) === false) {
			$reply->data = Task::getTaskByTaskName($pdo, $taskName);
		}

	} else if($method === "PUT" || $method === "POST") {
		// verify user has XSRF token
		verifyXsrf();

		// verify that the user adding/editing the task is a member of the correct family
		$task = Task::getTaskByTaskId($pdo, $id);
		$user = User::getUserByUserId($pdo, $task->getTaskUserId());

		if(empty($_SESSION["user"]) === true || ($_SESSION["user"]->getUserByUserId()->getUserFamilyId()->toString() !== $user->getUserFamilyId()->toString())) {
			throw(new \InvalidArgumentException("You are not allowed to post or edit this task", 403));
		}

		$requestContent = file_get_contents("php://input");
		$requestObject = json_decode($requestContent);


		// verify the date is accurate
		if(empty($requestObject->taskDueDate) === true) {
			$requestObject->taskDueDate = null;
		}

		// perform the actual put or post
		if($method === "PUT") {

			// verify the user has the correct privileges
			if($_SESSION["user"]->getUserPrivilege === 0) {
				throw(new \InvalidArgumentException("You are not authorized to make, edit, or delete tasks", 405));
			}

			// retrieve task to update
			$task = Task::getTaskByTaskId($pdo, $id);
			if($task === null) {
				throw(new RuntimeException("Task does not exist", 404));
			}

			// verify the user has a JWT token
			validateJwtHeader();

			// update all attributes
			$task->setTaskEventId($requestObject->taskEventId);
			$task->setTaskUserId($requestObject->taskUserId);
			$task->setTaskDescription($requestObject->taskDescription);
			$task->setTaskDueDate($requestObject->taskDueDate);
			$task->setTaskIsComplete($requestObject->taskIsComplete);
			$task->setTaskName($requestObject->taskName);
			$task->update($pdo);

			// update reply
			$reply->message = "Task updated successfully";

		} else if($method === "POST") {

			// verify the user has a JWT token
			validateJwtHeader();

			// create new task and insert into the database

			$task = new Task(generateUuidV4(), $requestObject->taskEventId, $requestObject->taskUserId, $requestObject->taskDescription, $requestObject->taskDueDate, $requestObject->taskIsComplete, $requestObject->taskName);
			$task->insert($pdo);

			// update reply
			$reply->message = "Task created successfully";
		}
	} else if($method === "DELETE") {

		// verify the user has XSRF togen
		verifyXsrf();

		// retrieve task to be deleted
		$task = Task::getTaskByTaskId($pdo, $id);
		if($task === null) {
			throw(new RuntimeException("Task does not exist", 404));
		}

		// verify the user is signed in and only trying to edit their own task
		//if(empty($_SESSION["user"]) === true || $_SESSION["user"]->getUserId()->toString() !== $task->getTaskUserId()->toString()) {
		//	throw(new \InvalidArgumentException("You are not allowed to delete this task", 403));
		//}

		// verify the user has a JWT token
		validateJwtHeader();

		// delete task
		$task->delete($pdo);

		// update reply
		$reply->message = "Task deleted successfully";
	} else {
		throw(new \InvalidArgumentException("Invalid HTTP method request", 418));
	}
// update the $reply->status $reply->message
} catch(\Exception | \TypeError $exception) {
	$reply->status = $exception->getCode();
	$reply->message = $exception->getMessage();
}

// encode and return to front end
header("Content-type: application/json");
echo json_encode($reply);
