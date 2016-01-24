<?php 

    require_once('Church.php');
    require_once('Rector.php');
    require_once('BookRegistry.php');

    /**
    * Class to registry one Confirmation
    * 
    * @author Jonathan Sandoval <jonathan_s_pisis@yahoo.com.mx>
    */
    class Confirmation
    {
        private $id;
        private $celebrationDate;
        private $idOwner;
        private $idGodFather;
        private $idBookRegistry;
        private $idChurch;
        private $idRector;

        /**
         * Contructor for class Confirmation
         * 
         * @param integer               $i  id
         * @param string                $bD celebrationDate
         * @param integer               $o  idOwner
         * @param integer               $gf idGodFather
         * @param integer               $br idBookRegistry
         * @param integer               $ch church
         * @param integer               $r  rector
         */
        function __construct($i = 0, $bD = "", $o = 0, $gf = 0, $br = 0, $ch = 0, $r = 0)
        {
            $this->id                 = $i;
            $this->celebrationDate    = $bD;
            $this->idOwner            = $o;
            $this->idGodFather        = $gf;
            $this->idBookRegistry     = $br;
            $this->idChurch           = $ch;
            $this->idRector           = $r;
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
        * Gets the value of celebrationDate.
        *
        * @author Jonathan Sandoval <jonathan_s_pisis@yahoo.com.mx>
        * @return mixed
        */
        public function getCelebrationDate()
        {
            return $this->celebrationDate;
        }
         
        /**
        * Sets the value of celebrationDate.
        *
        * @author Jonathan Sandoval <jonathan_s_pisis@yahoo.com.mx>
        * @param mixed $celebrationDate the celebration date
        */
        public function setCelebrationDate($celebrationDate)
        {
            $this->celebrationDate = $celebrationDate;
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
        * Gets the value of idGodFather.
        *
        * @author Jonathan Sandoval <jonathan_s_pisis@yahoo.com.mx>
        * @return mixed
        */
        public function getIdGodFather()
        {
            return $this->idGodFather;
        }
         
        /**
        * Sets the value of idGodFather.
        *
        * @author Jonathan Sandoval <jonathan_s_pisis@yahoo.com.mx>
        * @param mixed $idGodFather the id god father
        */
        public function setIdGodFather($idGodFather)
        {
            $this->idGodFather = $idGodFather;
        }
         
        /**
        * Gets the value of idBookRegistry.
        *
        * @author Jonathan Sandoval <jonathan_s_pisis@yahoo.com.mx>
        * @return mixed
        */
        public function getIdBookRegistry()
        {
            return $this->idBookRegistry;
        }
         
        /**
        * Sets the value of idBookRegistry.
        *
        * @author Jonathan Sandoval <jonathan_s_pisis@yahoo.com.mx>
        * @param mixed $idBookRegistry the id book registry
        */
        public function setIdBookRegistry($idBookRegistry)
        {
            $this->idBookRegistry = $idBookRegistry;
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
        * Gets the value of idRector.
        *
        * @author Jonathan Sandoval <jonathan_s_pisis@yahoo.com.mx>
        * @return mixed
        */
        public function getIdRector()
        {
            return $this->idRector;
        }
         
        /**
        * Sets the value of idRector.
        *
        * @author Jonathan Sandoval <jonathan_s_pisis@yahoo.com.mx>
        * @param mixed $idRector the id rector
        */
        public function setIdRector($idRector)
        {
            $this->idRector = $idRector;
        }
    }

 ?>