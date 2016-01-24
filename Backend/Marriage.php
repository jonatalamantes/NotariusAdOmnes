<?php 

    require_once('Church.php');
    require_once('Rector.php');
    require_once('BookRegistry.php');

    /**
    * Class to registry one Marriage
    * 
    * @author Jonathan Sandoval <jonathan_s_pisis@yahoo.com.mx>
    */
    class Marriage
    {
        private $id;
        private $celebrationDate;
        private $idBoyfriend;
        private $idGirlfriend;
        private $idGodFather;
        private $idGodMother;
        private $idWitness1;
        private $idWitness2;
        private $idBookRegistry;
        private $idChurchMarriage;
        private $idChurchProcess;
        private $idRector;

        /**
         * Contructor for class Marriage
         * 
         * @param integer           $i  id
         * @param string            $bD celebrationDate
         * @param integer           $g  idGirlfriend
         * @param integer           $b  idBoyfriend
         * @param integer           $gf idGodFather
         * @param integer           $gm idGodMother
         * @param integer           $w1 idWitness1
         * @param integer           $w2 idWitness2
         * @param integer           $br idBookRegistry
         * @param integer           $cw churchMarriage
         * @param integer           $cp churchProcess
         * @param integer           $r  rector
         */
        function __construct($i = 0, $bD = "", $g = 0, $b = 0, $gf = 0, $gm = 0, $w1 = 0, $w2 = 0, $br = 0, $cw = 0, $cp = 0, $r = 0)
        {
            $this->id              = $i;
            $this->celebrationDate = $bD;
            $this->idBoyfriend     = $b;
            $this->idGirlfriend    = $g;
            $this->idGodFather     = $gf;
            $this->idGodMother     = $gm;
            $this->idWitness1      = $w1;
            $this->idWitness2      = $w2;
            $this->idBookRegistry  = $br;
            $this->idChurchMarriage = $cw;
            $this->idChurchProcess = $cp;
            $this->idRector        = $r;
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
        * Gets the value of idBoyfriend.
        *
        * @author Jonathan Sandoval <jonathan_s_pisis@yahoo.com.mx>
        * @return mixed
        */
        public function getIdBoyfriend()
        {
            return $this->idBoyfriend;
        }
         
        /**
        * Sets the value of idBoyfriend.
        *
        * @author Jonathan Sandoval <jonathan_s_pisis@yahoo.com.mx>
        * @param mixed $idBoyfriend the id boyfriend
        */
        public function setIdBoyfriend($idBoyfriend)
        {
            $this->idBoyfriend = $idBoyfriend;
        }
         
        /**
        * Gets the value of idGirlfriend.
        *
        * @author Jonathan Sandoval <jonathan_s_pisis@yahoo.com.mx>
        * @return mixed
        */
        public function getIdGirlfriend()
        {
            return $this->idGirlfriend;
        }
         
        /**
        * Sets the value of idGirlfriend.
        *
        * @author Jonathan Sandoval <jonathan_s_pisis@yahoo.com.mx>
        * @param mixed $idGirlfriend the id girlfriend
        */
        public function setIdGirlfriend($idGirlfriend)
        {
            $this->idGirlfriend = $idGirlfriend;
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
        * Gets the value of idWitness1.
        *
        * @author Jonathan Sandoval <jonathan_s_pisis@yahoo.com.mx>
        * @return mixed
        */
        public function getIdWitness1()
        {
            return $this->idWitness1;
        }
         
        /**
        * Sets the value of idWitness1.
        *
        * @author Jonathan Sandoval <jonathan_s_pisis@yahoo.com.mx>
        * @param mixed $idWitness1 the id witness1
        */
        public function setIdWitness1($idWitness1)
        {
            $this->idWitness1 = $idWitness1;
        }
         
        /**
        * Gets the value of idWitness2.
        *
        * @author Jonathan Sandoval <jonathan_s_pisis@yahoo.com.mx>
        * @return mixed
        */
        public function getIdWitness2()
        {
            return $this->idWitness2;
        }
         
        /**
        * Sets the value of idWitness2.
        *
        * @author Jonathan Sandoval <jonathan_s_pisis@yahoo.com.mx>
        * @param mixed $idWitness2 the id witness2
        */
        public function setIdWitness2($idWitness2)
        {
            $this->idWitness2 = $idWitness2;
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
        * Gets the value of idChurchMarriage.
        *
        * @author Jonathan Sandoval <jonathan_s_pisis@yahoo.com.mx>
        * @return mixed
        */
        public function getIdChurchMarriage()
        {
            return $this->idChurchMarriage;
        }
         
        /**
        * Sets the value of idChurchMarriage.
        *
        * @author Jonathan Sandoval <jonathan_s_pisis@yahoo.com.mx>
        * @param mixed $idChurchMarriage the id church marriage
        */
        public function setIdChurchMarriage($idChurchMarriage)
        {
            $this->idChurchMarriage = $idChurchMarriage;
        }
         
        /**
        * Gets the value of idChurchProcess.
        *
        * @author Jonathan Sandoval <jonathan_s_pisis@yahoo.com.mx>
        * @return mixed
        */
        public function getIdChurchProcess()
        {
            return $this->idChurchProcess;
        }
         
        /**
        * Sets the value of idChurchProcess.
        *
        * @author Jonathan Sandoval <jonathan_s_pisis@yahoo.com.mx>
        * @param mixed $idChurchProcess the id church process
        */
        public function setIdChurchProcess($idChurchProcess)
        {
            $this->idChurchProcess = $idChurchProcess;
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