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
class VIN implements Stringable {
  // Class Variables
  protected $VIN = null;
  protected $model_year = null;
  const VALID_CHARACTERS = "ABCDEFGHJKLMNPRSTUVWXYZ1234567890";

  /**
   * Class Constructor
   *
   * NOTE:
   *   (1) Vehicles prior to 1981 are officially
   *   unsupported, but might work by luck.
   *
   * @param string VIN
   * @throws None
   * @author Alec M. <https://amattu.com>
   * @date 2021-08-18
   */
  public function __construct(string $vin)
  {
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
    for ($i = 0; $i < strlen($this->VIN); $i++)
      if (strpos(VIN::VALID_CHARACTERS, $this->VIN[$i]) === false)
        return false;

    // Default
    return true;
  }

  /**
   * Decode VIN to Model Year
   *
   * NOTE:
   *   (1) A null return value is
   *   indicative of an invalid VIN.
   *
   * @return ?int model year
   * @throws None
   * @author Alec M. <https://amattu.com>
   * @date 2021-08-19
   */
  public function model_year() : ?int
  {
    // Check VIN
    if (!$this->valid())
      return null;

    // Check Existing Result
    if ($this->model_year)
      return $this->model_year;

    // Decode VIN
    if ($this->model_year = $this->vin_to_year())
      if (!is_numeric($this->VIN[6]))
        $this->model_year += 30;

    // Return
    return $this->model_year;
  }

  public function country() : string
  {
    return "";
  }

  public function region() : string
  {
    return "";
  }

  public function manufacturer() : string
  {
    return "";
  }

  public function model() : string
  {
    return "";
  }

  /**
   * Decode a VIN to model year
   *
   * @return ?int model year (1980-2010)
   * @throws TypeError
   * @author Alec M. <https://amattu.com>
   * @date 2021-08-19
   */
  private function vin_to_year() : ?int
  {
    switch ($this->VIN[9]) {
      case "A":
        return 1980;
      case "B":
        return 1981;
      case "C":
        return 1982;
      case "D":
        return 1983;
      case "E":
        return 1984;
      case "F":
        return 1985;
      case "G":
        return 1986;
      case "H":
        return 1987;
      case "J":
        return 1988;
      case "K":
        return 1989;
      case "L":
        return 1990;
      case "M":
        return 1991;
      case "N":
        return 1992;
      case "P":
        return 1993;
      case "R":
        return 1994;
      case "S":
        return 1995;
      case "T":
        return 1996;
      case "V":
        return 1997;
      case "W":
        return 1998;
      case "X":
        return 1999;
      case "Y":
        return 2000;
      case "1":
        return 2001;
      case "2":
        return 2002;
      case "3":
        return 2003;
      case "4":
        return 2004;
      case "5":
        return 2005;
      case "6":
        return 2006;
      case "7":
        return 2007;
      case "8":
        return 2008;
      case "9":
        return 2009;
    }

    // Default
    return null;
  }
}
