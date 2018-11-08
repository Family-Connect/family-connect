<?php
namespace FamConn\FamilyConnect\Test;

use FamConn\FamilyConnect\{Event, Family, User};

//grab the class under scrutiny
require_once(dirname(__DIR__) . "/autoload.php");

//grab the uuid generator
require_once(dirname(__DIR__, 2) . "/lib.uuid.php");

/**Full PHPUnit test for the Event class
 *
 *This is a complete PHPUnit test of the Event class. It is complete because *ALL* mySQL/PDO enabled methods are
 * tested for both invalid and valid inputs.
 *
 *@see \FamConn\FamilyConnect\Event
 *@author Sharon Romero <sromero130@cnm.edu>
 **/

class EventTest extends FamilyConnectTest {
	/**
	 * Family that created the event; this is for foreign key relations
	 * @var Family family
	 **/
	protected $family = null;

	/**
	 * User that created the event; this is for foreign key relations
	 * @var User user
	 **/
	protected $user = null;


}