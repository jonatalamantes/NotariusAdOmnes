<?php 

    require_once('Person.php');
    require_once('Church.php');

    /**
    * Class to registry one Rector/Priest
    * 
    * @author Jonathan Sandoval <jonathan_s_pisis@yahoo.com.mx>
    */
    class Rector
    {
        private $id;
        private $type;
        private $status;
        private $position;
        private $idActualChurch;
        private $idPerson;

        /**
         * Contructor for class Person
         * 
         * @param integer $i  id
         * @param string  $t  type
         * @param string  $s  status
         * @param string  $p  position
         * @param integer $ac idActualChurch
         * @param integer $ip idPerson
         */
        function __construct($i = 0, $t = "", $s = 'A', $p = "", $ac = 0, $ip = 0)
        {
            $this->id             = $i;
            $this->type           = $t;
            $this->status         = $s;
            $this->position       = $p;
            $this->idActualChurch = $ac;
            $this->idPerson       = $ip;
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
        * Gets the value of status.
        *
        * @author Jonathan Sandoval <jonathan_s_pisis@yahoo.com.mx>
        * @return mixed
        */
        public function getStatus()
        {
            return $this->status;
        }
         
        /**
        * Sets the value of status.
        *
        * @author Jonathan Sandoval <jonathan_s_pisis@yahoo.com.mx>
        * @param mixed $status the status
        */
        public function setStatus($status)
        {
            $this->status = $status;
        }
         
        /**
        * Gets the value of position.
        *
        * @author Jonathan Sandoval <jonathan_s_pisis@yahoo.com.mx>
        * @return mixed
        */
        public function getPosition()
        {
            return $this->position;
        }
         
        /**
        * Sets the value of position.
        *
        * @author Jonathan Sandoval <jonathan_s_pisis@yahoo.com.mx>
        * @param mixed $position the position
        */
        public function setPosition($position)
        {
            $this->position = $position;
        }
         
        /**
        * Gets the value of idActualChurch.
        *
        * @author Jonathan Sandoval <jonathan_s_pisis@yahoo.com.mx>
        * @return mixed
        */
        public function getIdActualChurch()
        {
            return $this->idActualChurch;
        }
         
        /**
        * Sets the value of idActualChurch.
        *
        * @author Jonathan Sandoval <jonathan_s_pisis@yahoo.com.mx>
        * @param mixed $idActualChurch the id actual church
        */
        public function setIdActualChurch($idActualChurch)
        {
            $this->idActualChurch = $idActualChurch;
        }
         
        /**
        * Gets the value of idPerson.
        *
        * @author Jonathan Sandoval <jonathan_s_pisis@yahoo.com.mx>
        * @return mixed
        */
        public function getIdPerson()
        {
            return $this->idPerson;
        }
         
        /**
        * Sets the value of idPerson.
        *
        * @author Jonathan Sandoval <jonathan_s_pisis@yahoo.com.mx>
        * @param mixed $idPerson the id person
        */
        public function setIdPerson($idPerson)
        {
            $this->idPerson = $idPerson;
        }
    }

 ?>