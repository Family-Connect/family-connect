<?php
/**
 * Created by PhpStorm.
 * User: michael
 * Date: 11/5/18
 * Time: 10:42 AM
 */

namespace FamConn\FamilyConnect;

require_once("autoload.php");
require_once(dirname(__DIR__, 2) . "/vendor/autoload.php");

use Ramsey\Uuid\Uuid;
/** This is the top-level entity for the Family Connect web app.
 *
 * @author Michael Bovee <michael.j.bovee@gmail.com>
 * version 1.0.0
 * @method getUserFamilyId()
 */

class Family implements \JsonSerializable {
	use ValidateUuid;
	/**
	 * id for this family, this is the primary key
	 * @var Uuid $familyId
	 */
	private $familyId;
	/**
	 * display name for family entity, this is a unique attribute
	 * @var string $familyName
	 */
	private $familyName;

	/**
	 * constructor for this family
	 * @param string|Uuid $newFamilyId if this family is null or if a new family
	 * @param string $newFamilyName - name of family
	 * @throws \InvalidArgumentException if data types aren't valid
	 * @throws \RangeException if data values are not correct length
	 * @throws \TypeError if data values are not the correct type
	 * @throws \Exception for any other mysqli_sql_exception
	 * @Documentation https://php.net/manual/en/language.oop5.decon.php
	 */
	public function __construct($newFamilyId, string $newFamilyName) {
		try {
			$this->setFamilyId($newFamilyId);
			$this->setFamilyName($newFamilyName);
		}
		// determine if/what exceptions were thrown
		catch(\InvalidArgumentException | \RangeException | \TypeError | \Exception $exception) {
			$exceptionType = get_class($exception);
			throw(new $exceptionType($exception->getMessage(), 0, $exception));
		}
	}

	/**
	 * accessor method for family id
	 *
	 * @return Uuid value of family id - this will be null if new family
	 */
	public function getFamilyId() : Uuid {
		return($this->familyId);
	}
	/**
	 * mutator method for family id
	 *
	 * @param Uuid|string $newFamilyId value of new family id
	 * @throws \RangeException if $newFamilyId is not positive
	 * @throws \TypeError if family id is not Uuid|String
	 */
	public function setFamilyId($newFamilyId) : void {
		// see if new family uuid is valid
		try {
			$uuid = self::validateUuid($newFamilyId);
		// throw error if Uuid is not valid
		} catch(\RangeException | \InvalidArgumentException | \Exception | \TypeError $exception) {
			$exceptionType = get_class($exception);
			throw(new $exceptionType($exception->getMessage(), 0, $exception));
		}
		// store the new family id
		$this->familyId = $uuid;
	}

	/**
	 * accessor method for family name
	 *
	 * @return string value of family name
	 */
	public function getFamilyName() : ?string {
		return ($this->familyName);
	}
	/**
	 * mutator method for family name
	 *
	 * @param string $newFamilyName value of new family name
	 * @throws \InvalidArgumentException if family name is not a string or if it's insecure
	 * @throws \RangeException if length of family name is greater than 64 characters
	 * @throws \TypeError if family name is not a string
	 */
	public function setFamilyName(string $newFamilyName) : void {
		$newFamilyName = trim($newFamilyName);
		$newFamilyName = filter_var($newFamilyName, FILTER_SANITIZE_STRING);
		// verify that the new family name is a string
		if($newFamilyName === false) {
			throw(new \InvalidArgumentException("new family name is not a string or is insecure"));
		}
		// verify that the new family name is not too long
		if(strlen($newFamilyName) > 64) {
			throw(new \RangeException("new family name is too long"));
		}
		// store new family name
		$this->familyName = $newFamilyName;
	}

	/**
	 * insert this family into mySQL
	 *
	 * @param \PDO $pdo PDO connection object
	 * @throws \PDOException when mySQL related errors happen
	 * @throws \TypeError if $pdo is not a PDO connection object
	 */
	public function insert(\PDO $pdo) : void {
		// create template for query
		$query = "INSERT INTO family(familyId, familyName) VALUES (:familyId, :familyName)";
		$statement = $pdo->prepare($query);

		// wire variables up to their template place holders
		$parameters = ["familyId" => $this->familyId->getBytes(), "familyName" => $this->familyName];
		$statement->execute($parameters);
	}

