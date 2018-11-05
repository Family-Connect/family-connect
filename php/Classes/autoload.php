<?php
/**
 * Created by PhpStorm.
 * User: michael
 * Date: 11/5/18
 * Time: 4:26 PM
 */

/**
 * PSR-4 Compliant Autoloader
 *
 * Enables classes to be automatically loaded by resolving prefix and class name
 *
 * @param string $class fully qualified class name to load
 * @see http://www.php-fig.org/psr/psr-4/examples/ PSR-4 Example Autoloader
 **/
 spl_autoload_register(function($class) {
	 /**
	  * CONFIGURABLE PARAMETERS:
	  * prefix: prefix for all the classes - namespace ...tbd
	  * baseDir: base directory for all the classes - this is by default the current directory
	  */
	 $prefix = "FamConn\\FamilyConnect";
	 $baseDir = __DIR__;
	 // does the class use the namespace prefix? - uses strncmp = "string of n compared"
	 $len = strlen($prefix);
	 if (strncmp($prefix, $class, $len) !== 0) {
		 // if the prefix and the first part of the class name (length of this matches the length of the prefix) are inequal, return and move to the next autoloader
		 return;
	 }

	 // get relative class name
	 $className = substr($class, $len);

	 // replace namespace prefix with base director, replace namespace separators with directory separators in relative class name, append with .php
	 $file = $baseDir . str_replace("\\", "/", $className) . ".php";

	 // require file if it exists
	 if(file_exists($file)) {
		 require_once ($file);
	 }
 });