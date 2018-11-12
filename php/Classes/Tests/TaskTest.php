<?php
/**
 * Created by PhpStorm.
 * User: michael
 * Date: 11/9/18
 * Time: 8:28 AM
 */

namespace FamConn\FamilyConnect\Test;

use FamConn\FamilyConnect\{Task, Event, User};

// grab class to be tested
require_once(dirname(__DIR__) . "/autoload.php");

// grab uuid generator
//require_once(dirname(__DIR__, 2) . "/");

/**
 * Full PHPUnit test for Task class
 *
 * This PHPUnit test is complete in that it tests all mySQL/PDO methods with valid and invalid inputs.
 *
 * @see \FamConn\FamilyConnect\Task
 * @author Michael Bovee <michael.j.bovee@gmail.com>
 */

class TaskTest extends FamilyConnectTest {

	/**
	 * Event linked to the Task; this is for foreign key relations
	 * @var Event event
	 */
	protected $event = null;

	/**
	 * User linked with the Task; this is also for foreign key relations
	 * @var User user
	 */
	protected $user = null;

	/**
	 * timestamp to use as eventEndDate; starts as null, value assigned later
	 * @var $VALID_EVENTENDDATE
	 */
	protected $VALID_EVENTENDDATE = null;

		/**
		 * timestamp to use as eventStartDate; starts as null, value assigned later
		 * @var $VALID_EVENTSTARTDATE
		 */
	protected $VALID_EVENTSTARTDATE = null;

	/**
	 * valid description for task
	 * @var $VALID_TASKDESCRIPTION
	 */
	protected $VALID_TASKDESCRIPTION = "PHPUnit test is passing";

	/**
	 * Timestamp of when this task is due; this starts as null, value is assigned later
	 * @var \DateTime $VALID_TASKDUEDATE
	 */
	protected $VALID_TASKDUEDATE = null;

	/**
	 * valid value indicating whether or not task has been completed
	 * @var $VALID_TASKISCOMPLETE
	 */
	protected $VALID_TASKISCOMPLETE = "0";

	/**
	 * valid value indicating whether or not task has been completed
	 * @var $VALID_TASKISCOMPLETE2
	 */
	protected $VALID_TASKISCOMPLETE2 = "1";

	/**
	 * valid name for task
	 * @var $VALID_TASKNAME
	 */
	protected $VALID_TASKNAME = "PHPUnit test is passing";

	/**
	 * valid updated task name
	 * @var $VALID_TASKNAME2
	 */
	protected $VALID_TASKNAME2 = "PHPUnit test is still passing";

	/**
	 * valid timestamp to use as sunriseTaskDueDate
	 * @var $VALID_SUNRISEDATE
	 */
	protected $VALID_SUNRISEDATE = null;

	/**
	 * valid timestampt to use as sunsetTaskDueDate
	 * @var $VALID_SUNSETDATE
	 */
	protected $VALID_SUNSETDATE = null;

	/**
	 * valid userHash to create user object to own the test
	 * @var $VALID_USERHASH
	 */
	protected $VALID_USERHASH;

	/**
	 * create dependent objects before running each test
	 */
	public final function setUp() : void {
		parent::setUp();
		$password = "abc123";
		$this->VALID_USERHASH = password_hash($password, PASSWORD_ARGON2I, ["time_cost" => 384]);

		// create and insert event to be connected with the test Task
		$this->event = new Event(generateUuidV4, generateUuidV4, generateUuidV4, null, $this->VALID_EVENTENDDATE, "event name", $this->VALID_EVENTSTARTDATE);
		$this->event->insert($this->getPDO());

		// create and insert user to be connected with the test Task
		$this->user = new User(generateUuidV4, generateUuidV4, null, null, "display name", "email@email.com", $this->VALID_USERHASH, null, "0");
		$this->user->insert($this->getPDO());

		// calculate dates (just use time of test)
		$this->VALID_TASKDUEDATE = new \DateTime();
		$this->VALID_EVENTENDDATE = new \DateTime();
		$this->VALID_EVENTSTARTDATE = new \DateTime();

		// format sunrise date to use for testing
		$this->VALID_SUNRISEDATE = new \DateTime();
		$this->VALID_SUNRISEDATE->sub(new \DateInterval("P10D"));

		// format sunset date to use for testing
		$this->VALID_SUNSETDATE = new \DateTime();
		$this->VALID_SUNSETDATE->add(new \DateInterval("P10D"));
	}

