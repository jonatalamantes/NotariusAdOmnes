<?php 

    /**
    * Class to register the activity of the users
    * 
    * @author Jonathan Sandoval <jonathan_s_pisis@yahoo.com.mx>
    */
    class ChangesLogs
    {
        private $id;
        private $date;
        private $type;
        private $description;
        private $idUser;
        
        /**
         * Contructor to Made Objets
         *
         * @author Jonathan Sandoval <jonathan_s_pisis@yahoo.com.mx>
         * @param integer    $i    id
         * @param integer    $d    date
         * @param string     $t    type
         * @param string     $e    description
         * @param integer    $iu   idUser
         */
        function __construct($i = 0, $d = 0, $t = "", $e = "", $iu = 0)
        {
            $this->id          = $i;   
            $this->date        = $d;
            $this->type        = $t;
            $this->description = $e;
            $this->idUser      = $iu;
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
        * @param mixed $id the id
        * @author Jonathan Sandoval <jonathan_s_pisis@yahoo.com.mx>
        *
        * @return self
        */
        public function setId($id)
        {
            $this->id = $id;
        }
     
        /**
        * Gets the value of date.
        * 
        * @author Jonathan Sandoval <jonathan_s_pisis@yahoo.com.mx>
        * @return mixed
        */
        public function getDate()
        {
            return $this->date;
        }
     
        /**
        * Sets the value of date.
        *
        * @param mixed $date the date
        * @author Jonathan Sandoval <jonathan_s_pisis@yahoo.com.mx>
        *
        * @return self
        */
        public function setDate($date)
        {
            $this->date = $date;
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
        * @param mixed $type the type
        * @author Jonathan Sandoval <jonathan_s_pisis@yahoo.com.mx>
        *
        * @return self
        */
        public function setType($type)
        {
            $this->type = $type;
        }
     
        /**
        * Gets the value of description.
        * 
        * @author Jonathan Sandoval <jonathan_s_pisis@yahoo.com.mx>
        * @return mixed
        */
        public function getDescription()
        {
            return $this->description;
        }
     
        /**
        * Sets the value of description.
        *
        * @param mixed $description the description
        * @author Jonathan Sandoval <jonathan_s_pisis@yahoo.com.mx>
        *
        * @return self
        */
        public function setDescription($description)
        {
            $this->description = $description;
        }
     
        /**
        * Gets the value of idUser.
        * 
        * @author Jonathan Sandoval <jonathan_s_pisis@yahoo.com.mx>
        * @return mixed
        */
        public function getIdUser()
        {
            return $this->idUser;
        }
     
        /**
        * Sets the value of idUser.
        *
        * @param mixed $idUser the id user
        * @author Jonathan Sandoval <jonathan_s_pisis@yahoo.com.mx>
        *
        * @return self
        */
        public function setIdUser($idUser)
        {
            $this->idUser = $idUser;
        }
    }

 ?>