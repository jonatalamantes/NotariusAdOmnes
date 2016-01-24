<?php 

    /**
    * Class to registry one Dean
    * 
    * @author Jonathan Sandoval <jonathan_s_pisis@yahoo.com.mx>
    */
    class Dean
    {
        private $id;
        private $name;
        
        /**
         * Contructor to Made Objets
         *
         * @param integer  $i   id
         * @param string   $n   name
         */
        function __construct($i = 0, $n = "")
        {
            $this->id   = $i;
            $this->name = $n;
        }

        /**
        * Gets the value of id.
        * 
        * @author Jonathan Sandoval <jonathan_s_pisis@hotmail.com>
        * @return mixed
        */
        public function getId()
        {
            return $this->id;
        }
         
        /**
        * Sets the value of id.
        *
        * @author Jonathan Sandoval <jonathan_s_pisis@hotmail.com>
        * @param mixed $id the id
        */
        public function setId($id)
        {
            $this->id = $id;
        }
         
        /**
        * Gets the value of name.
        * 
        * @author Jonathan Sandoval <jonathan_s_pisis@hotmail.com>
        * @return mixed
        */
        public function getName()
        {
            return $this->name;
        }
         
        /**
        * Sets the value of name.
        *
        * @author Jonathan Sandoval <jonathan_s_pisis@hotmail.com>
        * @param mixed $name the name
        */
        public function setName($name)
        {
            $this->name = $name;
        }
    }



 ?>