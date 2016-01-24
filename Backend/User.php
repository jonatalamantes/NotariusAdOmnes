<?php 

    require_once('Church.php');

    /**
    * Class to registry one User
    * 
    * @author Jonathan Sandoval <jonathan_s_pisis@yahoo.com.mx>
    */
    class User
    {
        private $id;
        private $username;
        private $password;
        private $type;
        private $idChurch;
        private $offline;
        private $language;
        private $idPaperConfig;
        private $lastActivityTime;
        private $addressIP;

        /**
         * Contructor for class User
         * 
         * @param integer $i id
         * @param string  $u username
         * @param string  $p password
         * @param char    $t type
         * @param integer $c idChurch
         * @param integer $o offline
         * @param integer $le language
         * @param integer $la lastActivityTime
         * @param integer $pc idPaperConfig
         */
        function __construct($i = 0, $u = "", $p = "", $t = 'A', $c = 0, $o = 1, $le = 'en', 
                             $la = 0, $pc = 0, $a = "0.0.0.0")
        {
            $this->id               = $i;
            $this->username         = $u;
            $this->password         = $p;
            $this->type             = $t;
            $this->idChurch         = $c;
            $this->offline          = $o;
            $this->language         = $le;
            $this->lastActivityTime = $la;
            $this->idPaperConfig    = $pc;
            $this->addressIP        = $a;
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
        * Gets the value of username.
        *
        * @author Jonathan Sandoval <jonathan_s_pisis@yahoo.com.mx>
        * @return mixed
        */
        public function getUsername()
        {
            return $this->username;
        }
         
        /**
        * Sets the value of username.
        *
        * @author Jonathan Sandoval <jonathan_s_pisis@yahoo.com.mx>
        * @param mixed $username the username
        */
        public function setUsername($username)
        {
            $this->username = $username;
        }
         
        /**
        * Gets the value of password.
        *
        * @author Jonathan Sandoval <jonathan_s_pisis@yahoo.com.mx>
        * @return mixed
        */
        public function getPassword()
        {
            return $this->password;
        }
         
        /**
        * Sets the value of password.
        *
        * @author Jonathan Sandoval <jonathan_s_pisis@yahoo.com.mx>
        * @param mixed $password the password
        */
        public function setPassword($password)
        {
            $this->password = $password;
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
        * Gets the value of idChurch.
        *
        * @author Jonathan Sandoval <jonathan_s_pisis@yahoo.com.mx>
        * @return mixed
        */
        public function getIdChurch()
        {
            return $this->idChurch;
        }
         
        /**
        * Sets the value of idChurch.
        *
        * @author Jonathan Sandoval <jonathan_s_pisis@yahoo.com.mx>
        * @param mixed $idChurch the id church
        */
        public function setIdChurch($idChurch)
        {
            $this->idChurch = $idChurch;
        }
         
        /**
        * Gets the value of offline.
        *
        * @author Jonathan Sandoval <jonathan_s_pisis@yahoo.com.mx>
        * @return mixed
        */
        public function getOffline()
        {
            return $this->offline;
        }
         
        /**
        * Sets the value of offline.
        *
        * @author Jonathan Sandoval <jonathan_s_pisis@yahoo.com.mx>
        * @param mixed $offline the offline
        */
        public function setOffline($offline)
        {
            $this->offline = $offline;
        }
         
        /**
        * Gets the value of language.
        *
        * @author Jonathan Sandoval <jonathan_s_pisis@yahoo.com.mx>
        * @return mixed
        */
        public function getLanguage()
        {
            return $this->language;
        }
         
        /**
        * Sets the value of language.
        *
        * @author Jonathan Sandoval <jonathan_s_pisis@yahoo.com.mx>
        * @param mixed $language the language
        */
        public function setLanguage($language)
        {
            $this->language = $language;
        }
         
        /**
        * Gets the value of idPaperConfig.
        *
        * @author Jonathan Sandoval <jonathan_s_pisis@yahoo.com.mx>
        * @return mixed
        */
        public function getIdPaperConfig()
        {
            return $this->idPaperConfig;
        }
         
        /**
        * Sets the value of idPaperConfig.
        *
        * @author Jonathan Sandoval <jonathan_s_pisis@yahoo.com.mx>
        * @param mixed $idPaperConfig the id paper config
        */
        public function setIdPaperConfig($idPaperConfig)
        {
            $this->idPaperConfig = $idPaperConfig;
        }
         
        /**
        * Gets the value of lastActivityTime.
        *
        * @author Jonathan Sandoval <jonathan_s_pisis@yahoo.com.mx>
        * @return mixed
        */
        public function getLastActivityTime()
        {
            return $this->lastActivityTime;
        }
         
        /**
        * Sets the value of lastActivityTime.
        *
        * @author Jonathan Sandoval <jonathan_s_pisis@yahoo.com.mx>
        * @param mixed $lastActivityTime the last activity time
        */
        public function setLastActivityTime($lastActivityTime)
        {
            $this->lastActivityTime = $lastActivityTime;
        }
         
        /**
        * Gets the value of addressIP.
        *
        * @author Jonathan Sandoval <jonathan_s_pisis@yahoo.com.mx>
        * @return mixed
        */
        public function getAddressIP()
        {
            return $this->addressIP;
        }
         
        /**
        * Sets the value of addressIP.
        *
        * @author Jonathan Sandoval <jonathan_s_pisis@yahoo.com.mx>
        * @param mixed $addressIP the address
        */
        public function setAddressIP($addressIP)
        {
            $this->addressIP = $addressIP;
        }
    }

 ?>