<?php
/*
  Produced 2019-2021
  By https://amattu.com/links/github
  Copy Alec M.
  License GNU Affero General Public License v3.0
*/

// Namespace
namespace amattu;

// Exception Classes
class InvalidLengthException extends \Exception {}
class InvalidCharacterException extends \Exception {}
class InvalidYearException extends \Exception {}
class EmptyOperationException extends \Exception {}
class DecodedYearMismatch extends \Exception {}

// Vehicle Identification Number Class
class VIN {
  // Class Variables
  protected $VIN = "";
  protected $Year = 0;
  protected $Country = "";
  protected $Region = "";
  protected $_Characters = "ABCDEFGHJKLMNPRSTUVWXYZ1234567890";
  protected $_YearMinimum = 1966;

  /**
  * Class constructor
  *
  * @param string $vin
  * @return None
  * @throws TypeError, InvalidLengthException, InvalidCharacterException, InvalidYearException
  **/
  public function __construct(string $vin, int $year = 0) {
    // Checks
    if (strlen($vin) !== 17) {
      throw new InvalidLengthException("VIN length is not 17 characters");
    }
    if ($this->validate($vin) !== true) {
      throw new InvalidCharacterException("VIN contains a invalid character");
    }
    if ($year !== 0 && $year < $_YearMinimum) {
      throw new InvalidYearException("VIN year provided is unsupported");
    }

    // Variables
    $this->VIN = strtoupper($vin);
    $this->Year = $year;
  }

  /**
  * Class stringify method
  *
  * @param None
  * @return string $vin
  * @throws None
  **/
  public function __tostring() : string {
    // Return
    return sprintf("VIN:%s Country:%s Region:%s", $this->VIN, $this->country(), $this->region());
  }

  /**
  * Detect vehicle production country
  *
  * @param None
  * @return string $country
  * @throws EmptyOperationException
  */
  public function country() : string {
    return "";
  }

  /**
  * Detect vehicle production region
  *
  * @param None
  * @return string $region
  * @throws EmptyOperationException
  */
  public function region() : string {
    return "";
  }

  /**
  * Detect vehicle production manufacturer
  *
  * @param None
  * @return string $manufacturer
  * @throws EmptyOperationException
  */
  public function manufacturer() : string {
    return "";
  }

  /**
  * Detect vehicle production year
  *
  * @param None
  * @return int $year
  * @throws InvalidYearException, DecodedYearMismatch
  */
  public function year() : int {
    return 0;
  }


  /**
  * Return the last characters of the VIN
  * (From character 17 to index)
  * (Default to 8)
  *
  * @param None|int $length
  * @return string $last
  * @throws None
  */
  public function last(int $length = 8) : string {
    // Checks
    if ($length > strlen($this->VIN)) {
      $length = 8;
    }

    // Return
    return substr($this->VIN, strlen($this->VIN) - $length, strlen($this->VIN));
  }

  /**
  * Validate VIN characters
  *
  * @param string $vin
  * @return bool valid
  * @throws TypeError
  */
  protected function validate(string $vin) : bool {
    // Variables
    $valid = true;

    // Loops
    for ($i = 0; $i < strlen($vin); $i++) {
      if (strpos($this->_Characters, strtoupper($vin[$i])) !== false) {
        continue;
      } else {
        $valid = false;
        break;
      }
    }

    // Return
    return $valid;
  }
}

// Vehicle Identification Number WMI
class WMI {
  // Class Variables
  protected $country;
  protected $region;
  protected $low;
  protected $high;
  protected $Characters = "ABCDEFGHJKLMNPRSTUVWXYZ1234567890";

  /**
  * Class constructor
  *
  * @param string $vin
  * @return None
  * @throws None
  **/
  public function __construct($country = "", $region = "", $low = "", $high = "") {
    // Variables
    $this->country = $country;
    $this->region = $region;
    $this->low = $low;
    $this->high = $high;
  }

  /**
  * Class stringify method
  *
  * @param None
  * @return string WMI Country, Region (Low, High)
  * @throws None
  **/
  public function __tostring() : string {
    return sprintf("%s, %s (%s, %s)", $this->country, $this->region, $this->low, $this->high);
  }

  private static function CodeToDec($code) {
    // Checks
    if (strlen($code) != 2) {
      return false;
    }

    // Return
    return (strpos($this->Characters, $code{0}) * strlen($this->Characters)) + strpos($this->Characters, $code{1});
  }

  public function match($vin) : boolean {
    $code = substr($vin,0,2);
    $_low = WMI::CodeToDec($this->low);
    $_high = WMI::CodeToDec($this->high);
    $_code = WMI::CodeToDec($code);

    return (($_code >= $_low) && ($_code <= $_high));
  }
}
?>
