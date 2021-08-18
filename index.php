<?php
/*
	Produced 2019
	By https://github.com/amattu2
	Copy Alec M.
	License GNU Affero General Public License v3.0
*/

/*
	Notes:
	- https://www.decodethevin.com/
	- https://www.northamericanmotoring.com/forums/vindecoder.php
	- https://stackoverflow.com/questions/6206954/iso-3779-vehicle-vin-decoder-in-php
*/

// Files
require(dirname(__FILE__) . "/classes/vin.class.php");

$vin = new amattu\VIN("WBB123B87AFG14984");

echo $vin . "<br/>";
echo $vin->last() . "<br/>";
?>
