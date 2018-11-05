<?php

namespace agarcia\family-connect ;

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
	 * Phone number user uses as information
	 * @var string $userPhoneNumber
	 */
	private $userPhoneNumber;
	/**
	 * Privilege allows user to do administrative tasks
	 @var string $userPrivilege
	 */
	private $userPrivilege;
}
