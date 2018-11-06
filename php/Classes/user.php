<?php

namespace agarcia707\FamConn\FamilyConnect;

require_once("autoload.php");
require_once(dirname(__DIR__,2)."/vendor/autoload.php");

use FamConn\FamilyConnect\ValidateUuid;
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

/**
 * constructor for this User
 *
 * @param string|Uuid $newUserId id of this User or null if a new User
 * @param string|Uuid $newUserFamilyId id of the Family the User belongs to
 * @param int $newUserPrivilege tinyint containing privilege for user
 * @param string $newUserActivationToken new value of the user activation hash
 * @param string $newUserAvatar string containing characters for user representation
 * @param string $newUserDisplayName string containing characters to identify user
 * @param string $newUserEmail string containing characters to allow log in
 * @param string $newUserHash new value of the user hash
 * @param string $newUserPhoneNumber string containing characters to use as user information
 * @throws \InvalidArgumentException if data types are not valid
 * @throws \InvalidArgumentException if $newUserActivationToken is not a valid data type
 * @throws \InvalidArgumentException if $newUserHash is empty
 * @throws \RangeException if data values are out of bounds (e.g., strings too long, negative integers)
 * @throws \RangeException if $newUserActivationToken is longer than 32 characters
 * @throws \RangeException if profile hash is longer than 97 character
 * @throws \TypeError if data types violate type hints
 * @throws \Exception if some other exception occurs
 * @throws \Exception if user hash is not hexadecimal
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
	 * mutator method for profile activation token
	 *
	 * @param string $newUserActivationToken new value of the user activation hash
	 * @throws \InvalidArgumentException if $newUserActivationToken is not a valid data type
	 * @throws \RangeException if $newUserActivationToken is longer than 32 characters
	 */
	public function setUserActivationToken(string $newUserActivationToken): void {
		// verify the string is 32 characters
		if(strlen($newUserActivationToken) !== 32) {
			throw (new \RangeException("string is not 32 characters"));
		}
		// verify the string is hexadecimal
		if(ctype_xdigit($newUserActivationToken) === false) {
			throw (new \InvalidArgumentException("String is not hexadecimal"));
		}
		// sanitize activation token string
		$newUserActivationToken = filter_var($newUserActivationToken, FILTER_SANITIZE_STRING);
		// store the string
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
		throw(new \InvalidArgumentException("user avatar is empty or insecure"));
	}

	if(strlen($newUserAvatar) > 128) {
		throw(new \RangeException("user avatar too large"));
	}

	$this->userAvatar = $newUserAvatar;
}

/**
 * mutator method for user avatar
 *
 * @param string $newUserDisplayName new value of user display name
 * @throws \InvalidArgumentException if $newUserDisplayName is not a string or insecure
 * @throws \RangeException if $newUserDisplayName is > 128 characters
 * @throws \TypeError if $newUserDisplayName is not a string
 **/
	public function setUserDisplayName(string $newUserDisplayName) : void {
	$newUserDisplayName = trim($newUserDisplayName);
	$newUserDisplayName = filter_var($newUserDisplayName, FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES);
	if(empty($newUserDisplayName) === true) {
		throw(new \InvalidArgumentException("user display name empty or insecure"));
	}

	if(strlen($newUserDisplayName) > 128) {
		throw(new \RangeException("user display name too large"));
	}

	$this->userDisplayName = $newUserDisplayName;
}

