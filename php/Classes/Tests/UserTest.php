<?php
namespace FamConn\FamilyConnect\Test;

use FamConn\FamilyConnect\{Family};

//grab class that is going to be tested
require_once (dirname(__DIR__) . "/autoload.php");

//grab uuid generator
require_once (dirname(__DIR__, 2) . "/lib/uuid.php");

/**
 * Full PHPUnit test for the User class
 *
 * This is a complete PHPUnit test of the User Class.
 *
 * @see User
 * @author Anthony Garcia <antgarcia014@gmail.com>
 */

class UserTest extends FamilyConnectTest {
	/**
	 * Family creates User; this a foreign key relationship
	 * @var Family family
	 */
	protected $family = null;

	/**
	 * valid user activation token for user object to own test
	 * @var $VALID_ACTIVATION_TOKEN;
	 */
	protected $VALID_ACTIVATION_TOKEN;

	 /**
	  *avatar of the user
	  * @var string $VALID_AVATAR
	  */
	 protected $VALID_AVATAR = "PHPUnit test passing";

	 /**
	  * updated avatar of the user
	  * @var string $VALID_AVATAR2
	  */
	 protected $VALID_AVATAR2 = "PHPUnit test still passing";

	/**
 	* Display name that identifies who the user is
 	* @var string $VALID_DISPLAY_NAME
 	*/
	protected $VALID_DISPLAY_NAME = "Good news, the test is passing";

	/**
	 * Updated display name that identifies who the user is
	 * @var string $VALID_DISPLAY_NAME2
	 */
	protected $VALID_DISPLAY_NAME2 = "It works!";

	/**
	 * Email used by user to log in
	 * @var string $VALID_EMAIL
	 */
	protected $VALID_EMAIL = "thisisaemail34@yahoo.com";

	/**
	 * Updated email used by user
	 * @var string $VALID_EMAIL2
	 */
	protected $VALID_EMAIL2 = "newemail35@yahoo.com";

	/**
	 * valid user hash to create object to own test
	 * @var $VALID_HASH
	 */
	protected $VALID_HASH;

	/**
	 * Phone number user uses for information
	 * @var string $VALID_PHONE_NUMBER
	 */
	protected $VALID_PHONE_NUMBER = "5555555";

	/**
	 * Updated phone number user uses for information
	 * @var string $VALID_PHONE_NUMBER2
	 */
	protected $VALID_PHONE_NUMBER2 = "5655656";

	/**
	 * Privilege allows user to do administrative tasks
	 * @var int $VALID_PRIVILEGE
	 */
	protected $VALID_PRIVILEGE = "0";

	/**
	 * Privilege allows user to do administrative tasks
	 * @var int $VALID_PRIVILEGE2
	 */
	protected $VALID_PRIVILEGE2 = "1";

/**
 * create dependent objects before running each test
 */
	public final function setUp() : void {
		parent::setUp();
		$password = "abc123";
		$this->VALID_USERHASH = password_hash($password, PASSWORD_ARGON2I, ["time_cost" => 384]);


		// create and insert a Family to own the test User
		$this->family = new Family(generateUuidV4(), $this->VALID_FAMILYNAME);
		$this->family->insert($this->getPDO());
	}

	/**
	 * test inserting a valid User and verify that the actual mySQL data matches
	 */
	/**
	 * @return Connection
	 */
	public function testInsertValidUser() : void {
		$numRows = $this->getConnection()->getRowCount("user");

		// create a new Task and insert into mySQL
		$userId = generateUuidV4();
		$user = new User($userId, $this->family->getFamilyId(), $this->VALID_AVATAR, $this->VALID_DISPLAY_NAME, $this->VALID_EMAIL, $this->VALID_PHONE_NUMBER, $this->VALID_PRIVILEGE);
		$user->insert($this->getPDO());
	}
}