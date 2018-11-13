<?php
namespace FamConn\FamilyConnect\Test;

use FamConn\FamilyConnect\{Family, User, Event};

//grab the class under scrutiny
require_once("FamilyConnectTest.php");
require_once(dirname(__DIR__) . "/autoload.php");

//grab the uuid generator
require_once(dirname(__DIR__, 2) . "/lib/uuid.php");

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

	/**
	 * Create dependent objects before running each test
	 **/
	public final function setUp() : void {
		// run the default setup method first
		parent::setUp();
		$password = "abc123";
		$VALID_USERHASH = password_hash($password, PASSWORD_ARGON2I, ["time_cost" => 384]);
		$VALID_ACTIVATION_TOKEN = "0CB1A0E520F194FF2226441E21CEC775";

		// create and insert a Family to own the test User
		$this->family = new Family(generateUuidV4(), "Johnson");
		$this->family->insert($this->getPDO());

		// create and insert a Family to own the test User
		$this->user = new User(generateUuidV4(), $this->family->getFamilyId(), $VALID_ACTIVATION_TOKEN,
			"https://ubisafe.org/images/mini-clip-avatar-1.png", "joe3", "johnson@gmail.com",
			$VALID_USERHASH, "505-255-3253", "1");
		$this->user->insert($this->getPDO());


		// calculate the date (use the time the unit test was set up)
		$this->VALID_EVENTDATE = new \DateTime();

		// format the event start date to use for testing
		$this->VALID_EVENTSTARTDATE = new \DateTime();
		$this->VALID_EVENTSTARTDATE->sub(new \DateInterval("P10D"));

		// format the event end date to use for testing
		$this->VALID_EVENTENDDATE = new \DateTime();
		$this->VALID_EVENTENDDATE->add(new \DateInterval("P10D"));
	}

	/**
	 * test inserting valid Event and verify that the actual mySQL data matches
	 **/
	public function testInsertValidEvent() : void {
		// count the number of rows and save it for later
		$numRows = $this->getConnection()->getRowCount("event");

		// create a new Event and insert it into mySQL
		$eventId = generateUuidv4();
		$event = new Event($eventId, $this->family->getFamilyId(), $this->user->getUserId(), $this->VALID_EVENTCONTENT,
			$this->VALID_EVENTENDDATE, $this->VALID_EVENTNAME, $this->VALID_EVENTSTARTDATE);
		$event->insert($this->getPDO());

		// grab the data from mySQL and enforce the fields match our expectations
		$pdoEvent = Event::getEventByEventId($this->getPDO(), $event->getEventId());
		$this->assertEquals($numRows + 1, $this->getConnection()->getRowCount("event"));
		$this->assertEquals($pdoEvent->getEventId(), $eventId);
		$this->assertEquals($pdoEvent->getEventFamilyId(), $this->family->getFamilyId());
		$this->assertEquals($pdoEvent->getEventUserId(), $this->user->getUserId());
		$this->assertEquals($pdoEvent->getEventContent(), $this->VALID_EVENTCONTENT);
		$this->assertEquals($pdoEvent->getEventName(), $this->VALID_EVENTNAME);
		//format the date to seconds since the beginning of time to avoid round off error
		$this->assertEquals($pdoEvent->getEventEndDate()->getTimestamp(), $this->VALID_EVENTENDDATE->getTimestamp());
		$this->assertEquals($pdoEvent->getEventStartDate()->getTimestamp(), $this->VALID_EVENTSTARTDATE->getTimestamp());
	}

	/**
	 * test inserting an Event, editing it, and then updating it
	 **/
	public function testUpdateValidEvent() : void {
		// count the number of rows and save it for later
		$numRows = $this->getConnection()->getRowCount("event");

		// create a new Event and insert it into mySQL
		$eventId = generateUuidV4();
		$event = new Event($eventId, $this->family->getFamilyId(), $this->user->getUserId(), $this->VALID_EVENTCONTENT,
			$this->VALID_EVENTENDDATE, $this->VALID_EVENTNAME, $this->VALID_EVENTSTARTDATE);
		$event->update($this->getPDO());

		// edit the Event and update it in mySQL
		$event->setEventContent($this->VALID_EVENTCONTENT2);
		$event->update($this->getPDO());

		// grab the data from mySQL and enforce the fields match our expectations
		$pdoEvent = Event::getEventByEventId($this->getPDO(), $event->getEventId());
		$this->assertEquals($pdoEvent->getEventId(), $eventId);
		$this->assertEquals($numRows + 1, $this->getConnection()->getRowCount("event"));
		$this->assertEquals($pdoEvent->getEventFamilyId(), $this->family->getFamilyId());
		$this->assertEquals($pdoEvent->getEventUserId(), $this->user->getUserId());
		$this->assertEquals($pdoEvent->getEventContent(), $this->VALID_EVENTCONTENT2);
		$this->assertEquals($pdoEvent->getEventName(), $this->VALID_EVENTNAME);
		//format the date to seconds since the beginning of time to avoid round off error
		$this->assertEquals($pdoEvent->getEventEndDate()->getTimestamp(), $this->VALID_EVENTENDDATE->getTimestamp());
		$this->assertEquals($pdoEvent->getEventStartDate()->getTimestamp(), $this->VALID_EVENTSTARTDATE->getTimestamp());
	}

	/**
	 * test creating an Event and then deleting it
	 **/
	public function testDeleteValidEvent() : void {
		// count the number of rows and save it for later
		$numRows = $this->getConnection()->getRowCount("event");

		// create a new Event and insert it into mySQL
		$eventId = generateUuidV4();
		$event = new Event($eventId, $this->family->getFamilyId(), $this->user->getUserId(), $this->VALID_EVENTCONTENT,
			$this->VALID_EVENTENDDATE, $this->VALID_EVENTNAME, $this->VALID_EVENTSTARTDATE);
		$event->update($this->getPDO());

		// delete the Event from mySQL
		$this->assertEquals($numRows + 1, $this->getConnection()->getRowCount("event"));
		$event->delete($this->getPDO());

		// grab the data from mySQL and enforce the Event does not exist
		$pdoEvent = Event::getEventByEventId($this->getPDO(), $event->getEventId());
		$this->assertNull($pdoEvent);
		$this->assertEquals($numRows, $this->getConnection()->getRowCount("event"));
	}

	/**
	 * test grabbing an Event that does not exist
	 **/
	public function testGetInvalidEventByEventId() : void {
		// grab a family id that exceeds the maximum allowable family id
		$event = Event::getEventByEventId($this->getPDO(), generateUuidV4());
		$this->assertNull($event);
	}

	/**
	 * test inserting an Event and regrabbing it from mySQL
	 **/
	public function testGetValidEventByEventFamilyId() {
		// count the number of rows and save it for later
		$numRows = $this->getConnection()->getRowCount("event");

		// create a new Event and insert it into mySQL
		$eventId = generateUuidV4();
		$event = new Event($eventId, $this->family->getFamilyId(), $this->user->getUserId(), $this->VALID_EVENTCONTENT,
			$this->VALID_EVENTENDDATE, $this->VALID_EVENTNAME, $this->VALID_EVENTSTARTDATE);
		$event->insert($this->getPDO());

		// grab the data from mySQL and enforce the fields match our expectations
		$results = Event::getEventByEventFamilyId($this->getPDO(), $event->getEventFamilyId());
		$this->assertEquals($numRows + 1, $this->getConnection()->getRowCount("event"));
		$this->assertCount(1, $results);
		$this->assertContainsOnlyInstancesOf("FamConn\\FamilyConnect\\Event", $results);

		// grab the result from the array and validate it
		$pdoEvent = $results[0];
		$this->assertEquals($pdoEvent->getEventId(), $eventId);
		$this->assertEquals($pdoEvent->getEventFamilyId(), $this->family->getFamilyId());
		$this->assertEquals($pdoEvent->getEventUserId(), $this->user->getUserId());
		$this->assertEquals($pdoEvent->getEventContent(), $this->VALID_EVENTCONTENT);
		$this->assertEquals($pdoEvent->getEventName(), $this->VALID_EVENTNAME);
		// format the date to seconds since the beginning of time to avoid round off error
		$this->assertEquals($pdoEvent->getEventEndDate()->getTimestamp(), $this->VALID_EVENTENDDATE->getTimestamp());
		$this->assertEquals($pdoEvent->getEventStartDate()->getTimestamp(), $this->VALID_EVENTSTARTDATE->getTimestamp());
	}

	/**
	 * test grabbing an Event that does not exist
	 **/
	public function testGetInvalidEventByFamilyId() : void {
		// grab a family id that exceeds the maximum allowable family id
		$event = Event::getEventByEventFamilyId($this->getPDO(), generateUuidV4());
		$this->assertCount(0, $event);
	}

	/**
	 * test inserting an Event and regrabbing it from mySQL
	 **/
	public function testGetValidEventByEventUserId() {
		// count the number of rows and save it for later
		$numRows = $this->getConnection()->getRowCount("event");

		// create a new Event and insert it into mySQL
		$eventId = generateUuidV4();
		$event = new Event($eventId, $this->family->getFamilyId(), $this->user->getUserId(), $this->VALID_EVENTCONTENT,
			$this->VALID_EVENTENDDATE, $this->VALID_EVENTNAME, $this->VALID_EVENTSTARTDATE);
		$event->insert($this->getPDO());

		// grab the data from mySQL and enforce the fields match our expectations
		$results = Event::getEventByEventUserId($this->getPDO(), $event->getEventUserId());
		$this->assertEquals($numRows + 1, $this->getConnection()->getRowCount("event"));
		$this->assertCount(1, $results);
		$this->assertContainsOnlyInstancesOf("FamConn\\FamilyConnect\\Event", $results);

		// grab the result from the array and validate it
		$pdoEvent = $results[0];
		$this->assertEquals($pdoEvent->getEventId(), $eventId);
		$this->assertEquals($pdoEvent->getEventFamilyId(), $this->family->getFamilyId());
		$this->assertEquals($pdoEvent->getEventUserId(), $this->user->getUserId());
		$this->assertEquals($pdoEvent->getEventContent(), $this->VALID_EVENTCONTENT);
		$this->assertEquals($pdoEvent->getEventName(), $this->VALID_EVENTNAME);
		// format the date to seconds since the beginning of time to avoid round off error
		$this->assertEquals($pdoEvent->getEventEndDate()->getTimestamp(), $this->VALID_EVENTENDDATE->getTimestamp());
		$this->assertEquals($pdoEvent->getEventStartDate()->getTimestamp(), $this->VALID_EVENTSTARTDATE->getTimestamp());
	}

	/**
	 * test grabbing an Event that does not exist
	 **/
	public function testGetInvalidEventByUserId() : void {
		// grab a user id that exceeds the maximum allowable user id
		$event = Event::getEventByEventUserId($this->getPDO(), generateUuidV4());
		$this->assertCount(0, $event);
	}

	/**
	* test grabbing an Event by event content
	**/
	public function testGetValidEventByEventContent() : void {
		// count the number of rows and save it for later
		$numRows = $this->getConnection()->getRowCount("event");

		// create a new Event and insert it into mySQL
		$eventId = generateUuidV4();
		$event = new Event($eventId, $this->family->getFamilyId(), $this->user->getUserId(), $this->VALID_EVENTCONTENT,
			$this->VALID_EVENTENDDATE, $this->VALID_EVENTNAME, $this->VALID_EVENTSTARTDATE);
		$event->insert($this->getPDO());

		// grab the data from mySQL and enforce the fields match our expectations
		$results = Event::getEventByEventContent($this->getPDO(), $event->getEventContent());
		$this->assertEquals($numRows + 1, $this->getConnection()->getRowCount("event"));
		$this->assertCount(1, $results);

		// enforce no other objects are bleeding into the test
		$this->assertContainsOnlyInstancesOf("FamConn\\FamilyConnect\\Event", $results);

		// grab the result from the array and validate it
		$pdoEvent = $results[0];
		$this->assertEquals($pdoEvent->getEventId(), $eventId);
		$this->assertEquals($pdoEvent->getEventFamilyId(), $this->family->getFamilyId());
		$this->assertEquals($pdoEvent->getEventUserId(), $this->user->getUserId());
		$this->assertEquals($pdoEvent->getEventContent(), $this->VALID_EVENTCONTENT);
		$this->assertEquals($pdoEvent->getEventName(), $this->VALID_EVENTNAME);
		// format the date to seconds since the beginning of time to avoid round off error
		$this->assertEquals($pdoEvent->getEventEndDate()->getTimestamp(), $this->VALID_EVENTENDDATE->getTimestamp());
		$this->assertEquals($pdoEvent->getEventStartDate()->getTimestamp(), $this->VALID_EVENTSTARTDATE->getTimestamp());
	}

	/**
	 * test grabbing an Event by content that does not exist
	 **/
	public function testGetInvalidEventByEventContent() : void {
		// grab an event by content that does not exist
		$event = Event::getEventByEventContent($this->getPDO(), "Comcast has the best service EVER");
		$this->assertCount(0, $event);
	}

	/**
	* test grabbing an Event by event name
	**/
	public function testGetValidEventByEventName() : void {
		// count the number of rows and save it for later
		$numRows = $this->getConnection()->getRowCount("event");

		// create a new Event and insert it into mySQL
		$eventId = generateUuidV4();
		$event = new Event($eventId, $this->family->getFamilyId(), $this->user->getUserId(), $this->VALID_EVENTCONTENT,
			$this->VALID_EVENTENDDATE, $this->VALID_EVENTNAME, $this->VALID_EVENTSTARTDATE);
		$event->insert($this->getPDO());

		// grab the data from mySQL and enforce the fields match our expectations
		$results = Event::getEventByEventName($this->getPDO(), $event->getEventName());
		$this->assertEquals($numRows + 1, $this->getConnection()->getRowCount("event"));
		$this->assertCount(1, $results);

		// enforce no other objects are bleeding into the test
		$this->assertContainsOnlyInstancesOf("FamConn\\FamilyConnect\\Event", $results);

		// grab the result from the array and validate it
		$pdoEvent = $results[0];
		$this->assertEquals($pdoEvent->getEventId(), $eventId);
		$this->assertEquals($pdoEvent->getEventFamilyId(), $this->family->getFamilyId());
		$this->assertEquals($pdoEvent->getEventUserId(), $this->user->getUserId());
		$this->assertEquals($pdoEvent->getEventContent(), $this->VALID_EVENTCONTENT);
		$this->assertEquals($pdoEvent->getEventName(), $this->VALID_EVENTNAME);
		// format the date to seconds since the beginning of time to avoid round off error
		$this->assertEquals($pdoEvent->getEventEndDate()->getTimestamp(), $this->VALID_EVENTENDDATE->getTimestamp());
		$this->assertEquals($pdoEvent->getEventStartDate()->getTimestamp(), $this->VALID_EVENTSTARTDATE->getTimestamp());
	}

	/**
	 * test grabbing an Event by a name that does not exist
	 **/
	public function testGetInvalidEventByEventName() : void {
		// grab an event by a name that does not exist
		$event = Event::getEventByEventName($this->getPDO(), "Xfinity has the best service EVER");
		$this->assertCount(0, $event);
	}

	/**
 	 * test grabbing all Events
 	 **/
	public function testGetAllValidEvents() : void {
	// count the number of rows and save it for later
	$numRows = $this->getConnection()->getRowCount("event");

	// create a new Event and insert it into mySQL
	$eventId = generateUuidV4();
	$event = new Event($eventId, $this->family->getFamilyId(), $this->user->getUserId(), $this->VALID_EVENTCONTENT,
	$this->VALID_EVENTENDDATE, $this->VALID_EVENTNAME, $this->VALID_EVENTSTARTDATE);
	$event->insert($this->getPDO());

	// grab the data from mySQL and enforce the fields match our expectations
	$results = Event::getAllEvents($this->getPDO());
	$this->assertEquals($numRows + 1, $this->getConnection()->getRowCount("event"));
	$this->assertCount(1, $results);
	$this->assertContainsOnlyInstancesOf("FamConn\\FamilyConnect\\Event", $results);

	// grab the result from the array and validate it
	$pdoEvent = $results[0];
	$this->assertEquals($pdoEvent->getEventId(), $eventId);
	$this->assertEquals($pdoEvent->getEventFamilyId(), $this->family->getFamilyId());
	$this->assertEquals($pdoEvent->getEventUserId(), $this->user->getUserId());
	$this->assertEquals($pdoEvent->getEventContent(), $this->VALID_EVENTCONTENT);
	$this->assertEquals($pdoEvent->getEventName(), $this->VALID_EVENTNAME);
	//format the date to seconds since the beginning of time to avoid round off error
	$this->assertEquals($pdoEvent->getEventEndDate()->getTimestamp(), $this->VALID_EVENTENDDATE->getTimestamp());
	$this->assertEquals($pdoEvent->getEventStartDate()->getTimestamp(), $this->VALID_EVENTSTARTDATE->getTimestamp());
	}

}