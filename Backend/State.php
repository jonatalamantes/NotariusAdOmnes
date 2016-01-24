<?php 

    /**
    * Class to registry one State
    * 
    * @author Jonathan Sandoval <jonathan_s_pisis@yahoo.com.mx>
    */
    class State
    {
        private $id;
        private $shortName;
        private $name;
        private $country;

        /**
         * Contructor to Made Objets
         *
         * @author Jonathan Sandoval <jonathan_s_pisis@yahoo.com.mx>
         * @param integer $a    id
         * @param string  $b    shorname
         * @param string  $c    name
         * @param string  $d    country
         */
        function __construct($a = 0, $b = "", $c = "", $d = "")
        {
            $this->id        = $a;
            $this->shortName = $b;
            $this->name      = $c;
            $this->country   = $d;
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
        * Gets the value of shortName.
        *
        * @author Jonathan Sandoval <jonathan_s_pisis@yahoo.com.mx>
        * @return mixed
        */
        public function getShortName()
        {
            return $this->shortName;
        }
         
        /**
        * Sets the value of shortName.
        *
        * @author Jonathan Sandoval <jonathan_s_pisis@yahoo.com.mx>
        * @param mixed $shortName the short name
        */
        public function setShortName($shortName)
        {
            $this->shortName = $shortName;
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
        * Gets the value of country.
        *
        * @author Jonathan Sandoval <jonathan_s_pisis@yahoo.com.mx>
        * @return mixed
        */
        public function getCountry()
        {
            return $this->country;
        }
         
        /**
        * Sets the value of country.
        *
        * @author Jonathan Sandoval <jonathan_s_pisis@yahoo.com.mx>
        * @param mixed $country the country
        */
        public function setCountry($country)
        {
            $this->country = $country;
        }
    }

 ?>