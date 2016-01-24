<?php 

    require_once('OfficeCivilRegistry.php');

    /**
    * Class to registry one instance from the Civil Registry
    * 
    * @author Jonathan Sandoval <jonathan_s_pisis@yahoo.com.mx>
    */
    class CivilRegistry
    {
        private $id;
        private $number;
        private $book;
        private $page;
        private $idOffice;

        /**
         * Contructor for class CivilRegistry
         * 
         * @param integer              $i id
         * @param integer              $n number
         * @param integer              $b book
         * @param integer              $p page
         * @param integer              $o idOffice
         */
        function __construct($i = 0, $n = 0, $b = 0, $p = 0, $o = 0)
        {
            $this->id       = $i;
            $this->number   = $n;
            $this->book     = $b;
            $this->page     = $p;
            $this->idOffice = $o;
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
        * Gets the value of book.
        *
        * @author Jonathan Sandoval <jonathan_s_pisis@yahoo.com.mx>
        * @return mixed
        */
        public function getBook()
        {
            return $this->book;
        }
         
        /**
        * Sets the value of book.
        *
        * @author Jonathan Sandoval <jonathan_s_pisis@yahoo.com.mx>
        * @param mixed $book the book
        */
        public function setBook($book)
        {
            $this->book = $book;
        }
         
        /**
        * Gets the value of page.
        *
        * @author Jonathan Sandoval <jonathan_s_pisis@yahoo.com.mx>
        * @return mixed
        */
        public function getPage()
        {
            return $this->page;
        }
         
        /**
        * Sets the value of page.
        *
        * @author Jonathan Sandoval <jonathan_s_pisis@yahoo.com.mx>
        * @param mixed $page the page
        */
        public function setPage($page)
        {
            $this->page = $page;
        }
         
        /**
        * Gets the value of idOffice.
        *
        * @author Jonathan Sandoval <jonathan_s_pisis@yahoo.com.mx>
        * @return mixed
        */
        public function getIdOffice()
        {
            return $this->idOffice;
        }
         
        /**
        * Sets the value of idOffice.
        *
        * @author Jonathan Sandoval <jonathan_s_pisis@yahoo.com.mx>
        * @param mixed $idOffice the id office
        */
        public function setIdOffice($idOffice)
        {
            $this->idOffice = $idOffice;
        }
    }

 ?>