<?php
/**
 * Created by PhpStorm.
 * User: michael
 * Date: 11/5/18
 * Time: 2:08 PM
 */

namespace FamConn\FamilyConnect;

require_once("autoload.php");
require_once(dirname(__DIR__, 2) . "/vendor/autoload.php");

use Ramsey\Uuid\Uuid;
/**
 * This is a lower-level entity linked to users and events
 *
 * @author Michael Bovee <michael.j.bovee@gmail.com>
 * @version 1.0.0
 */
class Task implements \JsonSerializable {
	use ValidateDate;
	use ValidateUuid;
	/**
	 * id for this task, this is the primary key
	 * @var Uuid $taskId
	 */
	private $taskId;
	/**
	 * id for this event associated with this task (if applicable), this is a foreign key
	 * @var Uuid $taskEventId
	 */
	private $taskEventId;
	/**
	 * id for the user associated with this task (if applicable), this is a foreign key
	 * @var Uuid $taskUserId
	 */
	private $taskUserId;
	/**
	 * string content describing task
	 * @var string $taskDescription
	 */
	private $taskDescription;
	/**
	 * date and time before which the task must be completed, in a PHP DateTime object
	 * @var \DateTime $taskDueDate
	 */
	private $taskDueDate;
	/**
	 * tiny int value regarding whether or not task has been completed
	 * @var int $taskIsComplete
	 */
	private $taskIsComplete;
	/**
	 * string value holding name of this task
	 * @var string $taskName
	 */
	private $taskName;

	/**
	 * constructor for this task
	 *
	 * @param string|Uuid $newTaskId if this comment is null or a new comment
	 * @param string|Uuid|null $newTaskEventId if this comment is null or a new comment
	 * @param string|Uuid|null $newTaskUserId if this comment is null or a new comment
	 * @param string $newTaskDescription for content of task description
	 * @param \DateTime $newTaskDueDate for datetime task is due
	 * @param string $newTaskName for name of task
	 * @throws \InvalidArgumentException if data types aren't valid
	 * @throws \RangeException if data values are incorrect lengths
	 * @throws \TypeError if data values are wrong type
	 * @throws \Exception for any others
	 */
	public function __construct($newTaskId, $newTaskEventId = null, $newTaskUserId = null, $newTaskDescription, $newTaskDueDate, $newTaskName) {
		try {
			$this->setTaskId($newTaskId);
			$this->setTaskEventId($newTaskEventId);
			$this->setTaskUserId($newTaskUserId);
			$this->setTaskDescription($newTaskDescription);
			$this->setTaskDueDate($newTaskDueDate);
			$this->setTaskName($newTaskName);
		}
		catch(\InvalidArgumentException | \RangeException | \TypeError | \Exception $exception) {
			$exceptionType = get_class($exception);
			throw(new $exceptionType($exception->getMessage(), 0, $exception));
		}
	}

	/**
	 * accessor method for taskId
	 *
	 * @return Uuid value of taskId
	 */
	public function getTaskId() : Uuid {
		return ($this->taskId);
	}
	/**
	 * mutator method for taskId
	 *
	 *@param Uuid|string $newTaskId new value of task id
	 *@throws \RangeException if $newTaskId is not positive
	 *@throws \TypeError if $newTaskId is not Uuid or string
	 */
	public function setTaskId($newTaskId) : void {
		try {
			$uuid = self::validateUuid($newTaskId);
		} catch(\RangeException | \InvalidArgumentException | \Exception | \TypeError $exception) {
			$exceptionType = get_class($exception);
			throw(new $exceptionType($exception->getMessage(), 0, $exception));
		}
		$this->taskId = $uuid;
	}

