<?php 

    require_once(__DIR__."/../../Backend/SessionManager.php");
    require_once(__DIR__."/../../Backend/PersonManager.php");
    require_once(__DIR__."/../../Backend/RectorManager.php");
    require_once(__DIR__."/../../Backend/BaptismManager.php");
    require_once(__DIR__."/../../Backend/ConfirmationManager.php");
    require_once("FPDF/fpdf.php");

    /**
    * Class to registry one Confirmation Certificate Copy
    * 
    * @author Jonathan Sandoval <jonathan_s_pisis@yahoo.com.mx>
    */
    class CopyConfirmationCertificate extends FPDF
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
         * @param  boolean $full           full
         */
        function __construct($idUser = 0, $idConfirmation = 0, $full = false)
        {
            //Define the constructor
            if ($full == 'true')
            {
                parent::FPDF('P', 'mm', array(286, 217));    
            }
            else
            {
                parent::FPDF('P', 'mm', 'Letter');
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

            $rectorConfirmation  = $this->confirmation->getIdRector();
            $rectorConfirmation  = RectorManager::getSingleRector('id', $rectorConfirmation);
            $rectorConfirmationP = PersonManager::getSinglePerson('id', $rectorConfirmation->getIdPerson());

            $userChurch     = $this->user->getIdChurch();
            $userChurch     = ChurchManager::getSingleChurch('id', $userChurch);

            $rectorUser  = RectorManager::getSingleRector('idActualChurch', $userChurch->getId(), 'position', 'Sr. Cura');
            $rectorUserP = $rectorUser->getPosition();
            $rectorUser  = PersonManager::getSinglePerson('id', $rectorUser->getIdPerson());

            $celebrationDate = DatabaseManager::databaseDateToSingleDate($this->confirmation->getCelebrationDate());

            $child  = PersonManager::getSinglePerson('id', $this->confirmation->getIdOwner());

            $father = PersonManager::getSinglePerson('id', $child->getIdFather());
            $mother = PersonManager::getSinglePerson('id', $child->getIdMother());

            $godFather = PersonManager::getSinglePerson('id', $this->confirmation->getIdGodFather());

            $confirmationRegistry = ConfirmationManager::getSingleConfirmationRegistry('id', $this->confirmation->getIdBookRegistry());

            if ($confirmationRegistry === NULL)
            {
                $confirmationRegistry = new ConfirmationRegistry();
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
            
                $this->Image(__DIR__."/../../Backend/Certs/img/confirmationCertCopy.jpg", $x+1, $y+4, 209, 282);
            }
            else
            {
                $x = intval($paperConfig->getCopyConfirmationCertX());
                $y = intval($paperConfig->getCopyConfirmationCertY());
            }

            //Create the box of the Notarius
            $this->SetFont('Arial','B', 9);

            //Get user Church Name 
            $this->SetXY($x+27, $y+64-$cellSize);
            $this->Cell(79, $cellSize, iconv('utf-8', 'cp1252', $userChurch->getName()), $test, 0, 'C');

            //Get user Church Address 
            $this->SetXY($x+9, $y+72-$cellSize);
            $this->Cell(97, $cellSize, iconv('utf-8', 'cp1252', $userChurch->getAddress()), $test, 0, 'C');

            //Get user Church City 
            $cityTemp   = CityManager::getSingleCity('id', $userChurch->getIdCity());
            $stateTemp  = CityManager::getSingleState('id', $cityTemp->getIdState());

            $this->SetXY($x+9, $y+80-$cellSize);
            $this->Cell(97, $cellSize, iconv('utf-8', 'cp1252', $cityTemp->getName(). ", " . $stateTemp->getShortName()), $test, 0, 'C');

            //Continue with the other part of the document
            $this->SetFont('Arial','B', 10);

            //Get user Rector 
            $this->SetXY($x+33, $y+92-$cellSize);
            $this->Cell(170, $cellSize, iconv('utf-8', 'cp1252', $rectorUserP . " " . $rectorUser->getFullNameBeginName()), $test, 0, 'C');

            //Get user Church Name 
            $this->SetXY($x+30, $y+101-$cellSize);
            $this->Cell(173, $cellSize, iconv('utf-8', 'cp1252', $userChurch->getName()), $test, 0, 'C');

            //Get The Book Registry Book
            $this->SetXY($x+95, $y+118-$cellSize);
            $this->Cell(18, $cellSize, $confirmationRegistry->getBook(), $test, 0, 'C');

            //Get The Book Registry Page
            $page = $confirmationRegistry->getPage();

            if ($confirmationRegistry->getReverse() === 'Y')
            {
                $page = $page . "v";
            }

            $this->SetXY($x+125, $y+118-$cellSize);
            $this->Cell(19, $cellSize, $page, $test, 0, 'C');

            $this->SetXY($x+155, $y+118-$cellSize);
            $this->Cell(17, $cellSize, $confirmationRegistry->getNumber(), $test, 0, 'C');

            //Set The rector of confirmation
            $rectorCName = $rectorConfirmation->getPosition() . " " . $rectorConfirmationP->getFullNameBeginName();
            $this->SetXY($x+25, $y+127-$cellSize);
            $this->Cell(178, $cellSize, iconv('utf-8', 'cp1252', $rectorCName), $test, 0, 'C');

            //Set The church of confirmation
            $this->SetXY($x+34, $y+135-$cellSize);
            $this->Cell(169, $cellSize, iconv('utf-8', 'cp1252', $confirmationChurch->getName()), $test, 0, 'C');

            //Set The day of confirmation
            $this->SetXY($x+20, $y+143-$cellSize);
            $this->Cell(13, $cellSize, substr($celebrationDate, 0, 2), $test, 0, 'C');

            //Set The month of confirmation
            $this->SetXY($x+55, $y+143-$cellSize);
            $this->Cell(50, $cellSize, $month[intval(substr($celebrationDate, 3, 2))-1], $test, 0, 'C');

            //Set The year of confirmation
            $this->SetXY($x+111, $y+143-$cellSize);
            $this->Cell(19, $cellSize, substr($celebrationDate, 6), $test, 0, 'C');

            //Set The child
            $this->SetXY($x+8, $y+151-$cellSize);
            $this->Cell(195, $cellSize, iconv('utf-8', 'cp1252', $child->getFullNameBeginName()), $test, 0, 'C');

            if ($child->getGender() == 'F')
            {
                $this->SetXY($x+73, $y+168-$cellSize);
                $this->Cell(10, $cellSize, iconv('utf-8', 'cp1252', 'a'), $test, 0, 'C');
            }
            else
            {
                $this->SetXY($x+73, $y+168-$cellSize);
                $this->Cell(10, $cellSize, iconv('utf-8', 'cp1252', 'o'), $test, 0, 'C');
            }

            //Set the Father
            if ($father != NULL)
            {
                $this->SetXY($x+8, $y+176-$cellSize);
                $this->Cell(97, $cellSize, iconv('utf-8', 'cp1252', $father->getFullNameBeginName()), $test, 0, 'C');
            }

            //Set the Mother
            if ($mother != NULL)
            {   
                $this->SetXY($x+115, $y+176-$cellSize);
                $this->Cell(88, $cellSize, iconv('utf-8', 'cp1252', $mother->getFullNameBeginName()), $test, 0, 'C');
            }

            //Set the GodFathers
            if ($godFather != NULL)
            {
                $godFathersString = $godFather->getFullNameBeginName();
                $this->SetXY($x+28, $y+193-$cellSize);
                $this->Cell(175, $cellSize, iconv('utf-8', 'cp1252', $godFathersString), $test, 0, 'C');
            }

            //Get the marginal Notes
            $baptism  = BaptismManager::getSingleBaptism('idOwner', $this->confirmation->getIdOwner());

            if ($baptism === NULL)
            {                
                $this->SetXY($x+58, $y+201-$cellSize);
                $this->Cell(145, $cellSize, iconv('utf-8', 'cp1252', '*****************'), $test, 0, 'C');    

                //Set The day of baptism
                $this->SetXY($x+20, $y+209-$cellSize);
                $this->Cell(14, $cellSize, '**', $test, 0, 'C');

                //Set The month of baptism
                $this->SetXY($x+42, $y+209-$cellSize);
                $this->Cell(43, $cellSize, '********', $test, 0, 'C');

                //Set The year of baptism
                $this->SetXY($x+94, $y+209-$cellSize);
                $this->Cell(15, $cellSize, '****', $test, 0, 'C');

                //Set The Age
                $this->SetXY($x+15, $y+168-$cellSize);
                $this->Cell(24, $cellSize, iconv('utf-8', 'cp1252', '**'), $test, 0, 'C');

                //Get The Book Registry Book
                $this->SetXY($x+122, $y+209-$cellSize);
                $this->Cell(20, $cellSize, '***', $test, 0, 'C');

                //Get The Book Registry Page
                $this->SetXY($x+152, $y+209-$cellSize);
                $this->Cell(16, $cellSize, '***', $test, 0, 'C');

                //Get The Book Registry Number
                $this->SetXY($x+180, $y+209-$cellSize);
                $this->Cell(23, $cellSize, '****', $test, 0, 'C');            
            }
            else
            {
                $baptismDate   = DatabaseManager::databaseDateToSingleDate($baptism->getCelebrationDate());
                $baptismChurch = ChurchManager::getSingleChurch('id', $baptism->getIdChurch());
                
                $this->SetXY($x+58, $y+201-$cellSize);
                $this->Cell(145, $cellSize, iconv('utf-8', 'cp1252', $baptismChurch->getName()), $test, 0, 'C');    

                //Set The day of baptism
                $this->SetXY($x+20, $y+209-$cellSize);
                $this->Cell(14, $cellSize, substr($baptismDate, 0, 2), $test, 0, 'C');

                //Set The month of baptism
                $this->SetXY($x+42, $y+209-$cellSize);
                $this->Cell(43, $cellSize, $month[intval(substr($baptismDate, 3, 2))-1], $test, 0, 'C');

                //Set The year of baptism
                $this->SetXY($x+94, $y+209-$cellSize);
                $this->Cell(15, $cellSize, substr($baptismDate, 6), $test, 0, 'C');

                //Set The Age
                $age = strval( intval(substr($baptismDate, 6)) - intval(substr($celebrationDate, 6)) );
                $this->SetXY($x+15, $y+168-$cellSize);
                $this->Cell(24, $cellSize, iconv('utf-8', 'cp1252', $age), $test, 0, 'C');

                //Get the Baptism Registry
                $baptismRegistry = BaptismManager::getSingleBaptismRegistry('id', $baptism->getIdBookRegistry());

                if ($baptismRegistry === NULL)
                {
                    $baptismRegistry = new BaptismRegistry();
                }

                //Get The Book Registry Book
                $this->SetXY($x+122, $y+209-$cellSize);
                $this->Cell(20, $cellSize, $baptismRegistry->getBook(), $test, 0, 'C');

                //Get The Book Registry Page
                $page = $baptismRegistry->getPage();

                if ($baptismRegistry->getReverse() === 'Y')
                {
                    $page = $page . "v";
                }

                $this->SetXY($x+152, $y+209-$cellSize);
                $this->Cell(16, $cellSize, $page, $test, 0, 'C');

                //Get The Book Registry Number
                $this->SetXY($x+180, $y+209-$cellSize);
                $this->Cell(23, $cellSize, $baptismRegistry->getNumber(), $test, 0, 'C');
            }

            //Get the current location
            $this->SetXY($x+65, $y+223-$cellSize);
            $this->Cell(138, $cellSize, iconv('utf-8', 'cp1252', $cityTemp->getName(). ", " . $stateTemp->getShortName()), $test, 0, 'C');

            //Get The Current Day
            $this->SetXY($x+12, $y+239-$cellSize);
            $this->Cell(19, $cellSize, date("d"), $test, 0, 'C');

            //Get The Current Month
            $this->SetXY($x+61, $y+239-$cellSize);
            $this->Cell(48, $cellSize, $month[intval(date("m"))-1], $test, 0, 'C');

            //Get The Current Year
            $this->SetXY($x+123, $y+239-$cellSize);
            $this->Cell(9, $cellSize, date('Y'), $test, 0, 'C');
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

            $cellSize = 5;
            $test = 0;
            
            if ($this->full == 'true')
            {
                $x = 0;
                $y = 0;
            }
            else
            {
                $x = intval($paperConfig->getCopyConfirmationCertX());
                $y = intval($paperConfig->getCopyConfirmationCertY());
            }

            //Get The Current Rector
            $this->SetXY($x+125, $y+272-$cellSize);
            $this->Cell(80, $cellSize, iconv('utf-8', 'cp1252', $rectorUserP . " " . $rectorUser->getFullNameBeginName()), $test, 0, 'R');
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