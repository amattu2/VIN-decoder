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
   * Class Constructor
   *
   * @param string VIN
   * @throws None
   * @author Alec M. <https://amattu.com>
   * @date 2021-08-18
   */
  public function __construct(string $vin)
  {
    // Variables
    $this->VIN = strtoupper($vin);
  }

  /**
   * Class Stringify
   *
   * @return string Formatted String
   * @throws None
   * @author Alec M. <https://amattu.com>
   * @date 2021-08-18
   */
  public function __tostring() : string
  {
    return $this->VIN;
  }

  /**
   * Return the last N-characters of a VIN
   *
   * NOTE
   *  (1) An argument is not required
   *  if not provided, will return the last
   *  8 characters of the VIN
   *
   * @param integer N
   * @return string N-characters
   * @throws None
   * @author Alec M. <https://amattu.com>
   * @date 2021-08-18
   */
  public function last(int $length = 8) : string
  {
    // Checks
    if ($length <= 0 || $length > strlen($this->VIN))
      $length = 8;

    // Return
    return substr($this->VIN, strlen($this->VIN) - $length, strlen($this->VIN));
  }

  /**
   * Validate the VIN number
   *
   * @return bool valid VIN
   * @throws None
   * @author Alec M. <https://amattu.com>
   * @date 2021-08-18
   */
  public function valid() : bool
  {
    // Check Length
    if (strlen($this->VIN) !== 17)
      return false;

    // Check Characters
    for ($i = 0; $i < strlen($vin); $i++)
      if (strpos($this->_Characters, $vin[$i]) === false)
        return false;

    // Default
    return true;
  }

  public function country() : string
  {
    return "";
  }

  public function region() : string
  {
    return "";
  }

  public function year() : int
  {
    return 0;
  }

  public function manufacturer() : string
  {
    return "";
  }

  public function model() : string
  {

  }
}
