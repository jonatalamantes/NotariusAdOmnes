<?php 
    
    require_once("Vicar.php");
    require_once("Dean.php");
    require_once("City.php");
    require_once("Niche.php");

    /**
    * Class to registry one Church
    * 
    * @author Jonathan Sandoval <jonathan_s_pisis@yahoo.com.mx>
    */
    class Church
    {
        private $id;
        private $name;
        private $type;
        private $code;
        private $address;
        private $colony;
        private $postalCode;
        private $phoneNumber;
        private $idVicar;
        private $idDean;
        private $idCity;
        private $idNiche;

        /**
         * Contructor for class Church
         * 
         * @author Jonathan Sandoval <jonathan_s_pisis@hotmail.com>
         * @param integer    $i     id
         * @param string     $n     name
         * @param string     $t     type
         * @param integer    $c     code
         * @param string     $a     address
         * @param string     $co    colony
         * @param integer    $pc    postalCode
         * @param string     $pn    phoneNumber
         * @param integer    $v     idVicar
         * @param integer    $d     idDean
         * @param integer    $ci    idCity
         * @param integer    $ni    idNiche    
         */
        function __construct($i = 0, $n = "", $t = "", $c = 0, $a = "", $co = "", $pc = 0, $pn = "", $v = 0, $d = 0, $ci = 0, $ni = 0)
        {
            $this->id           = $i;
            $this->name         = $n;
            $this->type         = $t;
            $this->code         = $c;
            $this->address      = $a;
            $this->colony       = $co;
            $this->postalCode   = $pc;
            $this->phoneNumber  = $pn;
            $this->idVicar      = $v;
            $this->idDean       = $d;
            $this->idCity       = $ci;
            $this->idNiche      = $ni;
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
        * Gets the value of name.
        *
        * @author Jonathan Sandoval <jonathan_s_pisis@yahoo.com.mx>
        * @return mixed
        */
        public function getName()
        {
            return $this->name;
        }
         
        /**
        * Sets the value of name.
        *
        * @author Jonathan Sandoval <jonathan_s_pisis@yahoo.com.mx>
        * @param mixed $name the name
        */
        public function setName($name)
        {
            $this->name = $name;
        }
         
        /**
        * Gets the value of type.
        *
        * @author Jonathan Sandoval <jonathan_s_pisis@yahoo.com.mx>
        * @return mixed
        */
        public function getType()
        {
            return $this->type;
        }
         
        /**
        * Sets the value of type.
        *
        * @author Jonathan Sandoval <jonathan_s_pisis@yahoo.com.mx>
        * @param mixed $type the type
        */
        public function setType($type)
        {
            $this->type = $type;
        }
         
        /**
        * Gets the value of code.
        *
        * @author Jonathan Sandoval <jonathan_s_pisis@yahoo.com.mx>
        * @return mixed
        */
        public function getCode()
        {
            return $this->code;
        }
         
        /**
        * Sets the value of code.
        *
        * @author Jonathan Sandoval <jonathan_s_pisis@yahoo.com.mx>
        * @param mixed $code the code
        */
        public function setCode($code)
        {
            $this->code = $code;
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
        * Gets the value of colony.
        *
        * @author Jonathan Sandoval <jonathan_s_pisis@yahoo.com.mx>
        * @return mixed
        */
        public function getColony()
        {
            return $this->colony;
        }
         
        /**
        * Sets the value of colony.
        *
        * @author Jonathan Sandoval <jonathan_s_pisis@yahoo.com.mx>
        * @param mixed $colony the colony
        */
        public function setColony($colony)
        {
            $this->colony = $colony;
        }
         
        /**
        * Gets the value of postalCode.
        *
        * @author Jonathan Sandoval <jonathan_s_pisis@yahoo.com.mx>
        * @return mixed
        */
        public function getPostalCode()
        {
            return $this->postalCode;
        }
         
        /**
        * Sets the value of postalCode.
        *
        * @author Jonathan Sandoval <jonathan_s_pisis@yahoo.com.mx>
        * @param mixed $postalCode the postal code
        */
        public function setPostalCode($postalCode)
        {
            $this->postalCode = $postalCode;
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
        * Gets the value of idVicar.
        *
        * @author Jonathan Sandoval <jonathan_s_pisis@yahoo.com.mx>
        * @return mixed
        */
        public function getIdVicar()
        {
            return $this->idVicar;
        }
         
        /**
        * Sets the value of idVicar.
        *
        * @author Jonathan Sandoval <jonathan_s_pisis@yahoo.com.mx>
        * @param mixed $idVicar the id vicar
        */
        public function setIdVicar($idVicar)
        {
            $this->idVicar = $idVicar;
        }
         
        /**
        * Gets the value of idDean.
        *
        * @author Jonathan Sandoval <jonathan_s_pisis@yahoo.com.mx>
        * @return mixed
        */
        public function getIdDean()
        {
            return $this->idDean;
        }
         
        /**
        * Sets the value of idDean.
        *
        * @author Jonathan Sandoval <jonathan_s_pisis@yahoo.com.mx>
        * @param mixed $idDean the id dean
        */
        public function setIdDean($idDean)
        {
            $this->idDean = $idDean;
        }
         
        /**
        * Gets the value of idCity.
        *
        * @author Jonathan Sandoval <jonathan_s_pisis@yahoo.com.mx>
        * @return mixed
        */
        public function getIdCity()
        {
            return $this->idCity;
        }
         
        /**
        * Sets the value of idCity.
        *
        * @author Jonathan Sandoval <jonathan_s_pisis@yahoo.com.mx>
        * @param mixed $idCity the id city
        */
        public function setIdCity($idCity)
        {
            $this->idCity = $idCity;
        }
         
        /**
        * Gets the value of idNiche.
        *
        * @author Jonathan Sandoval <jonathan_s_pisis@yahoo.com.mx>
        * @return mixed
        */
        public function getIdNiche()
        {
            return $this->idNiche;
        }
         
        /**
        * Sets the value of idNiche.
        *
        * @author Jonathan Sandoval <jonathan_s_pisis@yahoo.com.mx>
        * @param mixed $idNiche the id niche
        */
        public function setIdNiche($idNiche)
        {
            $this->idNiche = $idNiche;
        }
    }

 ?>