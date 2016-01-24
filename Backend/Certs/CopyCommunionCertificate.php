<?php 

    require_once(__DIR__."/../../Backend/SessionManager.php");
    require_once(__DIR__."/../../Backend/PersonManager.php");
    require_once(__DIR__."/../../Backend/RectorManager.php");
    require_once(__DIR__."/../../Backend/BaptismManager.php");
    require_once(__DIR__."/../../Backend/CommunionManager.php");
    require_once("FPDF/fpdf.php");

    /**
    * Class to registry one Communion Certificate Copy
    * 
    * @author Jonathan Sandoval <jonathan_s_pisis@yahoo.com.mx>
    */
    class CopyCommunionCertificate extends FPDF
    {
        private $communion;
        private $user;
        private $full;

        /**
         * Class Constructor
         *
         * @author Jonathan Sandoval <jonathan_s_pisis@yahoo.com.mx>
         * @param  integer $idUser      idUser
         * @param  integer $idCommunion idCommunion
         * @param  boolean $full        full document
         */
        function __construct($idUser = 0, $idCommunion = 0, $full = false)
        {
            //Define the constructor
            parent::FPDF('P', 'mm', 'Letter');

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

            $rectorCommunion  = $this->communion->getIdRector();
            $rectorCommunion  = RectorManager::getSingleRector('id', $rectorCommunion);
            $rectorCommunionP = PersonManager::getSinglePerson('id', $rectorCommunion->getIdPerson());

            $userChurch     = $this->user->getIdChurch();
            $userChurch     = ChurchManager::getSingleChurch('id', $userChurch);

            $rectorUser  = RectorManager::getSingleRector('idActualChurch', $userChurch->getId(), 'position', 'Sr. Cura');
            $rectorUserP = $rectorUser->getPosition();
            $rectorUser  = PersonManager::getSinglePerson('id', $rectorUser->getIdPerson());

            $rectorMaxCommunion = RectorManager::getSingleRector('idActualChurch', $communionChurch->getId(), 'position', 'Sr. Cura');
            
            if ($rectorMaxCommunion !== NULL)
            {
                $rectorMaxCommunionP = $rectorMaxCommunion->getPosition();
                $rectorMaxCommunion  = PersonManager::getSinglePerson('id', $rectorMaxCommunion->getIdPerson());
            }
            else
            {   
                $rectorMaxCommunionP = $rectorCommunion->getPosition();
                $rectorMaxCommunion  = $rectorCommunionP;
            }

            $celebrationDate = DatabaseManager::databaseDateToSingleDate($this->communion->getCelebrationDate());

            $child  = PersonManager::getSinglePerson('id', $this->communion->getIdOwner());

            $father = PersonManager::getSinglePerson('id', $child->getIdFather());
            $mother = PersonManager::getSinglePerson('id', $child->getIdMother());

            $godFather = PersonManager::getSinglePerson('id', $this->communion->getIdGodFather());

            $communionRegistry = CommunionManager::getSingleCommunionRegistry('id', $this->communion->getIdBookRegistry());

            if ($communionRegistry === NULL)
            {
                $communionRegistry = new CommunionRegistry();
            }

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
            $paperConfig = SessionManager::getSinglePaperConfig('id', $this->user->getIdPaperConfig());

            $cellSize = 5;
            $test = 0;

            if ($this->full == 'true')
            {
                $x = 0;
                $y = 0;
                
                $this->Image(__DIR__."/../../Backend/Certs/img/communionCertCopy.jpg", $x+3, $y+2, 209, 281);
            }
            else
            {
                $x = intval($paperConfig->getCopyCommunionCertX());
                $y = intval($paperConfig->getCopyCommunionCertY());
            }

            //Create the box of the Notarius
            $this->SetFont('Arial','B', 9);

            //Get user Church Name 
            $this->SetXY($x+39, $y+57-$cellSize);
            $this->Cell(49, $cellSize, iconv('utf-8', 'cp1252', $userChurch->getName()), $test, 0, 'C');

            //Get user Church Address 
            $this->SetXY($x+39, $y+64-$cellSize);
            $this->Cell(49, $cellSize, iconv('utf-8', 'cp1252', $userChurch->getAddress()), $test, 0, 'C');

            //Get user Church City 
            $cityTemp   = CityManager::getSingleCity('id', $userChurch->getIdCity());
            $stateTemp  = CityManager::getSingleState('id', $cityTemp->getIdState());

            $this->SetXY($x+39, $y+72-$cellSize);
            $this->Cell(49, $cellSize, iconv('utf-8', 'cp1252', $cityTemp->getName(). ", " . $stateTemp->getShortName()), $test, 0, 'C');

            //Continue with the other part of the document
            $this->SetFont('Arial','B', 10);

            //Get user Rector 
            $this->SetXY($x+74, $y+85-$cellSize);
            $this->Cell(132, $cellSize, iconv('utf-8', 'cp1252', $rectorMaxCommunionP . " " . 
                                                                 $rectorMaxCommunion->getFullNameBeginName()), $test, 0, 'C');

            //Get user Church Name 
            $this->SetXY($x+66, $y+94-$cellSize);
            $this->Cell(140, $cellSize, iconv('utf-8', 'cp1252', $communionChurch->getName()), $test, 0, 'C');

            //Get The Book Registry Book
            $this->SetXY($x+141, $y+103-$cellSize);
            $this->Cell(20, $cellSize, $communionRegistry->getBook(), $test, 0, 'C');

            //Get The Book Registry Page
            $page = $communionRegistry->getPage();

            if ($communionRegistry->getReverse() === 'Y')
            {
                $page = $page . "v";
            }

            $this->SetXY($x+171, $y+103-$cellSize);
            $this->Cell(17, $cellSize, $page, $test, 0, 'C');

            //Set The rector of communion
            $rectorCName = $rectorCommunion->getPosition() . " " . $rectorCommunionP->getFullNameBeginName();
            $this->SetXY($x+115, $y+113-$cellSize);
            $this->Cell(92, $cellSize, iconv('utf-8', 'cp1252', $rectorCName), $test, 0, 'C');

            //Set The day of communion
            $this->SetXY($x+58, $y+130-$cellSize);
            $this->Cell(12, $cellSize, substr($celebrationDate, 0, 2), $test, 0, 'C');

            //Set The month of communion
            $this->SetXY($x+92, $y+130-$cellSize);
            $this->Cell(55, $cellSize, $month[intval(substr($celebrationDate, 3, 2))-1], $test, 0, 'C');

            //Set The year of communion
            $this->SetXY($x+153, $y+130-$cellSize);
            $this->Cell(18, $cellSize, substr($celebrationDate, 6), $test, 0, 'C');

            //Set The child
            $this->SetXY($x+96, $y+140-$cellSize);
            $this->Cell(110, $cellSize, iconv('utf-8', 'cp1252', $child->getFullNameBeginName()), $test, 0, 'C');

            //Set the Father
            if ($father != NULL)
            {
                $this->SetXY($x+61, $y+149-$cellSize);
                $this->Cell(145, $cellSize, iconv('utf-8', 'cp1252', $father->getFullNameBeginName()), $test, 0, 'C');
            }

            //Set the Mother
            if ($mother != NULL)
            {   
                $this->SetXY($x+56, $y+158-$cellSize);
                $this->Cell(150, $cellSize, iconv('utf-8', 'cp1252', $mother->getFullNameBeginName()), $test, 0, 'C');
            }

            //Set the GodFathers
            if ($godFather != NULL)
            {
                $godFathersString = $godFather->getFullNameBeginName();
                $this->SetXY($x+61, $y+167-$cellSize);
                $this->Cell(145, $cellSize, iconv('utf-8', 'cp1252', $godFathersString), $test, 0, 'C');
            }

            //Get the Baptism Data
            $baptism  = BaptismManager::getSingleBaptism('idOwner', $this->communion->getIdOwner());

            if ($baptism === NULL)
            {
                $stringAsterick = "***************************************";
                
                $this->SetXY($x+70, $y+177-$cellSize);
                $this->Cell(175, $cellSize, iconv('utf-8', 'cp1252', $stringAsterick), $test, 0, 'C');    

                $this->SetXY($x+81, $y+186-$cellSize);
                $this->Cell(175, $cellSize, iconv('utf-8', 'cp1252', $stringAsterick), $test, 0, 'C');  
            }
            else
            {
                $baptismDate   = DatabaseManager::databaseDateToSingleDate($baptism->getCelebrationDate());
                $baptismChurch = ChurchManager::getSingleChurch('id', $baptism->getIdChurch());
                
                $this->SetXY($x+70, $y+177-$cellSize);
                $this->Cell(135, $cellSize, iconv('utf-8', 'cp1252', $baptismChurch->getName()), $test, 0, 'C');    

                $this->SetXY($x+81, $y+186-$cellSize);
                $this->Cell(125, $cellSize, iconv('utf-8', 'cp1252', $baptismDate), $test, 0, 'C');  
            }

            //Get the current location
            $this->SetXY($x+47, $y+223-$cellSize);
            $this->Cell(66, $cellSize, iconv('utf-8', 'cp1252', $cityTemp->getName(). ", " . $stateTemp->getShortName()), $test, 0, 'C');

            //Get The Current Day
            $this->SetXY($x+120, $y+223-$cellSize);
            $this->Cell(15, $cellSize, date("d"), $test, 0, 'C');

            //Get The Current Month
            $this->SetXY($x+142, $y+223-$cellSize);
            $this->Cell(44, $cellSize, $month[intval(date("m"))-1], $test, 0, 'C');

            //Get The Current Year
            $this->SetXY($x+197.5, $y+223-$cellSize);
            $this->Cell(9, $cellSize, date('y'), $test, 0, 'C');

            //Get The Current Rector
            $this->SetXY($x+127, $y+240-$cellSize);
            $this->Cell(80, $cellSize, iconv('utf-8', 'cp1252', $rectorUserP . " " . $rectorUser->getFullNameBeginName()), $test, 0, 'R');
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