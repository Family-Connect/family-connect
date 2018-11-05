<?php
/**
 * Created by PhpStorm.
 * User: michael
 * Date: 11/5/18
 * Time: 2:08 PM
 */

namespace ;

require_once("autoload.php");
require_once(dirname(__DIR__, 2) . "/vendor/autoload.php");

use Ramsey\Uuid\Uuid;
/**
 * This is a lower-level entity linked to users and events
 *
 * @author Michael Bovee <michael.j.bovee@gmail.com>
 * @version 1.0.0
 */

class Task {
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
	 * string value holding name of this task
	 * @var string $taskName
	 */
	private $taskName;

	/**
	 * constructor for this task
	 *
	 * @param string|Uuid $newTaskId if this comment is null or a new comment
	 * @param string|Uuid $newTaskEventId if this comment is null or a new comment
	 * @param string|Uuid $newTaskUserId if this comment is null or a new comment
	 * @param string $newTaskDescription for content of task description
	 * @param \DateTime $newTaskDueDate for datetime task is due
	 * @param string $newTaskName for name of task
	 * @throws \InvalidArgumentException if data types aren't valid
	 * @throws \RangeException if data values are incorrect lengths
	 * @throws \TypeError if data values are wrong type
	 * @throws \Exception for any others
	 */
	public function __construct($newTaskId, $newTaskEventId, $newTaskUserId, $newTaskDescription, $newTaskDueDate, $newTaskName) {
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
		$this->taskId = $newTaskId;
	}

}