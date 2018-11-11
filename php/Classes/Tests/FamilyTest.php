<?php
/**
 * Created by PhpStorm.
 * User: michael
 * Date: 11/11/18
 * Time: 1:26 PM
 */

namespace FamConn\FamilyConnect\Test;

use FamConn\FamilyConnect\{Family};

// grab class to be tested
require_once(dirname(__DIR__) . "/autoload.php");

// grab uuid generator
//require_once(dirname(__DIR__, 2) . "/lib/uuid.php");

/**
 * Full PHPUnit test for Family class
 *
 * This PHPUnit test is complete in that it tests all mySQL/PDO methods with valid and invalid inputs.
 *
 * @see \FamConn\FamilyConnect\Family
 * @author Michael Bovee <michael.j.bovee@gmail.com>
 */

class FamilyTest extends FamilyConnectTest {
	/**
	 * name of Family
	 * @var string $VALID_FAMILYNAME
	 */
	protected $VALID_FAMILYNAME = "PHPUnit test passing";

	/**
	 * updated name of Family
	 * @var string $VALID_FAMILYNAME2
	 */
	protected $VALID_FAMILYNAME2 = "PHPUnit test still passing";

	public final function setUp() : void {
		parent::setUp();
	}

	/**
	 * test inserting a valid Family and verify the actual mySQL data matches
	 */
	public function testInsertValidFamily() : void {
		// count rows, save for later
		$numRows = $this->getConnection()->getRowCount("family");

		// create a new Family and insert to mySQL
		$familyId =  "eac7aad3-28f7-4293-847b-87fd7a2ad225";
		$family = new Family($familyId, $this->VALID_FAMILYNAME);
		$family->insert($this->getPDO());

		// grab the data from mySQL and make sure fields match expectations
		$pdoFamily = Family::getFamilyByFamilyId($this->getPDO(), $family->getFamilyId());
		$this->assertEquals($pdoFamily->getFamilyId(), $familyId);
		$this->assertEquals($numRows + 1, $this->getConnection()->getRowCount("family"));
		$this->assertEquals($pdoFamily->getFamilyName(), $this->VALID_FAMILYNAME);
	}

	/**
	 * test inserting a Family, editing it, then updating it
	 */
	public function testUpdateValidFamily() : void  {
		// count rows, save for later
		$numRows = $this->getConnection()->getRowCount("family");

		//create a new family and insert to mySQL
		$familyId =  "3772ebb6-abcb-48d5-a549-ab0640f2fd67";
		$family = new Family($familyId, $this->VALID_FAMILYNAME);
		$family->insert($this->getPDO());

		// edit family and update it in mySQL
		$family->setFamilyName($this->VALID_FAMILYNAME2);
		$family->update($this->getPDO());

		// grab the data from mySQL and make sure fields match expectations
		$pdoFamily = Family::getFamilyByFamilyId($this->getPDO(), $family->getFamilyId());
		$this->assertEquals($pdoFamily->getFamilyId(), $familyId);
		$this->assertEquals($numRows + 1, $this->getConnection()->getRowCount("family"));
		$this->assertEquals($pdoFamily->getFamilyName(), $this->VALID_FAMILYNAME2);
	}

	/**
	 * test creating a Family and then deleting it
	 */
	public function testDeleteValidFamily() : void {
		// count rows, save for later
		$numRows = $this->getConnection()->getRowCount("family");

		//create a new family and insert to mySQL
		$familyId =  "bc289be5-8f77-4972-8d7b-9192a9d07232";
		$family = new Family($familyId, $this->VALID_FAMILYNAME);
		$family->insert($this->getPDO());

		// delete the family from mySQL
		$this->assertEquals($numRows + 1, $this->getConnection()->getRowCount("family"));
		$family->delete($this->getPDO());

		//grab the data from mySQL and make sure that the Family does not exist
		$pdoFamily = Family::getFamilyByFamilyId($this->getPDO(), $family->getFamilyId());
		$this->assertNull($pdoFamily);
		$this->assertEquals($numRows, $this->getConnection()->getRowCount("family"));
	}
}