	/**
	 * accessor method for taskEventId
	 *
	 * @return Uuid value of taskEventId
	 */
	public function getTaskEventId() : ?Uuid {
		return ($this->taskEventId);
	}
	/**
	 * mutator method for taskEventId
	 *
	 *@param Uuid|string $newTaskEventId new value of task event id
	 *@throws \RangeException if $newTaskEventId is not positive
	 *@throws \TypeError if $newTaskEventId is not Uuid or string
	 */
	public function setTaskEventId($newTaskEventId = null) : void {
		if ($newTaskEventId === null) {
			$this->taskEventId = null;
		}
		try {
			$uuid = self::validateUuid($newTaskEventId);
		} catch(\RangeException | \InvalidArgumentException | \Exception | \TypeError $exception) {
			$exceptionType = get_class($exception);
			throw(new $exceptionType($exception->getMessage(), 0, $exception));
		}
		$this->taskEventId = $uuid;
	}

	/**
	 * accessor method for taskUserId
	 *
	 * @return Uuid value of taskUserId
	 */
	public function getTaskUserId() : ?Uuid {
		return ($this->taskUserId);
	}
	/**
	 * mutator method for taskUserId
	 *
	 *@param Uuid|string $newTaskUserId new value of task user id
	 *@throws \RangeException if $newTaskUserId is not positive
	 *@throws \TypeError if $newTaskUserId is not Uuid or string
	 */
	public function setTaskUserId($newTaskUserId = null) : void {
		if ($newTaskUserId === null) {
			$this->taskUserId = null;
		}
		try {
			$uuid = self::validateUuid($newTaskUserId);
		} catch(\RangeException | \InvalidArgumentException | \Exception | \TypeError $exception) {
			$exceptionType = get_class($exception);
			throw(new $exceptionType($exception->getMessage(), 0, $exception));
		}
		$this->taskUserId = $uuid;
	}


	/**
	 * accessor method for task description
	 *
	 * @return string value of task description
	 */
	public function getTaskDescription() : ?string {
		return ($this->taskDescription);
	}
	/**
	 * mutator method for task description
	 *
	 * @param string $newTaskDescription value of new task description
	 * @throws \InvalidArgumentException if task description is not a string or if it's insecure
	 * @throws \RangeException if length of task description is greater than 512 characters
	 * @throws \TypeError if family name is not a string
	 */
	public function setTaskDescription(string $newTaskDescription) : void {
		$newTaskDescription = trim($newTaskDescription);
		$newTaskDescription = filter_var($newTaskDescription, FILTER_SANITIZE_STRING);
		// verify that the new task description is a string
		if($newTaskDescription === false) {
			throw(new \InvalidArgumentException("new task description is not a string or is insecure"));
		}
		// verify that the new task description is not too long
		if(strlen($newTaskDescription) > 512) {
			throw(new \RangeException("new task description is too long"));
		}
		// store new task description
		$this->taskDescription = $newTaskDescription;
	}

	/**
	 * accessor method for task due date
	 *
	 * @return \DateTime value of task due date
	 */
	public function getTaskDueDate(): \DateTime {
		return($this->taskDueDate);
	}

	/**
	 * mutator method for task due date
	 *
	 * @param \DateTime|string|null $newTaskDueDate task due date as a DateTime object or string (or null to load current time)
	 * @throws \InvalidArgumentException if $newTaskDueDate is not a valid object or string
	 * @throws \RangeException if $newTaskDueDate is a date that does not exist
	 * @throws \Exception
	 */
	public function setTaskDueDate($newTaskDueDate = null) : void {


		try {
			$newTaskDueDate = self::validateDateTime($newTaskDueDate);
		} catch(\InvalidArgumentException | \Exception | \RangeException | \TypeError $exception) {
			$exceptionType = get_class($exception);
			throw(new $exceptionType($exception->getMessage(), 0, $exception));
		}
		$this->taskDueDate = $newTaskDueDate;
	}

