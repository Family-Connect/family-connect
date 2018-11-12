<?php
/**
 * Created by PhpStorm.
 * User: felizmunoz
 * Date: 11/12/18
 * Time: 2:41 PM
 */
namespace FamConn\FamilyConnect;

use FamConn\FamilyConnect{Id, EventId, TaskId, UserId, Content, Comment};

// grab the class under scrutiny
require_once(dirname(__DIR__) . "/autoload.php");

// grab the uuid generator
require_once(dirname(__DIR__, 2) . "/lib/uuid.php");

/**
 * Full PHPUnit test for the Comment class
 *
 * This is a complete PHPUnit test of the Comment class. It is complete because *ALL* mySQL/PDO enabled methods
 * are tested for both invalid and valid inputs.
 *
 * @see Comment
 * @author Feliz Munoz <fmunoz111@cnm.edu>
 **/

class CommentTest extends DataDesignTest {
	/**
	 * Id that belongs to the comment; this a primary key
	 * @var STRING $VALID_COMMENTID
	 **/
	protected $id = $VALID_COMMENTID = "PHPUnit test passing";

	/**
	 * eventid of the Comment; this starts as null and is assigned later
	 * @var \Binary $VALID_COMMENTEVENTID
	 **/
	protected $VALID_COMMENTEVENTID = null;

	/**
	 * taskid of the Comment; this starts as null and is assigned later
	 * @var \Binary $VALID_COMMENTTASKID
	 **/
	protected $VALID_COMMENTTASKID = null;

	/**
	 * userid of the Comment
	 * @var \Binary $VALID_COMMENTUSERID
	 **/
	protected $VALID_COMMENTUSERID = "PHPUnit test passing";

	/**
	 * content of the Comment
	 * @var string $VALID_COMMENTCONTENT
	 **/
	protected $VALID_COMMENTCONTENT = "PHPUnit test passing";
	public final function setUp()  : void {
		// run the default setUp() method first
		parent::setUp();
		$this->VALID_COMMENTID = new CommentId(generateUuidV4();
		$this->id->inset($this->getPDO());
	}

	/**
	 *test inserting a valid Comment and verify that the actual mySQL data matches
	 **/
	public function testInsertValidComment() : void {
		// count the number of rows and save it for later
		$numRows = $this->getConnection()->getRowCount("comment");

		// create a new Comment and insert to into mySQL
		$commentId = generateUUidV4();
		$comment = new Comment($commentId, $this ->comment->getCommentId(), $this->VALID_COMMENTEVENTID, $this->VALID_COMMENTTASKID, $this->VALID_COMMENTUSERID, $this->VALID_COMMENTCONTENT);
		$comment->insert($this->getPDO());

		//grab the data from mySQL and enforce the fields match our expectations
		$pdoComment = Comment::getCommentByCommentId($this->getPDO(), $comment->getCommentId());
		$this->assertEquals($numRows + 1, $this->getConnection()->getRowCount("comment"));
		$this->assertEquals($pdoComment->getCommentId(), $commentId);
		$this->assertEquals($pdoComment->getCommentEventId(), $this->event->getCommentEventId());
		$this->assertEquals($pdoComment->getCommenTaskId(), $this->task->getCommentTaskId());
		$this->assertEquals($pdoComment->getCommentUserId(), $this->user->getUserId());
		$this->assertEquals($pdoComment->getCommentContent(), $this->VALID_COMMENTCONTENT);
	}

	/**
	 * test inserting a Comment, editing it, and then updating it
	 **/
	public function testUpdateValidComment() : void {
		// count the number of rows and save it for later
		$numRows  = $this->getConnection()->getRowCount("comment");

		//create a new Comment and insert to into mySQL
		$commentId = generateUuidV4();
		$comment = new Comment($commentId, $this ->comment->getCommentId(), $this->VALID_COMMENTEVENTID, $this->VALID_COMMENTTASKID, $this->VALID_COMMENTUSERID, $this->VALID_COMMENTCONTENT);
		$comment->insert($this->getPDO());

		//edit the Comment and update it in mySQL
		$comment->setCommentContent($this->VALID_COMMENTCONTENT2);
		$comment->update($this->getPDO());

		//grab the data from mySQL and enforce the fields match our expectations
		$pdoComment = Comment::getCommentByCommentId($this->getPDO(), $comment->getCommentId());
		$this->assertEquals($numRows + 1, $this->getConnection()->getRowCount("comment"));
		$this->assertEquals($pdoComment->getCommentId(), $commentId);
		$this->assertEquals($pdoComment->getCommentEventId(), $this->event->getCommentEventId());
		$this->assertEquals($pdoComment->getCommenTaskId(), $this->task->getCommentTaskId());
		$this->assertEquals($pdoComment->getCommentUserId(), $this->user->getUserId());
		$this->assertEquals($pdoComment->getCommentContent(), $this->VALID_COMMENTCONTENT);
	}

	/**
	 * test creating a Comment and then deleting it
	 **/
	public function testDeleteValidComment() : void {
		// count the number of rows and save it for later
		$numRows = $this->getConnection()->getRowCount("comment");

		// create a new Comment and insert to into mySQL
		$commentId = generateUuidV4();
		$comment = new Comment($commentId, $this ->comment->getCommentId(), $this->VALID_COMMENTEVENTID, $this->VALID_COMMENTTASKID, $this->VALID_COMMENTUSERID, $this->VALID_COMMENTCONTENT);
		$comment->insert($this->getPDO());

		// delete the Comment from mySQL
		$this->assertEquals($numRows + 1, $this->getConnection()->getRowCount("comment"));
		$comment->delete($this->getPDO());

		// grab the data from mySQL and enforce the Comment does not exist
		$pdoComment = Comment::getCommentByCommentId($this->getPDO(), $comment->getCommentId());
		$this->assertNull($pdoComment);
		$this->assertEquals($numRows, $this->getConnection()->getRowCount("comment"));
	}


}