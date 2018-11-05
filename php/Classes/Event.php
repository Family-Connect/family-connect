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
	 * @var uuid $eventFamilyId ;
	 **/
	private $eventFamilyId;
	/**
	 * id of the event that the user creates; this is a foreign key.
	 * @var $eventUserId ;
	 **/
	private $eventUserId;
	/**
	 *content of the event.
	 * @var string $eventContent ;
	 **/
	private $eventContent;
	/**
	 * End date for the event.
	 * @var \DateTime $eventEndDate
	 **/
	private $eventEndDate;
	/**
	 * Name of the event
	 * @var $eventName
	 **/
	private $eventName;
	/**
	 * This is the start date of the event.
	 * @var \DateTime $eventStartDate
	 **/
	private $eventStartDate;
	/**
	 * constructor for event class
	 * @param uuid $newEventId id of this event or null if new event
	 * @param uuid $newEventFamilyId id of the family channel the event is tied to
	 * @param uuid $newEventUserId id of the user who created the event
	 * @param string $newEventContent string containing the content of the event
	 * @param \DateTime $newEventEndDate string containing the end date of the event
	 * @param string $newEventName string containing the name of the event
	 * @param \DateTime $newEventStartDate string containing the start date of the event
	 **/
	public function __construct($newEventId, $newEventFamilyId, $newEventUserId, string $newEventContent, $newEventEndDate,
										 $newEventName, $newEventStartDate) {
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

	/**
	 * accessor method for event id
	 *
	 * @return Uuid value for eventId
	 **/
	public function getEventId(): Uuid {
		return ($this->eventId);

		//this outside of class
		//$event->get event id();
	}

	/**
	* mutator method for event id
	* @param uuid $newEventId new value of event id
	* @throws \RangeException if $newEventId is not positive
	* @throws \TypeError if $newEventId is not a uuid
	**/
	public function setEventId($newEventId): void {
		try {
			$uuid = self::validateUuid($newEventId);
		} catch(\InvalidArgumentException | \RangeException | \Exception | \TypeError $exception) {
		}

		//convert and store the article id
		$this->eventId = $uuid;
	}

/**
* accessor method for event family id
*
* @return uuid value for event family
**/
	public function getEventFamilyId(): uuid {
		return ($this->eventFamilyId);
	}

/**
 * mutator method for event family id
 * @param string | Uuid $newEventFamilyId new value of event family id
 * @throws \RangeException if $newEventFamilyId is not positive
 * @throws \TypeError if $newEventFamilyId is not an integer
 **/

	public function setEventFamilyId($newEventFamilyId): void {
		try {
			$uuid = self::validateUuid($newEventFamilyId);
		} catch
		(\InvalidArgumentException | \RangeException | \Exception | \TypeError $exception) {
			$exceptionType = get_class($exception);
			throw(new $exceptionType($exception->getMessage(), 0, $exception));
		}
		// convert and store the event family id
		$this->eventFamilyId = $uuid;
	}

	/**
	 * accessor method for event user id
	 *
	 * @return uuid value for event user id
	 **/
	public function getEventUserId(): uuid {
		return ($this->eventUserId);
	}

	/**
	 * mutator method for event user id
	 * @param string | Uuid $newEventUserId new value of event user id
	 * @throws \RangeException if $newEventUserId is not positive
	 * @throws \TypeError if $newEventUserId is not an integer
	 **/

	public function setEventUserId($newEventUserId): void {
		try {
			$uuid = self::validateUuid($newEventUserId);
		} catch
		(\InvalidArgumentException | \RangeException | \Exception | \TypeError $exception) {
			$exceptionType = get_class($exception);
			throw(new $exceptionType($exception->getMessage(), 0, $exception));
		}
		// convert and store the event user id
		$this->eventUserId = $uuid;
	}

	/**
	 * accessor method for event content
	 *
	 * @return string value of event content
	 **/
	public function getEventContent(): string {
		return ($this->EventContent);
	}
	/**
	 * mutator method for event content
	 *
	 * @param string $newEventContent new value of event content
	 * @throws \InvalidArgumentException if $newEventContent is not a string or insecure
	 * @throws \RangeException if $newEventContent is > 255 characters
	 * @throws \TypeError if $newEventContent is not a string
	 **/
	public function setEventContent(string $newEventContent): void {
		//verify the article content is secure
		$newEventContent = trim($newEventContent);
		$newEventContent = filter_var($newEventContent, FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES);
		if(empty($newEventContent) === true) {
			throw(new \InvalidArgumentException("event content is empty or insecure"));
		}

		//verify the event content will fit in the database
		if(strlen($newEventContent) >= 255) {
			throw(new \RangeException("event content too large"));
		}

		// store the event content
		$this->eventContent = $newEventContent;
	}

		/**
	 	* accessor method for event end date
	 	*
	 	* @return \dateTime value of event end date
	 	**/
	public function getEventEndDate(): \DateTime {
		return ($this->EventEndDate);
	}

	/**
	 * mutator method for event end date
	 *
	 * @param \DateTime $newEventEndDate new value of event end date
	 * @throws \InvalidArgumentException if $newEventEndDate is not a valid object or string
	 * @throws \RangeException if $newEventEndDate is a date that does not exist
	 * @throws \Exception
	 **/
	public function setEventEndDate($newEventEndDate = null) : void {
		if($newEventEndDate === null) {
			$this->EventEndDate = new \DateTime();
			return;
		}

		try {
			$newEventEndDate = self::validateDateTime($newEventEndDate);
		} catch(\InvalidArgumentException | \RangeException $exception) {
			$exceptionType = get_class($exception);
			throw(new $exceptionType($exception->getMessage(), 0, $exception));
		}
		$this->eventEndDate = $newEventEndDate;
	}

	/**
	 * accessor method for event name
	 *
	 * @return string value of event name
	 **/
	public function getEventName(): string {
		return ($this->EventName);
	}
	/**
	 * mutator method for event name
	 *
	 * @param string $newEventName new value of event name
	 * @throws \InvalidArgumentException if $newEventName is not a string or insecure
	 * @throws \RangeException if $newEventName is > 30 characters
	 * @throws \TypeError if $newEventName is not a string
	 **/
	public function setEventName(string $newEventName): void {
		//verify the event name is secure
		$newEventName = trim($newEventName);
		$newEventName = filter_var($newEventName, FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES);
		if(empty($newEventName) === true) {
			throw(new \InvalidArgumentException("event name is empty or insecure"));
		}

		//verify the event name will fit in the database
		if(strlen($newEventName) >= 30) {
			throw(new \RangeException("event name too large"));
		}

		// store the event name
		$this->eventName = $newEventName;
	}




	}