	/**
	 * accesor method for task is complete
	 *
	 * @return int value of task is complete
	 */
	public function getTaskIsComplete() : int {
		return ($this->taskIsComplete);
	}
	/**
	 * mutator method for task is complete
	 *
	 * @param int $newTaskIsComplete value of new task is complete
	 * @throws \InvalidArgumentException if task is complete value is not an int or if it's insecure
	 * @throws \RangeException if task is complete value is not equal to 0 or 1
	 * @throws \TypeError if task is complete is no an int
	 */
	public function setTaskIsComplete(int $newTaskIsComplete) {
		// sanitize value
		$newTaskIsComplete = intval($newTaskIsComplete);
		$newTaskIsComplete = filter_var($newTaskIsComplete, FILTER_SANITIZE_NUMBER_INT);
		// verify that the value is an int
		if($newTaskIsComplete === false) {
			throw(new \InvalidArgumentException("new task is complete is not an int or is insecure"));
		}
		// verify that the value is a 0 or a 1
		if(intval($newTaskIsComplete !== 0 || $newTaskIsComplete !== 1)) {
			throw(new \RangeException("value does not fit set parameters"));
		}
		// store the new task is complete value
		$this->taskIsComplete = $newTaskIsComplete;
	}

	/**
	 * accessor method for task name
	 *
	 * @return string value of task name
	 */
	public function getTaskName() : ?string {
		return ($this->taskName);
	}
	/**
	 * mutator method for task name
	 *
	 * @param string $newTaskName value of new task name
	 * @throws \InvalidArgumentException if task name is not a string or if it's insecure
	 * @throws \RangeException if length of task name is greater than 30 characters
	 * @throws \TypeError if task name is not a string
	 */
	public function setTaskName(string $newTaskName) : void {
		$newTaskName = trim($newTaskName);
		$newTaskName = filter_var($newTaskName, FILTER_SANITIZE_STRING);
		// verify that the new task name is a string
		if($newTaskName === false) {
			throw(new \InvalidArgumentException("new task name is not a string or is insecure"));
		}
		// verify that the new task name is not too long
		if(strlen($newTaskName) > 30) {
			throw(new \RangeException("new task name is too long"));
		}
		// store new task name
		$this->taskName = $newTaskName;
	}

	/**
	 * insert this task into mySQL
	 *
	 * @param \PDO $pdo PDO connection object
	 * @throws \PDOException when mySQL related errors happen
	 * @throws \TypeError if $pdo is not a PDO connection object
	 */
	public function insert(\PDO $pdo) : void {
		// create template for query
		$query = "INSERT INTO task(taskId, taskEventId, taskUserId, taskDescription, taskDueDate, taskName) VALUES (:taskId, :taskEventId, :taskUserId, :taskDescription, :taskDueDate, :taskName)";
		$statement = $pdo->prepare($query);

		// wire variables up to their template place holders

		$formattedDate = $this->taskDueDate->format("Y-m-d H:i:s.u");
		$parameters = ["taskId" => $this->taskId->getBytes(), "taskEventId" => $this->taskEventId->getBytes(), "taskUserId" => $this->taskUserId->getBytes(), "taskDescription" => $this->taskDescription, "taskDueDate" => $formattedDate, "taskName" => $this->taskName];
		$statement->execute($parameters);
	}

	/**
	 * deletes this task from mySQL
	 *
	 * @param \PDO $pdo PDO connection object
	 * @throws \PDOException when mySQL related errors occur
	 * @throws \TypeError if $pdo is not a connection object
	 */
	public function delete(\PDO $pdo) : void {
		// create template for query
		$query = "DELETE FROM task WHERE taskId = :taskId";
		$statement = $pdo->prepare($query);

		// wire up variable to template placeholder
		$parameters = ["taskId" => $this->taskId->getBytes()];
		$statement->execute($parameters);
	}

	/**
	 * updates this task in mySQL
	 *
	 * @param \PDO $pdo connection object
	 * @throws \PDOException when mySQL related errors occur
	 * @throws \TypeError if $pdo is not a connection object
	 */
	public function update(\PDO $pdo) : void {
		// create template for query
		$query = "UPDATE task SET taskId = :taskId, taskEventId = :taskEventId, taskUserId = :taskUserId, taskDescription = :taskDescription, taskDueDate = :taskDueDate, taskName = :taskName";
		$statement = $pdo->prepare($query);

		// wire up variables to place holders in query
		$formattedDate = $this->taskDueDate->format("Y-m-d H:i:s.u");
		$parameters = ["taskId" => $this->taskId->getBytes(), "taskEventId" => $this->taskEventId->getBytes(), "taskUserId" => $this->taskUserId->getBytes(), "taskDescription" => $this->taskDescription, "taskDueDate" => $formattedDate, "taskName" => $this->taskName];
		$statement->execute($parameters);
	}

