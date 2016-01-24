<?php 

    require_once(__DIR__."/../../Backend/SessionManager.php");
    require_once(__DIR__."/../../Backend/ConfirmationManager.php");
    require_once(__DIR__."/../../Backend/PersonManager.php");
    require_once(__DIR__."/../../Backend/RectorManager.php");
    require_once(__DIR__."/../../Backend/BaptismManager.php");
    require_once("FPDF/fpdf.php");

    /**
    * Class to registry one Confirmation Certificate
    * 
    * @author Jonathan Sandoval <jonathan_s_pisis@yahoo.com.mx>
    */
    class ConfirmationCertificate extends FPDF
    {
        private $confirmation;
        private $user;
        private $full;

        /**
         * Class Constructor
         *
         * @author Jonathan Sandoval <jonathan_s_pisis@yahoo.com.mx>
         * @param  integer $idUser         idUser
         * @param  integer $idConfirmation idConfirmation
         * @param  boolean $full           full document
         */
        function __construct($idUser = 0, $idConfirmation = 0, $full = false)
        {
            //Define the constructor
            if ($full == 'true')
            {
                parent::FPDF('L', 'mm', array(283, 190));
            }
            else
            {
                parent::FPDF('L', 'mm', 'Letter');
            }

            $this->confirmation = ConfirmationManager::getSingleConfirmation('id', $idConfirmation);
            $this->user    = SessionManager::getSingleUser('id', $idUser);

            $this->full = $full;
        }

        function displayData()
        {
            //Get the data necesary of create the document
            $month = array("Enero","Febrero","Marzo","Abril","Mayo","Junio","Julio","Agosto","Septiembre","Octubre","Noviembre","Diciembre");

            $confirmationChurch = $this->confirmation->getIdChurch();
            $confirmationChurch = ChurchManager::getSingleChurch('id', $confirmationChurch);
            $cityChurch = CityManager::getSingleCity('id', $confirmationChurch->getIdCity());

            $rectorConfirmation = $this->confirmation->getIdRector();
            $rectorConfirmation = RectorManager::getSingleRector('id', $rectorConfirmation);
            $rectorConfirmationP = PersonManager::getSinglePerson('id', $rectorConfirmation->getIdPerson());

            $celebrationDate = DatabaseManager::databaseDateToSingleDate($this->confirmation->getCelebrationDate());

            $child  = PersonManager::getSinglePerson('id', $this->confirmation->getIdOwner());
            $father = PersonManager::getSinglePerson('id', $child->getIdFather());
            $mother = PersonManager::getSinglePerson('id', $child->getIdMother());

            $godFather = PersonManager::getSinglePerson('id', $this->confirmation->getIdGodFather());

            $confirmationRegistry = ConfirmationManager::getSingleConfirmationRegistry('id', $this->confirmation->getIdBookRegistry());

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
            $this->SetFont('Arial','B', 9);
            $paperConfig = SessionManager::getSinglePaperConfig('id', $this->user->getIdPaperConfig());

            $cellSizeY = 5;
            $test = 0;

            if ($this->full == 'true')
            {
                $x = 0;
                $y = 0;
            
                $this->Image(__DIR__."/../../Backend/Certs/img/confirmationCert.jpg", $x, $y, 283, 190);
            }
            else
            {
                $x = intval($paperConfig->getConfirmationCertX());
                $y = intval($paperConfig->getConfirmationCertY());
            }

            //Put the data of the Certificate

            //Set The Name of the Child
            $this->SetXY($x+140, $y+42-$cellSizeY);
            $this->Cell(50, $cellSizeY, iconv('utf-8', 'cp1252', $child->getNames()), $test, 0, 'C');

            //Set The Lastname1 of the Child
            $this->SetXY($x+190, $y+42-$cellSizeY);
            $this->Cell(40, $cellSizeY, iconv('utf-8', 'cp1252', $child->getLastname1()), $test, 0, 'C');

            //Set The Lastname2 of the Child
            $this->SetXY($x+230, $y+42-$cellSizeY);
            $this->Cell(40, $cellSizeY, iconv('utf-8', 'cp1252', $child->getLastname2()), $test, 0, 'C');

            if ($child->getGender() == 'F')
            {
                $this->SetXY($x+145, $y+54-$cellSizeY);
                $this->Cell(6, $cellSizeY, iconv('utf-8', 'cp1252', "a"), $test, 0, 'C');                
            }
            else
            {
                $this->SetXY($x+145, $y+54-$cellSizeY);
                $this->Cell(6, $cellSizeY, iconv('utf-8', 'cp1252', "o"), $test, 0, 'C');                
            }

            $this->SetFont('Arial','B', 7);

            //Get The Father
            $this->SetXY($x+157, $y+54-$cellSizeY);
            $this->Cell(50, $cellSizeY, iconv('utf-8', 'cp1252', $father->getFullNameBeginName()), $test, 0, 'C');

            //Get The Mother
            $this->SetXY($x+210, $y+54-$cellSizeY);
            $this->Cell(60, $cellSizeY, iconv('utf-8', 'cp1252', $mother->getFullNameBeginName()), $test, 0, 'C');

            $this->SetFont('Arial','B', 9);

            //Get The Confirmation Rector
            $this->SetXY($x+140, $y+78-$cellSizeY);
            $this->Cell(130, $cellSizeY, iconv('utf-8', 'cp1252', $rectorConfirmation->getPosition() . " " . 
                                                                  $rectorConfirmationP->getFullNameBeginName()), $test, 0, 'C');

            //Set The day of confirmation
            $this->SetXY($x+150, $y+90-$cellSizeY);
            $this->Cell(16, $cellSizeY, substr($celebrationDate, 0, 2), $test, 0, 'C');

            //Set The month of confirmation
            $this->SetXY($x+172, $y+90-$cellSizeY);
            $this->Cell(55, $cellSizeY, $month[intval(substr($celebrationDate, 3, 2))-1], $test, 0, 'C');

            //Set The year of confirmation
            $this->SetXY($x+233, $y+90-$cellSizeY);
            $this->Cell(14, $cellSizeY, substr($celebrationDate, 6), $test, 0, 'C');

            //Set The church of confirmation
            $this->SetXY($x+140, $y+102-$cellSizeY);
            $this->Cell(130, $cellSizeY, iconv('utf-8', 'cp1252', $confirmationChurch->getName()), $test, 0, 'C');

            $this->SetXY($x+140, $y+114-$cellSizeY);
            $this->Cell(130, $cellSizeY, iconv('utf-8', 'cp1252', $confirmationChurch->getAddress() . " " . $cityChurch->getName()), $test, 0, 'C');

            $this->SetXY($x+187, $y+126-$cellSizeY);
            $this->Cell(83, $cellSizeY, iconv('utf-8', 'cp1252', $godFather->getFullNameBeginName()), $test, 0, 'C');

            if ($child->getGender() == 'F')
            {
                $this->SetXY($x+157, $y+138-$cellSizeY);
                $this->Cell(6, $cellSizeY, iconv('utf-8', 'cp1252', "a"), $test, 0, 'C');                
            }
            else
            {
                $this->SetXY($x+157, $y+138-$cellSizeY);
                $this->Cell(6, $cellSizeY, iconv('utf-8', 'cp1252', "o"), $test, 0, 'C');                
            }

            $baptism  = BaptismManager::getSingleBaptism('idOwner', $this->confirmation->getIdOwner());

            if ($baptism === NULL)
            {                
                //Get The name of the Church
                $this->SetXY($x+187, $y+138-$cellSizeY);
                $this->Cell(83, $cellSizeY, iconv('utf-8', 'cp1252', '**************'), $test, 0, 'C');    

                //Set The day of confirmation
                $this->SetXY($x+151, $y+150-$cellSizeY);
                $this->Cell(10, $cellSizeY, '**', $test, 0, 'C');

                //Set The month of confirmation
                $this->SetXY($x+170, $y+150-$cellSizeY);
                $this->Cell(45, $cellSizeY, '**********', $test, 0, 'C');

                //Set The year of confirmation
                $this->SetXY($x+225, $y+150-$cellSizeY);
                $this->Cell(13, $cellSizeY, '****', $test, 0, 'C');            
            }
            else
            {
                $baptismDate   = DatabaseManager::databaseDateToSingleDate($baptism->getCelebrationDate());
                $baptismChurch = ChurchManager::getSingleChurch('id', $baptism->getIdChurch());
                
                //Get The name of the Church
                $this->SetXY($x+187, $y+138-$cellSizeY);
                $this->Cell(83, $cellSizeY, iconv('utf-8', 'cp1252', $baptismChurch->getName()), $test, 0, 'C');    

                //Set The day of confirmation
                $this->SetXY($x+151, $y+150-$cellSizeY);
                $this->Cell(10, $cellSizeY, substr($baptismDate, 0, 2), $test, 0, 'C');

                //Set The month of confirmation
                $this->SetXY($x+170, $y+150-$cellSizeY);
                $this->Cell(45, $cellSizeY, $month[intval(substr($baptismDate, 3, 2))-1], $test, 0, 'C');

                //Set The year of confirmation
                $this->SetXY($x+225, $y+150-$cellSizeY);
                $this->Cell(13, $cellSizeY, substr($baptismDate, 6), $test, 0, 'C');
            }

            //Set The data of the left part
            if ($baptism === NULL)
            {
                $this->SetXY($x+26, $y+33-$cellSizeY);
                $this->Cell(90, $cellSizeY, iconv('utf-8', 'cp1252', '**************'), $test, 0, 'C');    

                $this->SetXY($x+3, $y+47-$cellSizeY);
                $this->Cell(113, $cellSizeY, iconv('utf-8', 'cp1252', '*************'), $test, 0, 'C');

                //Get The Book Registry Book
                $this->SetXY($x+71, $y+61-$cellSizeY);
                $this->Cell(10, $cellSizeY, '***', $test, 0, 'C');

                //Get The Book Registry Page
                $this->SetXY($x+88, $y+61-$cellSizeY);
                $this->Cell(9, $cellSizeY, '***', $test, 0, 'C');

                //Get The Book Registry Number
                $this->SetXY($x+105, $y+61-$cellSizeY);
                $this->Cell(11, $cellSizeY, '***', $test, 0, 'C');
            }
            else
            {
                //Set The name of the Church
                $cityChurchB = CityManager::getSingleCity('id', $baptismChurch->getIdCity());

                $this->SetXY($x+26, $y+33-$cellSizeY);
                $this->Cell(90, $cellSizeY, iconv('utf-8', 'cp1252', $baptismChurch->getName()), $test, 0, 'C');    

                $this->SetXY($x+3, $y+47-$cellSizeY);
                $this->Cell(113, $cellSizeY, iconv('utf-8', 'cp1252', $baptismChurch->getAddress() . " " . 
                                                                      $cityChurchB->getName()), $test, 0, 'C');

                //Get the Baptism Registry
                $baptismRegistry = BaptismManager::getSingleBaptismRegistry('id', $baptism->getIdBookRegistry());

                if ($baptismRegistry === NULL)
                {
                    $baptismRegistry = new BaptismRegistry();
                }

                //Get The Book Registry Book
                $this->SetXY($x+71, $y+61-$cellSizeY);
                $this->Cell(10, $cellSizeY, $baptismRegistry->getBook(), $test, 0, 'C');

                //Get The Book Registry Page
                $page = $baptismRegistry->getPage();

                if ($baptismRegistry->getReverse() === 'Y')
                {
                    $page = $page . "v";
                }

                $this->SetXY($x+88, $y+61-$cellSizeY);
                $this->Cell(9, $cellSizeY, $page, $test, 0, 'C');

                //Get The Book Registry Number
                $this->SetXY($x+105, $y+61-$cellSizeY);
                $this->Cell(11, $cellSizeY, $baptismRegistry->getNumber(), $test, 0, 'C');
            }

            //Get the name of the Child
            $this->SetXY($x+11, $y+75-$cellSizeY);
            $this->Cell(38, $cellSizeY, iconv('utf-8', 'cp1252', $child->getNames()), $test, 0, 'C');

            //Set The Lastname1 of the Child
            $this->SetXY($x+49, $y+75-$cellSizeY);
            $this->Cell(33, $cellSizeY, iconv('utf-8', 'cp1252', $child->getLastname1()), $test, 0, 'C');

            //Set The Lastname2 of the Child
            $this->SetXY($x+82, $y+75-$cellSizeY);
            $this->Cell(33, $cellSizeY, iconv('utf-8', 'cp1252', $child->getLastname2()), $test, 0, 'C');

            if ($child->getGender() == 'F')
            {
                $this->SetXY($x+7.5, $y+90-$cellSizeY);
                $this->Cell(5, $cellSizeY, iconv('utf-8', 'cp1252', "a"), $test, 0, 'C');                
            }
            else
            {
                $this->SetXY($x+7.5, $y+90-$cellSizeY);
                $this->Cell(5, $cellSizeY, iconv('utf-8', 'cp1252', "o"), $test, 0, 'C');                
            }

            $this->SetFont('Arial','B', 7);

            //Get The Father
            $this->SetXY($x+17, $y+90-$cellSizeY);
            $this->Cell(46, $cellSizeY, iconv('utf-8', 'cp1252', $father->getFullNameBeginName()), $test, 0, 'C');

            //Get The Mother
            $this->SetXY($x+66, $y+90-$cellSizeY);
            $this->Cell(50, $cellSizeY, iconv('utf-8', 'cp1252', $mother->getFullNameBeginName()), $test, 0, 'C');

            $this->SetFont('Arial','B', 9);

            //Get The Confirmation Rector
            $this->SetXY($x+42, $y+104-$cellSizeY);
            $this->Cell(74, $cellSizeY, iconv('utf-8', 'cp1252', $rectorConfirmation->getPosition() . " " . 
                                                                 $rectorConfirmationP->getFullNameBeginName()), $test, 0, 'C');

            //Set The day of confirmation
            $this->SetXY($x+12, $y+118-$cellSizeY);
            $this->Cell(14, $cellSizeY, substr($celebrationDate, 0, 2), $test, 0, 'C');

            //Set The month of confirmation
            $this->SetXY($x+31, $y+118-$cellSizeY);
            $this->Cell(45, $cellSizeY, $month[intval(substr($celebrationDate, 3, 2))-1], $test, 0, 'C');

            //Set The year of confirmation
            $this->SetXY($x+82, $y+118-$cellSizeY);
            $this->Cell(13, $cellSizeY, substr($celebrationDate, 6), $test, 0, 'C');

            //Set The church of confirmation
            $this->SetXY($x+3, $y+132-$cellSizeY);
            $this->Cell(113, $cellSizeY, iconv('utf-8', 'cp1252', $confirmationChurch->getName()), $test, 0, 'C');

            $this->SetXY($x+3, $y+146-$cellSizeY);
            $this->Cell(113, $cellSizeY, iconv('utf-8', 'cp1252', $confirmationChurch->getAddress() . " " . $cityChurch->getName()), $test, 0, 'C');

            //Get the Godfather
            $this->SetXY($x+42, $y+160-$cellSizeY);
            $this->Cell(74, $cellSizeY, iconv('utf-8', 'cp1252', $godFather->getFullNameBeginName()), $test, 0, 'C');
        }

        // Footer
        function Footer()
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
                $x = intval($paperConfig->getConfirmationCertX());
                $y = intval($paperConfig->getConfirmationCertY());
            }

            //Get The Rector from the user
            $this->SetXY($x+213, $y+185-$cellSizeY);
            $this->Cell(57, $cellSizeY, iconv('utf-8', 'cp1252', $rectorUserP . " " . $rectorUser->getFullNameBeginName()), $test, 0, 'C');
        }
        
        /**
        * Gets the value of confirmation.
        * 
        * @author Jonathan Sandoval <jonathan_s_pisis@yahoo.com.mx>
        * @return mixed
        */
        public function getConfirmation()
        {
            return $this->confirmation;
        }
     
        /**
        * Sets the value of confirmation.
        *
        * @param mixed $confirmation the confirmation
        * @author Jonathan Sandoval <jonathan_s_pisis@yahoo.com.mx>
        *
        * @return self
        */
        public function setConfirmation($confirmation)
        {
            $this->confirmation = $confirmation;
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