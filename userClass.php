<?php

class User
{
	private $ID;
	private $userName;
	private $password;
	private $email;
	private $firstName;
	private $lastName;
	private $phoneNumber;
	private $gender;
    private $birthYear;
	private $registerDate;
	private $userStatus;
	private $addressID;
	private $userPrivilege;
    private $imagePath;
    private $resumePath;
    private $identityID;
    private $fbLink;
    private $twLink;
    private $lkLink;

	function __construct($ID = 0, $userName = "", $password = "", $email = "", $firstName = "", $lastName = "", $phoneNumber = "", $gender = "", $birthYear = "", $registerDate = "", $userStatus = "", $addressID = 0, $userPrivilege = 0, $imagePath= "", $resumePath = "", $identityID = "", $fbLink = "", $twLink = "", $lkLink = "")
	{
		$this->ID = $ID;
		$this->userName = $userName;
		$this->password = $password;
		$this->email = $email;
		$this->firstName = $firstName;
		$this->lastName = $lastName;
		$this->phoneNumber = $phoneNumber;
		$this->gender = $gender;
        $this->birthYear = $birthYear;
		$this->registerDate = $registerDate;
		$this->userStatus = $userStatus;
		$this->addressID = $addressID;
		$this->userPrivilege = $userPrivilege;
        $this->imagePath = $imagePath;
        $this->resumePath = $resumePath;
        $this->identityID = $identityID;
        $this->fbLink = $fbLink;
        $this->twLink = $twLink;
        $this->lkLink = $lkLink;
	}

    public function getID()
    {
        return $this->ID;
    }

    public function setID($ID)
    {
        $this->ID = $ID;
    }

    public function getUserName()
    {
        return $this->userName;
    }

    public function setUserName($userName)
    {
        $this->userName = $userName;
    }

    public function getPassword()
    {
        return $this->password;
    }

    public function setPassword($password)
    {
        $this->password = $password;
    }

    public function getEmail()
    {
        return $this->email;
    }

    public function setEmail($email)
    {
        $this->email = $email;
    }

    public function getFirstName()
    {
        return $this->firstName;
    }

    public function setFirstName($firstName)
    {
        $this->firstName = $firstName;
    }

    public function getLastName()
    {
        return $this->lastName;
    }

    public function setLastName($lastName)
    {
        $this->lastName = $lastName;
    }

    public function getPhoneNumber()
    {
        return $this->phoneNumber;
    }

    public function setPhoneNumber($phoneNumber)
    {
        $this->phoneNumber = $phoneNumber;
    }

    public function getGender()
    {
        if($this->gender == 0)
            return 'Male';
        else
            return 'Female';
    }

    public function setGender($gender)
    {
        $this->gender = $gender;
    }

    public function getBirthYear()
    {
        return $this->birthYear;
    }

    public function setBirthYear($birthYear)
    {
        $this->birthYear = $birthYear;
    }

    public function getAge()
    {
        $curYear = date('Y');
        $age = $curYear - $this->birthYear;
        return $age;
    }

    public function getRegisterDate()
    {
        return $this->registerDate;
    }

    public function setRegisterDate($registerDate)
    {
        $this->registerDate = $registerDate;
    }

    public function getUserStatus()
    { 
        if ($this->userStatus == 0)
            return 'Mentee';
        else if ($this->userStatus == 1)
            return 'Mentor';
        else
            return 'Neither';
    }
	
	public function getUserStatusNum()
    {   
		return $this->userStatus;
    }

    public function setUserStatus($userStatus)
    {
        $this->userStatus = $userStatus;
    }

    public function getAddressID()
    {
        return $this->addressID;
    }

    public function setAddressID($addressID)
    {
        $this->addressID = $addressID;
    }

    public function getUserPrivilege()
    {
        return $this->userPrivilege;
    }

    public function setUserPrivilege($userPrivilege)
    {
        $this->userPrivilege = $userPrivilege;
    }

    public function getImagePath()
    {
        return $this->imagePath;
    }

    public function setImagePath($imagePath)
    {
        $this->imagePath = $imagePath;
    }

    public function getResumePath()
    {
        return $this->resumePath;
    }

    public function setResumePath($resumePath)
    {
        $this->resumePath = $resumePath;
    }

    public function getIdentityID()
    {
        return $this->identityID;
    }

    public function setIdentityID($identityID)
    {
        $this->identityID = $identityID;
    }

    public function getFbLink()
    {
        return $this->fbLink;
    }

    public function setFbLink($fbLink)
    {
        $this->fbLink = $fbLink;
    }

    public function getTwLink()
    {
        return $this->twLink;
    }

    public function setTwLink($twLink)
    {
        $this->twLink = $twLink;
    }

    public function getLkLink()
    {
        return $this->lkLink;
    }

    public function setLkLink($lkLink)
    {
        $this->lkLink = $lkLink;
    }
}