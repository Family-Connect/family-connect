<?php
/**
 * Created by PhpStorm.
 * User: michael
 * Date: 11/5/18
 * Time: 4:43 PM
 */

namespace FamConn\FamilyConnect;
require_once ("../Classes/autoload.php");

$instance = new Family("b02fe7f8-69df-4915-9448-166358834b83", "family name");

var_dump($instance);