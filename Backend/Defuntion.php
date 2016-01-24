<?php 

    require_once('Church.php');
    require_once('Person.php');
    require_once('Crypt.php');

    /**
    * Class to registry one Defuntion
    * 
    * @author Jonathan Sandoval <jonathan_s_pisis@yahoo.com.mx>
    */
    class Defuntion
    {
        private $id;
        private $idOwner;
        private $deadDate;
        private $idCrypt;
        private $idChurch;

        /**
         * Contructor for class Defuntion
         * 
         * @param integer $i  id
         * @param integer $o  idOwner
         * @param string  $d  deadDate
         * @param integer $cr idCrypt
         * @param integer $ch church
         */
        function __construct($i = 0, $o = 0, $d = "", $cr = 0, $ch = 0)
        {
            $this->id         = $i;
            $this->idOwner    = $o;
            $this->deadDate   = $d;
            $this->idCrypt    = $cr;
            $this->idChurch   = $ch;
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
        * Gets the value of idOwner.
        *
        * @author Jonathan Sandoval <jonathan_s_pisis@yahoo.com.mx>
        * @return mixed
        */
        public function getIdOwner()
        {
            return $this->idOwner;
        }
         
        /**
        * Sets the value of idOwner.
        *
        * @author Jonathan Sandoval <jonathan_s_pisis@yahoo.com.mx>
        * @param mixed $idOwner the id owner
        */
        public function setIdOwner($idOwner)
        {
            $this->idOwner = $idOwner;
        }
         
        /**
        * Gets the value of deadDate.
        *
        * @author Jonathan Sandoval <jonathan_s_pisis@yahoo.com.mx>
        * @return mixed
        */
        public function getDeadDate()
        {
            return $this->deadDate;
        }
         
        /**
        * Sets the value of deadDate.
        *
        * @author Jonathan Sandoval <jonathan_s_pisis@yahoo.com.mx>
        * @param mixed $deadDate the dead date
        */
        public function setDeadDate($deadDate)
        {
            $this->deadDate = $deadDate;
        }
         
        /**
        * Gets the value of idCrypt.
        *
        * @author Jonathan Sandoval <jonathan_s_pisis@yahoo.com.mx>
        * @return mixed
        */
        public function getIdCrypt()
        {
            return $this->idCrypt;
        }
         
        /**
        * Sets the value of idCrypt.
        *
        * @author Jonathan Sandoval <jonathan_s_pisis@yahoo.com.mx>
        * @param mixed $idCrypt the id crypt
        */
        public function setIdCrypt($idCrypt)
        {
            $this->idCrypt = $idCrypt;
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
    }

 ?>