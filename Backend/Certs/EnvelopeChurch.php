<?php 

    require_once(__DIR__."/../../Backend/SessionManager.php");
    require_once(__DIR__."/../../Backend/ChurchManager.php");
    require_once("FPDF/fpdf.php");

    /**
    * Class to registry one Baptism Certificate
    * 
    * @author Jonathan Sandoval <jonathan_s_pisis@yahoo.com.mx>
    */
    class EnvelopeChurch extends FPDF
    {
        private $church;
        private $user;

        /**
         * Constructor of the Class
         *
         * @author Jonathan Sandoval <jonathan_s_pisis@yahoo.com.mx>
         * @param  integer $idUser    idUser
         * @param  integer $idChurch  idChurch
         * @param  boolean $full      full document
         */
        function __construct($idUser = 0, $idChurch = 0)
        {
            //Define the constructor
            parent::FPDF('L', 'mm', 'Letter');

            $this->church = ChurchManager::getSingleChurch('id', $idChurch);
            $this->user   = SessionManager::getSingleUser('id', $idUser);
        }

        function displayData()
        {
            $cityTemp   = CityManager::getSingleCity('id', $this->church->getIdCity());
    
            if ($cityTemp === NULL)
            {
                $cityTemp = new City();
            }

            $stateTemp  = CityManager::getSingleState('id', $cityTemp->getIdState());
            $cityString = "*************************";
            
            if ($stateTemp === NULL)
            {
                $stateTemp = new State();
            }
            else
            {
                $cityString = $cityTemp->getName() . ", " . $stateTemp->getShortName();   
            }
            
            $this->SetFont('Arial','B', 10);
            $cellSizeY = 5;
            
            
            for ($i = 0; $i < 3; $i++)
            {
                //Get the data necesary of create the document            
                $this->SetXY($x+100, $i*60 + $y+40-$cellSizeY);
                $this->Cell(80, $cellSizeY, iconv('utf-8', 'cp1252', $this->church->getName()), 0, 0, 'C');
                
                $this->SetXY($x+100, $i*60 + $y+47-$cellSizeY);
                $this->Cell(80, $cellSizeY, iconv('utf-8', 'cp1252', $this->church->getAddress()), 0, 0, 'C');
                
                $this->SetXY($x+100, $i*60 + $y+54-$cellSizeY);
                $this->Cell(80, $cellSizeY, iconv('utf-8', 'cp1252', 'CP. ' . $this->church->getPostalCode()), 0, 0, 'C');
                
                $this->SetXY($x+100, $i*60 + $y+61-$cellSizeY);
                $this->Cell(80, $cellSizeY, iconv('utf-8', 'cp1252', $cityString), 0, 0, 'C');    
            }    
        }
     
        /**
        * Gets the value of baptism.
        * 
        * @author Jonathan Sandoval <jonathan_s_pisis@yahoo.com.mx>
        * @return mixed
        */
        public function getChurch()
        {
            return $this->church;
        }
     
        /**
        * Sets the value of baptism.
        *
        * @param mixed $baptism the baptism
        * @author Jonathan Sandoval <jonathan_s_pisis@yahoo.com.mx>
        *
        * @return self
        */
        public function setChurch($baptism)
        {
            $this->church = $church;
        }
     
        /**
        * Gets the value of user.
        * 
        * @author Jonathan Sandoval <jonathan_s_pisis@yahoo.com.mx>
        * @return mixed
        */
        public function getUser()
        {
            return $this->user;
        }
     
        /**
        * Sets the value of user.
        *
        * @param mixed $user the user
        * @author Jonathan Sandoval <jonathan_s_pisis@yahoo.com.mx>
        *
        * @return self
        */
        public function setUser($user)
        {
            $this->user = $user;
        }
    }
 ?>