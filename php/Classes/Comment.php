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