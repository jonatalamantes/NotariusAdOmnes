<?php 

    require_once(__DIR__."/../../Backend/SessionManager.php");
    require_once(__DIR__."/../../Backend/CommunionManager.php");
    require_once(__DIR__."/../../Backend/PersonManager.php");
    require_once(__DIR__."/../../Backend/RectorManager.php");
    require_once("FPDF/fpdf.php");

    /**
    * Class to registry one Communion Certificate
    * 
    * @author Jonathan Sandoval <jonathan_s_pisis@yahoo.com.mx>
    */
    class CommunionCertificate extends FPDF
    {
        private $communion;
        private $user;
        private $full;

        /**
         * Class Contructor
         *
         * @author Jonathan Sandoval <jonathan_s_pisis@yahoo.com.mx>
         * @param  integer $idUser      idUser
         * @param  integer $idCommunion idCommunion
         * @param  boolean $full        full document
         */
        function __construct($idUser = 0, $idCommunion = 0, $full = false)
        {
            //Define the constructor
            if ($full == 'true')
            {
                parent::FPDF('P', 'mm', array(190, 160));    
            }
            else
            {
                parent::FPDF('P', 'mm', 'letter');
            }

            $this->communion = CommunionManager::getSingleCommunion('id', $idCommunion);
            $this->user    = SessionManager::getSingleUser('id', $idUser);

            $this->full = $full;
        }

        function displayData()
        {
            //Get the data necesary of create the document
            $month = array("Enero","Febrero","Marzo","Abril","Mayo","Junio","Julio","Agosto","Septiembre","Octubre","Noviembre","Diciembre");

            $communionChurch = $this->communion->getIdChurch();
            $communionChurch = ChurchManager::getSingleChurch('id', $communionChurch);
            $cityChurch = CityManager::getSingleCity('id', $communionChurch->getIdCity());

            $rectorCommunion = $this->communion->getIdRector();
            $rectorCommunion = RectorManager::getSingleRector('id', $rectorCommunion);
            $rectorCommunionP = PersonManager::getSinglePerson('id', $rectorCommunion->getIdPerson());

            $celebrationDate = DatabaseManager::databaseDateToSingleDate($this->communion->getCelebrationDate());

            $child  = PersonManager::getSinglePerson('id', $this->communion->getIdOwner());
            $father = PersonManager::getSinglePerson('id', $child->getIdFather());
            $mother = PersonManager::getSinglePerson('id', $child->getIdMother());

            $godFather = PersonManager::getSinglePerson('id', $this->communion->getIdGodFather());

            $communionRegistry = CommunionManager::getSingleCommunionRegistry('id', $this->communion->getIdBookRegistry());

            if ($father === NULL)
            {
                $father = new Person(0, "*************************");
            }

            if ($mother === NULL)
            {
                $mother = new Person(0, "*************************");
            }

            if ($godFather === NULL)
            {
                $godFather = new Person(0, "*************************");
            }

            //Config the document 
            $this->SetFont('Arial','B', 10);
            $paperConfig = SessionManager::getSinglePaperConfig('id', $this->user->getIdPaperConfig());

            $cellSizeY = 5;
            $test = 0;

            if ($this->full == 'true')
            {
                $x = 0;
                $y = 0;
                
                $this->Image(__DIR__."/../../Backend/Certs/img/communionCert.jpg", $x, $y, 155, 187);
            }
            else
            {
                $x = intval($paperConfig->getCommunionCertX());
                $y = intval($paperConfig->getCommunionCertY());
            }

            //Set The Name of the Child
            $this->SetXY($x+65, $y+57-$cellSizeY);
            $this->Cell(82, $cellSizeY, iconv('utf-8', 'cp1252', $child->getFullNameBeginName()), $test, 0, 'C');

            if ($child->getGender() == 'F')
            {
                $this->SetXY($x+46.5, $y+68-$cellSizeY);
                $this->Cell(6, $cellSizeY, iconv('utf-8', 'cp1252', "a"), $test, 0, 'C');                
            }
            else
            {
                $this->SetXY($x+46.5, $y+68-$cellSizeY);
                $this->Cell(6, $cellSizeY, iconv('utf-8', 'cp1252', "o"), $test, 0, 'C');                
            }

            //Get The Father
            $this->SetXY($x+59, $y+68-$cellSizeY);
            $this->Cell(88, $cellSizeY, iconv('utf-8', 'cp1252', $father->getFullNameBeginName()), $test, 0, 'C');

            //Get The Mother
            $this->SetXY($x+50, $y+79-$cellSizeY);
            $this->Cell(97, $cellSizeY, iconv('utf-8', 'cp1252', $mother->getFullNameBeginName()), $test, 0, 'C');

            //Get The Communion Rector
            $this->SetXY($x+43, $y+101.5-$cellSizeY);
            $this->Cell(104, $cellSizeY, iconv('utf-8', 'cp1252', $rectorCommunion->getPosition() . " " . 
                                                                  $rectorCommunionP->getFullNameBeginName()), $test, 0, 'C');

            //Set the Godfather
            if ($child->getGender() == 'F')
            {
                $this->SetXY($x+42, $y+113-$cellSizeY);
                $this->Cell(6, $cellSizeY, iconv('utf-8', 'cp1252', 'M'), $test, 0, 'C');

                $this->SetXY($x+58, $y+113-$cellSizeY);
                $this->Cell(6, $cellSizeY, iconv('utf-8', 'cp1252', 'a'), $test, 0, 'C');
            }
            else
            {
                $this->SetXY($x+42, $y+113-$cellSizeY);
                $this->Cell(6, $cellSizeY, iconv('utf-8', 'cp1252', 'P'), $test, 0, 'C');

                $this->SetXY($x+58, $y+113-$cellSizeY);
                $this->Cell(6, $cellSizeY, iconv('utf-8', 'cp1252', 'o'), $test, 0, 'C');
            }
            
            $this->SetXY($x+64, $y+113-$cellSizeY);
            $this->Cell(83, $cellSizeY, iconv('utf-8', 'cp1252', $godFather->getFullNameBeginName()), $test, 0, 'C');

            //Set The church of communion
            $this->SetXY($x+64, $y+124-$cellSizeY);
            $this->Cell(83, $cellSizeY, iconv('utf-8', 'cp1252', $communionChurch->getName()), $test, 0, 'C');

            $this->SetFont('Arial','B', 7);

            $this->SetXY($x+59, $y+135-$cellSizeY);
            $this->Cell(36, $cellSizeY, iconv('utf-8', 'cp1252', $communionChurch->getAddress()), $test, 0, 'C');

            $this->SetXY($x+113, $y+135-$cellSizeY);
            $this->Cell(33, $cellSizeY, iconv('utf-8', 'cp1252', $cityChurch->getName()), $test, 0, 'C');

            $this->SetFont('Arial','B', 10);

            //Set The day of communion
            $this->SetXY($x+53, $y+146-$cellSizeY);
            $this->Cell(10.5, $cellSizeY, substr($celebrationDate, 0, 2), $test, 0, 'C');

            //Set The month of communion
            $this->SetXY($x+69, $y+146-$cellSizeY);
            $this->Cell(33, $cellSizeY, $month[intval(substr($celebrationDate, 3, 2))-1], $test, 0, 'C');

            //Set The year of communion
            $this->SetXY($x+115, $y+146-$cellSizeY);
            $this->Cell(13, $cellSizeY, substr($celebrationDate, 6), $test, 0, 'C');
            
            if ($this->full != 'true')
            {
                $userChurch = $this->user->getIdChurch();
                $userChurch = ChurchManager::getSingleChurch('id', $userChurch);
    
                $rectorUser  = RectorManager::getSingleRector('idActualChurch', $userChurch->getId(), 'position', 'Sr. Cura');
                $rectorUserP = $rectorUser->getPosition();
                $rectorUser  = PersonManager::getSinglePerson('id', $rectorUser->getIdPerson());
    
                $this->SetFont('Arial','B', 10);
    
                $communionRegistry = CommunionManager::getSingleCommunionRegistry('id', $this->communion->getIdBookRegistry());
    
                if ($communionRegistry === NULL)
                {
                    $communionRegistry = new CommunionRegistry();
                }
    
                //Get The Book Registry Book
                $this->SetXY($x+52, $y+158-$cellSizeY);
                $this->Cell(13, $cellSizeY, $communionRegistry->getBook(), $test, 0, 'C');
    
                //Get The Book Registry Page
                $page = $communionRegistry->getPage();
    
                if ($communionRegistry->getReverse() === 'Y')
                {
                    $page = $page . "v";
                }
    
                $this->SetXY($x+75, $y+158-$cellSizeY);
                $this->Cell(13, $cellSizeY, $page, $test, 0, 'C');
    
                //Get The Rector from the user
                $this->SetXY($x+90, $y+182-$cellSizeY);
                $this->Cell(57, $cellSizeY, iconv('utf-8', 'cp1252', $rectorUserP . " " . $rectorUser->getFullNameBeginName()), $test, 0, 'C');
            }
        }

        // Footer
        function Footer()
        {
            if ($this->full == 'true')
            {
                $userChurch = $this->user->getIdChurch();
                $userChurch = ChurchManager::getSingleChurch('id', $userChurch);
    
                $rectorUser  = RectorManager::getSingleRector('idActualChurch', $userChurch->getId(), 'position', 'Sr. Cura');
                $rectorUserP = $rectorUser->getPosition();
                $rectorUser  = PersonManager::getSinglePerson('id', $rectorUser->getIdPerson());
    
                $this->SetFont('Arial','B', 10);
                $paperConfig = SessionManager::getSinglePaperConfig('id', $this->user->getIdPaperConfig());
    
                $cellSizeY = 5;
                $test = 0;
    
                if ($this->full == 'true')
                {
                    $x = 0;
                    $y = 0;
                }
                else
                {
                    $x = intval($paperConfig->getCommunionCertX());
                    $y = intval($paperConfig->getCommunionCertY());
                }
    
                $communionRegistry = CommunionManager::getSingleCommunionRegistry('id', $this->communion->getIdBookRegistry());
    
                if ($communionRegistry === NULL)
                {
                    $communionRegistry = new CommunionRegistry();
                }
    
                //Get The Book Registry Book
                $this->SetXY($x+52, $y+158-$cellSizeY);
                $this->Cell(13, $cellSizeY, $communionRegistry->getBook(), $test, 0, 'C');
    
                //Get The Book Registry Page
                $page = $communionRegistry->getPage();
    
                if ($communionRegistry->getReverse() === 'Y')
                {
                    $page = $page . "v";
                }
    
                $this->SetXY($x+75, $y+158-$cellSizeY);
                $this->Cell(13, $cellSizeY, $page, $test, 0, 'C');
    
                //Get The Rector from the user
                $this->SetXY($x+90, $y+182-$cellSizeY);
                $this->Cell(57, $cellSizeY, iconv('utf-8', 'cp1252', $rectorUserP . " " . $rectorUser->getFullNameBeginName()), $test, 0, 'C');
            }
        }
     
        /**
        * Gets the value of communion.
        * 
        * @author Jonathan Sandoval <jonathan_s_pisis@yahoo.com.mx>
        * @return mixed
        */
        public function getCommunion()
        {
            return $this->communion;
        }
     
        /**
        * Sets the value of communion.
        *
        * @param mixed $communion the communion
        * @author Jonathan Sandoval <jonathan_s_pisis@yahoo.com.mx>
        *
        * @return self
        */
        public function setCommunion($communion)
        {
            $this->communion = $communion;
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
     
        /**
        * Gets the value of full.
        * 
        * @author Jonathan Sandoval <jonathan_s_pisis@yahoo.com.mx>
        * @return mixed
        */
        public function getFull()
        {
            return $this->full;
        }
     
        /**
        * Sets the value of full.
        *
        * @param mixed $full the full
        * @author Jonathan Sandoval <jonathan_s_pisis@yahoo.com.mx>
        *
        * @return self
        */
        public function setFull($full)
        {
            $this->full = $full;
        }
    }
 ?>