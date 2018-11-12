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
	 * valid user hash to create object to own test
	 * @var $VALID_HASH
	 */
	protected $VALID_HASH;

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


}