	/**
	 * test inserting a valid Task and see if the mySQL data matches expectations
	 */
	public function testInsertValidTask() : void {
		// count the number of rows and save for later
		$numRows = $this->getConnection()->getRowCount("task");

		// create a new Task and insert into mySQL
		$taskId = generateUuid4;
		$task = new Task($taskId, $this->event->getEventId(), $this->user->getUserId(), $this->VALID_TASKDESCRIPTION, $this->VALID_TASKDUEDATE, $this->VALID_TASKISCOMPLETE, $this->VALID_TASKNAME);
		$task->insert($this->getPDO());

		// grab data from mySQL and make sure the fields match expectations
		$pdoTask = Task::getTaskByTaskId($this->getPDO(), $task->getTaskId());
		$this->assertEquals($numRows + 1, $this->getConnection()->getRowCount("task"));
		$this->assertEquals($pdoTask->getTaskId(), $taskId);
		$this->assertEquals($pdoTask->getTaskEventId(), $this->event->getEventId());
		$this->assertEquals($pdoTask->getTaskUserId(), $this->user->getUserId());
		$this->assertEquals($pdoTask->getTaskDescription(), $this->VALID_TASKDESCRIPTION);
		// format date to seconds since the beginning of time to avoid rounding error
		$this->assertEquals($pdoTask->getTaskDueDate()->getTimestamp(), $this->VALID_TASKDUEDATE->getTimestamp());
		$this->assertEquals($pdoTask->getTaskIsComplete(), $this->VALID_TASKISCOMPLETE);
		$this->assertEquals($pdoTask->getTaskName(), $this->VALID_TASKNAME);
	}

	/**
	 * test inserting, editing, and updating a valid task
	 */
	public function testUpdateValidTask() : void {
		// count the number of rows and save for later
		$numRows = $this->getConnection()->getRowCount("task");

		// create a new Task and insert into mySQL
		$taskId = generateUuid4;
		$task = new Task($taskId, $this->event->getEventId(), $this->user->getUserId(), $this->VALID_TASKDESCRIPTION, $this->VALID_TASKDUEDATE, $this->VALID_TASKISCOMPLETE, $this->VALID_TASKNAME);
		$task->insert($this->getPDO());

		// edit the task and update it in mySQL -- let's see if both variables are changed
		$task->setTaskName($this->VALID_TASKNAME2);
		$task->setTaskIsComplete($this->VALID_TASKISCOMPLETE2);
		$task->update($this->getPDO());

		// grab data from mySQL and make sure the fields match expectations
		$pdoTask = Task::getTaskByTaskId($this->getPDO(), $task->getTaskId());
		$this->assertEquals($numRows + 1, $this->getConnection()->getRowCount("task"));
		$this->assertEquals($pdoTask->getTaskId(), $taskId);
		$this->assertEquals($pdoTask->getTaskEventId(), $this->event->getEventId());
		$this->assertEquals($pdoTask->getTaskUserId(), $this->user->getUserId());
		$this->assertEquals($pdoTask->getTaskDescription(), $this->VALID_TASKDESCRIPTION);
		// format date to seconds since the beginning of time to avoid rounding error
		$this->assertEquals($pdoTask->getTaskDueDate()->getTimestamp(), $this->VALID_TASKDUEDATE->getTimestamp());
		$this->assertEquals($pdoTask->getTaskIsComplete(), $this->VALID_TASKISCOMPLETE);
		$this->assertEquals($pdoTask->getTaskName(), $this->VALID_TASKNAME);
	}

}