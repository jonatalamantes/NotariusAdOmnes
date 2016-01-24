<?php 
    
    require_once("Church.php");

    /**
    * Class to registry one Book Registry
    * 
    * @author Jonathan Sandoval <jonathan_s_pisis@yahoo.com.mx>
    */
    class BookRegistry
    {
        private $id;
        private $book;
        private $number;
        private $page;
        private $reverse;

        /**
         * Contructor for class BookRegistry
         * 
         * @param integer $i id
         * @param string  $b book
         * @param integer $n number
         * @param integer $p page
         * @param string  $r reverse
         */
        function __construct($i = 0, $b = "", $n = 0, $p = 0, $r = 'n')
        {
            $this->id       = $i;
            $this->book     = $b;
            $this->number   = $n;
            $this->page     = $p;
            $this->reverse  = $r;
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
        * @param mixed   $id   the id
        */
        public function setId($id)
        {
            $this->id = $id;
        }
         
        /**
        * Gets the value of book.
        * 
        * @author Jonathan Sandoval <jonathan_s_pisis@hotmail.com>
        * @return mixed
        */
        public function getBook()
        {
            return $this->book;
        }
         
        /**
        * Sets the value of book.
        *
        * @author Jonathan Sandoval <jonathan_s_pisis@hotmail.com>
        * @param mixed   $book   the book
        */
        public function setBook($book)
        {
            $this->book = $book;
        }
         
        /**
        * Gets the value of number.
        * 
        * @author Jonathan Sandoval <jonathan_s_pisis@hotmail.com>
        * @return mixed
        */
        public function getNumber()
        {
            return $this->number;
        }
         
        /**
        * Sets the value of number.
        *
        * @author Jonathan Sandoval <jonathan_s_pisis@hotmail.com>
        * @param mixed   $number   the number
        */
        public function setNumber($number)
        {
            $this->number = $number;
        }
         
        /**
        * Gets the value of page.
        * 
        * @author Jonathan Sandoval <jonathan_s_pisis@hotmail.com>
        * @return mixed
        */
        public function getPage()
        {
            return $this->page;
        }
         
        /**
        * Sets the value of page.
        *
        * @author Jonathan Sandoval <jonathan_s_pisis@hotmail.com>
        * @param mixed   $page   the page
        */
        public function setPage($page)
        {
            $this->page = $page;
        }
         
        /**
        * Gets the value of reverse.
        * 
        * @author Jonathan Sandoval <jonathan_s_pisis@hotmail.com>
        * @return mixed
        */
        public function getReverse()
        {
            return $this->reverse;
        }
         
        /**
        * Sets the value of reverse.
        *
        * @author Jonathan Sandoval <jonathan_s_pisis@hotmail.com>
        * @param mixed   $reverse   the reverse
        */
        public function setReverse($reverse)
        {
            $this->reverse = $reverse;
        }
    }

    /**
    * Class to registry one Baptism Registry
    * 
    * @author Jonathan Sandoval <jonathan_s_pisis@yahoo.com.mx>
    */
    class BaptismRegistry extends BookRegistry {}

    /**
    * Class to registry one Comunion Registry
    * 
    * @author Jonathan Sandoval <jonathan_s_pisis@yahoo.com.mx>
    */
    class CommunionRegistry extends BookRegistry {}

    /**
    * Class to registry one Confirmation Registry
    * 
    * @author Jonathan Sandoval <jonathan_s_pisis@yahoo.com.mx>
    */
    class ConfirmationRegistry extends BookRegistry {}

    /**
    * Class to registry one Wedding Registry
    * 
    * @author Jonathan Sandoval <jonathan_s_pisis@yahoo.com.mx>
    */
    class MarriageRegistry extends BookRegistry {}

 ?>