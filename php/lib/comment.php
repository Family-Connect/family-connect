<?php
/**
 * Created by PhpStorm.
 * User: felizmunoz
 * Date: 11/9/18
 * Time: 10:45 AM
 */

namespace FamConn\FamilyConnect;
require_once ("..\Classes\autoload.php");

$instance = new Comment
("9c27b364-ce71-44e7-bedc-392f91a7119a", "4d67e141-60d8-4baf-94f4-e1fab2f0f109", "96deed57-32b7-4810-97aa-ab611c0f8ea5", "be26fe1b-01bc-4d70-a3e1-aeb8564166f9", "here is comment content");

var_dump($instance);