	/**
	 * get task by task id
	 *
	 * @param \PDO $pdo PDO connection object
	 * @param Uuid|string $taskId task id used in query
	 * @return Task|null - task if there's a result, null if there isn't
	 * @throws \PDOException when mySQL errors occur
	 * @throws \TypeError when the variables are not the correct data type
	 */
	public static function getTaskByTaskId(\PDO $pdo, $taskId) : ?Task {
		// sanitize string / Uuid
		try {
			$taskId = self::validateUuid($taskId);
		} catch(\InvalidArgumentException | \RangeException | \Exception | \TypeError $exception) {
			throw(new \PDOException($exception->getMessage(), 0, $exception));
		}

		// create template for new query
		$query = "SELECT taskId, taskEventId, taskUserId, taskDescription, taskDueDate, taskName FROM task WHERE taskId = :taskId";
		$statement = $pdo->prepare($query);

		// wire up variable (taskId) to query
		$parameters = ["taskId" => $taskId->getBytes()];
		$statement->execute($parameters);

		// grab task from mySQL
		try {
			$task = null;
			$statement->setFetchMode(\PDO::FETCH_ASSOC);
			$row = $statement->fetch();
			if($row !== false) {
				$task = new Task($row["taskId"], $row["taskEventId"], $row["taskUserId"], $row["taskDescription"], $row["taskDueDate"], $row["taskName"]);
			}
		} catch(\Exception $exception) {
			throw(new \PDOException($exception->getMessage(), 0, $exception));
		}
		return($task);
	}

	/**
	 * get task by task event id
	 *
	 * @param \PDO $pdo PDO connection object
	 * @param Uuid|string $taskEventId task event id used in query
	 * @return \SplFixedArray SplFixedArray of tasks found
	 * @throws \PDOException when mySQL errors occur
	 * @throws \TypeError when the variables are not the correct data type
	 */

	public static function getTaskByTaskEventId(\PDO $pdo, $taskEventId) : \SplFixedArray {
		// sanitize string / Uuid
		try {
			$taskEventId = self::validateUuid($taskEventId);
		} catch(\InvalidArgumentException | \RangeException | \Exception | \TypeError $exception) {
			throw(new \PDOException($exception->getMessage(), 0, $exception));
		}

		// create template for new query
		$query = "SELECT task.taskId, task.taskEventId, task.taskUserId, task.taskDescription, task.taskDueDate, task.taskName, event.eventName, FROM task INNER JOIN event ON task.taskEventId = event.eventId WHERE taskEventId = :taskEventId";
		$statement = $pdo->prepare($query);

		// wire up variable (taskEventId) to query
		$parameters = ["taskEventId" => $taskEventId->getBytes()];
		$statement->execute($parameters);

		// build array of tasks
		$tasks = new \SplFixedArray($statement->rowCount());
		$statement->setFetchMode(\PDO::FETCH_ASSOC);
		while(($row = $statement->fetch()) !== false) {
			try {
				$task = new Task($row["taskId"], $row["taskEventId"], $row["taskUserId"], $row["taskDescription"], $row["taskDueDate"], $row["taskName"]);
				$tasks[$tasks->key()] = (object) ["task" => $task, "eventName" => $row["eventName"]];
				$tasks->next();
			} catch(\Exception $exception) {
				throw(new \PDOException($exception->getMessage(), 0, $exception));
			}
		}
		return($tasks);
	}

