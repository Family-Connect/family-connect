<?php
namespace sharonromero\FamilyConnect;

require_once(dirname(__DIR__, 2) . "/vendor/autoload.php");
require_once("autoload.php");

use Ramsey\Uuid\Uuid;

/**
 * This shows what a user sees when they go to the website.
 *
 * @author Sharon Romero <sromero130@cnm.edu>
 * @version 1.0.0
 **/
class Event {
use ValidateUuid;
/**id for the Event, this is the primary key.
* @var uuid eventId
**/
private $eventId;
/**
* id of the event that the family creates; this is a foreign key.
* @var uuid $eventFamilyId;
**/
private $eventFamilyId;
/**
* id of the event that the user creates; this is a foreign key.
* @var $eventUserId;
**/
private $eventUserId;
/**
*content of the event.
* @var string $eventContent;
**/
private $eventContent;
	/**
	 * End date for the event.
	 * @var $eventEndDate
	**/
private $eventEndDate;
	/**
	 * Name of the event
	 * @var $eventName
	**/
private $eventName;
	/**
	 * This is the start date of the event.
	 * @var $eventStartDate
	**/
private $eventStartDate;



public function __construct($newEventId, $newEventFamilyId, $newEventUserId, string $newEventContent, $newEventEndDate,
									 $newEventName,$newEventStartDate) {
	try {
		$this->setEventId($newEventId);
		$this->setEventFamilyId($newEventFamilyId);
		$this->setEventUserId($newEventUserId);
		$this->setEventContent($newEventContent);
		$this->setEventEndDate($newEventEndDate);
		$this->setEventName($newEventName);
		$this->setEventStartDate($newEventStartDate);
	} //determine what exception was thrown
	catch(\InvalidArgumentException | \RangeException | \Exception | \TypeError $exception) {
		$exceptionType = get_class($exception);
		throw(new $exceptionType($exception->getMessage(), 0, $exception));
	}
}