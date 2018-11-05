<?php
/**
 * Created by PhpStorm.
 * User: michael
 * Date: 11/5/18
 * Time: 10:42 AM
 */

namespace ;

require_once("autoload.php");
require_once(dirname(__DIR__, 2) . "/vendor/autoload.php");

use Ramsey\Uuid\Uuid;
/** This is the top-level entity for the Family Connect web app.
 *
 * @author Michael Bovee <michael.j.bovee@gmail.com>
 * version 1.0.0
 */

class Family {
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
	public function __construct($newFamilyId, $newFamilyName) {
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
}