<?php
/*
  Produced 2019-2021
  By https://amattu.com/links/github
  Copy Alec M.
  License GNU Affero General Public License v3.0
*/

// Namespace
namespace amattu;

// Vehicle Identification Number Class
class VIN implements Stringable {
  /**
   * VIN passed to constructor
   *
   * @var string
   */
  protected $VIN = null;

  /**
   * Decoded model year
   *
   * @var int
   */
  protected $model_year = null;

  /**
   * Valid VIN characters
   *
   * @var string
   */
  const VALID_CHARACTERS = "ABCDEFGHJKLMNPRSTUVWXYZ1234567890";

  /**
   * VIN positional weights for Check-Digit
   *
   * @var array
   */
  const POSITION_WEIGHTS = Array(8, 7, 6, 5, 4, 3, 2, 10, 0, 9, 8, 7, 6, 5, 4, 3, 2);

  /**
   * VIN transliterations for Check-Digit
   *
   * @var Array
   */
  const TRANSLITERATIONS = Array(
      "A" => 1, "B" => 2, "C" => 3, "D" => 4,
      "E" => 5, "F" => 6, "G" => 7, "H" => 8,
      "J" => 1, "K" => 2, "L" => 3, "M" => 4,
      "N" => 5, "P" => 7, "R" => 9, "S" => 2,
      "T" => 3, "U" => 4, "V" => 5, "W" => 6,
      "X" => 7, "Y" => 8, "Z" => 9
  );

  /**
   * Array of WMIs
   *
   * Region
   *   Country
   *     Manufacturer
   *
   * @var Array
   */
  private $WMI = Array(
    "North America" => Array(
      "United States" => Array(
        "1B" => "Dodge",
        "1C" => "Chrysler",
        "1F" => "Ford",
        "1G" => "General Motors",
        "1G1" => "Chevrolet",
        "1G2" => "Pontiac",
        "1G3" => "Oldsmobile",
        /* TBD */
      ),
      /* TBD */
    ),
  );

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
   * NOTE:
   *   (1) An argument is not required
   *   if not provided, will return the last
   *   8 characters of the VIN
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

    // Check Check-Digit
    if (!$this->validate_check_digit())
      return false;

    // Check Characters
    for ($i = 0; $i < strlen($this->VIN); $i++)
      if (strpos(VIN::VALID_CHARACTERS, $this->VIN[$i]) === false)
        return false;

    // Default
    return true;
  }

  /**
   * Get VIN WMI selection
   *
   * @return string WMI
   * @throws None
   * @author Alec M. <https://amattu.com>
   * @date 2021-08-19
   */
  public function get_wmi() : string
  {
    return substr($this->VIN, 0, 2);
  }

  /**
   * Get VIN VDS selection
   *
   * @return string VDS
   * @throws None
   * @author Alec M. <https://amattu.com>
   * @date 2021-08-19
   */
  public function get_vds() : string
  {
    return substr($this->VIN, 3, 7);
  }

  /**
   * Get VIN VIS selection
   *
   * @return string VIS
   * @throws None
   * @author Alec M. <https://amattu.com>
   * @date 2021-08-19
   */
  public function get_vis() : string
  {
    return substr($this->VIN, 9, 16);
  }

  /**
   * Get VIN check digit
   *
   * @return string check digit
   * @throws None
   * @author Alec M. <https://amattu.com>
   * @date 2021-08-19
   */
  public function get_check_digit() : string
  {
    return $this->VIN[8];
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
   * @return ?int model year (1980-2009)
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

  /**
   * Validate VIN check digit
   *
   * @return bool valid check digit
   * @throws None
   * @author Alec M. <https://amattu.com>
   * @see https://stackoverflow.com/a/3832074/4149581
   * @date 2021-08-19
   */
  private function validate_check_digit() : bool
  {
    // Variables
    $sum = 0;

    // Iterate through VIN
    for ($i = 0; $i < strlen($this->VIN); $i++)
      if (!is_numeric($this->VIN[$i]))
        $sum += VIN::TRANSLITERATIONS[$this->VIN[$i]] * VIN::POSITION_WEIGHTS[$i];
      else
        $sum += $this->VIN[$i] * VIN::POSITION_WEIGHTS[$i];

    // Find Check Digit
    $checkdigit = $sum % 11;
    if ($checkdigit == 10)
      $checkdigit = "X";

    return ($checkdigit == $this->VIN[8]);
  }

  /**
   * Decode WMI (first 2-3) characters to manufacturer
   *
   * @return array vehicle manufacturer
   * @throws None
   * @author Alec M. <https://amattu.com>
   * @date 2021-08-19
   */
  private function decode_WMI() : ?array
  {

  }
}
