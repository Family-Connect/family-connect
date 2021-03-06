<?php
/**
 * Created by PhpStorm.
 * User: michael
 * Date: 11/9/18
 * Time: 8:28 AM
 */

namespace FamConn\FamilyConnect\Test;

use FamConn\FamilyConnect\{Family, Task, Event, User};

require_once("FamilyConnectTest.php");

// grab class to be tested
require_once(dirname(__DIR__) . "/autoload.php");

// grab uuid generator
require_once(dirname(__DIR__, 2) . "/lib/uuid.php");

/**
 * Full PHPUnit test for Task class
 *
 * This PHPUnit test is complete insofar as it tests all mySQL/PDO methods with valid and invalid inputs.
 *
 * @see \FamConn\FamilyConnect\Task
 * @author Michael Bovee <michael.j.bovee@gmail.com>
 */

class TaskTest extends FamilyConnectTest {

	/**
	 * Family linked to the Task; this is for foreign key relations
	 * @var Event event
	 */
	protected $family = null;
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
	 * valid content for task
	 * @var $VALID_EVENTCONTENT
	 */
	protected $VALID_EVENTCONTENT = "PHPUnit test is still going on";


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
	protected $VALID_TASKISCOMPLETE;

	/**
	 * valid value indicating whether or not task has been completed
	 * @var $VALID_TASKISCOMPLETE2
	 */
	protected $VALID_TASKISCOMPLETE2;

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
	 * @var $VALID_STARTINTERVAL
	 */
	protected $VALID_STARTINTERVAL = null;

	/**
	 * valid timestampt to use as sunsetTaskDueDate
	 * @var $VALID_ENDINTERVAL
	 */
	protected $VALID_ENDINTERVAL = null;

	/**
	 * valid user privilege for user linked with task
	 * @var $VALID_USERPRIVILEGE
	 */
	protected $VALID_USERPRIVILEGE;

	/**
	 * valid activation token for user linked with task
	 * @var $VALID_USERACTIVATIONTOKEN
	 */
	protected $VALID_USERACTIVATIONTOKEN;

	/**
	 * valid userHash to create user object to own the test
	 * @var $VALID_USERHASH
	 */
	protected $VALID_USERHASH;

	/**
	 * create dependent objects before running each test
	 * @throws \Exception
	 */
	public final function setUp() : void {
		parent::setUp();
		$password = "abc123";
		$this->taskId = generateUuidV4();
		$this->VALID_USERHASH = password_hash($password, PASSWORD_ARGON2I, ["time_cost" => 384]);
		$this->VALID_USERACTIVATIONTOKEN = "0CB1A0E520F194FF2226441E21CEC775";
		$this->VALID_USERPRIVILEGE = intval(1);
		$this->VALID_TASKISCOMPLETE = intval(1);
		$this->VALID_TASKISCOMPLETE2 = intval(1);

		// calculate dates (just use time of test)
		$this->VALID_TASKDUEDATE = new \DateTime();
		$this->VALID_EVENTENDDATE = new \DateTime();
		$this->VALID_EVENTSTARTDATE = new \DateTime();

		// format sunrise date to use for testing
		$this->VALID_STARTINTERVAL = new \DateTime();
		$this->VALID_STARTINTERVAL->sub(new \DateInterval("P10D"));

		// format sunset date to use for testing
		$this->VALID_ENDINTERVAL = new \DateTime();
		$this->VALID_ENDINTERVAL->add(new \DateInterval("P10D"));

		//create and insert family to be connected with event
		$familyId = generateUuidV4();
		$this->family = new Family($familyId, "family name");
		$this->family->insert($this->getPDO());

		// create and insert user to be connected with the test Task and event
		$userId = generateUuidV4();
		$this->user = new User($userId, $familyId, $this->VALID_USERACTIVATIONTOKEN, "hello", "display name", "email@email.com", $this->VALID_USERHASH, "5055055005", $this->VALID_USERPRIVILEGE);
		$this->user->insert($this->getPDO());

		// create and insert event to be connected with the test Task
		$eventId = generateUuidV4();
		$this->event = new Event($eventId, $familyId, $userId, $this->VALID_EVENTCONTENT, $this->VALID_EVENTENDDATE, "event name", $this->VALID_EVENTSTARTDATE);
		$this->event->insert($this->getPDO());
	}

