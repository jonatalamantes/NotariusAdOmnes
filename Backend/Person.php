<?php 

    require_once('City.php');

    /**
    * Class to registry one Person
    * 
    * @author Jonathan Sandoval <jonathan_s_pisis@yahoo.com.mx>
    */
    class Person
    {
        private $id;
        private $names;
        private $lastname1;
        private $lastname2;
        private $gender;
        private $address;
        private $phoneNumber;
        private $idFather;
        private $idMother;
        private $idCityAddress;

        /**
         * Contructor for class Person
         * 
         * @param integer $i        id
         * @param string  $n        names
         * @param string  $ln1      lastname1
         * @param string  $ln2      lastname2
         * @param string  $g        gender
         * @param string  $a        address
         * @param string  $pn       phoneNumber
         * @param integer $f        idFather
         * @param integer $m        idMother
         * @param integer $ca       idCityAddress
         */
        function __construct($i = 0, $n = "", $ln1 = "", $ln2 = "", $g = 'M', $a = "", $pn = "", $f = 0, $m = 0, $ca = 0)
        {
            $this->id             = $i;
            $this->names          = $n;
            $this->lastname1      = $ln1;
            $this->lastname2      = $ln2;
            $this->gender         = $g;
            $this->address        = $a;
            $this->phoneNumber    = $pn;
            $this->idFather       = $f;
            $this->idMother       = $m;
            $this->idCityAddress  = $ca;
        }        
         
        /**
        * Gets the value of id.
        *
        * @author Jonathan Sandoval <jonathan_s_pisis@yahoo.com.mx>
        * @return mixed
        */
        public function getId()
        {
            return $this->id;
        }
         
        /**
        * Sets the value of id.
        *
        * @author Jonathan Sandoval <jonathan_s_pisis@yahoo.com.mx>
        * @param mixed $id the id
        */
        public function setId($id)
        {
            $this->id = $id;
        }
         
        /**
        * Gets the value of names.
        *
        * @author Jonathan Sandoval <jonathan_s_pisis@yahoo.com.mx>
        * @return mixed
        */
        public function getNames()
        {
            return $this->names;
        }
         
        /**
        * Sets the value of names.
        *
        * @author Jonathan Sandoval <jonathan_s_pisis@yahoo.com.mx>
        * @param mixed $names the names
        */
        public function setNames($names)
        {
            $this->names = $names;
        }
         
        /**
        * Gets the value of lastname1.
        *
        * @author Jonathan Sandoval <jonathan_s_pisis@yahoo.com.mx>
        * @return mixed
        */
        public function getLastname1()
        {
            return $this->lastname1;
        }
         
        /**
        * Sets the value of lastname1.
        *
        * @author Jonathan Sandoval <jonathan_s_pisis@yahoo.com.mx>
        * @param mixed $lastname1 the lastname1
        */
        public function setLastname1($lastname1)
        {
            $this->lastname1 = $lastname1;
        }
         
        /**
        * Gets the value of lastname2.
        *
        * @author Jonathan Sandoval <jonathan_s_pisis@yahoo.com.mx>
        * @return mixed
        */
        public function getLastname2()
        {
            return $this->lastname2;
        }
         
        /**
        * Sets the value of lastname2.
        *
        * @author Jonathan Sandoval <jonathan_s_pisis@yahoo.com.mx>
        * @param mixed $lastname2 the lastname2
        */
        public function setLastname2($lastname2)
        {
            $this->lastname2 = $lastname2;
        }
         
        /**
        * Gets the value of gender.
        *
        * @author Jonathan Sandoval <jonathan_s_pisis@yahoo.com.mx>
        * @return mixed
        */
        public function getGender()
        {
            return $this->gender;
        }
         
        /**
        * Sets the value of gender.
        *
        * @author Jonathan Sandoval <jonathan_s_pisis@yahoo.com.mx>
        * @param mixed $gender the gender
        */
        public function setGender($gender)
        {
            $this->gender = $gender;
        }
         
        /**
        * Gets the value of address.
        *
        * @author Jonathan Sandoval <jonathan_s_pisis@yahoo.com.mx>
        * @return mixed
        */
        public function getAddress()
        {
            return $this->address;
        }
         
        /**
        * Sets the value of address.
        *
        * @author Jonathan Sandoval <jonathan_s_pisis@yahoo.com.mx>
        * @param mixed $address the address
        */
        public function setAddress($address)
        {
            $this->address = $address;
        }
         
        /**
        * Gets the value of phoneNumber.
        *
        * @author Jonathan Sandoval <jonathan_s_pisis@yahoo.com.mx>
        * @return mixed
        */
        public function getPhoneNumber()
        {
            return $this->phoneNumber;
        }
         
        /**
        * Sets the value of phoneNumber.
        *
        * @author Jonathan Sandoval <jonathan_s_pisis@yahoo.com.mx>
        * @param mixed $phoneNumber the phone number
        */
        public function setPhoneNumber($phoneNumber)
        {
            $this->phoneNumber = $phoneNumber;
        }
         
        /**
        * Gets the value of idFather.
        *
        * @author Jonathan Sandoval <jonathan_s_pisis@yahoo.com.mx>
        * @return mixed
        */
        public function getIdFather()
        {
            return $this->idFather;
        }
         
        /**
        * Sets the value of idFather.
        *
        * @author Jonathan Sandoval <jonathan_s_pisis@yahoo.com.mx>
        * @param mixed $idFather the id father
        */
        public function setIdFather($idFather)
        {
            $this->idFather = $idFather;
        }
         
        /**
        * Gets the value of idMother.
        *
        * @author Jonathan Sandoval <jonathan_s_pisis@yahoo.com.mx>
        * @return mixed
        */
        public function getIdMother()
        {
            return $this->idMother;
        }
         
        /**
        * Sets the value of idMother.
        *
        * @author Jonathan Sandoval <jonathan_s_pisis@yahoo.com.mx>
        * @param mixed $idMother the id mother
        */
        public function setIdMother($idMother)
        {
            $this->idMother = $idMother;
        }
         
        /**
        * Gets the value of idCityAddress.
        *
        * @author Jonathan Sandoval <jonathan_s_pisis@yahoo.com.mx>
        * @return mixed
        */
        public function getIdCityAddress()
        {
            return $this->idCityAddress;
        }
         
        /**
        * Sets the value of idCityAddress.
        *
        * @author Jonathan Sandoval <jonathan_s_pisis@yahoo.com.mx>
        * @param mixed $idCityAddress the id city address
        */
        public function setIdCityAddress($idCityAddress)
        {
            $this->idCityAddress = $idCityAddress;
        }

        /**
        * Gets the fullname begin with lastname
        *
        * @author Jonathan Sandoval <jonathan_s_pisis@yahoo.com.mx>
        * @return mixed
        */
        public function getFullName()
        {
            return ($this->lastname1 . " " . $this->lastname2 . " " . $this->names);
        }

        /**
        * Gets the fullname begin with lastname
        *
        * @author Jonathan Sandoval <jonathan_s_pisis@yahoo.com.mx>
        * @return mixed
        */
        public function getFullNameBeginName()
        {
            return ($this->names . " " . $this->lastname1 . " " . $this->lastname2);
        }
    }

 ?>