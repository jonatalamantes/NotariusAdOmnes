<?php 

    require_once('Church.php');

    /**
    * Class to registry one Message
    * 
    * @author Jonathan Sandoval <jonathan_s_pisis@yahoo.com.mx>
    */
    class Message
    {
        private $id;
        private $contest;
        private $idUserFrom;
        private $idUserTo;
        private $seen;
        private $received;
        private $time;

        /**
         * Contructor for class Message
         * 
         * @param integer $i id
         * @param string  $c contest
         * @param string  $f idUserFrom
         * @param char    $t idUserTo
         * @param integer $s seen
         * @param integer $r received
         * @param integer $m time
         */
        function __construct($i = 0, $c = "", $f = "", $t = 'A', $s = 0, $r = 1, $m = 0)
        {
            $this->id               = $i;
            $this->contest          = $c;
            $this->idUserFrom       = $f;
            $this->idUserTo         = $t;
            $this->seen             = $s;
            $this->received         = $r;
            $this->time             = $m;
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
        * Gets the value of contest.
        *
        * @author Jonathan Sandoval <jonathan_s_pisis@yahoo.com.mx>
        * @return mixed
        */
        public function getContest()
        {
            return $this->contest;
        }
         
        /**
        * Sets the value of contest.
        *
        * @author Jonathan Sandoval <jonathan_s_pisis@yahoo.com.mx>
        * @param mixed $contest the contest
        */
        public function setContest($contest)
        {
            $this->contest = $contest;
        }
         
        /**
        * Gets the value of idUserFrom.
        *
        * @author Jonathan Sandoval <jonathan_s_pisis@yahoo.com.mx>
        * @return mixed
        */
        public function getIdUserFrom()
        {
            return $this->idUserFrom;
        }
         
        /**
        * Sets the value of idUserFrom.
        *
        * @author Jonathan Sandoval <jonathan_s_pisis@yahoo.com.mx>
        * @param mixed $idUserFrom the id user from
        */
        public function setIdUserFrom($idUserFrom)
        {
            $this->idUserFrom = $idUserFrom;
        }
         
        /**
        * Gets the value of idUserTo.
        *
        * @author Jonathan Sandoval <jonathan_s_pisis@yahoo.com.mx>
        * @return mixed
        */
        public function getIdUserTo()
        {
            return $this->idUserTo;
        }
         
        /**
        * Sets the value of idUserTo.
        *
        * @author Jonathan Sandoval <jonathan_s_pisis@yahoo.com.mx>
        * @param mixed $idUserTo the id user to
        */
        public function setIdUserTo($idUserTo)
        {
            $this->idUserTo = $idUserTo;
        }
         
        /**
        * Gets the value of seen.
        *
        * @author Jonathan Sandoval <jonathan_s_pisis@yahoo.com.mx>
        * @return mixed
        */
        public function getSeen()
        {
            return $this->seen;
        }
         
        /**
        * Sets the value of seen.
        *
        * @author Jonathan Sandoval <jonathan_s_pisis@yahoo.com.mx>
        * @param mixed $seen the seen
        */
        public function setSeen($seen)
        {
            $this->seen = $seen;
        }
         
        /**
        * Gets the value of received.
        *
        * @author Jonathan Sandoval <jonathan_s_pisis@yahoo.com.mx>
        * @return mixed
        */
        public function getReceived()
        {
            return $this->received;
        }
         
        /**
        * Sets the value of received.
        *
        * @author Jonathan Sandoval <jonathan_s_pisis@yahoo.com.mx>
        * @param mixed $received the received
        */
        public function setReceived($received)
        {
            $this->received = $received;
        }
         
        /**
        * Gets the value of time.
        *
        * @author Jonathan Sandoval <jonathan_s_pisis@yahoo.com.mx>
        * @return mixed
        */
        public function getTime()
        {
            return $this->time;
        }
         
        /**
        * Sets the value of time.
        *
        * @author Jonathan Sandoval <jonathan_s_pisis@yahoo.com.mx>
        * @param mixed $time the time
        */
        public function setTime($time)
        {
            $this->time = $time;
        }
    }

 ?>