/**
 * mutator method for user email
 *
 * @param string $newUserEmail new value of user avatar
 * @throws \InvalidArgumentException if $newUserEmail is not a string or insecure
 * @throws \RangeException if $newUserEmail is > 128 characters
 * @throws \TypeError if $newUserEmail is not a string
 **/
	public function setUserEmail(string $newUserEmail) : void {
	$newUserEmail = trim($newUserEmail);
	$newUserEmail = filter_var($newUserEmail, FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES);
	if(empty($newUserEmail) === true) {
		throw(new \InvalidArgumentException("user email is empty or insecure"));
	}

	if(strlen($newUserEmail) > 128) {
		throw(new \RangeException("user email too large"));
	}

	$this->userEmail = $newUserEmail;
}

	/**
	 * accessor method for user hash
	 *
	 * @return string of user hash
	 */
	public function getUserHash(): string {
		return $this->userHash;
	}
	/**
	 * mutator method for user hash
	 *
	 * @param string $newUserHash new value of the user hash
	 * @throws \InvalidArgumentException if $newUserHash is empty
	 * @throws \RangeException if profile hash is longer than 97 characters
	 * @throws \Exception if user hash is not hexadecimal
	 */
	public function setUserHash(string $newUserHash): void {
		// verify if the profile hash is not empty
		if(empty($newUserHash) === true) {
			throw (new \InvalidArgumentException("profile hash is empty"));
		}
		// verify the hash is not too long
		if(strlen($newUserHash) > 97) {
			throw (new \RangeException("hash is too long"));
		}
		// verify that hash is hexadecimal
		if(ctype_xdigit($newUserHash) === false) {
			throw (new \Exception("hash is not hexadecimal"));
		}
		// store the string
		$this->userHash = $newUserHashHash;
	}

	/**
	 * mutator method for user phone number
	 *
	 * @param string $newUserPhoneNumber new value of user phone number
	 * @throws \InvalidArgumentException if $newPhoneNumber is not a string or insecure
	 * @throws \RangeException if $newUserPhoneNumber is > 32 characters
	 * @throws \TypeError if $newUserPhoneNumber is not a string
	 **/
	public function setUserPhoneNumber(string $newUserPhoneNumber) : void {
		$newUserPhoneNumber = trim($newUserPhoneNumber);
		$newUserPhoneNumber = filter_var($newUserPhoneNumber, FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES);
		if(empty($newUserPhoneNumber) === true) {
			throw(new \InvalidArgumentException("user phone number is empty or insecure"));
		}

		if(strlen($newUserPhoneNumber) > 32) {
			throw(new \RangeException("user phone number too large"));
		}

		$this->userPhoneNumber = $newUserPhoneNumber;
	}

	/**
	 * accessor method for user privilege
	 *
	 * @return int for user privilege
	 **/
	public function getBeerIbu(): int {
		return $this->userPrivilege;
	}
	/**
	 * mutator method for user privilege
	 *
	 * @param int $newUserPrivilege user privilege range is from 0-120
	 * @throws \RangeException when input is out of range
	 **/
	public function setNewUserPrivilege(int $newUserPrivilege): void {
		if($newUserPrivilege < 0 || $newUserPrivilege > 120) {
			throw(new \RangeException("user privilege is out of range"));
		}
		//convert and store beer ibu
		$this-> userPrivilege = $newUserPrivilege;
	}

	/**
	 * inserts this user into mySQL
	 *
	 * @param \PDO $pdo PDO connection object
	 * @throws \PDOException when mySQL related errors occur
	 * @throws \TypeError if $pdo is not a PDO connection object
	 **/
	public function insert(\PDO $pdo) : void {

		// create query template
		$query = "INSERT INTO user(userId, userFamilyId, userActivationToken, userAvatar, userDisplayName, userEmail, userHash, userPhoneNumber, userPrivilege) VALUES(:userId, :userFamilyId, :userActivationToken, :userAvatar, :userDisplayName, :userEmail, :userHash, :userPhoneNumber, :userPrivilege)";
		$statement = $pdo->prepare($query);

		// bind the member variables to the place holders in the template
		$parameters = ["userId" => $this->userId->getBytes(), "tweetProfileId" => $this->userFamilyId->getBytes(), "userActivationToken" => $this->userActivationToken, "userAvatar" => $this->userAvatar, "userDisplayName" => $this->userDisplayName, "userEmail" => $this->userEmail, "userHash" => $this->userHash, "userPhoneNumber" => $this->userPhoneNumber, "userPrivilege" => $this->userPrivilege];
		$statement->execute($parameters);
	}


	/**
	 * deletes this User from mySQL
	 *
	 * @param \PDO $pdo PDO connection object
	 * @throws \PDOException when mySQL related errors occur
	 * @throws \TypeError if $pdo is not a PDO connection object
	 **/
	public function delete(\PDO $pdo) : void {

		// create query template
		$query = "DELETE FROM user WHERE userId = :tweetId";
		$statement = $pdo->prepare($query);

		// bind the member variables to the place holder in the template
		$parameters = ["userId" => $this->userId->getBytes()];
		$statement->execute($parameters);
	}

	/**
	 * updates this User in mySQL
	 *
	 * @param \PDO $pdo PDO connection object
	 * @throws \PDOException when mySQL related errors occur
	 * @throws \TypeError if $pdo is not a PDO connection object
	 **/
	public function update(\PDO $pdo) : void {

		// create query template
		$query = "UPDATE user SET userFamilyId = :userFamilyId, userActivationToken = :userActivationToken, userAvatar = :userAvatar, userDisplayName = ;userDisplayName, userEmail = :userEmail, userHash = :userHash, userPhoneNumber = :userPhoneNumber, userPrivilege = :userPrivilege WHERE userId = :userId";
		$statement = $pdo->prepare($query);


		$parameters = ["userId" => $this->userId->getBytes(), "tweetProfileId" => $this->userFamilyId->getBytes(), "userActivationToken" => $this->userActivationToken, "userAvatar" => $this->userAvatar, "userDisplayName" => $this->userDisplayName, "userEmail" => $this->userEmail, "userHash" => $this->userHash, "userPhoneNumber" => $this->userPhoneNumber, "userPrivilege" => $this->userPrivilege];
		$statement->execute($parameters);
	}

	/**
	 * gets the User by userId
	 *
	 * @param \PDO $pdo PDO connection object
	 * @param Uuid|string $userId user id to search for
	 * @return Tweet|null User found or null if not found
	 * @throws \PDOException when mySQL related errors occur
	 * @throws \TypeError when a variable are not the correct data type
	 **/
	public static function getUserByUserId(\PDO $pdo, $tweetId) : ?Tweet {
		// sanitize the tweetId before searching
		try {
			$tweetId = self::validateUuid($tweetId);
		} catch(\InvalidArgumentException | \RangeException | \Exception | \TypeError $exception) {
			throw(new \PDOException($exception->getMessage(), 0, $exception));
		}

		// create query template
		$query = "SELECT userId, userFamilyId, userActivationToken, userAvatar, userDisplayName, userEmail, userHash, userPhoneNumber, userPrivilege FROM user WHERE userId = :userId";
		$statement = $pdo->prepare($query);

		$parameters = ["userId" => $userId->getBytes()];
		$statement->execute($parameters);

		// grab the user from mySQL
		try {
			$user = null;
			$statement->setFetchMode(\PDO::FETCH_ASSOC);
			$row = $statement->fetch();
			if($row !== false) {
				$user = new User($row["userId"], $row["userFamilyId"], $row["userActivationToken"], $row["userAvatar"], $row["userDisplayName"], $row["userEmail"], $row["userHash"], $row["userPhoneNumber"], $row["userPrivilege"]);
			}
		} catch(\Exception $exception) {
			// if the row couldn't be converted, rethrow it
			throw(new \PDOException($exception->getMessage(), 0, $exception));
		}
		return($user);
	}

	/**
	 * gets the User by profile id
	 *
	 * @param \PDO $pdo PDO connection object
	 * @param Uuid|string $userFamilyId family id to search by
	 * @return \SplFixedArray SplFixedArray of Users found
	 * @throws \PDOException when mySQL related errors occur
	 * @throws \TypeError when variables are not the correct data type
	 **/
	public static function getUserByUserFamilyId(\PDO $pdo, $userFamilyId) : \SplFixedArray {

		try {
			$userFamilyIdId = self::validateUuid($userFamilyId);
		} catch(\InvalidArgumentException | \RangeException | \Exception | \TypeError $exception) {
			throw(new \PDOException($exception->getMessage(), 0, $exception));
		}

		// create query template
		$query = "SELECT userId, userFamilyId, userActivationToken, userAvatar, userDisplayName, userEmail, userHash, userPhoneNumber, userPrivilege FROM user WHERE userId = :userId";
		$statement = $pdo->prepare($query);
		// bind the user family id to the place holder in the template
		$parameters = ["userFamilyId" => $userFamilyId->getBytes()];
		$statement->execute($parameters);
		// build an array of tweets
		$users = new \SplFixedArray($statement->rowCount());
		$statement->setFetchMode(\PDO::FETCH_ASSOC);
		while(($row = $statement->fetch()) !== false) {
			try {
				$user = new User($row["userId"], $row["userFamilyId"], $row["userActivationToken"], $row["userAvatar"], $row["userDisplayName"], $row["userEmail"], $row["userHash"], $row["userPhoneNumber"], $row["userPrivilege"]);
				$users[$users->key()] = $user;
				$users->next();
			} catch(\Exception $exception) {
				// if the row couldn't be converted, rethrow it
				throw(new \PDOException($exception->getMessage(), 0, $exception));
			}
		}
		return($users);
	}

	/**
	 * gets the User by content
	 *
	 * @param \PDO $pdo PDO connection object
	 * @param string $userEmail user email to search for
	 * @return \SplFixedArray SplFixedArray of Tweets found
	 * @throws \PDOException when mySQL related errors occur
	 * @throws \TypeError when variables are not the correct data type
	 **/
	public static function getUserByUserEmail(\PDO $pdo, string $userEmail) : \SplFixedArray {
		// sanitize the description before searching
		$userEmail = trim($userEmail);
		$userEmail = filter_var($userEmail, FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES);
		if(empty($userEmail) === true) {
			throw(new \PDOException("tweet content is invalid"));
		}

		// escape any mySQL wild cards
		$userEmail = str_replace("_", "\\_", str_replace("%", "\\%", $userEmail));

		// create query template
		$query = "SELECT userId, userFamilyId, userActivationToken, userAvatar, userDisplayName, userEmail, userHash, userPhoneNumber, userPrivilege FROM user WHERE userEmail LIKE :userEmail";
		$statement = $pdo->prepare($query);

		// bind the user email to the place holder in the template
		$userEmail = "%$userEmail%";
		$parameters = ["tweetContent" => $tweetContent];
		$statement->execute($parameters);

		// build an array of tweets
		$tweets = new \SplFixedArray($statement->rowCount());
		$statement->setFetchMode(\PDO::FETCH_ASSOC);
		while(($row = $statement->fetch()) !== false) {
			try {
				$tweet = new Tweet($row["tweetId"], $row["tweetProfileId"], $row["tweetContent"], $row["tweetDate"]);
				$tweets[$tweets->key()] = $tweet;
				$tweets->next();
			} catch(\Exception $exception) {
				// if the row couldn't be converted, rethrow it
				throw(new \PDOException($exception->getMessage(), 0, $exception));
			}
		}
		return($tweets);
	}

	/**
	 * gets all Tweets
	 *
	 * @param \PDO $pdo PDO connection object
	 * @return \SplFixedArray SplFixedArray of Tweets found or null if not found
	 * @throws \PDOException when mySQL related errors occur
	 * @throws \TypeError when variables are not the correct data type
	 **/
	public static function getAllTweets(\PDO $pdo) : \SPLFixedArray {
		// create query template
		$query = "SELECT tweetId, tweetProfileId, tweetContent, tweetDate FROM tweet";
		$statement = $pdo->prepare($query);
		$statement->execute();

		// build an array of tweets
		$tweets = new \SplFixedArray($statement->rowCount());
		$statement->setFetchMode(\PDO::FETCH_ASSOC);
		while(($row = $statement->fetch()) !== false) {
			try {
				$tweet = new Tweet($row["tweetId"], $row["tweetProfileId"], $row["tweetContent"], $row["tweetDate"]);
				$tweets[$tweets->key()] = $tweet;
				$tweets->next();
			} catch(\Exception $exception) {
				// if the row couldn't be converted, rethrow it
				throw(new \PDOException($exception->getMessage(), 0, $exception));
			}
		}
		return ($tweets);
	}

	/**
	 * formats the state variables for JSON serialization
	 *
	 * @return array resulting state variables to serialize
	 **/
	public function jsonSerialize() : array {
		$fields = get_object_vars($this);

		$fields["tweetId"] = $this->tweetId->toString();
		$fields["tweetProfileId"] = $this->tweetProfileId->toString();

		//format the date so that the front end can consume it
		$fields["tweetDate"] = round(floatval($this->tweetDate->format("U.u")) * 1000);
		return($fields);
	}

}
