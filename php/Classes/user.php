<?php

namespace agarcia707\family-connect;

require_once("autoload.php");
require_once(dirname(__DIR__,2)."/vendor/autoload.php");

use Ramsey\Uuid\Uuid;
/**
 * @author agarcia707 <antgarcia014@gmail.com>
 *version 1.0.0
 */

class User {
	use ValidateUuid;
	/**
	 * id for this User; this is the primary key
	 * @var Uuid $userId
	 */
	private $userId;
	/**
	 * id of this Family in which the user belongs to; this is a foreign key
	 * @var Uuid $userFamilyId
	 */
	private $userFamilyId;
	/**
	 * Activation Token for the user
	 * @var string $userActivationToken
	 */
	private $userActivationToken;
	/**
	 * Icon that represents the user
	 * @var string $userAvatar
	 */
	private $userAvatar;
	/**
	 *Text that identifies the user
	 * @var string $userDisplayName
	 */
	private $userDisplayName;
	/**
	 * Email the user uses to log in
	 * @var string $userEmail
	 */
	private $userEmail;
	/**
	 * Hash for the user
	 * @var string $userHash
	 */
	private $userHash;
	/**
	 * Phone number used as user information
	 * @var string $userPhoneNumber
	 */
	private $userPhoneNumber;
	/**
	 * Privilege allows user to do administrative tasks
	 @var int $userPrivilege
	 */
	private $userPrivilege;
}
/**
 * constructor for this User
 *
 * @param string|Uuid $newUserId id of this User or null if a new User
 * @param string|Uuid $newUserFamilyId id of the Family the User belongs to
 * @param string $ewUserActivationToken string containing characters that verifies account
 * @param string $newUserAvatar string containing characters for user representation
 * @param string $newUserDisplayName string containing characters to identify user
 * @param string $newUserEmail string containing characters to allow log in
 * @param string $newUserHash string containing characters to look up information in database
 * @param string $newUserPhoneNumber string containing characters to use as user information
 * @param int $newUserPrivilege
 * @throws \InvalidArgumentException if data types are not valid
 * @throws \RangeException if data values are out of bounds (e.g., strings too long, negative integers)
 * @throws \TypeError if data types violate type hints
 * @throws \Exception if some other exception occurs
 */