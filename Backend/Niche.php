<?php 

    /**
    * Class to registry one Niche
    * 
    * @author Jonathan Sandoval <jonathan_s_pisis@yahoo.com.mx>
    */
    class Niche
    {
        private $id;
        private $maxCol;
        private $maxRow;
        private $size;

        /**
         * Contructor to Made Objets
         *
         * @author Jonathan Sandoval <jonathan_s_pisis@yahoo.com.mx>
         * @param integer    $i    id
         * @param integer    $mc   maxCol
         * @param integer    $mr   maxRow
         * @param integer    $s    size
         */
        function __construct($i = 0, $mc = 0, $mr = 0, $s = 0)
        {

            $this->id     = $i;   
            $this->maxCol = $mc;
            $this->maxRow = $mr;
            $this->size   = $s;
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
        * Gets the value of maxCol.
        * 
        * @author Jonathan Sandoval <jonathan_s_pisis@hotmail.com>
        * @return mixed
        */
        public function getMaxCol()
        {
            return $this->maxCol;
        }
         
        /**
        * Sets the value of maxCol.
        *
        * @author Jonathan Sandoval <jonathan_s_pisis@hotmail.com>
        * @param mixed $maxCol the max col
        */
        public function setMaxCol($maxCol)
        {
            $this->maxCol = $maxCol;
        }
         
        /**
        * Gets the value of maxRow.
        * 
        * @author Jonathan Sandoval <jonathan_s_pisis@hotmail.com>
        * @return mixed
        */
        public function getMaxRow()
        {
            return $this->maxRow;
        }
         
        /**
        * Sets the value of maxRow.
        *
        * @author Jonathan Sandoval <jonathan_s_pisis@hotmail.com>
        * @param mixed $maxRow the max row
        */
        public function setMaxRow($maxRow)
        {
            $this->maxRow = $maxRow;
        }
         
        /**
        * Gets the value of size.
        * 
        * @author Jonathan Sandoval <jonathan_s_pisis@hotmail.com>
        * @return mixed
        */
        public function getSize()
        {
            return $this->size;
        }
         
        /**
        * Sets the value of size.
        *
        * @author Jonathan Sandoval <jonathan_s_pisis@hotmail.com>
        * @param mixed $size the size
        */
        public function setSize($size)
        {
            $this->size = $size;
        }
    }


 ?>