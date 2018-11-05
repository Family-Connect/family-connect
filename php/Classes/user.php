<?php

namespace ;

require_once("autoload.php");
require_once(dirname(__DIR__,2)."/vendor/autoload.php");

use Ramsey\Uuid\Uuid;
/**
 * @author agarcia707 <antgarcia014@gmail.com>
 *version 1.0.0
 */

class User implements \JsonSerializable {
	use ValidateUuid;
	/**
	 * id for this
	 */
}