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
}