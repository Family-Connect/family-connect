<?php
/**
 * Created by PhpStorm.
 * User: michael
 * Date: 12/11/18
 * Time: 9:27 AM
 */
namespace FamConn\FamilyConnect;
require_once("autoload.php");

/**
 * JsonObjectStorage Class
 *
 * This class adds JsonSerializable to SplObjectStorage, allowing for the stored data to be json serialized. This lets the data be gotten in the interactions between frontend and backend in the RESTful apis.
 *
 *@author Dylan McDonald <dmcdonald21@cnm.edu>
 *
 **/
class JsonObjectStorage extends \SplObjectStorage implements \JsonSerializable {
	public function jsonSerialize() {
		$fields = [];
		foreach($this as $object) {
			$fields[] = $object;
			$object->comments = $this[$object];
		}
		return ($fields);
	}
}