	/**
	 * deletes this family from mySQL
	 *
	 * @param \PDO $pdo PDO connection object
	 * @throws \PDOException when mySQL related errors occur
	 * @throws \TypeError if $pdo is not a connection object
	 */
	public function delete(\PDO $pdo) : void {
		// create template for query
		$query = "DELETE FROM family WHERE familyId = :familyId";
		$statement = $pdo->prepare($query);

		// wire up variable to template placeholder
		$parameters = ["familyId" => $this->familyId->getBytes()];
		$statement->execute($parameters);
	}

	/**
	 * updates this family in mySQL
	 *
	 * @param \PDO $pdo connection object
	 * @throws \PDOException when mySQL related errors occur
	 * @throws \TypeError if $pdo is not a connection object
	 */
	public function update(\PDO $pdo) : void {
		// create template for query
		$query = "UPDATE family SET familyId = :familyId, familyName = :familyName WHERE familyId = :familyId";
		$statement = $pdo->prepare($query);

		// wire up variables to place holders in query
		$parameters = ["familyId" => $this->familyId->getBytes(), "familyName" => $this->familyName];
		$statement->execute($parameters);
	}

	/**
	 * get family by family id
	 *
	 * @param \PDO $pdo PDO connection object
	 * @param Uuid|string $familyId family id used in query
	 * @return Family|null - family if there's a result, null if there isn't
	 * @throws \PDOException when mySQL errors occur
	 * @throws \TypeError when the variables are not the correct data type
	 */
	public static function getFamilyByFamilyId(\PDO $pdo, $familyId) : ?Family {
		// sanitize string / Uuid
		try {
			$familyId = self::validateUuid($familyId);
		} catch(\InvalidArgumentException | \RangeException | \Exception | \TypeError $exception) {
			throw(new \PDOException($exception->getMessage(), 0, $exception));
		}

		// create template for new query
		$query = "SELECT familyId, familyName FROM family WHERE familyId = :familyId";
		$statement = $pdo->prepare($query);

		// wire up variable (familyId) to query
		$parameters = ["familyId" => $familyId->getBytes()];
		$statement->execute($parameters);

		// grab family from mySQL
		try {
			$family = null;
			$statement->setFetchMode(\PDO::FETCH_ASSOC);
			$row = $statement->fetch();
			if($row !== false) {
				$family = new Family($row["familyId"], $row["familyName"]);
			}
		} catch(\Exception $exception) {
			throw(new \PDOException($exception->getMessage(), 0, $exception));
		}
		return($family);
	}

	/**
	 * get family by family name
	 *
	 * @param \PDO $pdo PDO connection object
	 * @param string $familyName family name used in query
	 * @return Family|null - family if there's a result, null if there isn't
	 * @throws \PDOException when mySQL errors occur
	 * @throws \TypeError when the variables are not the correct data type
	 */
	public static function getFamilyByFamilyName(\PDO $pdo, $familyName) : ?Family {
		// sanitize string
		try {
			$familyName = filter_var($familyName, FILTER_SANITIZE_STRING);
		} catch(\InvalidArgumentException | \RangeException | \Exception | \TypeError $exception) {
			throw(new \PDOException($exception->getMessage(), 0, $exception));
		}

		// create template for new query
		$query = "SELECT familyId, familyName FROM family WHERE familyName = :familyName";
		$statement = $pdo->prepare($query);

		// wire up variable (familyId) to query
		$parameters = ["familyName" => $familyName];
		$statement->execute($parameters);

		// grab family from mySQL
		try {
			$family = null;
			$statement->setFetchMode(\PDO::FETCH_ASSOC);
			$row = $statement->fetch();
			if($row !== false) {
				$family = new Family($row["familyId"], $row["familyName"]);
			}
		} catch(\Exception $exception) {
			throw(new \PDOException($exception->getMessage(), 0, $exception));
		}
		return($family);
	}

	/**
	 * formats the state variables for JSON serialization
	 *
	 * @return array resulting state variables to serialize
	 */
	public function jsonSerialize() : array {
		$fields = get_object_vars($this);

		$fields["familyId"] = $this->familyId->toString();
		return($fields);
	}

}