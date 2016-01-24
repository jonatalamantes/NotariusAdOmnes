<?php 

    require_once('City.php');

    /**
    * Class to registry one Office from Civil Registry
    * 
    * @author Jonathan Sandoval <jonathan_s_pisis@yahoo.com.mx>
    */
    class OfficeCivilRegistry
    {
        private $id;
        private $number;
        private $idCity;

        /**
         * Contructor for class OfficeCivilRegistry
         * 
         * @param integer $i id
         * @param integer $c idCity
         */
        function __construct($i = 0, $n = 0, $c = 0)
        {
            $this->id     = $i;
            $this->number = $n;
            $this->idCity = $c;
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
        * Gets the value of number.
        *
        * @author Jonathan Sandoval <jonathan_s_pisis@yahoo.com.mx>
        * @return mixed
        */
        public function getNumber()
        {
            return $this->number;
        }
         
        /**
        * Sets the value of number.
        *
        * @author Jonathan Sandoval <jonathan_s_pisis@yahoo.com.mx>
        * @param mixed $number the number
        */
        public function setNumber($number)
        {
            $this->number = $number;
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
    }


 ?>