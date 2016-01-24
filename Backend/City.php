<?php 

    require_once("State.php");

    /**
    * Class to registry one City
    * 
    * @author Jonathan Sandoval <jonathan_s_pisis@yahoo.com.mx>
    */
    class City
    {
        private $id;
        private $name;
        private $idState;
        
        /**
         * Contructor for class City
         * 
         * @author Jonathan Sandoval <jonathan_s_pisis@hotmail.com>
         * @param integer $i   id
         * @param string  $n   name
         * @param State   $s   idState
         */
        function __construct($i = 0, $n = "", $s = 0)
        {
            $this->id      = $i;
            $this->name    = $n;
            $this->idState = $s;
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
        * Gets the value of idState.
        *
        * @author Jonathan Sandoval <jonathan_s_pisis@yahoo.com.mx>
        * @return mixed
        */
        public function getIdState()
        {
            return $this->idState;
        }
         
        /**
        * Sets the value of idState.
        *
        * @author Jonathan Sandoval <jonathan_s_pisis@yahoo.com.mx>
        * @param mixed $idState the id state
        */
        public function setIdState($idState)
        {
            $this->idState = $idState;
        }
    }

 ?>