	/**
	 * test inserting a valid Task and see if the mySQL data matches expectations
	 * @throws \Exception
	 */
	public function testInsertValidTask() : void {
		// count the number of rows and save for later
		$numRows = $this->getConnection()->getRowCount("task");

		// create a new Task and insert into mySQL
		$taskId = generateUuidV4();
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
	 * @throws \Exception
	 */
	public function testUpdateValidTask() : void {
		// count the number of rows and save for later
		$numRows = $this->getConnection()->getRowCount("task");

		// create a new Task and insert into mySQL
		$taskId = generateUuidV4();
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
		$this->assertEquals($pdoTask->getTaskIsComplete(), $this->VALID_TASKISCOMPLETE2);
		$this->assertEquals($pdoTask->getTaskName(), $this->VALID_TASKNAME2);
	}

	/**
	 * test creating a task and then deleting it
	 * @throws \Exception
	 */
	public function testDeleteValidTask() : void {
		// count the number of rows and save for later
		$numRows = $this->getConnection()->getRowCount("task");

		// create a new Task and insert into mySQL
		$taskId = generateUuidV4();
		$task = new  Task($taskId, $this->event->getEventId(), $this->user->getUserId(), $this->VALID_TASKDESCRIPTION, $this->VALID_TASKDUEDATE, $this->VALID_TASKISCOMPLETE, $this->VALID_TASKNAME);
		$task->insert($this->getPDO());

		// delete the task from mySQL
		$this->assertEquals($numRows + 1, $this->getConnection()->getRowCount("task"));
		$task->delete($this->getPDO());

		// grab the data from mySQL and make sure the task doesn't exist
		$pdoTask = Task::getTaskByTaskId($this->getPDO(), $task->getTaskId());
		$this->assertNull($pdoTask);
		$this->assertEquals($numRows, $this->getConnection()->getRowCount("task"));
	}

	/**
	 * test creating a Task and retreiving it by task event id
	 * @throws \Exception
	 */
	public function testGetValidTaskByTaskEventId() {
		// count the number of rows and save for later
		$numRows = $this->getConnection()->getRowCount("task");

		// create a new Task and insert into mySQL
		$taskId = generateUuidV4();
		$task = new Task($taskId, $this->event->getEventId(), $this->user->getUserId(), $this->VALID_TASKDESCRIPTION, $this->VALID_TASKDUEDATE, $this->VALID_TASKISCOMPLETE, $this->VALID_TASKNAME);
		$task->insert($this->getPDO());

		// grab data from mySQL and make sure the fields match expectations
		$results = Task::getTaskByTaskEventId($this->getPDO(), $task->getTaskEventId());
		$this->assertEquals($numRows + 1, $this->getConnection()->getRowCount("task"));
		$this->assertCount(1, $results);

		// grab the result from an array and validate it
		$pdoTask = $results[0];


		$this->assertEquals($pdoTask->task->getTaskId(), $taskId);
		$this->assertEquals($pdoTask->task->getTaskEventId(), $this->event->getEventId());
		$this->assertEquals($pdoTask->task->getTaskUserId(), $this->user->getUserId());
		$this->assertEquals($pdoTask->task->getTaskDescription(), $this->VALID_TASKDESCRIPTION);
		// format date to seconds since the beginning of time to avoid rounding error
		$this->assertEquals($pdoTask->task->getTaskDueDate()->getTimestamp(), $this->VALID_TASKDUEDATE->getTimestamp());
		$this->assertEquals($pdoTask->task->getTaskIsComplete(), $this->VALID_TASKISCOMPLETE);
		$this->assertEquals($pdoTask->task->getTaskName(), $this->VALID_TASKNAME);



	}

	/**
	 * test creating a Task and retreiving it by task user id
	 * @throws \Exception
	 */
	public function testGetValidTaskByTaskUserId() {
		// count the number of rows and save for later
		$numRows = $this->getConnection()->getRowCount("task");

		// create a new Task and insert into mySQL
		$taskId = generateUuidV4();
		$task = new Task($taskId, $this->event->getEventId(), $this->user->getUserId(), $this->VALID_TASKDESCRIPTION, $this->VALID_TASKDUEDATE, $this->VALID_TASKISCOMPLETE, $this->VALID_TASKNAME);
		$task->insert($this->getPDO());

		// grab data from mySQL and make sure the fields match expectations
		$results = Task::getTaskByTaskUserId($this->getPDO(), $task->getTaskUserId());
		$this->assertEquals($numRows + 1, $this->getConnection()->getRowCount("task"));
		$this->assertCount(1, $results);

		// grab the result from an array and validate it
		$pdoTask = $results[0];

		$this->assertEquals($pdoTask->task->getTaskId(), $taskId);
		$this->assertEquals($pdoTask->task->getTaskEventId(), $this->event->getEventId());
		$this->assertEquals($pdoTask->task->getTaskUserId(), $this->user->getUserId());
		$this->assertEquals($pdoTask->task->getTaskDescription(), $this->VALID_TASKDESCRIPTION);
		// format date to seconds since the beginning of time to avoid rounding error
		$this->assertEquals($pdoTask->task->getTaskDueDate()->getTimestamp(), $this->VALID_TASKDUEDATE->getTimestamp());
		$this->assertEquals($pdoTask->task->getTaskIsComplete(), $this->VALID_TASKISCOMPLETE);
		$this->assertEquals($pdoTask->task->getTaskName(), $this->VALID_TASKNAME);
	}

	/**
	 * test creating a Task and grabbing it by its task due date value
	 * @throws \Exception
	 */
	public function testGetValidTaskByTaskDueDate() : void {
		// count the number of rows and save for later
		$numRows = $this->getConnection()->getRowCount("task");

		// create a new Task and insert into mySQL
		$taskId = generateUuidV4();
		$task = new Task($taskId, $this->event->getEventId(), $this->user->getUserId(), $this->VALID_TASKDESCRIPTION, $this->VALID_TASKDUEDATE, $this->VALID_TASKISCOMPLETE, $this->VALID_TASKNAME);
		$task->insert($this->getPDO());

		// grab the data from mySQL and make sure the fields match expectations
		$results = Task::getTaskByTaskDueDate($this->getPDO(),$this->VALID_STARTINTERVAL, $this->VALID_ENDINTERVAL);
		$this->assertEquals($numRows + 1, $this->getConnection()->getRowCount("task"));
		$this->assertCount(1, $results);

		// grab the result from an array and validate it
		$pdoTask = $results[0];

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
	 * test creating a Task and grabbing it by its task is complete value
	 * @throws \Exception
	 */
	public function testGetValidTaskByTaskIsComplete() : void {
		// count the number of rows and save for later
		$numRows = $this->getConnection()->getRowCount("task");

		// create a new Task and insert into mySQL
		$taskId = generateUuidV4();
		$task = new Task($taskId, $this->event->getEventId(), $this->user->getUserId(), $this->VALID_TASKDESCRIPTION, $this->VALID_TASKDUEDATE, $this->VALID_TASKISCOMPLETE, $this->VALID_TASKNAME);
		$task->insert($this->getPDO());

		// grab the data from mySQL and make sure the fields match expectations
		$results = Task::getTaskByTaskIsComplete($this->getPDO(),$task->getTaskIsComplete());
		$this->assertEquals($numRows + 1, $this->getConnection()->getRowCount("task"));
		$this->assertCount(1, $results);

		// grab the result from an array and validate it
		$pdoTask = $results[0];

		$this->assertEquals($pdoTask->task->getTaskId(), $taskId);
		$this->assertEquals($pdoTask->task->getTaskEventId(), $this->event->getEventId());
		$this->assertEquals($pdoTask->task->getTaskUserId(), $this->user->getUserId());
		$this->assertEquals($pdoTask->task->getTaskDescription(), $this->VALID_TASKDESCRIPTION);
		// format date to seconds since the beginning of time to avoid rounding error
		$this->assertEquals($pdoTask->task->getTaskDueDate()->getTimestamp(), $this->VALID_TASKDUEDATE->getTimestamp());
		$this->assertEquals($pdoTask->task->getTaskIsComplete(), $this->VALID_TASKISCOMPLETE);
		$this->assertEquals($pdoTask->task->getTaskName(), $this->VALID_TASKNAME);
	}
}
