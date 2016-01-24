<?php 

    require_once(__DIR__."/../../Backend/SessionManager.php");
    require_once(__DIR__."/../../Backend/MarriageManager.php");
    require_once(__DIR__."/../../Backend/PersonManager.php");
    require_once(__DIR__."/../../Backend/RectorManager.php");
    require_once(__DIR__."/../../Backend/MarriageManager.php");
    require_once(__DIR__."/../../Backend/BaptismManager.php");
    require_once("FPDF/fpdf.php");

    /**
    * Class to registry one Marriage Exhort
    * 
    * @author Jonathan Sandoval <jonathan_s_pisis@yahoo.com.mx>
    */
    class MarriageExhort extends FPDF
    {
        private $marriage;
        private $user;
        private $full;
        private $type;
        private $owner;

        /**
         * Class Constructor
         *
         * @author Jonathan Sandoval <jonathan_s_pisis@yahoo.com.mx>
         * @param  integer $idUser     idUser
         * @param  integer $idMarriage idMarriage
         * @param  boolean $full       full document
         */
        function __construct($idUser = 0, $idMarriage = 0, $full = false)
        {
            //Define the constructor
            if ($full == 'true')
            {
                parent::FPDF('L', 'mm', array(230,170));
            }
            else
            {
                parent::FPDF('L', 'mm', 'Letter');
            }

            $this->marriage = MarriageManager::getSingleMarriage('id', $idMarriage);
            $this->user    = SessionManager::getSingleUser('id', $idUser);

            $this->full = $full;
        }

        function displayData()
        {
            //Get the data necesary of create the document
            $month = array("Enero","Febrero","Marzo","Abril","Mayo","Junio","Julio","Agosto","Septiembre","Octubre","Noviembre","Diciembre");

            $userChurch = $this->user->getIdChurch();
            $userChurch = ChurchManager::getSingleChurch('id', $userChurch);

            $rectorUser  = RectorManager::getSingleRector('idActualChurch', $userChurch->getId(), 'position', 'Sr. Cura');
            $rectorUserP = $rectorUser->getPosition();
            $rectorUser  = PersonManager::getSinglePerson('id', $rectorUser->getIdPerson());

            $marriageChurch = $this->marriage->getIdChurchMarriage();
            $marriageChurch = ChurchManager::getSingleChurch('id', $marriageChurch);
            $cityChurchMarriage = CityManager::getSingleCity('id', $marriageChurch->getIdCity());

            $processChurch = $this->marriage->getIdChurchProcess();
            $processChurch = ChurchManager::getSingleChurch('id', $processChurch);

            $celebrationDate = DatabaseManager::databaseDateToSingleDate($this->marriage->getCelebrationDate());

            $boyfriend  = PersonManager::getSinglePerson('id', $this->marriage->getIdBoyfriend());
            $girlfriend = PersonManager::getSinglePerson('id', $this->marriage->getIdGirlfriend());

            //Get the marriage Registry 
            $marriageRegistry   = MarriageManager::getSingleMarriageRegistry('id', $this->marriage->getIdBookRegistry());

            if ($marriageRegistry === NULL)
            {
                $marriageRegistry = new MarriageRegistry();
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
            
                if ($this->type == 'no-reverse')
                {
                    $this->Image(__DIR__."/../../Backend/Certs/img/marriageExhort1.jpg", $x, $y+5, 230, 160);    
                }
                else
                {
                    $this->Image(__DIR__."/../../Backend/Certs/img/marriageExhort2.jpg", $x, $y+5, 230, 160);
                }
            }
            else
            {
                $x = intval($paperConfig->getMarriageExhortX()) + 2;
                $y = intval($paperConfig->getMarriageExhortY());
            }

            //Put the data of the Exhort
            if ($this->type == 'no-reverse')
            {
                $this->SetFont('Arial','B', 7);

                //Get user Church Name 
                $this->SetXY($x+8, $y+62-$cellSizeY);
                $this->Cell(45, $cellSizeY, iconv('utf-8', 'cp1252', $userChurch->getName()), $test, 0, 'C');

                //Get user Church Address 
                $this->SetXY($x+8, $y+70-$cellSizeY);
                $this->Cell(45, $cellSizeY, iconv('utf-8', 'cp1252', $userChurch->getAddress()), $test, 0, 'C');

                //Get user Church City 
                $cityTemp   = CityManager::getSingleCity('id', $userChurch->getIdCity());
                $stateTemp  = CityManager::getSingleState('id', $cityTemp->getIdState());

                $this->SetXY($x+8, $y+74-$cellSizeY);
                $this->Cell(45, $cellSizeY, iconv('utf-8', 'cp1252', $cityTemp->getName(). ", " . $stateTemp->getShortName()), $test, 0, 'C');

                $this->SetFont('Arial','B', 9);

                //Put The 'Expediente'
                $page = $marriageRegistry->getPage();

                if ($marriageRegistry->getReverse() === 'Y')
                {
                    $page = $page . "v";
                }

                $stringExp = $marriageRegistry->getBook() . ", " . $page . ", " . $marriageRegistry->getNumber(); 
                $this->SetXY($x+186, $y+32-$cellSizeY);
                $this->Cell(38, $cellSizeY, iconv('utf-8', 'cp1252', $stringExp), $test, 0, 'C');

                if ($this->owner == 'girlfriend')
                {
                    $baptism = BaptismManager::getSingleBaptism('idOwner', $girlfriend->getId());

                    if ($baptism !== NULL)
                    {
                        $processChurch = ChurchManager::getSingleChurch('id', $baptism->getIdChurch());

                        //Get process Church Name 
                        $this->SetXY($x+81, $y+54-$cellSizeY);
                        $this->Cell(143, $cellSizeY, iconv('utf-8', 'cp1252', $processChurch->getName()), $test, 0, 'C');

                        //Set the Exhort Data
                        $this->SetXY($x+95, $y+60-$cellSizeY);
                        $this->Cell(10, $cellSizeY, iconv('utf-8', 'cp1252', 'a'), $test, 0, 'C');

                        $this->SetXY($x+126, $y+60-$cellSizeY);
                        $this->Cell(9, $cellSizeY, iconv('utf-8', 'cp1252', ''), $test, 0, 'C');

                        //Get process Church Name 
                        $this->SetXY($x+60, $y+66-$cellSizeY);
                        $this->Cell(164, $cellSizeY, iconv('utf-8', 'cp1252', 'La comunidad de "' . $processChurch->getName() . '"'), $test, 0, 'C');
                    }
                    else
                    {
                        //Get process Church Name 
                        $this->SetXY($x+81, $y+54-$cellSizeY);
                        $this->Cell(143, $cellSizeY, iconv('utf-8', 'cp1252', $processChurch->getName()), $test, 0, 'C');

                        //Set the Exhort Data
                        $this->SetXY($x+95, $y+60-$cellSizeY);
                        $this->Cell(10, $cellSizeY, iconv('utf-8', 'cp1252', 'a'), $test, 0, 'C');

                        $this->SetXY($x+126, $y+60-$cellSizeY);
                        $this->Cell(9, $cellSizeY, iconv('utf-8', 'cp1252', ''), $test, 0, 'C');

                        //Get process Church Name 
                        $this->SetXY($x+60, $y+66-$cellSizeY);
                        $this->Cell(164, $cellSizeY, iconv('utf-8', 'cp1252', 'La comunidad de "' . $processChurch->getName() . '"'), $test, 0, 'C');
                    }
                }
                else if ($this->owner == 'boyfriend')
                {
                    $baptism = BaptismManager::getSingleBaptism('idOwner', $boyfriend->getId());

                    if ($baptism !== NULL)
                    {
                        $processChurch = ChurchManager::getSingleChurch('id', $baptism->getIdChurch());

                        //Get process Church Name 
                        $this->SetXY($x+81, $y+54-$cellSizeY);
                        $this->Cell(143, $cellSizeY, iconv('utf-8', 'cp1252', $processChurch->getName()), $test, 0, 'C');

                        //Set the Exhort Data
                        $this->SetXY($x+95, $y+60-$cellSizeY);
                        $this->Cell(10, $cellSizeY, iconv('utf-8', 'cp1252', 'e'), $test, 0, 'C');

                        $this->SetXY($x+126, $y+60-$cellSizeY);
                        $this->Cell(9, $cellSizeY, iconv('utf-8', 'cp1252', ''), $test, 0, 'C');

                        //Get process Church Name 
                        $this->SetXY($x+60, $y+66-$cellSizeY);
                        $this->Cell(164, $cellSizeY, iconv('utf-8', 'cp1252', 'La comunidad de "' . $processChurch->getName() . '"'), $test, 0, 'C');
                    }
                    else
                    {
                        //Get process Church Name 
                        $this->SetXY($x+81, $y+54-$cellSizeY);
                        $this->Cell(143, $cellSizeY, iconv('utf-8', 'cp1252', $processChurch->getName()), $test, 0, 'C');

                        //Set the Exhort Data
                        $this->SetXY($x+95, $y+60-$cellSizeY);
                        $this->Cell(10, $cellSizeY, iconv('utf-8', 'cp1252', 'e'), $test, 0, 'C');

                        $this->SetXY($x+126, $y+60-$cellSizeY);
                        $this->Cell(9, $cellSizeY, iconv('utf-8', 'cp1252', ''), $test, 0, 'C');

                        //Get process Church Name 
                        $this->SetXY($x+60, $y+66-$cellSizeY);
                        $this->Cell(164, $cellSizeY, iconv('utf-8', 'cp1252', 'La comunidad de "' . $processChurch->getName() . '"'), $test, 0, 'C');
                    }                
                }
                else
                {
                    //Get process Church Name 
                    $this->SetXY($x+81, $y+54-$cellSizeY);
                    $this->Cell(143, $cellSizeY, iconv('utf-8', 'cp1252', $processChurch->getName()), $test, 0, 'C');

                    //Set the Exhort Data
                    $this->SetXY($x+95, $y+60-$cellSizeY);
                    $this->Cell(10, $cellSizeY, iconv('utf-8', 'cp1252', 'os'), $test, 0, 'C');

                    $this->SetXY($x+126, $y+60-$cellSizeY);
                    $this->Cell(9, $cellSizeY, iconv('utf-8', 'cp1252', 'n'), $test, 0, 'C');

                    //Get process Church Name 
                    $this->SetXY($x+60, $y+66-$cellSizeY);
                    $this->Cell(164, $cellSizeY, iconv('utf-8', 'cp1252', 'La comunidad de "' . $processChurch->getName() . '"'), $test, 0, 'C');
                }
            }
            else
            {
                $x = $x + 2;
                
                //Get the baptism of the boyfriend
                $baptismBoy   = BaptismManager::getSingleBaptism('idOwner', $boyfriend->getId());
                $baptismGirl  = BaptismManager::getSingleBaptism('idOwner', $girlfriend->getId());

                $fatherBoy = PersonManager::getSinglePerson('id', $boyfriend->getIdFather());

                if ($fatherBoy === NULL)
                {
                    $fatherBoy = new Person(0, '*****************');
                }

                $motherBoy = PersonManager::getSinglePerson('id', $boyfriend->getIdMother());

                if ($motherBoy === NULL)
                {
                    $motherBoy = new Person(0, '*****************');
                }

                $fatherGirl = PersonManager::getSinglePerson('id', $girlfriend->getIdFather());

                if ($fatherGirl === NULL)
                {
                    $fatherGirl = new Person(0, '*****************');
                }

                $motherGirl = PersonManager::getSinglePerson('id', $girlfriend->getIdMother());

                if ($motherGirl === NULL)
                {
                    $motherGirl = new Person(0, '*****************');
                }

                //Get The Process church
                $processChurch = $this->marriage->getIdChurchProcess();
                $processChurch = ChurchManager::getSingleChurch('id', $processChurch);

                //Set The Church Process
                $this->SetXY($x+85, $y+46-$cellSizeY);
                $this->Cell(55, $cellSizeY, iconv('utf-8', 'cp1252', $processChurch->getName()), $test, 0, 'C');

                //Set the Boy
                $this->SetXY($x+9, $y+82-$cellSizeY);
                $this->Cell(95, $cellSizeY, iconv('utf-8', 'cp1252', $boyfriend->getFullNameBeginName()), $test, 0, 'C');                

                //Set the Girl
                $this->SetXY($x+120, $y+82-$cellSizeY);
                $this->Cell(95, $cellSizeY, iconv('utf-8', 'cp1252', $girlfriend->getFullNameBeginName()), $test, 0, 'C');                

                //Set The Father of the Boy
                $this->SetXY($x+21, $y+114-$cellSizeY);
                $this->Cell(83, $cellSizeY, iconv('utf-8', 'cp1252', $fatherBoy->getFullNameBeginName()), $test, 0, 'C');                

                //Set The Mother of the Boy
                $this->SetXY($x+17, $y+123-$cellSizeY);
                $this->Cell(87, $cellSizeY, iconv('utf-8', 'cp1252', $motherBoy->getFullNameBeginName()), $test, 0, 'C');                

                //Set The Father of the Boy
                $this->SetXY($x+132, $y+114-$cellSizeY);
                $this->Cell(83, $cellSizeY, iconv('utf-8', 'cp1252', $fatherGirl->getFullNameBeginName()), $test, 0, 'C');                

                //Set The Mother of the Boy
                $this->SetXY($x+128, $y+123-$cellSizeY);
                $this->Cell(87, $cellSizeY, iconv('utf-8', 'cp1252', $motherGirl->getFullNameBeginName()), $test, 0, 'C');                

                if ($baptismBoy !== NULL)
                {
                    $baptismChurch     = $baptismBoy->getIdChurch();
                    $baptismChurch     = ChurchManager::getSingleChurch('id', $baptismChurch);
                    $cityChurchBaptism = CityManager::getSingleCity('id', $baptismChurch->getIdCity());
                    $stateTemp         = CityManager::getSingleState('id', $cityChurchBaptism->getIdState());

                    $bornDate        = DatabaseManager::databaseDateToSingleDate($baptismBoy->getBornDate());

                    //Set the Born Place of Baptism
                    $this->SetXY($x+24, $y+92-$cellSizeY);
                    $this->Cell(80, $cellSizeY, iconv('utf-8', 'cp1252', $baptismBoy->getBornPlace()), $test, 0, 'C');                

                    //Set The day of born
                    $this->SetXY($x+13, $y+102-$cellSizeY);
                    $this->Cell(10.5, $cellSizeY, substr($bornDate, 0, 2), $test, 0, 'C');

                    //Set The month of born
                    $this->SetXY($x+31, $y+102-$cellSizeY);
                    $this->Cell(53, $cellSizeY, $month[intval(substr($bornDate, 3, 2))-1], $test, 0, 'C');

                    //Set The year of born
                    $this->SetXY($x+95, $y+102-$cellSizeY);
                    $this->Cell(9, $cellSizeY, substr($bornDate, 6), $test, 0, 'C');

                    //Set the City of Baptism
                    $this->SetXY($x+9, $y+144-$cellSizeY);
                    $this->Cell(95, $cellSizeY, iconv('utf-8', 'cp1252', $cityChurchBaptism->getName(). ", " . 
                                                                         $stateTemp->getShortName()), $test, 0, 'C');
                }
                else
                {
                    //Set the Born Place of Baptism
                    $this->SetXY($x+24, $y+92-$cellSizeY);
                    $this->Cell(80, $cellSizeY, iconv('utf-8', 'cp1252', 'Capture El Bautizmo Primero'), $test, 0, 'C');                

                    //Set The day of born
                    $this->SetXY($x+13, $y+102-$cellSizeY);
                    $this->Cell(10.5, $cellSizeY, 'X', $test, 0, 'C');

                    //Set The month of born
                    $this->SetXY($x+31, $y+102-$cellSizeY);
                    $this->Cell(53, $cellSizeY, 'X', $test, 0, 'C');

                    //Set The year of born
                    $this->SetXY($x+95, $y+102-$cellSizeY);
                    $this->Cell(9, $cellSizeY, 'X', $test, 0, 'C');

                    //Set the City of Baptism
                    $this->SetXY($x+9, $y+144-$cellSizeY);
                    $this->Cell(95, $cellSizeY, iconv('utf-8', 'cp1252', 'Capture El Bautizmo Primero'), $test, 0, 'C');
                }

                if ($baptismGirl !== NULL)
                {
                    $baptismChurch     = $baptismGirl->getIdChurch();
                    $baptismChurch     = ChurchManager::getSingleChurch('id', $baptismChurch);
                    $cityChurchBaptism = CityManager::getSingleCity('id', $baptismChurch->getIdCity());
                    $stateTemp         = CityManager::getSingleState('id', $cityChurchBaptism->getIdState());

                    $bornDate        = DatabaseManager::databaseDateToSingleDate($baptismGirl->getBornDate());

                    //Set the Born Place of Baptism
                    $this->SetXY($x+135, $y+91-$cellSizeY);
                    $this->Cell(80, $cellSizeY, iconv('utf-8', 'cp1252', $baptismGirl->getBornPlace()), $test, 0, 'C');                

                    //Set The day of born
                    $this->SetXY($x+124, $y+102-$cellSizeY);
                    $this->Cell(10.5, $cellSizeY, substr($bornDate, 0, 2), $test, 0, 'C');

                    //Set The month of born
                    $this->SetXY($x+142, $y+102-$cellSizeY);
                    $this->Cell(53, $cellSizeY, $month[intval(substr($bornDate, 3, 2))-1], $test, 0, 'C');

                    //Set The year of born
                    $this->SetXY($x+206, $y+102-$cellSizeY);
                    $this->Cell(9, $cellSizeY, substr($bornDate, 6), $test, 0, 'C');

                    //Set the City of Baptism
                    $this->SetXY($x+120, $y+144-$cellSizeY);
                    $this->Cell(95, $cellSizeY, iconv('utf-8', 'cp1252', $cityChurchBaptism->getName(). ", " . 
                                                                         $stateTemp->getShortName()), $test, 0, 'C');
                }
                else
                {
                    //Set the Born Place of Baptism
                    $this->SetXY($x+135, $y+92-$cellSizeY);
                    $this->Cell(80, $cellSizeY, iconv('utf-8', 'cp1252', 'Capture El Bautizmo Primero'), $test, 0, 'C');                

                    //Set The day of born
                    $this->SetXY($x+124, $y+102-$cellSizeY);
                    $this->Cell(10.5, $cellSizeY, 'X', $test, 0, 'C');

                    //Set The month of born
                    $this->SetXY($x+142, $y+102-$cellSizeY);
                    $this->Cell(53, $cellSizeY, 'X', $test, 0, 'C');

                    //Set The year of born
                    $this->SetXY($x+206, $y+102-$cellSizeY);
                    $this->Cell(9, $cellSizeY, 'X', $test, 0, 'C');

                    //Set the City of Baptism
                    $this->SetXY($x+120, $y+144-$cellSizeY);
                    $this->Cell(95, $cellSizeY, 'Capture El Bautizmo Primero', $test, 0, 'C');                    
                }
                
                if ($this->full != 'true')
                {
                    $userChurch = $this->user->getIdChurch();
                    $userChurch = ChurchManager::getSingleChurch('id', $userChurch);
    
                    $rectorUser  = RectorManager::getSingleRector('idActualChurch', $userChurch->getId(), 'position', 'Sr. Cura');
                    $rectorUserP = $rectorUser->getPosition();
                    $rectorUser  = PersonManager::getSinglePerson('id', $rectorUser->getIdPerson());
    
                    $this->SetFont('Arial','B', 10);
    
                    //Get the Current Location
                    $cityTemp   = CityManager::getSingleCity('id', $userChurch->getIdCity());
                    $stateTemp  = CityManager::getSingleState('id', $cityTemp->getIdState());
    
                    $this->SetXY($x+55, $y+164-$cellSizeY);
                    $this->Cell(62, $cellSizeY, iconv('utf-8', 'cp1252', $cityTemp->getName(). ", " . $stateTemp->getShortName()), $test, 0, 'C');
    
                    //Get The Current Day
                    $this->SetXY($x+124, $y+164-$cellSizeY);
                    $this->Cell(10, $cellSizeY, date("d"), $test, 0, 'C');
    
                    //Get The Current Month
                    $this->SetXY($x+140, $y+164-$cellSizeY);
                    $this->Cell(54, $cellSizeY, $month[intval(date("m"))-1], $test, 0, 'C');
    
                    //Get The Current Year
                    $this->SetXY($x+200, $y+164-$cellSizeY);
                    $this->Cell(15, $cellSizeY, date('Y'), $test, 0, 'C');
                }
            }
        }

        // Footer
        function Footer()
        {
            //Get the data necesary of create the document
            $month = array("Enero","Febrero","Marzo","Abril","Mayo","Junio","Julio","Agosto","Septiembre","Octubre","Noviembre","Diciembre");

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
                $x = intval($paperConfig->getMarriageNoticeX());
                $y = intval($paperConfig->getMarriageNoticeY());
            }
    
            if ($this->type !== 'reverse' && $this->full == 'true')
            {
                $userChurch = $this->user->getIdChurch();
                $userChurch = ChurchManager::getSingleChurch('id', $userChurch);

                $rectorUser  = RectorManager::getSingleRector('idActualChurch', $userChurch->getId(), 'position', 'Sr. Cura');
                $rectorUserP = $rectorUser->getPosition();
                $rectorUser  = PersonManager::getSinglePerson('id', $rectorUser->getIdPerson());

                $this->SetFont('Arial','B', 10);

                //Get the Current Location
                $cityTemp   = CityManager::getSingleCity('id', $userChurch->getIdCity());
                $stateTemp  = CityManager::getSingleState('id', $cityTemp->getIdState());

                $this->SetXY($x+55, $y+159-$cellSizeY);
                $this->Cell(62, $cellSizeY, iconv('utf-8', 'cp1252', $cityTemp->getName(). ", " . $stateTemp->getShortName()), $test, 0, 'C');

                //Get The Current Day
                $this->SetXY($x+124, $y+159-$cellSizeY);
                $this->Cell(10, $cellSizeY, date("d"), $test, 0, 'C');

                //Get The Current Month
                $this->SetXY($x+140, $y+159-$cellSizeY);
                $this->Cell(54, $cellSizeY, $month[intval(date("m"))-1], $test, 0, 'C');

                //Get The Current Year
                $this->SetXY($x+200, $y+159-$cellSizeY);
                $this->Cell(15, $cellSizeY, date('Y'), $test, 0, 'C');
            }
        }

        /**
        * Gets the value of marriage.
        * 
        * @author Jonathan Sandoval <jonathan_s_pisis@yahoo.com.mx>
        * @return mixed
        */
        public function getMarriage()
        {
            return $this->marriage;
        }
     
        /**
        * Sets the value of marriage.
        *
        * @param mixed $marriage the marriage
        * @author Jonathan Sandoval <jonathan_s_pisis@yahoo.com.mx>
        *
        * @return self
        */
        public function setMarriage($marriage)
        {
            $this->marriage = $marriage;
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
     
        /**
        * Gets the value of type.
        * 
        * @author Jonathan Sandoval <jonathan_s_pisis@yahoo.com.mx>
        * @return mixed
        */
        public function getType()
        {
            return $this->type;
        }
     
        /**
        * Sets the value of type.
        *
        * @param mixed $type the type
        * @author Jonathan Sandoval <jonathan_s_pisis@yahoo.com.mx>
        *
        * @return self
        */
        public function setType($type)
        {
            $this->type = $type;
        }
     
        /**
        * Gets the value of owner.
        * 
        * @author Jonathan Sandoval <jonathan_s_pisis@yahoo.com.mx>
        * @return mixed
        */
        public function getOwner()
        {
            return $this->owner;
        }
     
        /**
        * Sets the value of owner.
        *
        * @param mixed $owner the owner
        * @author Jonathan Sandoval <jonathan_s_pisis@yahoo.com.mx>
        *
        * @return self
        */
        public function setOwner($owner)
        {
            $this->owner = $owner;
        }
    }
 ?>