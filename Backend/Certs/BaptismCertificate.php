<?php 

    require_once(__DIR__."/../../Backend/SessionManager.php");
    require_once(__DIR__."/../../Backend/BaptismManager.php");
    require_once(__DIR__."/../../Backend/PersonManager.php");
    require_once(__DIR__."/../../Backend/RectorManager.php");
    require_once("FPDF/fpdf.php");

    /**
    * Class to registry one Baptism Certificate
    * 
    * @author Jonathan Sandoval <jonathan_s_pisis@yahoo.com.mx>
    */
    class BaptismCertificate extends FPDF
    {
        private $baptism;
        private $user;
        private $full;

        /**
         * Constructor of the Class
         *
         * @author Jonathan Sandoval <jonathan_s_pisis@yahoo.com.mx>
         * @param  integer $idUser    idUser
         * @param  integer $idBaptism idBaptism
         * @param  boolean $full      full document
         */
        function __construct($idUser = 0, $idBaptism = 0, $full = false)
        {
            //Define the constructor
            if ($full == 'false')
            {
                parent::FPDF('P', 'mm', 'Letter');
            }
            else
            {
                parent::FPDF('P', 'mm', array(230, 175));
            }

            $this->baptism = BaptismManager::getSingleBaptism('id', $idBaptism);
            $this->user    = SessionManager::getSingleUser('id', $idUser);

            $this->full = $full;
        }

        function displayData()
        {
            //Get the data necesary of create the document
            $month = array("Enero","Febrero","Marzo","Abril","Mayo","Junio","Julio","Agosto","Septiembre","Octubre","Noviembre","Diciembre");

            $baptismChurch = $this->baptism->getIdChurch();
            $baptismChurch = ChurchManager::getSingleChurch('id', $baptismChurch);

            $rectorBaptism = $this->baptism->getIdRector();
            $rectorBaptism = RectorManager::getSingleRector('id', $rectorBaptism);
            $rectorBaptism = PersonManager::getSinglePerson('id', $rectorBaptism->getIdPerson());

            $userChurch = $this->user->getIdChurch();
            $userChurch = ChurchManager::getSingleChurch('id', $userChurch);

            $rectorUser  = RectorManager::getSingleRector('idActualChurch', $userChurch->getId(), 'position', 'Sr. Cura');
            $rectorUserP = $rectorUser->getPosition();
            $rectorUser  = PersonManager::getSinglePerson('id', $rectorUser->getIdPerson());

            $celebrationDate = DatabaseManager::databaseDateToSingleDate($this->baptism->getCelebrationDate());
            $bornDate        = DatabaseManager::databaseDateToSingleDate($this->baptism->getBornDate());

            $child  = PersonManager::getSinglePerson('id', $this->baptism->getIdOwner());
            $father = PersonManager::getSinglePerson('id', $child->getIdFather());
            $mother = PersonManager::getSinglePerson('id', $child->getIdMother());

            $godFather = PersonManager::getSinglePerson('id', $this->baptism->getIdGodFather());
            $godMother = PersonManager::getSinglePerson('id', $this->baptism->getIdGodMother());

            $civilRegistry = BaptismManager::getSingleCivilRegistry('id', $this->baptism->getIdCivilRegistry());
            $officineCivil = BaptismManager::getSingleOfficeCivilRegistry('id', $civilRegistry->getIdOffice());
            $placeCivil    = new City();

            $baptismRegistry = BaptismManager::getSingleBaptismRegistry('id', $this->baptism->getIdBookRegistry());

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

            if ($godMother === NULL)
            {
                $godMother = new Person(0, "*************************");
            }

            if ($civilRegistry->getId() == 1)
            {
                $officineCivil = new OfficeCivilRegistry();
            }
            else
            {
                $placeCivil = CityManager::getSingleCity('id', $officineCivil->getIdCity());
            }

            //Config the document 
            $this->SetFont('Arial','B', 10);
            $paperConfig = SessionManager::getSinglePaperConfig('id', $this->user->getIdPaperConfig());

            $cellSizeY = 5;
            $x = intval($paperConfig->getBaptismCertX());
            $y = intval($paperConfig->getBaptismCertY());
            $test = 0;

            if ($this->full == 'true')
            {
                $this->Image(__DIR__."/../../Backend/Certs/img/baptismCert.jpg", 9, 2, 167, 227);
                
                $x = 0;
                $y = 0;
            }
            else
            {
                $x = intval($paperConfig->getBaptismCertX());
                $y = intval($paperConfig->getBaptismCertY());
            }

            //Begin of print the data
            if ($child->getGender() === 'M')
            {
                //Set The data for boy
                $this->SetXY($x+80.7, $y+69-$cellSizeY);
                $this->Cell(5, $cellSizeY, 'E', $test, 0, 'C');

                $this->SetXY($x+100.5, $y+69-$cellSizeY);
                $this->Cell(5, $cellSizeY, 'o', $test, 0, 'C');

                $this->SetXY($x+99, $y+78.2-$cellSizeY);
                $this->Cell(5, $cellSizeY, 'o', $test, 0, 'C');

                $this->SetXY($x+80, $y+125.6-$cellSizeY);
                $this->Cell(18, $cellSizeY, 'o', $test, 0, 'C');
            }
            else
            {
                //Set The data for girl
                $this->SetXY($x+89.7, $y+69-$cellSizeY);
                $this->Cell(5, $cellSizeY, 'a', $test, 0, 'C');

                $this->SetXY($x+100.5, $y+69-$cellSizeY);
                $this->Cell(5, $cellSizeY, 'a', $test, 0, 'C');

                $this->SetXY($x+99, $y+78.2-$cellSizeY);
                $this->Cell(5, $cellSizeY, 'a', $test, 0, 'C');

                $this->SetXY($x+80, $y+125.6-$cellSizeY);
                $this->Cell(18, $cellSizeY, 'a', $test, 0, 'C');
            }

            //Set The Name of the Child
            $this->SetXY($x+107, $y+69-$cellSizeY);
            $this->Cell(61, $cellSizeY, iconv('utf-8', 'cp1252', $child->getFullNameBeginName()), $test, 0, 'C');

            //Set The place of baptism
            $cityTemp   = CityManager::getSingleCity('id', $baptismChurch->getIdCity());
            $stateTemp  = CityManager::getSingleState('id', $cityTemp->getIdState());

            $this->SetXY($x+110, $y+78.2-$cellSizeY);
            $this->Cell(58, $cellSizeY, iconv('utf-8', 'cp1252', $cityTemp->getName(). ", " . $stateTemp->getShortName()), $test, 0, 'C');

            //Set The church of baptism
            $this->SetXY($x+96, $y+87.4-$cellSizeY);
            $this->Cell(73, $cellSizeY, iconv('utf-8', 'cp1252', $baptismChurch->getName()), $test, 0, 'C');

            //Set The day of baptism
            $this->SetXY($x+89.5, $y+96.6-$cellSizeY);
            $this->Cell(10.5, $cellSizeY, substr($celebrationDate, 0, 2), $test, 0, 'C');

            //Set The month of baptism
            $this->SetXY($x+106, $y+96.6-$cellSizeY);
            $this->Cell(41, $cellSizeY, $month[intval(substr($celebrationDate, 3, 2))-1], $test, 0, 'C');

            //Set The year of baptism
            $this->SetXY($x+152, $y+96.6-$cellSizeY);
            $this->Cell(18, $cellSizeY, substr($celebrationDate, 6), $test, 0, 'C');

            //Set The Baptism Place
            $this->SetXY($x+95, $y+105.8-$cellSizeY);
            $this->Cell(74, $cellSizeY, iconv('utf-8', 'cp1252', $this->baptism->getBornPlace()), $test, 0, 'C');

            //Set The day of born
            $this->SetXY($x+89.5, $y+116-$cellSizeY);
            $this->Cell(10.5, $cellSizeY, substr($bornDate, 0, 2), $test, 0, 'C');

            //Set The month of born
            $this->SetXY($x+106, $y+116-$cellSizeY);
            $this->Cell(41, $cellSizeY, $month[intval(substr($bornDate, 3, 2))-1], $test, 0, 'C');

            //Set The year of born
            $this->SetXY($x+152, $y+116-$cellSizeY);
            $this->Cell(18, $cellSizeY, substr($bornDate, 6), $test, 0, 'C');

            //Get The Father
            $this->SetXY($x+95, $y+125.6-$cellSizeY);
            $this->Cell(73, $cellSizeY, iconv('utf-8', 'cp1252', $father->getFullNameBeginName()), $test, 0, 'C');

            //Get The Mother
            $this->SetXY($x+88, $y+135-$cellSizeY);
            $this->Cell(81, $cellSizeY, iconv('utf-8', 'cp1252', $mother->getFullNameBeginName()), $test, 0, 'C');

            //Get The GodFother
            $this->SetXY($x+95, $y+145-$cellSizeY);
            $this->Cell(73, $cellSizeY, iconv('utf-8', 'cp1252', $godFather->getFullNameBeginName()), $test, 0, 'C');

            //Get The GodMother
            $this->SetXY($x+84, $y+156-$cellSizeY);
            $this->Cell(85, $cellSizeY, iconv('utf-8', 'cp1252', $godMother->getFullNameBeginName()), $test, 0, 'C');

            //Get The Baptism Rector
            $this->SetXY($x+102, $y+166-$cellSizeY);
            $this->Cell(68, $cellSizeY, iconv('utf-8', 'cp1252', $rectorBaptism->getFullNameBeginName()), $test, 0, 'C');

            //Get The Civil Registry Office
            $this->SetXY($x+109, $y+180-$cellSizeY);
            $this->Cell(12, $cellSizeY, $officineCivil->getNumber(), $test, 0, 'C');

            //Get The Civil Registry Act
            $this->SetXY($x+130.5, $y+180-$cellSizeY);
            $this->Cell(15, $cellSizeY, $civilRegistry->getNumber(), $test, 0, 'C');

            //Get The Civil Registry Book
            $this->SetXY($x+155.5, $y+180-$cellSizeY);
            $this->Cell(13, $cellSizeY, $civilRegistry->getBook(), $test, 0, 'C');

            //Get The Civil Registry Office Place
            $cityTemp   = $placeCivil;
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

            $this->SetXY($x+90.5, $y+190-$cellSizeY);
            $this->Cell(78, $cellSizeY, iconv('utf-8', 'cp1252', $cityString), $test, 0, 'C');

            //Get The Rector from the user
            $this->SetXY($x+97, $y+204-$cellSizeY);
            $this->Cell(68, $cellSizeY, iconv('utf-8', 'cp1252', $rectorUserP . " " . $rectorUser->getFullNameBeginName()), $test, 0, 'C');
            
            if ($this->full != 'true')
            {
                $this->SetFont('Arial','B', 10);
                $baptismRegistry = BaptismManager::getSingleBaptismRegistry('id', $this->baptism->getIdBookRegistry());
    
                if ($baptismRegistry === NULL)
                {
                    $baptismRegistry = new BaptismRegistry();
                }
    
                //Get The Book Registry Book
                $this->SetXY($x+102, $y+218.5-$cellSizeY);
                $this->Cell(14, $cellSizeY, $baptismRegistry->getBook(), $test, 0, 'C');
    
                //Get The Book Registry Page
                $page = $baptismRegistry->getPage();
    
                if ($baptismRegistry->getReverse() === 'Y')
                {
                    $page = $page . "v";
                }
    
                $this->SetXY($x+127, $y+218.5-$cellSizeY);
                $this->Cell(13, $cellSizeY, $page, $test, 0, 'C');
    
                //Get The Book Registry Number
                $this->SetXY($x+152, $y+218.5-$cellSizeY);
                $this->Cell(13, $cellSizeY, $baptismRegistry->getNumber(), $test, 0, 'C');
            }
        }

        // Footer
        function Footer()
        {
            if ($this->full == 'true')
            {
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
                    $x = intval($paperConfig->getBaptismCertX());
                    $y = intval($paperConfig->getBaptismCertY());
                }
                
                $baptismRegistry = BaptismManager::getSingleBaptismRegistry('id', $this->baptism->getIdBookRegistry());
    
                if ($baptismRegistry === NULL)
                {
                    $baptismRegistry = new BaptismRegistry();
                }
    
                //Get The Book Registry Book
                $this->SetXY($x+102, $y+213.5-$cellSizeY);
                $this->Cell(14, $cellSizeY, $baptismRegistry->getBook(), $test, 0, 'C');
    
                //Get The Book Registry Page
                $page = $baptismRegistry->getPage();
    
                if ($baptismRegistry->getReverse() === 'Y')
                {
                    $page = $page . "v";
                }
    
                $this->SetXY($x+127, $y+213.5-$cellSizeY);
                $this->Cell(13, $cellSizeY, $page, $test, 0, 'C');
    
                //Get The Book Registry Number
                $this->SetXY($x+152, $y+213.5-$cellSizeY);
                $this->Cell(13, $cellSizeY, $baptismRegistry->getNumber(), $test, 0, 'C');
            }
        }
     
        /**
        * Gets the value of baptism.
        * 
        * @author Jonathan Sandoval <jonathan_s_pisis@yahoo.com.mx>
        * @return mixed
        */
        public function getBaptism()
        {
            return $this->baptism;
        }
     
        /**
        * Sets the value of baptism.
        *
        * @param mixed $baptism the baptism
        * @author Jonathan Sandoval <jonathan_s_pisis@yahoo.com.mx>
        *
        * @return self
        */
        public function setBaptism($baptism)
        {
            $this->baptism = $baptism;
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