<?php
/*
	Produced 2019
	By https://amattu.com/links/github
	Copy Alec M.
	License GNU Affero General Public License v3.0
*/

// Exception Classes
class InvalidLengthException extends Exception {}
class InvalidCharacterException extends Exception {}
class InvalidYearException extends Exception {}
class EmptyOperationException extends Exception {}
class DecodedYearMismatch extends Exception {}

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
		
		$brandx = strtoupper(substr($this->VIN,0,3));  # extract first 3 letters that represent WMI identifier
			/*
			* Info source: https://en.wikibooks.org/wiki/Vehicle_Identification_Numbers_(VIN_codes)/World_Manufacturer_Identifier_(WMI)
			* Update by Socol Ionut - www.euromarket.ro
			*/				

						
			if($brandx == 'AAV')  { $brand = 'Volkswagen South Africa'; }
			if($brandx == 'AC5')  { $brand = 'Hyundai South Africa'; }
			if($brandx == 'ADD')  { $brand = 'Hyundai South Africa'; }
			if($brandx == 'AFA')  { $brand = 'Ford South Africa'; }
			if($brandx == 'AHT')  { $brand = 'Toyota South Africa'; }
			if($brandx == 'JA3')  { $brand = 'Mitsubishi'; }
			if($brandx == 'JA4')  { $brand = 'Mitsubishi'; }
			if(strpos($brandx,'JA') !==false)  {  $brand='Isuzu'; }
			if(strpos($brandx,'JD') !==false)  {  $brand='Daihatsu'; }
			if(strpos($brandx,'JF') !==false)  {  $brand='Fuji Heavy Industries (Subaru)'; }
			if(strpos($brandx,'JHA-JHE') !==false)  {  $brand='Hino'; }
			if(strpos($brandx,'JHF-JHG, JHL-JHN, JHZ,') !==false)  {  $brand='Honda'; }
			if(strpos($brandx,'JH1-JH5') !==false)  {  $brand=''; }
			if(strpos($brandx,'JK') !==false)  {  $brand='Kawasaki (motorcycles)'; }
			if($brandx == 'JL5')  { $brand = 'Mitsubishi Fuso'; }
			if($brandx == 'JM1')  { $brand = 'Mazda'; }
			if($brandx == 'JMB')  { $brand = 'Mitsubishi Motors'; }
			if($brandx == 'JMY')  { $brand = 'Mitsubishi Motors'; }
			if($brandx == 'JMZ')  { $brand = 'Mazda'; }
			if(strpos($brandx,'JN') !==false)  {  $brand='Nissan'; }
			if(strpos($brandx,'JS') !==false)  {  $brand='Suzuki'; }
			if(strpos($brandx,'JT') !==false)  {  $brand='Toyota'; }
			if(strpos($brandx,'JY') !==false)  {  $brand='Yamaha (motorcycles)'; }
			if(strpos($brandx,'KL') !==false)  {  $brand='Daewoo General Motors South Korea'; }
			if(strpos($brandx,'KM') !==false)  {  $brand='Hyundai'; }
			if($brandx == 'KMY')  { $brand = 'Daelim (motorcycles)'; }
			if($brandx == 'KM1')  { $brand = 'Hyosung (motorcycles)'; }
			if(strpos($brandx,'KN') !==false)  {  $brand='Kia'; }
			if($brandx == 'KNM')  { $brand = 'Renault Samsung'; }
			if($brandx == 'KPA')  { $brand = 'SsangYong'; }
			if($brandx == 'KPT')  { $brand = 'SsangYong'; }
			if($brandx == 'LAE')  { $brand = 'Jinan Qingqi Motorcycle'; }
			if($brandx == 'LAL')  { $brand = 'Sundiro Honda Motorcycle'; }
			if($brandx == 'LAN')  { $brand = 'Changzhou Yamasaki Motorcycle'; }
			if($brandx == 'LBB')  { $brand = 'Zhejiang Qianjiang Motorcycle (Keeway/Generic)'; }
			if($brandx == 'LBE')  { $brand = 'Beijing Hyundai'; }
			if($brandx == 'LBM')  { $brand = 'Zongshen Piaggio'; }
			if($brandx == 'LBP')  { $brand = 'Chongqing Jainshe Yamaha (motorcycles)'; }
			if($brandx == 'LB2')  { $brand = 'Geely Motorcycles'; }
			if($brandx == 'LCE')  { $brand = 'Hangzhou Chunfeng Motorcycles (CFMOTO)'; }
			if($brandx == 'LDC')  { $brand = 'Dong Feng Peugeot Citroen (DPCA), China'; }
			if($brandx == 'LDD')  { $brand = 'Dandong Huanghai Automobile'; }
			if($brandx == 'LDF')  { $brand = 'Dezhou Fulu Vehicle (motorcycles)'; }
			if($brandx == 'LDN')  { $brand = 'SouEast Motor'; }
			if($brandx == 'LDY')  { $brand = 'Zhongtong Coach, China'; }
			if($brandx == 'LET')  { $brand = 'Jiangling-Isuzu Motors, China'; }
			if($brandx == 'LE4')  { $brand = 'Beijing Benz, China'; }
			if($brandx == 'LFB')  { $brand = 'FAW, China (busses)'; }
			if($brandx == 'LFG')  { $brand = 'Taizhou Chuanl Motorcycle Manufacturing'; }
			if($brandx == 'LFP')  { $brand = 'FAW, China (passenger vehicles)'; }
			if($brandx == 'LFT')  { $brand = 'FAW, China (trailers)'; }
			if($brandx == 'LFV')  { $brand = 'FAW-Volkswagen, China'; }
			if($brandx == 'LFW')  { $brand = 'FAW JieFang, China'; }
			if($brandx == 'LFY')  { $brand = 'Changshu Light Motorcycle Factory'; }
			if($brandx == 'LGB')  { $brand = 'Dong Feng (DFM), China'; }
			if($brandx == 'LGH')  { $brand = 'Qoros (formerly Dong Feng (DFM)), China'; }
			if($brandx == 'LGX')  { $brand = 'BYD Auto, China'; }
			if($brandx == 'LHB')  { $brand = 'Beijing Automotive Industry Holding'; }
			if($brandx == 'LH1')  { $brand = 'FAW-Haima, China'; }
			if($brandx == 'LJC')  { $brand = 'JAC, China'; }
			if($brandx == 'LJ1')  { $brand = 'JAC, China'; }
			if($brandx == 'LKL')  { $brand = 'Suzhou King Long, China'; }
			if($brandx == 'LL6')  { $brand = 'Hunan Changfeng Manufacture Joint-Stock'; }
			if($brandx == 'LL8')  { $brand = 'Linhai (ATV)'; }
			if($brandx == 'LMC')  { $brand = 'Suzuki Hong Kong (motorcycles)'; }
			if($brandx == 'LPR')  { $brand = 'Yamaha Hong Kong (motorcycles)'; }
			if($brandx == 'LPS')  { $brand = 'Polestar (Volvo) (Sweden)'; }
			if($brandx == 'LSG')  { $brand = 'Shanghai General Motors, China'; }
			if($brandx == 'LSJ')  { $brand = 'MG Motor UK Limited - SAIC Motor, Shanghai, China'; }
			if($brandx == 'LSV')  { $brand = 'Shanghai Volkswagen, China'; }
			if($brandx == 'LSY')  { $brand = 'Brilliance Zhonghua'; }
			if($brandx == 'LTP')  { $brand = 'National Electric Vehicle Sweden AB (NEVS)'; }
			if($brandx == 'LTV')  { $brand = 'Toyota Tian Jin'; }
			if($brandx == 'LUC')  { $brand = 'Guangqi Honda, China'; }
			if($brandx == 'LVS')  { $brand = 'Ford Chang An'; }
			if($brandx == 'LVV')  { $brand = 'Chery, China'; }
			if($brandx == 'LVZ')  { $brand = 'Dong Feng Sokon Motor Company (DFSK)'; }
			if($brandx == 'LV3')  { $brand = 'National Electric Vehicle Sweden AB (NEVS)'; }
			if($brandx == 'LZM')  { $brand = 'MAN China'; }
			if($brandx == 'LZE')  { $brand = 'Isuzu Guangzhou, China'; }
			if($brandx == 'LZG')  { $brand = 'Shaanxi Automobile Group, China'; }
			if($brandx == 'LZP')  { $brand = 'Zhongshan Guochi Motorcycle (Baotian)'; }
			if($brandx == 'LZY')  { $brand = 'Yutong Zhengzhou, China'; }
			if($brandx == 'LZZ')  { $brand = 'Chongqing Shuangzing Mech & Elec (Howo)'; }
			if($brandx == 'L4B')  { $brand = 'Xingyue Group (motorcycles)'; }
			if($brandx == 'L5C')  { $brand = 'KangDi (ATV)'; }
			if($brandx == 'L5K')  { $brand = 'Zhejiang Yongkang Easy Vehicle'; }
			if($brandx == 'L5N')  { $brand = 'Zhejiang Taotao, China (ATV & motorcycles)'; }
			if($brandx == 'L5Y')  { $brand = 'Merato Motorcycle Taizhou Zhongneng'; }
			if($brandx == 'L85')  { $brand = 'Zhejiang Yongkang Huabao Electric Appliance'; }
			if($brandx == 'L8X')  { $brand = 'Zhejiang Summit Huawin Motorcycle'; }
			if($brandx == 'MAB')  { $brand = 'Mahindra & Mahindra'; }
			if($brandx == 'MAC')  { $brand = 'Mahindra & Mahindra'; }
			if($brandx == 'MAJ')  { $brand = 'Ford India'; }
			if($brandx == 'MAK')  { $brand = 'Honda Siel Cars India'; }
			if($brandx == 'MAL')  { $brand = 'Hyundai India'; }
			if($brandx == 'MAT')  { $brand = 'Tata Motors'; }
			if($brandx == 'MA1')  { $brand = 'Mahindra & Mahindra'; }
			if($brandx == 'MA3')  { $brand = 'Suzuki India (Maruti)'; }
			if($brandx == 'MA6')  { $brand = 'GM India'; }
			if($brandx == 'MA7')  { $brand = 'Mitsubishi India (formerly Honda)'; }
			if($brandx == 'MB8')  { $brand = 'Suzuki India Motorcycles'; }
			if($brandx == 'MBH')  { $brand = 'Suzuki India (Maruti)'; }
			if($brandx == 'MBJ')  { $brand = 'Toyota India'; }
			if($brandx == 'MBR')  { $brand = 'Mercedes-Benz India'; }
			if($brandx == 'MB1')  { $brand = 'Ashok Leyland'; }
			if($brandx == 'MCA')  { $brand = 'Fiat India'; }
			if($brandx == 'MCB')  { $brand = 'GM India'; }
			if($brandx == 'MC2')  { $brand = 'Volvo Eicher commercial vehicles limited.'; }
			if($brandx == 'MDH')  { $brand = 'Nissan India'; }
			if($brandx == 'MD2')  { $brand = 'Bajaj Auto'; }
			if($brandx == 'MD9')  { $brand = 'Shuttle Cars India'; }
			if($brandx == 'MEC')  { $brand = 'Daimler India Commercial Vehicles'; }
			if($brandx == 'MEE')  { $brand = 'Renault India'; }
			if($brandx == 'MEX')  { $brand = 'Volkswagen India'; }
			if($brandx == 'MHF')  { $brand = 'Toyota Indonesia'; }
			if($brandx == 'MHR')  { $brand = 'Honda Indonesia'; }
			if($brandx == 'MLC')  { $brand = 'Suzuki Thailand'; }
			if($brandx == 'NAA')  { $brand = 'Iran Khodro (Peugeot Iran)'; }
			if($brandx == 'NAP')  { $brand = 'Pars Khodro'; }
			if($brandx == 'MLH')  { $brand = 'Honda Thailand'; }
			if($brandx == 'MMA')  { $brand = 'Mitsubishi Thailand'; }
			if($brandx == 'MMB')  { $brand = 'Mitsubishi Thailand'; }
			if($brandx == 'MMC')  { $brand = 'Mitsubishi Thailand'; }
			if($brandx == 'MMM')  { $brand = 'Chevrolet Thailand'; }
			if($brandx == 'MMS')  { $brand = 'Suzuki Thailand'; }
			if($brandx == 'MMT')  { $brand = 'Mitsubishi Thailand'; }
			if($brandx == 'MMU')  { $brand = 'Holden Thailand'; }
			if($brandx == 'MM8')  { $brand = 'Mazda Thailand'; }
			if($brandx == 'MNB')  { $brand = 'Ford Thailand'; }
			if($brandx == 'MNT')  { $brand = 'Nissan Thailand'; }
			if($brandx == 'MPA')  { $brand = 'Isuzu Thailand'; }
			if($brandx == 'MP1')  { $brand = 'Isuzu Thailand'; }
			if($brandx == 'MRH')  { $brand = 'Honda Thailand'; }
			if($brandx == 'MR0')  { $brand = 'Toyota Thailand'; }
			if($brandx == 'MS0')  { $brand = 'SSS MOTORS Myanmar'; }
			if($brandx == 'MS3')  { $brand = 'Suzuki Myanmar Motor Co.,Ltd.'; }
			if($brandx == 'NLA')  { $brand = 'Honda Türkiye'; }
			if($brandx == 'NLE')  { $brand = 'Mercedes-Benz Türk Truck'; }
			if($brandx == 'NLH')  { $brand = 'Hyundai Assan'; }
			if($brandx == 'NLR')  { $brand = 'OTOKAR'; }
			if($brandx == 'NLT')  { $brand = 'TEMSA'; }
			if($brandx == 'NMB')  { $brand = 'Mercedes-Benz Türk Buses'; }
			if($brandx == 'NMC')  { $brand = 'BMC'; }
			if($brandx == 'NM0')  { $brand = 'Ford Turkey'; }
			if($brandx == 'NM4')  { $brand = 'Tofaş Türk'; }
			if($brandx == 'NMT')  { $brand = 'Toyota Türkiye'; }
			if($brandx == 'NNA')  { $brand = 'Isuzu Turkey'; }
			if($brandx == 'PE1')  { $brand = 'Ford Philippines'; }
			if($brandx == 'PE3')  { $brand = 'Mazda Philippines'; }
			if($brandx == 'PL1')  { $brand = 'Proton, Malaysia'; }
			if($brandx == 'PNA')  { $brand = 'NAZA, Malaysia (Peugeot)'; }
			if($brandx == 'R2P')  { $brand = 'Evoke Electric Motorcycles HK'; }
			if($brandx == 'RA1')  { $brand = 'Steyr Trucks International FZE, UAE'; }
			if($brandx == 'RFB')  { $brand = 'Kymco, Taiwan'; }
			if($brandx == 'RFG')  { $brand = 'Sanyang SYM, Taiwan'; }
			if($brandx == 'RFL')  { $brand = 'Adly, Taiwan'; }
			if($brandx == 'RFT')  { $brand = 'CPI, Taiwan'; }
			if($brandx == 'RF3')  { $brand = 'Aeon Motor, Taiwan'; }
			if($brandx == 'SAB')  { $brand = 'Optare'; }
			if($brandx == 'SAD')  { $brand = 'Jaguar (F-Pace, I-Pace)'; }
			if($brandx == 'SAL')  { $brand = 'Land Rover'; }
			if($brandx == 'SAJ')  { $brand = 'Jaguar'; }
			if($brandx == 'SAR')  { $brand = 'Rover'; }
			if($brandx == 'SAX')  { $brand = 'Austin-Rover'; }
			if($brandx == 'SB1')  { $brand = 'Toyota UK'; }
			if($brandx == 'SBM')  { $brand = 'McLaren'; }
			if($brandx == 'SCA')  { $brand = 'Rolls Royce'; }
			if($brandx == 'SCB')  { $brand = 'Bentley'; }
			if($brandx == 'SCC')  { $brand = 'Lotus Cars'; }
			if($brandx == 'SCE')  { $brand = 'DeLorean Motor Cars N. Ireland (UK)'; }
			if($brandx == 'SCF')  { $brand = 'Aston'; }
			if($brandx == 'SCK')  { $brand = 'iFor Williams'; }
			if($brandx == 'SDB')  { $brand = 'Peugeot UK (formerly Talbot)'; }
			if($brandx == 'SED')  { $brand = 'General Motors Luton Plant'; }
			if($brandx == 'SEY')  { $brand = 'LDV'; }
			if($brandx == 'SFA')  { $brand = 'Ford UK'; }
			if($brandx == 'SFD')  { $brand = 'Alexander Dennis UK'; }
			if($brandx == 'SHH')  { $brand = 'Honda UK'; }
			if($brandx == 'SHS')  { $brand = 'Honda UK'; }
			if($brandx == 'SJN')  { $brand = 'Nissan UK'; }
			if($brandx == 'SKF')  { $brand = 'Vauxhall'; }
			if($brandx == 'SLP')  { $brand = 'JCB Research UK'; }
			if($brandx == 'SMT')  { $brand = 'Triumph Motorcycles'; }
			if($brandx == 'SUF')  { $brand = 'Fiat Auto Poland'; }
			if($brandx == 'SUL')  { $brand = 'FSC (Poland)'; }
			if($brandx == 'SUP')  { $brand = 'FSO-Daewoo (Poland)'; }
			if($brandx == 'SU9')  { $brand = 'Solaris Bus & Coach (Poland)'; }
			if($brandx == 'SUU')  { $brand = 'Solaris Bus & Coach (Poland)'; }
			if($brandx == 'SWV')  { $brand = 'TA-NO (Poland)'; }
			if($brandx == 'TCC')  { $brand = 'Micro Compact Car AG (smart 1998-1999)'; }
			if($brandx == 'TDM')  { $brand = 'QUANTYA Swiss Electric Movement (Switzerland)'; }
			if($brandx == 'TK9')  { $brand = 'SOR buses (Czech Republic)'; }
			if($brandx == 'TMA')  { $brand = 'Hyundai Motor Manufacturing Czech'; }
			if($brandx == 'TMB')  { $brand = 'Škoda (Czech Republic)'; }
			if($brandx == 'TMK')  { $brand = 'Karosa (Czech Republic)'; }
			if($brandx == 'TMP')  { $brand = 'Škoda trolleybuses (Czech Republic)'; }
			if($brandx == 'TMT')  { $brand = 'Tatra (Czech Republic)'; }
			if($brandx == 'TM9')  { $brand = 'Škoda trolleybuses (Czech Republic)'; }
			if($brandx == 'TNE')  { $brand = 'TAZ'; }
			if($brandx == 'TN9')  { $brand = 'Karosa (Czech Republic)'; }
			if($brandx == 'TRA')  { $brand = 'Ikarus Bus'; }
			if($brandx == 'TRU')  { $brand = 'Audi Hungary'; }
			if($brandx == 'TSB')  { $brand = 'Ikarus Bus'; }
			if($brandx == 'TSE')  { $brand = 'Ikarus Egyedi Autobuszgyar, (Hungary)'; }
			if($brandx == 'TSM')  { $brand = 'Suzuki Hungary'; }
			if($brandx == 'TW1')  { $brand = 'Toyota Caetano Portugal'; }
			if($brandx == 'TYA')  { $brand = 'Mitsubishi Trucks Portugal'; }
			if($brandx == 'TYB')  { $brand = 'Mitsubishi Trucks Portugal'; }
			if($brandx == 'UU1')  { $brand = 'Renault Dacia, (Romania)'; }
			if($brandx == 'UU2')  { $brand = 'Oltcit'; }
			if($brandx == 'UU3')  { $brand = 'ARO'; }
			if($brandx == 'UU4')  { $brand = 'Roman SA'; }
			if($brandx == 'UU5')  { $brand = 'Rocar'; }
			if($brandx == 'UU6')  { $brand = 'Daewoo Romania'; }
			if($brandx == 'UU7')  { $brand = 'Euro Bus Diamond'; }
			if($brandx == 'UU9')  { $brand = 'Astra Bus'; }
			if($brandx == 'UZT')  { $brand = 'UTB (Uzina de Tractoare Brașov)'; }
			if($brandx == 'U5Y')  { $brand = 'Kia Motors Slovakia'; }
			if($brandx == 'U6Y')  { $brand = 'Kia Motors Slovakia'; }
			if($brandx == 'VAG')  { $brand = 'Magna Steyr Puch'; }
			if($brandx == 'VAN')  { $brand = 'MAN Austria'; }
			if($brandx == 'VBK')  { $brand = 'KTM (Motorcycles)'; }
			if($brandx == 'VF1')  { $brand = 'Renault'; }
			if($brandx == 'VF2')  { $brand = 'Renault'; }
			if($brandx == 'VF3')  { $brand = 'Peugeot'; }
			if($brandx == 'VF4')  { $brand = 'Talbot'; }
			if($brandx == 'VF6')  { $brand = 'Renault (Trucks & Buses)'; }
			if($brandx == 'VF7')  { $brand = 'Citroën'; }
			if($brandx == 'VF8')  { $brand = 'Matra'; }
			if(strpos($brandx,'VF9/795') !==false)  {  $brand='Bugatti'; }
			if($brandx == 'VG5')  { $brand = 'MBK (motorcycles)'; }
			if($brandx == 'VLU')  { $brand = 'Scania France'; }
			if($brandx == 'VN1')  { $brand = 'SOVAB (France)'; }
			if($brandx == 'VNE')  { $brand = 'Irisbus (France)'; }
			if($brandx == 'VNK')  { $brand = 'Toyota France'; }
			if($brandx == 'VNV')  { $brand = 'Renault-Nissan'; }
			if($brandx == 'VSA')  { $brand = 'Mercedes-Benz Spain'; }
			if($brandx == 'VSE')  { $brand = 'Suzuki Spain (Santana Motors)'; }
			if($brandx == 'VSK')  { $brand = 'Nissan Spain'; }
			if($brandx == 'VSS')  { $brand = 'SEAT'; }
			if($brandx == 'VSX')  { $brand = 'Opel Spain'; }
			if($brandx == 'VS6')  { $brand = 'Ford Spain'; }
			if($brandx == 'VS7')  { $brand = 'Citroën Spain'; }
			if($brandx == 'VS9')  { $brand = 'Carrocerias Ayats (Spain)'; }
			if($brandx == 'VTH')  { $brand = 'Derbi (motorcycles)'; }
			if($brandx == 'VTL')  { $brand = 'Yamaha Spain (motorcycles)'; }
			if($brandx == 'VTT')  { $brand = 'Suzuki Spain (motorcycles)'; }
			if($brandx == 'VV9')  { $brand = 'TAURO Spain'; }
			if($brandx == 'VWA')  { $brand = 'Nissan Spain'; }
			if($brandx == 'VWV')  { $brand = 'Volkswagen Spain'; }
			if($brandx == 'VX1')  { $brand = 'Zastava / Yugo Serbia'; }
			if($brandx == 'WAG')  { $brand = 'Neoplan'; }
			if($brandx == 'WAU')  { $brand = 'Audi'; }
			if($brandx == 'WA1')  { $brand = 'Audi SUV'; }
			if($brandx == 'WBA')  { $brand = 'BMW'; }
			if($brandx == 'WBS')  { $brand = 'BMW M'; }
			if($brandx == 'WBW')  { $brand = 'BMW'; }
			if($brandx == 'WBY')  { $brand = 'BMW'; }
			if($brandx == 'WDA')  { $brand = 'Daimler'; }
			if($brandx == 'WDB')  { $brand = 'Mercedes-Benz'; }
			if($brandx == 'WDC')  { $brand = 'DaimlerChrysler'; }
			if($brandx == 'WDD')  { $brand = 'Mercedes-Benz'; }
			if($brandx == 'WDF')  { $brand = 'Mercedes-Benz (commercial vehicles)'; }
			if($brandx == 'WEB')  { $brand = 'Evobus GmbH (Mercedes-Bus)'; }
			if($brandx == 'WJM')  { $brand = 'Iveco Magirus'; }
			if($brandx == 'WF0')  { $brand = 'Ford Germany'; }
			if($brandx == 'WKE')  { $brand = 'Fahrzeugwerk Bernard Krone (truck trailers)'; }
			if($brandx == 'WKK')  { $brand = 'Kässbohrer/Setra'; }
			if($brandx == 'WMA')  { $brand = 'MAN Germany'; }
			if($brandx == 'WME')  { $brand = 'smart'; }
			if($brandx == 'WMW')  { $brand = 'MINI'; }
			if($brandx == 'WMX')  { $brand = 'Mercedes-AMG'; }
			if($brandx == 'WP0')  { $brand = 'Porsche'; }
			if($brandx == 'WP1')  { $brand = 'Porsche SUV'; }
			if($brandx == 'WSM')  { $brand = 'Schmitz-Cargobull (truck trailers)'; }
			if($brandx == 'W09')  { $brand = 'RUF'; }
			if($brandx == 'W0L')  { $brand = 'Opel'; }
			if($brandx == 'W0V')  { $brand = 'Opel (since 2017)'; }
			if($brandx == 'WUA')  { $brand = 'Audi Sport GmbH (formerly quattro GmbH)'; }
			if($brandx == 'WVG')  { $brand = 'Volkswagen MPV/SUV'; }
			if($brandx == 'WVW')  { $brand = 'Volkswagen'; }
			if($brandx == 'WV1')  { $brand = 'Volkswagen Commercial Vehicles'; }
			if($brandx == 'WV2')  { $brand = 'Volkswagen Bus/Van'; }
			if($brandx == 'WV3')  { $brand = 'Volkswagen Trucks'; }
			if($brandx == 'XLB')  { $brand = 'Volvo (NedCar)'; }
			if($brandx == 'XLE')  { $brand = 'Scania Netherlands'; }
			if($brandx == 'XLR')  { $brand = 'DAF (trucks)'; }
			if(strpos($brandx,'XL9/363') !==false)  {  $brand='Spyker'; }
			if($brandx == 'XMC')  { $brand = 'Mitsubishi (NedCar)'; }
			if($brandx == 'XMG')  { $brand = 'VDL Bus & Coach'; }
			if($brandx == 'XTA')  { $brand = 'Lada/AvtoVAZ (Russia)'; }
			if($brandx == 'XTC')  { $brand = 'KAMAZ (Russia)'; }
			if($brandx == 'XTH')  { $brand = 'GAZ (Russia)'; }
			if($brandx == 'XTT')  { $brand = 'UAZ/Sollers (Russia)'; }
			if($brandx == 'XTU')  { $brand = 'Trolza (Russia)'; }
			if($brandx == 'XTY')  { $brand = 'LiAZ (Russia)'; }
			if($brandx == 'XUF')  { $brand = 'General Motors Russia'; }
			if($brandx == 'XUU')  { $brand = 'AvtoTor (Russia, General Motors SKD)'; }
			if($brandx == 'XW8')  { $brand = 'Volkswagen Group Russia'; }
			if($brandx == 'XWB')  { $brand = 'UZ-Daewoo (Uzbekistan)'; }
			if($brandx == 'XWE')  { $brand = 'AvtoTor (Russia, Hyundai-Kia SKD)'; }
			if($brandx == 'X1M')  { $brand = 'PAZ (Russia)'; }
			if($brandx == 'X4X')  { $brand = 'AvtoTor (Russia, BMW SKD)'; }
			if($brandx == 'X7L')  { $brand = 'Renault AvtoFramos (Russia)'; }
			if($brandx == 'X7M')  { $brand = 'Hyundai TagAZ (Russia)'; }
			if($brandx == 'YBW')  { $brand = 'Volkswagen Belgium'; }
			if($brandx == 'YB1')  { $brand = 'Volvo Trucks Belgium'; }
			if($brandx == 'YCM')  { $brand = 'Mazda Belgium'; }
			if($brandx == 'YE2')  { $brand = 'Van Hool (buses)'; }
			if($brandx == 'YH2')  { $brand = 'BRP Finland (Lynx snowmobiles)'; }
			if($brandx == 'YK1')  { $brand = 'Saab-Valmet Finland'; }
			if($brandx == 'YSC')  { $brand = 'Cadillac (Saab)'; }
			if($brandx == 'YS2')  { $brand = 'Scania AB'; }
			if($brandx == 'YS3')  { $brand = 'Saab'; }
			if($brandx == 'YS4')  { $brand = 'Scania Bus'; }
			if($brandx == 'YTN')  { $brand = 'Saab NEVS'; }
			if(strpos($brandx,'YT9/007') !==false)  {  $brand='Koenigsegg'; }
			if(strpos($brandx,'YT9/034') !==false)  {  $brand='Carvia'; }
			if($brandx == 'YU7')  { $brand = 'Husaberg (motorcycles)'; }
			if($brandx == 'YVV')  { $brand = 'Polestar (Volvo) (Sweden)'; }
			if($brandx == 'YV1')  { $brand = 'Volvo Cars'; }
			if($brandx == 'YV4')  { $brand = 'Volvo Cars'; }
			if($brandx == 'YV2')  { $brand = 'Volvo Trucks'; }
			if($brandx == 'YV3')  { $brand = 'Volvo Buses'; }
			if($brandx == 'Y3M')  { $brand = 'MAZ (Belarus)'; }
			if($brandx == 'Y6D')  { $brand = 'Zaporozhets/AvtoZAZ (Ukraine)'; }
			if($brandx == 'ZAA')  { $brand = 'Autobianchi'; }
			if($brandx == 'ZAM')  { $brand = 'Maserati'; }
			if($brandx == 'ZAP')  { $brand = 'Piaggio/Vespa/Gilera'; }
			if($brandx == 'ZAR')  { $brand = 'Alfa Romeo'; }
			if($brandx == 'ZBN')  { $brand = 'Benelli'; }
			if($brandx == 'ZCG')  { $brand = 'Cagiva SpA / MV Agusta'; }
			if($brandx == 'ZCF')  { $brand = 'Iveco'; }
			if($brandx == 'ZDC')  { $brand = 'Honda Italia Industriale SpA'; }
			if($brandx == 'ZDM')  { $brand = 'Ducati Motor Holdings SpA'; }
			if($brandx == 'ZDF')  { $brand = 'Ferrari Dino'; }
			if($brandx == 'ZD0')  { $brand = 'Yamaha Italy'; }
			if($brandx == 'ZD3')  { $brand = 'Beta Motor'; }
			if($brandx == 'ZD4')  { $brand = 'Aprilia'; }
			if($brandx == 'ZFA')  { $brand = 'Fiat'; }
			if($brandx == 'ZFC')  { $brand = 'Fiat V.I.'; }
			if($brandx == 'ZFF')  { $brand = 'Ferrari'; }
			if($brandx == 'ZGU')  { $brand = 'Moto Guzzi'; }
			if($brandx == 'ZHW')  { $brand = 'Lamborghini'; }
			if($brandx == 'ZJM')  { $brand = 'Malaguti'; }
			if($brandx == 'ZJN')  { $brand = 'Innocenti'; }
			if($brandx == 'ZKH')  { $brand = 'Husqvarna Motorcycles Italy'; }
			if($brandx == 'ZLA')  { $brand = 'Lancia'; }
			if($brandx == 'Z8M')  { $brand = 'Marussia (Russia)'; }
			if($brandx == '1B3')  { $brand = 'Dodge'; }
			if($brandx == '1C3')  { $brand = 'Chrysler'; }
			if($brandx == '1C4')  { $brand = 'Chrysler'; }
			if($brandx == '1C6')  { $brand = 'Chrysler'; }
			if($brandx == '1D3')  { $brand = 'Dodge'; }
			if($brandx == '1FA')  { $brand = 'Ford Motor Company'; }
			if($brandx == '1FB')  { $brand = 'Ford Motor Company'; }
			if($brandx == '1FC')  { $brand = 'Ford Motor Company'; }
			if($brandx == '1FD')  { $brand = 'Ford Motor Company'; }
			if($brandx == '1FM')  { $brand = 'Ford Motor Company'; }
			if($brandx == '1FT')  { $brand = 'Ford Motor Company'; }
			if($brandx == '1FU')  { $brand = 'Freightliner'; }
			if($brandx == '1FV')  { $brand = 'Freightliner'; }
			if($brandx == '1F9')  { $brand = 'FWD Corp.'; }
			if(strpos($brandx,'1G') !==false)  {  $brand='General Motors USA'; }
			if($brandx == '1GC')  { $brand = 'Chevrolet Truck USA'; }
			if($brandx == '1GT')  { $brand = 'GMC Truck USA'; }
			if($brandx == '1G1')  { $brand = 'Chevrolet USA'; }
			if($brandx == '1G2')  { $brand = 'Pontiac USA'; }
			if($brandx == '1G3')  { $brand = 'Oldsmobile USA'; }
			if($brandx == '1G4')  { $brand = 'Buick USA'; }
			if($brandx == '1G6')  { $brand = 'Cadillac USA'; }
			if($brandx == '1G8')  { $brand = 'Saturn USA'; }
			if($brandx == '1GM')  { $brand = 'Pontiac USA'; }
			if($brandx == '1GY')  { $brand = 'Cadillac USA'; }
			if(strpos($brandx,'1H') !==false)  {  $brand='Honda USA'; }
			if($brandx == '1HD')  { $brand = 'Harley-Davidson'; }
			if($brandx == '1HT')  { $brand = 'International Truck and Engine Corp. USA'; }
			if($brandx == '1J4')  { $brand = 'Jeep'; }
			if($brandx == '1J8')  { $brand = 'Jeep'; }
			if(strpos($brandx,'1L') !==false)  {  $brand='Lincoln USA'; }
			if($brandx == '1ME')  { $brand = 'Mercury USA'; }
			if($brandx == '1M1')  { $brand = 'Mack Truck USA'; }
			if($brandx == '1M2')  { $brand = 'Mack Truck USA'; }
			if($brandx == '1M3')  { $brand = 'Mack Truck USA'; }
			if($brandx == '1M4')  { $brand = 'Mack Truck USA'; }
			if($brandx == '1M9')  { $brand = 'Mynatt Truck & Equipment'; }
			if(strpos($brandx,'1N') !==false)  {  $brand='Nissan USA'; }
			if($brandx == '1NX')  { $brand = 'NUMMI USA'; }
			if($brandx == '1P3')  { $brand = 'Plymouth USA'; }
			if($brandx == '1PY')  { $brand = 'John Deere USA'; }
			if($brandx == '1R9')  { $brand = 'Roadrunner Hay Squeeze USA'; }
			if($brandx == '1VW')  { $brand = 'Volkswagen USA'; }
			if($brandx == '1XK')  { $brand = 'Kenworth USA'; }
			if($brandx == '1XP')  { $brand = 'Peterbilt USA'; }
			if($brandx == '1YV')  { $brand = 'Mazda USA (AutoAlliance International)'; }
			if($brandx == '1ZV')  { $brand = 'Ford (AutoAlliance International)'; }
			if($brandx == '2A4')  { $brand = 'Chrysler Canada'; }
			if($brandx == '2BP')  { $brand = 'Bombardier Recreational Products'; }
			if($brandx == '2B3')  { $brand = 'Dodge Canada'; }
			if($brandx == '2B7')  { $brand = 'Dodge Canada'; }
			if($brandx == '2C3')  { $brand = 'Chrysler Canada'; }
			if($brandx == '2CN')  { $brand = 'CAMI'; }
			if($brandx == '2D3')  { $brand = 'Dodge Canada'; }
			if($brandx == '2FA')  { $brand = 'Ford Motor Company Canada'; }
			if($brandx == '2FB')  { $brand = 'Ford Motor Company Canada'; }
			if($brandx == '2FC')  { $brand = 'Ford Motor Company Canada'; }
			if($brandx == '2FM')  { $brand = 'Ford Motor Company Canada'; }
			if($brandx == '2FT')  { $brand = 'Ford Motor Company Canada'; }
			if($brandx == '2FU')  { $brand = 'Freightliner'; }
			if($brandx == '2FV')  { $brand = 'Freightliner'; }
			if($brandx == '2FZ')  { $brand = 'Sterling'; }
			if($brandx == '2Gx')  { $brand = 'General Motors Canada'; }
			if($brandx == '2G1')  { $brand = 'Chevrolet Canada'; }
			if($brandx == '2G2')  { $brand = 'Pontiac Canada'; }
			if($brandx == '2G3')  { $brand = 'Oldsmobile Canada'; }
			if($brandx == '2G4')  { $brand = 'Buick Canada'; }
			if($brandx == '2G9')  { $brand = 'mfr. of less than 1000/ yr. Canada'; }
			if($brandx == '2HG')  { $brand = 'Honda Canada'; }
			if($brandx == '2HK')  { $brand = 'Honda Canada'; }
			if($brandx == '2HJ')  { $brand = 'Honda Canada'; }
			if($brandx == '2HM')  { $brand = 'Hyundai Canada'; }
			if(strpos($brandx,'2M') !==false)  {  $brand='Mercury'; }
			if($brandx == '2NV')  { $brand = 'Nova Bus Canada'; }
			if($brandx == '2P3')  { $brand = 'Plymouth Canada'; }
			if(strpos($brandx,'2T') !==false)  {  $brand='Toyota Canada'; }
			if($brandx == '2TP')  { $brand = 'Triple E Canada LTD'; }
			if($brandx == '2V4')  { $brand = 'Volkswagen Canada'; }
			if($brandx == '2V8')  { $brand = 'Volkswagen Canada'; }
			if($brandx == '2WK')  { $brand = 'Western Star'; }
			if($brandx == '2WL')  { $brand = 'Western Star'; }
			if($brandx == '2WM')  { $brand = 'Western Star'; }
			if($brandx == '3C4')  { $brand = 'Chrysler Mexico'; }
			if($brandx == '3C6')  { $brand = 'RAM Mexico'; }
			if($brandx == '3D3')  { $brand = 'Dodge Mexico'; }
			if($brandx == '3D4')  { $brand = 'Dodge Mexico'; }
			if($brandx == '3FA')  { $brand = 'Ford Motor Company Mexico'; }
			if($brandx == '3FE')  { $brand = 'Ford Motor Company Mexico'; }
			if(strpos($brandx,'3G') !==false)  {  $brand='General Motors Mexico'; }
			if(strpos($brandx,'3H') !==false)  {  $brand='Honda Mexico'; }
			if($brandx == '3JB')  { $brand = 'BRP Mexico (all-terrain vehicles)'; }
			if($brandx == '3MD')  { $brand = 'Mazda Mexico'; }
			if($brandx == '3MZ')  { $brand = 'Mazda Mexico'; }
			if(strpos($brandx,'3N') !==false)  {  $brand='Nissan Mexico'; }
			if($brandx == '3NS')  { $brand = 'Polaris Industries USA'; }
			if($brandx == '3NE')  { $brand = 'Polaris Industries USA'; }
			if($brandx == '3P3')  { $brand = 'Plymouth Mexico'; }
			if($brandx == '3VW')  { $brand = 'Volkswagen Mexico'; }
			if($brandx == '46J')  { $brand = 'Federal Motors Inc. USA'; }
			if($brandx == '4EN')  { $brand = 'Emergency One USA'; }
			if(strpos($brandx,'4F') !==false)  {  $brand='Mazda USA'; }
			if($brandx == '4JG')  { $brand = 'Mercedes-Benz USA'; }
			if(strpos($brandx,'4M') !==false)  {  $brand='Mercury'; }
			if($brandx == '4P1')  { $brand = 'Pierce Manufacturing Inc. USA'; }
			if($brandx == '4RK')  { $brand = 'Nova Bus USA'; }
			if(strpos($brandx,'4S') !==false)  {  $brand='Subaru-Isuzu Automotive'; }
			if(strpos($brandx,'4T') !==false)  {  $brand='Toyota'; }
			if($brandx == '4T9')  { $brand = 'Lumen Motors'; }
			if($brandx == '4UF')  { $brand = 'Arctic Cat Inc.'; }
			if($brandx == '4US')  { $brand = 'BMW USA'; }
			if($brandx == '4UZ')  { $brand = 'Frt-Thomas Bus'; }
			if($brandx == '4V1')  { $brand = 'Volvo'; }
			if($brandx == '4V2')  { $brand = 'Volvo'; }
			if($brandx == '4V3')  { $brand = 'Volvo'; }
			if($brandx == '4V4')  { $brand = 'Volvo'; }
			if($brandx == '4V5')  { $brand = 'Volvo'; }
			if($brandx == '4V6')  { $brand = 'Volvo'; }
			if($brandx == '4VL')  { $brand = 'Volvo'; }
			if($brandx == '4VM')  { $brand = 'Volvo'; }
			if($brandx == '4VZ')  { $brand = 'Volvo'; }
			if($brandx == '538')  { $brand = 'Zero Motorcycles (USA)'; }
			if(strpos($brandx,'5F') !==false)  {  $brand='Honda USA-Alabama'; }
			if(strpos($brandx,'5J') !==false)  {  $brand='Honda USA-Ohio'; }
			if(strpos($brandx,'5L') !==false)  {  $brand='Lincoln'; }
			if($brandx == '5N1')  { $brand = 'Nissan USA'; }
			if($brandx == '5NP')  { $brand = 'Hyundai USA'; }
			if(strpos($brandx,'5T') !==false)  {  $brand='Toyota USA - trucks'; }
			if($brandx == '5YJ')  { $brand = 'Tesla, Inc.'; }
			if($brandx == '56K')  { $brand = 'Indian Motorcycle USA'; }
			if($brandx == '6AB')  { $brand = 'MAN Australia'; }
			if($brandx == '6F4')  { $brand = 'Nissan Motor Company Australia'; }
			if($brandx == '6F5')  { $brand = 'Kenworth Australia'; }
			if($brandx == '6FP')  { $brand = 'Ford Motor Company Australia'; }
			if($brandx == '6G1')  { $brand = 'General Motors-Holden (post Nov 2002)'; }
			if($brandx == '6G2')  { $brand = 'Pontiac Australia (GTO & G8)'; }
			if($brandx == '6H8')  { $brand = 'General Motors-Holden (pre Nov 2002)'; }
			if($brandx == '6MM')  { $brand = 'Mitsubishi Motors Australia'; }
			if($brandx == '6T1')  { $brand = 'Toyota Motor Corporation Australia'; }
			if($brandx == '6U9')  { $brand = 'Privately Imported car in Australia'; }
			if($brandx == '8AD')  { $brand = 'Peugeot Argentina'; }
			if($brandx == '8AF')  { $brand = 'Ford Motor Company Argentina'; }
			if($brandx == '8AG')  { $brand = 'Chevrolet Argentina'; }
			if($brandx == '8AJ')  { $brand = 'Toyota Argentina'; }
			if($brandx == '8AK')  { $brand = 'Suzuki Argentina'; }
			if($brandx == '8AP')  { $brand = 'Fiat Argentina'; }
			if($brandx == '8AW')  { $brand = 'Volkswagen Argentina'; }
			if($brandx == '8A1')  { $brand = 'Renault Argentina'; }
			if($brandx == '8GD')  { $brand = 'Peugeot Chile'; }
			if($brandx == '8GG')  { $brand = 'Chevrolet Chile'; }
			if($brandx == '8LD')  { $brand = 'Chevrolet Ecuador'; }
			if($brandx == '935')  { $brand = 'Citroën Brazil'; }
			if($brandx == '936')  { $brand = 'Peugeot Brazil'; }
			if($brandx == '93H')  { $brand = 'Honda Brazil'; }
			if($brandx == '93R')  { $brand = 'Toyota Brazil'; }
			if($brandx == '93U')  { $brand = 'Audi Brazil'; }
			if($brandx == '93V')  { $brand = 'Audi Brazil'; }
			if($brandx == '93X')  { $brand = 'Mitsubishi Motors Brazil'; }
			if($brandx == '93Y')  { $brand = 'Renault Brazil'; }
			if($brandx == '94D')  { $brand = 'Nissan Brazil'; }
			if($brandx == '9BF')  { $brand = 'Ford Motor Company Brazil'; }
			if($brandx == '9BG')  { $brand = 'Chevrolet Brazil'; }
			if($brandx == '9BM')  { $brand = 'Mercedes-Benz Brazil'; }
			if($brandx == '9BR')  { $brand = 'Toyota Brazil'; }
			if($brandx == '9BS')  { $brand = 'Scania Brazil'; }
			if($brandx == '9BW')  { $brand = 'Volkswagen Brazil'; }
			if($brandx == '9FB')  { $brand = 'Renault Colombia'; }
			if($brandx == 'WB1')  { $brand = 'BMW Motorrad of North America'; }




















		
		
		return "$brand";
		
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
