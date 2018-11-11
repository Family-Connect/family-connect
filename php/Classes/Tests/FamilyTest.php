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

	public function testInsertValidFamily() : void  {
		// count rows, save for later
		$numRows = $this->getConnection()->getRowCount("tweet");

		//create a new family and insert to mySQL
		$familyId =  "3772ebb6-abcb-48d5-a549-ab0640f2fd67";
		$family = new Family($familyId, $this->VALID_FAMILYNAME);
		$family->insert($this->getPDO());

		// edit family and update it in mySQL
		$family->setFamilyName($this->VALID_FAMILYNAME2);
		$family->update($this->getPDO());
	}
}