	/**
	 * get task by task user id
	 *
	 * @param \PDO $pdo PDO connection object
	 * @param Uuid|string $taskUserId task user id used in query
	 * @return \SplFixedArray SplFixedArray of tasks found
	 * @throws \PDOException when mySQL errors occur
	 * @throws \TypeError when the variables are not the correct data type
	 */
	public static function getTaskByTaskUserId(\PDO $pdo, $taskUserId) : ?Task {
		// sanitize string / Uuid
		try {
			$taskUserId = self::validateUuid($taskUserId);
		} catch(\InvalidArgumentException | \RangeException | \Exception | \TypeError $exception) {
			throw(new \PDOException($exception->getMessage(), 0, $exception));
		}

		// create template for new query
		$query = "SELECT task.taskId, task.taskEventId, task.taskUserId, task.taskDescription, task.taskDueDate, task.taskName, `user`.userDisplayName FROM task INNER JOIN `user` ON task.taskUserId = `user`.userId WHERE taskUserId = :taskUserId";
		$statement = $pdo->prepare($query);

		// wire up variable (taskUserId) to query
		$parameters = ["taskUserId" => $taskUserId->getBytes()];
		$statement->execute($parameters);

		// build array of tasks
		$tasks = new \SplFixedArray($statement->rowCount());
		$statement->setFetchMode(\PDO::FETCH_ASSOC);
		while(($row = $statement->fetch()) !== false) {
			try {
				$task = new Task($row["taskId"], $row["taskEventId"], $row["taskUserId"], $row["taskDescription"], $row["taskDueDate"], $row["taskName"]);
				$tasks[$tasks->key()] = (object) ["task" => $task, "userName" => $row["userDisplayName"]];
				$tasks->next();
			} catch(\Exception $exception) {
				throw(new \PDOException($exception->getMessage(), 0, $exception));
			}
		}
		return($tasks);
	}

	/**
	 * get task by task due date
	 *
	 * @param \PDO $pdo PDO connection object
	 * @param \DateTime|string $taskDueDate task due date used in query
	 * @return \SplFixedArray SplFixedArray of Tasks found
	 * @throws \PDOException when mySQL errors occur
	 * @throws \TypeError when the variables are not the correct data type
	 */
	//Todo Change method get task by start interval and end interval
	public static function getTaskByTaskDueDate(\PDO $pdo, $taskDueDate) : \SplFixedArray {
		// sanitize string / DateTime
		try {
			$taskDueDate = self::validateDateTime($taskDueDate);
		} catch(\InvalidArgumentException | \RangeException | \Exception | \TypeError $exception) {
			throw(new \PDOException($exception->getMessage(), 0, $exception));
		}

		// create template for new query
		$query = "SELECT taskId, taskEventId, taskUserId, taskDescription, taskDueDate, taskName FROM task WHERE taskDueDate = :taskDueDate OR taskDueDate BETWEEN :taskDueDate AND :taskDueDate ";
		$statement = $pdo->prepare($query);

		// wire up variables to query

		$parameters = ["taskDueDate" => $taskDueDate];
		$statement->execute($parameters);

		// build array of tasks
		$tasks = new \SplFixedArray($statement->rowCount());
		$statement->setFetchMode(\PDO::FETCH_ASSOC);
		while(($row = $statement->fetch()) !== false) {
			try {
				$task = new Task($row["taskId"], $row["taskEventId"], $row["taskUserId"], $row["taskDescription"], $row["taskDueDate"], $row["taskName"]);
				$tasks[$tasks->key()] = $task;
				$tasks->next();
			} catch(\Exception $exception){
				throw(new \PDOException($exception->getMessage(), 0, $exception));
			}
		}
		return($tasks);
	}

	/**
	 * formats the state variables for JSON serialization
	 *
	 * @return array resulting state variables to serialize
	 */
	public function jsonSerialize() : array {
		$fields = get_object_vars($this);

		$fields["taskId"] = $this->taskId->toString();
		$fields["taskEventId"] = $this->taskEventId->toString();
		$fields["taskUserId"] = $this->taskUserId->toString();

		$fields["taskDueDate"] = round(floatval($this->taskDueDate->format("U.u")) * 1000);

		return($fields);
	}

}

