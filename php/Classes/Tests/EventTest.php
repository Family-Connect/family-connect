<?php
namespace FamConn\FamilyConnect\Test;

use FamConn\FamilyConnect\{Event, Family, User};

//grab the class under scrutiny
require_once(dirname(__DIR__) . "/autoload.php");

//grab the uuid generator
require_once(dirname(__DIR__, 2) . "/lib.uuid.php");

/**Full PHPUnit test for the Event class
 *
 *This is a complete PHPUnit test of the Event class. It is complete because *ALL* mySQL/PDO enabled methods are
 * tested for both invalid and valid inputs.
 *
 *@see \FamConn\FamilyConnect\Event
 *@author Sharon Romero <sromero130@cnm.edu>
 **/

class EventTest extends FamilyConnectTest {
	/**
	 * Family that created the event; this is for foreign key relations
	 * @var Family family
	 **/
	protected $family = null;

	/**
	 * User that created the event; this is for foreign key relations
	 * @var User user
	 **/
	protected $user = null;

	/**
	 * content of the Event
	 * @var string $VALID_EVENTCONTENT
	 **/
	protected $VALID_EVENTCONTENT = "PHPUnit test passing";

	/**
	 * content of the updated Event
	 * @var string $VALID_EVENTCONTENT2
	 **/
	protected $VALID_EVENTCONTENT2 = "PHPUnit Test Still Passing";

	/**
	 * end date of the event
	 * @var \DateTime $VALID_EVENTENDDATE
	 **/
	protected $VALID_EVENTENDDATE = null;

	/**
	 * name of the event
	 * @var string $VALID_EVENTNAME
	 **/
	protected $VALID_EVENTNAME = "PHPUnit test passing";

	/**
	 * start date of the event
	 * @var \DateTime $VALID_EVENTSTARTDATE
	 **/
	protected $VALID_EVENTSTARTDATE = null;

}