<?php
/**
 * Created by PhpStorm.
 * User: michael
 * Date: 11/9/18
 * Time: 8:28 AM
 */

namespace FamConn\FamilyConnect\Test

use FamConn\FamilyConnect\{Task, Event, User};

// grab class to be tested
require_once(dirname(__DIR__) . "/autoload.php");

// grab uuid generator
require_once(dirname(__DIR__, 2) . "/");

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
	 * Timestamp of when this task is due; this starts as null, value is assigned later
	 * @var \DateTime $VALID_TASKDUEDATE
	 */
	protected $VALID_TASKDUEDATE = null;
}