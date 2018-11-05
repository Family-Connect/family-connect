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
}