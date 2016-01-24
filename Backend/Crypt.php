<?php 

    /**
    * Class to registry one Crypt in one Niche
    * 
    * @author Jonathan Sandoval <jonathan_s_pisis@yahoo.com.mx>
    */
    class Crypt
    {
        private $id;
        private $col;
        private $row;
        private $number;
        private $idNiche;

        /**
         * Contructor for class Crypt
         *
         * @param integer $i  id
         * @param integer $c  col
         * @param integer $r  row
         * @param integer $n  number
         * @param integer $ni idNiche
         */
        function __construct($i = 0, $c = 0, $r = 0, $n = 0, $ni = 0)
        {
            $this->id      = $i;
            $this->col     = $c;
            $this->row     = $r;
            $this->number  = $n;
            $this->idNiche = $ni;
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
        * Gets the value of col.
        *
        * @author Jonathan Sandoval <jonathan_s_pisis@yahoo.com.mx>
        * @return mixed
        */
        public function getCol()
        {
            return $this->col;
        }
         
        /**
        * Sets the value of col.
        *
        * @author Jonathan Sandoval <jonathan_s_pisis@yahoo.com.mx>
        * @param mixed $col the col
        */
        public function setCol($col)
        {
            $this->col = $col;
        }
         
        /**
        * Gets the value of row.
        *
        * @author Jonathan Sandoval <jonathan_s_pisis@yahoo.com.mx>
        * @return mixed
        */
        public function getRow()
        {
            return $this->row;
        }
         
        /**
        * Sets the value of row.
        *
        * @author Jonathan Sandoval <jonathan_s_pisis@yahoo.com.mx>
        * @param mixed $row the row
        */
        public function setRow($row)
        {
            $this->row = $row;
        }
         
        /**
        * Gets the value of number.
        *
        * @author Jonathan Sandoval <jonathan_s_pisis@yahoo.com.mx>
        * @return mixed
        */
        public function getNumber()
        {
            return $this->number;
        }
         
        /**
        * Sets the value of number.
        *
        * @author Jonathan Sandoval <jonathan_s_pisis@yahoo.com.mx>
        * @param mixed $number the number
        */
        public function setNumber($number)
        {
            $this->number = $number;
        }
         
        /**
        * Gets the value of idNiche.
        *
        * @author Jonathan Sandoval <jonathan_s_pisis@yahoo.com.mx>
        * @return mixed
        */
        public function getIdNiche()
        {
            return $this->idNiche;
        }
         
        /**
        * Sets the value of idNiche.
        *
        * @author Jonathan Sandoval <jonathan_s_pisis@yahoo.com.mx>
        * @param mixed $idNiche the id niche
        */
        public function setIdNiche($idNiche)
        {
            $this->idNiche = $idNiche;
        }
    }

 ?>