<?php 

    require_once('Church.php');
    require_once('Rector.php');

    /**
    * Class to registry one Proof of Talks
    * 
    * @author Jonathan Sandoval <jonathan_s_pisis@yahoo.com.mx>
    */
    class ProofTalks
    {
        private $id;
        private $idOwner;
        private $idGodFather;
        private $idGodMother;
        private $idChurch;
        private $type;

        /**
         * Contructor for class Wedding
         * 
         * @param integer $i  id
         * @param integer $o  idOwner
         * @param integer $gf idGodFather
         * @param integer $gm idGodMother
         * @param integer $ch idChurch
         * @param char    $t  type
         */
        function __construct($i = 0, $o = 0, $gf = 0, $gm = 0, $ch = 0,$t = 'B')
        {
            $this->id             = $i;
            $this->idOwner        = $o;
            $this->idGodFather    = $gf;
            $this->idGodMother    = $gm;
            $this->idChurch       = $ch;
            $this->type           = $t;
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
    }

 ?>