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
	 * valid userHash to create user object to own the test
	 */
	protected $VALID_USERHASH;

	/**
	 * timestamp to use as eventEndDate; starts as null, value assigned later
	 */
	protected $VALID_EVENTENDDATE;

		/**
		 * timestamp to use as eventStartDate; starts as null, value assigned later
		 */
	protected $VALID_EVENTSTARTDATE;

	/**
	 * Timestamp of when this task is due; this starts as null, value is assigned later
	 * @var \DateTime $VALID_TASKDUEDATE
	 */
	protected $VALID_TASKDUEDATE = null;

	/**
	 * valid timestamp to use as sunriseTaskDueDate
	 */
	protected $VALID_SUNRISEDATE = null;

	/**
	 * valid timestampt to use as sunsetTaskDueDate
	 */
	protected $VALID_SUNSETDATE = null;

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


}