<?php 

    require_once('Church.php');
    require_once('Rector.php');
    require_once('CivilRegistry.php');
    require_once('BookRegistry.php');

    /**
    * Class to registry one Baptism
    * 
    * @author Jonathan Sandoval <jonathan_s_pisis@yahoo.com.mx>
    */
    class Baptism
    {
        private $id;
        private $celebrationDate;
        private $bornPlace;
        private $bornDate;
        private $legitimate;
        private $idOwner;
        private $idGodFather;
        private $idGodMother;
        private $idBookRegistry;
        private $idCivilRegistry;
        private $idChurch;
        private $idRector;

        /**
         * Contructor for class Baptism
         * 
         * @param integer           $i  id
         * @param string            $bD celebrationDate
         * @param string            $bP bornPlace
         * @param string            $bF bornDate
         * @param string            $l  legitimate
         * @param integer           $o  idOwner
         * @param integer           $gf idGodFather
         * @param integer           $gm idGodMother
         * @param integer           $br idBookRegistry
         * @param integer           $cr idCivilRegistry
         * @param integer           $ch church
         * @param integer           $r  rector
         */
        function __construct($i = 0, $bD = "", $bP = "", $bF = "", $l = 'Y', $o = 0, $gf = 0, $gm = 0, $br = 0, $cr = 0, $ch = 0, $r = 0)
        {
            $this->id                 = $i;
            $this->celebrationDate    = $bD;
            $this->bornPlace          = $bP;
            $this->bornDate           = $bF;
            $this->legitimate         = $l;
            $this->idOwner            = $o;
            $this->idGodFather        = $gf;
            $this->idGodMother        = $gm;
            $this->idBookRegistry     = $br;
            $this->idCivilRegistry    = $cr;
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
        * Gets the value of bornPlace.
        *
        * @author Jonathan Sandoval <jonathan_s_pisis@yahoo.com.mx>
        * @return mixed
        */
        public function getBornPlace()
        {
            return $this->bornPlace;
        }
         
        /**
        * Sets the value of bornPlace.
        *
        * @author Jonathan Sandoval <jonathan_s_pisis@yahoo.com.mx>
        * @param mixed $bornPlace the born place
        */
        public function setBornPlace($bornPlace)
        {
            $this->bornPlace = $bornPlace;
        }
         
        /**
        * Gets the value of bornDate.
        *
        * @author Jonathan Sandoval <jonathan_s_pisis@yahoo.com.mx>
        * @return mixed
        */
        public function getBornDate()
        {
            return $this->bornDate;
        }
         
        /**
        * Sets the value of bornDate.
        *
        * @author Jonathan Sandoval <jonathan_s_pisis@yahoo.com.mx>
        * @param mixed $bornDate the born date
        */
        public function setBornDate($bornDate)
        {
            $this->bornDate = $bornDate;
        }
         
        /**
        * Gets the value of legitimate.
        *
        * @author Jonathan Sandoval <jonathan_s_pisis@yahoo.com.mx>
        * @return mixed
        */
        public function getLegitimate()
        {
            return $this->legitimate;
        }
         
        /**
        * Sets the value of legitimate.
        *
        * @author Jonathan Sandoval <jonathan_s_pisis@yahoo.com.mx>
        * @param mixed $legitimate the legitimate
        */
        public function setLegitimate($legitimate)
        {
            $this->legitimate = $legitimate;
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
        * Gets the value of idGodMother.
        *
        * @author Jonathan Sandoval <jonathan_s_pisis@yahoo.com.mx>
        * @return mixed
        */
        public function getIdGodMother()
        {
            return $this->idGodMother;
        }
         
        /**
        * Sets the value of idGodMother.
        *
        * @author Jonathan Sandoval <jonathan_s_pisis@yahoo.com.mx>
        * @param mixed $idGodMother the id god mother
        */
        public function setIdGodMother($idGodMother)
        {
            $this->idGodMother = $idGodMother;
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
        * Gets the value of idCivilRegistry.
        *
        * @author Jonathan Sandoval <jonathan_s_pisis@yahoo.com.mx>
        * @return mixed
        */
        public function getIdCivilRegistry()
        {
            return $this->idCivilRegistry;
        }
         
        /**
        * Sets the value of idCivilRegistry.
        *
        * @author Jonathan Sandoval <jonathan_s_pisis@yahoo.com.mx>
        * @param mixed $idCivilRegistry the id civil registry
        */
        public function setIdCivilRegistry($idCivilRegistry)
        {
            $this->idCivilRegistry = $idCivilRegistry;
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