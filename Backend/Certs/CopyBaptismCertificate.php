<?php 

    require_once(__DIR__."/../../Backend/SessionManager.php");
    require_once(__DIR__."/../../Backend/BaptismManager.php");
    require_once(__DIR__."/../../Backend/PersonManager.php");
    require_once(__DIR__."/../../Backend/RectorManager.php");
    require_once(__DIR__."/../../Backend/ConfirmationManager.php");
    require_once(__DIR__."/../../Backend/MarriageManager.php");
    require_once("FPDF/fpdf.php");

    /**
    * Class to registry one Baptism Certificate Copy
    * 
    * @author Jonathan Sandoval <jonathan_s_pisis@yahoo.com.mx>
    */
    class CopyBaptismCertificate extends FPDF
    {
        private $baptism;
        private $user;
        private $full;

        /**
         * Class Constructor
         *
         * @author Jonathan Sandoval <jonathan_s_pisis@yahoo.com.mx>
         * @param  integer $idUser    idUser
         * @param  integer $idBaptism idBaptism
         * @param  boolean $full      full document
         */
        function __construct($idUser = 0, $idBaptism = 0, $full = false)
        {
            //Define the constructor
            parent::FPDF('P', 'mm', 'Letter');

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

            $userChurch     = $this->user->getIdChurch();
            $userChurch     = ChurchManager::getSingleChurch('id', $userChurch);

            $rectorUser  = RectorManager::getSingleRector('idActualChurch', $userChurch->getId(), 'position', 'Sr. Cura');
            $rectorUserP = $rectorUser->getPosition();
            $rectorUser  = PersonManager::getSinglePerson('id', $rectorUser->getIdPerson());

            $celebrationDate = DatabaseManager::databaseDateToSingleDate($this->baptism->getCelebrationDate());
            $bornDate        = DatabaseManager::databaseDateToSingleDate($this->baptism->getBornDate());

            $child  = PersonManager::getSinglePerson('id', $this->baptism->getIdOwner());

            $father = PersonManager::getSinglePerson('id', $child->getIdFather());
            $gff    = new Person(0, "*************************");
            $gmf    = new Person(0, "*************************");

            $mother = PersonManager::getSinglePerson('id', $child->getIdMother());
            $gfm    = new Person(0, "*************************");
            $gmm    = new Person(0, "*************************");

            $godFather = PersonManager::getSinglePerson('id', $this->baptism->getIdGodFather());
            $godMother = PersonManager::getSinglePerson('id', $this->baptism->getIdGodMother());

            $civilRegistry = BaptismManager::getSingleCivilRegistry('id', $this->baptism->getIdCivilRegistry());
            $officineCivil = BaptismManager::getSingleOfficeCivilRegistry('id', $civilRegistry->getIdOffice());
            $placeCivil    = new City();

            $baptismRegistry = BaptismManager::getSingleBaptismRegistry('id', $this->baptism->getIdBookRegistry());

            if ($baptismRegistry === NULL)
            {
                $baptismRegistry = new BaptismRegistry();
            }

            if ($father === NULL)
            {
                $father = new Person(0, "*************************");
            }
            else //Get the Grandparents
            {
                $gff = PersonManager::getSinglePerson('id', $father->getIdFather());
                $gmf = PersonManager::getSinglePerson('id', $father->getIdMother());

                if ($gff === NULL)
                {
                    $gff = new Person(0, "*************************");
                }

                if ($gfm === NULL)
                {
                    $gfm = new Person(0, "*************************");
                }
            }

            if ($mother === NULL)
            {
                $mother = new Person(0, "*************************");
            }
            else //Get the Grandparents
            {
                $gfm = PersonManager::getSinglePerson('id', $mother->getIdFather());
                $gmm = PersonManager::getSinglePerson('id', $mother->getIdMother());

                if ($gfm === NULL)
                {
                    $gfm = new Person(0, "*************************");
                }

                if ($gfm === NULL)
                {
                    $gmm = new Person(0, "*************************");
                }
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
            $paperConfig = SessionManager::getSinglePaperConfig('id', $this->user->getIdPaperConfig());

            $cellSize = 5;
            $x = intval($paperConfig->getCopyBaptismCertX());
            $y = intval($paperConfig->getCopyBaptismCertY());

            $test = 0;

            if ($this->full == 'true')
            {
                $this->Image(__DIR__."/../../Backend/Certs/img/baptismCertCopy.jpg", 1, 0, 209, 282.5);
                
                $x = 0;
                $y = 0;
            }

            //Create the box of the Notarius
            $this->SetFont('Arial','B', 9);

            //Get user Church Name 
            $this->SetXY($x+5, $y+73-$cellSize);
            $this->Cell(49, $cellSize, iconv('utf-8', 'cp1252', $userChurch->getName()), $test, 0, 'C');

            //Get user Church Address 
            $this->SetXY($x+5, $y+81-$cellSize);
            $this->Cell(49, $cellSize, iconv('utf-8', 'cp1252', $userChurch->getAddress()), $test, 0, 'C');

            //Get user Church City 
            $cityTemp   = CityManager::getSingleCity('id', $userChurch->getIdCity());
            $stateTemp  = CityManager::getSingleState('id', $cityTemp->getIdState());

            $this->SetXY($x+5, $y+85-$cellSize);
            $this->Cell(49, $cellSize, iconv('utf-8', 'cp1252', $cityTemp->getName(). ", " . $stateTemp->getShortName()), $test, 0, 'C');

            //Continue with the other part of the document
            $this->SetFont('Arial','B', 10);

            //Get user Rector 
            $this->SetXY($x+70, $y+74-$cellSize);
            $this->Cell(134, $cellSize, iconv('utf-8', 'cp1252', $rectorUserP . " " . $rectorUser->getFullNameBeginName()), $test, 0, 'C');

            //Get user Church Name 
            $this->SetXY($x+75, $y+80.5-$cellSize);
            $this->Cell(71, $cellSize, iconv('utf-8', 'cp1252', $userChurch->getName()), $test, 0, 'C');

            //Get user Church Place 
            $this->SetXY($x+152.5, $y+80.5-$cellSize);
            $this->Cell(52, $cellSize, iconv('utf-8', 'cp1252', $cityTemp->getName(). ", " . $stateTemp->getShortName()), $test, 0, 'C');

            //Get The Book Registry Book
            $this->SetXY($x+140, $y+87.3-$cellSize);
            $this->Cell(10, $cellSize, $baptismRegistry->getBook(), $test, 0, 'C');

            //Get The Book Registry Page
            $page = $baptismRegistry->getPage();

            if ($baptismRegistry->getReverse() === 'Y')
            {
                $page = $page . "v";
            }

            $this->SetXY($x+159.5, $y+87.3-$cellSize);
            $this->Cell(10, $cellSize, $page, $test, 0, 'C');

            //Get The Book Registry Number
            $this->SetXY($x+193, $y+87.3-$cellSize);
            $this->Cell(11, $cellSize, $baptismRegistry->getNumber(), $test, 0, 'C');

            //Get The Tenor
            $this->SetXY($x+104, $y+95-$cellSize);
            $this->Cell(100.5, $cellSize, iconv('utf-8', 'cp1252', ''), $test, 0, 'C');

            //Get The Baptism Church
            $this->SetXY($x+63, $y+102-$cellSize);
            $this->Cell(141.5, $cellSize, iconv('utf-8', 'cp1252', $baptismChurch->getName()), $test, 0, 'C');

            //Set The day of baptism
            $this->SetXY($x+32, $y+110-$cellSize);
            $this->Cell(7, $cellSize, substr($celebrationDate, 0, 2), $test, 0, 'C');

            //Set The month of baptism
            $this->SetXY($x+45, $y+110-$cellSize);
            $this->Cell(48, $cellSize, $month[intval(substr($celebrationDate, 3, 2))-1], $test, 0, 'C');

            //Set The year of baptism
            $this->SetXY($x+99, $y+110-$cellSize);
            $this->Cell(16, $cellSize, substr($celebrationDate, 6), $test, 0, 'C');

            //Set The rector of baptism
            $this->SetXY($x+130, $y+110-$cellSize);
            $this->Cell(74.5, $cellSize, iconv('utf-8', 'cp1252', $rectorBaptism->getFullNameBeginName()), $test, 0, 'C');

            //Set The child
            $this->SetXY($x+74.5, $y+116.5-$cellSize);
            $this->Cell(130, $cellSize, iconv('utf-8', 'cp1252', $child->getFullNameBeginName()), $test, 0, 'C');

            //Set The born place
            $this->SetXY($x+53.5, $y+124-$cellSize);
            $this->Cell(65.5, $cellSize, iconv('utf-8', 'cp1252', $this->baptism->getBornPlace()), $test, 0, 'C');

            //Set The day of born
            $this->SetXY($x+130.5, $y+124-$cellSize);
            $this->Cell(5.5, $cellSize, substr($bornDate, 0, 2), $test, 0, 'C');

            //Set The month of born
            $this->SetXY($x+142, $y+124-$cellSize);
            $this->Cell(38.5, $cellSize, $month[intval(substr($bornDate, 3, 2))-1], $test, 0, 'C');

            //Set The year of born
            $this->SetXY($x+187, $y+124-$cellSize); //Here
            $this->Cell(17.5, $cellSize, substr($bornDate, 6), $test, 0, 'C');

            //Set The gender data
            if ($child->getGender() === 'F')
            {
                $this->SetXY($x+39, $y+129.5-$cellSize);
                $this->Cell(4.5, $cellSize, 'a', $test, 0, 'C');

                $this->SetXY($x+62.5, $y+129.5-$cellSize);
                $this->Cell(4.5, $cellSize, 'a', $test, 0, 'C');
            }
            else
            {
                $this->SetXY($x+39, $y+129.5-$cellSize);
                $this->Cell(4.5, $cellSize, 'o', $test, 0, 'C');

                $this->SetXY($x+62.5, $y+129.5-$cellSize);
                $this->Cell(4.5, $cellSize, 'o', $test, 0, 'C');
            }

            //Set if is Ilegitimate
            if ($this->baptism->getLegitimate() == 'N')
            {
                $this->SetXY($x+44.5, $y+129.5-$cellSize);
                $this->Cell(4, $cellSize, 'i', $test, 0, 'C');
            }

            //Set the Father
            if ($father != NULL)
            {
                $this->SetXY($x+73, $y+129.5-$cellSize);
                $this->Cell(131.5, $cellSize, iconv('utf-8', 'cp1252', $father->getFullNameBeginName()), $test, 0, 'C');
            }

            //Set the Mother
            if ($mother != NULL)
            {   
                $this->SetXY($x+37, $y+137-$cellSize);
                $this->Cell(167.5, $cellSize, iconv('utf-8', 'cp1252', $mother->getFullNameBeginName()), $test, 0, 'C');
            }

            //Set the Father of the father
            if ($gff != NULL)
            {
                $this->SetXY($x+62.5, $y+143.5-$cellSize);
                $this->Cell(142, $cellSize, iconv('utf-8', 'cp1252', $gff->getFullNameBeginName()), $test, 0, 'C');
            }

            //Set the Mother of the father
            if ($gmf != NULL)
            {
                $this->SetXY($x+29.5, $y+150-$cellSize);
                $this->Cell(175, $cellSize, iconv('utf-8', 'cp1252', $gmf->getFullNameBeginName()), $test, 0, 'C');
            }

            //Set the Father of the mother
            if ($gfm != NULL)
            {
                $this->SetXY($x+63.5, $y+157.5-$cellSize);
                $this->Cell(141, $cellSize, iconv('utf-8', 'cp1252', $gfm->getFullNameBeginName()), $test, 0, 'C');
            }

            //Set the Mother of the mother
            if ($gmm != NULL)
            {
                $this->SetXY($x+29.5, $y+164-$cellSize);
                $this->Cell(175, $cellSize, iconv('utf-8', 'cp1252', $gmm->getFullNameBeginName()), $test, 0, 'C');
            }

            //Set the GodFathers
            if ($godFather != NULL && $godMother != NULL)
            {
                $godFathersString = $godFather->getFullNameBeginName() . " y " . $godMother->getFullNameBeginName();
                $this->SetXY($x+47, $y+172-$cellSize);
                $this->Cell(157.5, $cellSize, iconv('utf-8', 'cp1252', $godFathersString), $test, 0, 'C');
            }

            //Get the marginal Notes
            $confirmation = ConfirmationManager::getSingleConfirmation('idOwner', $this->baptism->getIdOwner());
            $marriage = MarriageManager::getSingleMarriage('idBoyfriend', $this->baptism->getIdOwner());
            $isGirl = false;

            if ($marriage === NULL)
            {
                $marriage = MarriageManager::getSingleMarriage('idGirlfriend', $this->baptism->getIdOwner());
                $isGirl = true;
            }            

            $this->SetFont('Arial','B', 8);

            if ($confirmation === NULL && $marriage === NULL)
            {
                $stringAsterick = "*****************************************************";

                $this->SetXY($x+29, $y+206.5-$cellSize);
                $this->Cell(175, $cellSize, iconv('utf-8', 'cp1252', $stringAsterick), $test, 0, 'C');
            }
            else
            {
                if ($confirmation === NULL) //Marriage is not null
                {
                    if ($child->getGender() === 'F')
                    {
                        $person = PersonManager::getSinglePerson('id', $marriage->getIdBoyfriend());
                    }
                    else
                    {
                        $person = PersonManager::getSinglePerson('id', $marriage->getIdGirlfriend());
                    }

                    $churchMarriage = ChurchManager::getSingleChurch('id', $marriage->getIdChurchMarriage());
                    $dateMarriage = DatabaseManager::databaseDateToSingleDate($marriage->getCelebrationDate());

                    $stringMarginal2 = "Contrajo Matrimonio con ";
                    $stringMarginal2 = $stringMarginal2 . $person->getFullNameBeginName();
                    $stringMarginal2 = $stringMarginal2 . " en " . $churchMarriage->getName();
                    $stringMarginal2 = $stringMarginal2 . " " . $dateMarriage;

                    $this->SetXY($x+29, $y+206.5-$cellSize);
                    $this->Cell(175, $cellSize, iconv('utf-8', 'cp1252', $stringMarginal2), $test, 0, 'C');
                }
                else if ($marriage === NULL) //Confirmation is not null
                {
                    $churchConfirmation = ChurchManager::getSingleChurch('id', $confirmation->getIdChurch());
                    $dateConfirmation   = DatabaseManager::databaseDateToSingleDate($confirmation->getCelebrationDate());
                    
                    $rectorConfirmation  = $confirmation->getIdRector();
                    $rectorConfirmation  = RectorManager::getSingleRector('id', $rectorConfirmation);
                    $rectorConfirmationP = PersonManager::getSinglePerson('id', $rectorConfirmation->getIdPerson());

                    if ($child->getGender() === 'F')
                    {
                        $stringMarginal1 = "Confirmada";
                    }
                    else
                    {
                        $stringMarginal1 = "Confirmado";
                    }

                    $stringMarginal1 = $stringMarginal1 . " en " . $churchConfirmation->getName();
                    $stringMarginal1 = $stringMarginal1 . " por " . $rectorConfirmation->getPosition();
                    $stringMarginal1 = $stringMarginal1 . " " . $rectorConfirmationP->getFullNameBeginName();
                    $stringMarginal1 = $stringMarginal1 . " " . $dateConfirmation;

                    $this->SetXY($x+29, $y+206.5-$cellSize);
                    $this->Cell(175, $cellSize, iconv('utf-8', 'cp1252', $stringMarginal1), $test, 0, 'C');
                }
                else //Both are setters
                {
                    $churchConfirmation = ChurchManager::getSingleChurch('id', $confirmation->getIdChurch());
                    $dateConfirmation   = DatabaseManager::databaseDateToSingleDate($confirmation->getCelebrationDate());
                    
                    $rectorConfirmation  = $confirmation->getIdRector();
                    $rectorConfirmation  = RectorManager::getSingleRector('id', $rectorConfirmation);
                    $rectorConfirmationP = PersonManager::getSinglePerson('id', $rectorConfirmation->getIdPerson());

                    if ($child->getGender() === 'F')
                    {
                        $person = PersonManager::getSinglePerson('id', $marriage->getIdBoyfriend());
                        $stringMarginal1 = "Confirmada";
                    }
                    else
                    {
                        $person = PersonManager::getSinglePerson('id', $marriage->getIdGirlfriend());
                        $stringMarginal1 = "Confirmado";
                    }

                    $stringMarginal1 = $stringMarginal1 . " en " . $churchConfirmation->getName();
                    $stringMarginal1 = $stringMarginal1 . " por " . $rectorConfirmation->getPosition();
                    $stringMarginal1 = $stringMarginal1 . " " . $rectorConfirmationP->getFullNameBeginName();
                    $stringMarginal1 = $stringMarginal1 . " " . $dateConfirmation;

                    $churchMarriage = ChurchManager::getSingleChurch('id', $marriage->getIdChurchMarriage());
                    $dateMarriage = DatabaseManager::databaseDateToSingleDate($marriage->getCelebrationDate());

                    $stringMarginal2 = "Contrajo Matrimonio con ";
                    $stringMarginal2 = $stringMarginal2 . $person->getFullNameBeginName();
                    $stringMarginal2 = $stringMarginal2 . " en " . $churchMarriage->getName();
                    $stringMarginal2 = $stringMarginal2 . " " . $dateMarriage;

                    if (strlen($stringMarginal1) > strlen($stringMarginal2))
                    {
                        $this->SetXY($x+62, $y+199.5-$cellSize);
                        $this->Cell(142, $cellSize, iconv('utf-8', 'cp1252', $stringMarginal2), $test, 0, 'C');

                        $this->SetXY($x+29, $y+206.5-$cellSize);
                        $this->Cell(175, $cellSize, iconv('utf-8', 'cp1252', $stringMarginal1), $test, 0, 'C');
                    }
                    else
                    {
                        $this->SetXY($x+62, $y+199.5-$cellSize);
                        $this->Cell(142, $cellSize, iconv('utf-8', 'cp1252', $stringMarginal1), $test, 0, 'C');

                        $this->SetXY($x+29, $y+206.5-$cellSize);
                        $this->Cell(175, $cellSize, iconv('utf-8', 'cp1252', $stringMarginal2), $test, 0, 'C');
                    }
                }
            }

            $this->SetFont('Arial','B', 9);

            //Get The Civil Registry Book
            $this->SetXY($x+73, $y+213.5-$cellSize);
            $this->Cell(10, $cellSize, $civilRegistry->getBook(), $test, 0, 'C');

            //Get The Civil Registry Act
            $this->SetXY($x+100, $y+213.5-$cellSize);
            $this->Cell(9, $cellSize, $civilRegistry->getNumber(), $test, 0, 'C');

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

            $this->SetXY($x+120.5, $y+213.5-$cellSize);
            $this->Cell(47, $cellSize, iconv('utf-8', 'cp1252', $cityString), $test, 0, 'C');

            //Get The Civil Registry Officine 
            $this->SetXY($x+181.5, $y+213.5-$cellSize);
            $this->Cell(23, $cellSize, $officineCivil->getNumber(), $test, 0, 'C');

            //Get The Client Data
            $this->SetXY($x+88, $y+227-$cellSize);
            $this->Cell(3, $cellSize, 'l', $test, 0, 'C');

            //Get The Civil Registry Officine 
            $this->SetXY($x+109, $y+227-$cellSize);
            $this->Cell(6, $cellSize, 'o', $test, 0, 'C');

            //Get The Current Day
            $this->SetXY($x+163.5, $y+227-$cellSize);
            $this->Cell(5, $cellSize, date("d"), $test, 0, 'C');

            //Get The Current Month
            $this->SetXY($x+29.5, $y+234-$cellSize);
            $this->Cell(45, $cellSize, $month[intval(date("m"))-1], $test, 0, 'C');

            //Get The Current Year
            $this->SetXY($x+95, $y+234-$cellSize);
            $this->Cell(9, $cellSize, date('Y'), $test, 0, 'C');
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