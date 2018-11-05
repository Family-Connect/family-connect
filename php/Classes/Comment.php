<?php
/**
 * Created by PhpStorm.
 * User: felizmunoz
 * Date: 11/5/18
 * Time: 10:47 AM
 */

namspace fmunoz\family-connect;
require_once("sutoload.php");
require_once(dirname(path:__Dir__, levels: 2) . "/vendor/autoload.php");
use Ramsey\Uuid\Uuid;

/**
 * This is the comment section of Family Connect
 * comments can come from all users in a group
 *
 * @author Feliz Munoz <fmunoz11@cnm.edu>
 * @version 3.0.0
 */

class Comment {
	use ValidateUuid;
	/**
	 * id for comment; this is the primary key
	 * @varUuid $commentId
	 **/
	private $commentId;
	/**
	 * id of the event that the comment belongs to
	 * @varUuid $commentEventId
	 **/
	private $commentEventId;
	/**
	 * id of the task that the comment belongs to
	 * @varUuid $commentTaskId
	 **/
	private $commentTaskId;
	/**
	 * id of the user that the comment belongs to
	 * @varUuid $commentUserId
	 **/
	private $commentUserId;
	/**
	 * actual textual content that the the Comment will contain and be posted with the group
	 * @var string $commentContent
	 **/
	private $commentContent;
	/**
	 * actual time that the comment was posted
	 * @varDatetime $commentDate
	 **/
	private $commentDate;

	/**
 	* constructor for Comment
 	*
 	* @param string|Uuid $newCommentId id of the comment or null if new Comment
 	* @param string|Uuid $newCommentEventId of the event that the comment is associated with
 	* @param string|Uuid $newCommentTaskId of the task that the comment is assiciated with
 	* @param string|Uuid $newCommentUserId of the user that the comment s associated with
 	* @param string $newCommentContent string containing actual comment content posted
 	* @param string $newCommentDate string with actual date and time when comment is posted
 	* @throws \InvalidArgumentException if data types are not valid
 	* @throws \RangeException if data values are out of bounds (e.g., strings too long, negative integers)
 	* @throws \TypeError if data types violate type hints
 	* @throws \Exception if some other exception occurs
 	* @Documentation https://php.net/manual/en/language.oop5.decon.php
 	*/
	public function __construct($newCommentId, $newCommentEventId, $newCommentTaskId, $newCommentUserId, $newCommentContent, $newCommentDate= null) {
		try {
			$this->setCommentId($newCommentId);
			$this->setCommentEventId($newCommentEventId);
			$this->setCommentTaskId($newCommentTaskId);
			$this->setCommentUserId($newCommentUserId);
			$this->setCommentContent($newCommentContent);
			$this->setCommentDate($newCommentDate);
		}
		catch(\InvalidArgumentException | \RangeException | \Exception | \TypeError $exception) {
			$exceptionType = get_class($exception);
			throw(new $exceptionType($exception->getMessage(), 0, $exception));
		}
	}

/**
 * accessor method for comment id
 *
 * @return Uuid value of comment id
 */
public funtion getCommentId () : Uuid {
	return ($this->commentId);

	//this outside of class
	//$comment-getCommentId();
}

/**
 * mutator method for comment id
 *
 * @param Uuid|string $newCommentId new value of comment id
 * @throws \RangeException if #newCommentId is not positive
 * @throws \TypeError if $newCommentId is not a uuid or string
 **/
public function setCommentId($newCommentId) ; void {
	try {
		$newCommentId = self ::ValidateUuid($newCommentId);
	} catch(\InvalidArgumentException | \RangeException | \Exception | \TypeError $exception) {
		$exceptionType = get_class($exception);
		throw(new $expectionType($exception->getMessage(), 0, $expection));
	}

	// convert and store the comment id
	$this->commentId = $newCommentId;
}

/**
 * accessor method for comment event id
 *
 * @return Uuid values of comment event id
 **/
public function get CommentEventId() : Uuid{
	return($this->commentEventId);
}

/**
 * mutator method for comment event id
 *
 * @param | Uuid $newCommentEventId new value of comment event id
 * @throws \RangeException if $newCommentEventId is not positive
 * @throws \ TypeError if $newCommentEventId is not an integer
 **/
public function setCommentEventId( $newCommentEventId) : void {
	try {
		$uuid = self::validateUuid($newCommentEventId);
	}	catch(\InvalidArgumentException | \RangeException | \Exception | \TypeError) {
		throw(new $exceptionType($exception->getMessage(), 0, $exception));
	}
	// convert and store the comment event id
	$this->commentEventId = $uuid;
}

/**
 * accessor method for comment task id
 *
 * @return Uuid value of comment task id
 **/
public function getCommentTaskId() : Uuid{
	return($this->commentTaskId);
}

/**
 * mutator method for comment task id
 *
 * @param | Uuid $newCommentTaskId new value of comment task id
 * @throws \RangeException if $newCommentTaskId is not positive
 * @throws \TypeError if $newCommentTaskId is not an integer
 */
public function setCommentTaskId( $newCommentTaskId) : void {
	try {
		$uuid = self::validateUuid($newCommentTaskId);
	} catch(\InvalidArgumentException | \RangeException | \Exception |\TypeError $exception) {
		$exceptionType = get_class($exception);
		throw(new $exceptionType($exception->getMessage(), 0, $exception));
	}
	// convert and store the comment task id
	$this->commentTaskId = $uuid;
}

/**
 * accessor method for comment user id
 *
 * @return Uuid value of comment user id
 **/
public function getCommentUserId() : Uuid {
	return($this->commentUserId);
}

/**
 * mutator method for comment user id
 *
 * @param | Uuid $newCommentUserId new value of comment user id
 * @throws \RangeException if $newCommentUserId is not positive
 * @throws \TypeError if $newCommentUserId is not an integer
 **/
public function setCommentUserId( $newCommentUserId) : void {
	try{
		$uuid = self::validateUuid($newCommentUserId);
	} catch(\InvalidArgumentException | \RangeException | \Exception | \TypeError $exception) {
		$exceptionType = get_class($exception);
		throw(new $exceptionType($exception->getMessage(), 0, $exception));
	}
	// convert and store the comment user id
	$this->commentUserId = $uuid;
}

/**
 * accessor method for comment content
 *
 * @return string value of comment content
 **/





