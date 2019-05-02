<?php 

class Address
{
	private $ID;
	private $street1;
	private $street2;
	private $city;
	private $state;
	private $stateID;
	private $zipCode;
	private $country;
	private $countryID;

	function __construct($ID = 0, $street1 = "", $street2 = "", $city = "", $state = "", $stateID = 0,$zipCode = "", $country = "", $countryID = 0)
	{
		$this->ID = $ID;
		$this->street1 = $street1;
		$this->street2  = $street2;
		$this->city = $city;
		$this->state = $state;
		$this->stateID = $stateID;
		$this->zipCode = $zipCode;
		$this->country = $country;
		$this->countryID = $countryID;
	}

    public function getID()
    {
        return $this->ID;
    }

    public function setID($ID)
    {
        $this->ID = $ID;
    }

    public function getStreet1()
    {
        return $this->street1;
    }

    public function setStreet1($street1)
    {
        $this->street1 = $street1;
    }

    public function getStreet2()
    {
        return $this->street2;
    }

    public function setStreet2($street2)
    {
        $this->street2 = $street2;
    }

    public function getCity()
    {
        return $this->city;
    }

    public function setCity($city)
    {
        $this->city = $city;
    }

    public function getState()
    {
        return $this->state;
    }

    public function setState($state)
    {
        $this->state = $state;
    }

    public function getStateID()
    {
        return $this->stateID;
    }

    public function setStateID($stateID)
    {
        $this->stateID = $stateID;
    }

    public function getZipcode()
    {
        return $this->zipcode;
    }

    public function setZipcode($zipcode)
    {
        $this->zipcode = $zipcode;
    }

    public function getCountry()
    {
        return $this->country;
    }

    public function setCountry($country)
    {
        $this->country = $country;
    }

    public function getCountryID()
    {
        return $this->countryID;
    }

    public function setCountryID($countryID)
    {
        $this->countryID = $countryID;
    }
}