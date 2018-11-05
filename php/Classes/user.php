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
 * @param string $newUserActivationToken string containing characters that verifies account
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
	public function __construct($newUserId, $newUserFamilyId, $newUserActivationToken, $newUserAvatar, $newUserDisplayName, $newUserEmail, $newUserHash, $newUserPhoneNumber, $userUserPrivilege) {
		try {
			$this->setUserId($newUserId);
			$this->setUserFamilyId($newUserFamilyId);
			$this->setUserActivationToken($newUserActivationToken);
			$this->setUserAvatar($newUserAvatar);
			$this->setUserDisplayName($newUserDisplayName);
			$this->setUserEmail($newUserEmail);
			$this->setUserHash($newUserHash);
			$this->setUserPhoneNumber($newUserPhoneNumber);
			$this->setUserPrivilege($userUserPrivilege);
		}
		catch(\InvalidArgumentException | \RangeException | \Exception | \TypeError $exception) {
			$exceptionType = get_class($exception);
			throw(new $exceptionType($exception->getMessage(), 0, $exception));
		}
}

/**
 * accessor method for user id
 *
 * @return Uuid value of user id
 */
public function getUserId() : Uuid {
	return($this->UserId);
}

/**
 * mutator method for tweet id
 *
 * @param Uuid|string $newUserId new value of user id
 * @throws \RangeException if $newUserId is not positive
 * @throws \TypeError if $newUserId is not a uuid or string
 **/
public function setUserId( $newUserId) : void {
	try {
		$uuid = self::validateUuid($newUserId);
	} catch(\InvalidArgumentException | \RangeException | \Exception | \TypeError $exception) {
		$exceptionType = get_class($exception);
		throw(new $exceptionType($exception->getMessage(), 0, $exception));
	}

	// convert and store the user id
	$this->userId = $uuid;
}

/**
 * accessor method for user family id
 *
 * @return Uuid value of user family id
 **/
public function getUserFamilyId() : Uuid{
	return($this->userFamilyId);
}

/**
 * mutator method for user family id
 *
 * @param string | Uuid $newUserFamilyId new value of user family id
 * @throws \RangeException if $newUserFamilyId is not positive
 * @throws \TypeError if $newUserFamilyId is not an integer
 **/
public function setUserFamilyId( $newUserFamilyId) : void {
	try {
		$uuid = self::validateUuid($newUserFamilyId);
	} catch(\InvalidArgumentException | \RangeException | \Exception | \TypeError $exception) {
		$exceptionType = get_class($exception);
		throw(new $exceptionType($exception->getMessage(), 0, $exception));
	}

	// convert and store the profile id
	$this->userFamilyId = $uuid;
}

/**
 * mutator method for user activation token
 *
 * @param string $newUserActivationToken new value of user activation token
 * @throws \InvalidArgumentException if $newUserActivationToken is not a string or insecure
 * @throws \RangeException if $newUserActivationToken is > 32 characters
 * @throws \TypeError if $newUserActivationToken is not a string
 **/
public function setUserActivationToken(string $newUserActivationToken) : void {
	$newUserActivationToken = trim($newUserActivationToken);
	$newUserActivationToken = filter_var($newUserActivationToken, FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES);
	if(empty($newUserActivationToken) === true) {
		throw(new \InvalidArgumentException("tweet content is empty or insecure"));
	}

	if(strlen($newUserActivationToken) >= 32) {
		throw(new \RangeException("user activation token too large"));
	}

	$this->userActivationToken = $newUserActivationToken;
}

/**
 * mutator method for user avatar
 *
 * @param string $newUserAvatar new value of user avatar
 * @throws \InvalidArgumentException if $newUserAvatar is not a string or insecure
 * @throws \RangeException if $newUserAvatar is > 128 characters
 * @throws \TypeError if $newUserAvatar is not a string
 **/
public function setUserAvatar(string $newUserAvatar) : void {
	$newUserAvatar = trim($newUserAvatar);
	$newUserAvatar = filter_var($newUserAvatar, FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES);
	if(empty($newUserAvatar) === true) {
		throw(new \InvalidArgumentException("tweet content is empty or insecure"));
	}

	if(strlen($newUserAvatar) >= 128) {
		throw(new \RangeException("user activation token too large"));
	}

	$this->userAvatar = $newUserAvatar;
}

