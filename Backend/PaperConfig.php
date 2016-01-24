<?php 

    /**
    * Class to registry one Paper Config
    * 
    * @author Jonathan Sandoval <jonathan_s_pisis@yahoo.com.mx>
    */
    class PaperConfig
    {
        private $id;

        private $baptismCertX;
        private $baptismCertY;
        private $copyBaptismCertX;
        private $copyBaptismCertY;
        
        private $communionCertX;
        private $communionCertY;
        private $copyCommunionCertX;
        private $copyCommunionCertY;
        
        private $confirmationCertX;
        private $confirmationCertY;
        private $copyConfirmationCertX;
        private $copyConfirmationCertY;

        private $marriageCertX;
        private $marriageCertY;
        private $marriageConstancyX;
        private $marriageConstancyY;
        private $marriageNoticeX;
        private $marriageNoticeY;
        private $marriageExhortX;
        private $marriageExhortY;                
        private $marriageTraslationX;
        private $marriageTraslationY;

        /**
         * Contructor for the classe PaperConfig
         *
         * @author Jonathan Sandoval <jonathan_s_pisis@yahoo.com.mx>
         * @param  integer $i    id
         * @param  integer $bcx  baptismCertX
         * @param  integer $bcy  baptismCertY
         * @param  integer $cbcx copyBaptismCertX
         * @param  integer $cbcy copyBaptismCertY
         * @param  integer $ecx  communionCertX
         * @param  integer $ecy  communionCertY
         * @param  integer $cecx copyCommunionCertX
         * @param  integer $cecy copyCommunionCertY
         * @param  integer $ccx  confirmationCertX
         * @param  integer $ccy  confirmationCertY
         * @param  integer $cccx copyConfirmationCertX
         * @param  integer $cccy copyConfirmationCertY
         * @param  integer $mcx  marriageCertX
         * @param  integer $mcy  marriageCertY
         * @param  integer $mbx  marriageConstancyX
         * @param  integer $mby  marriageConstancyY
         * @param  integer $mnx  marriageNoticeX
         * @param  integer $mny  marriageNoticeY
         * @param  integer $mex  marriageExhortX
         * @param  integer $mey  marriageExhortY
         * @param  integer $mtx  marriageTraslationX
         * @param  integer $mty  marriageTraslationY
         */
        function __construct($i = 0, $bcx = 0, $bcy = 0, $cbcx = 0, $cbcy = 0, 
                                     $ecx = 0, $ecy = 0, $cecx = 0, $cecy = 0, 
                                     $ccx = 0, $ccy = 0, $cccx = 0, $cccy = 0,
                                     $mcx = 0, $mcy = 0, $mbx  = 0, $mby  = 0,
                                     $mnx = 0, $mny = 0, $mex  = 0, $mey  = 0,
                                     $mtx = 0, $mty = 0)
        {
            $this->id                    = $i;
         
            $this->baptismCertX          = $bcx;
            $this->baptismCertY          = $bcy;
            $this->copyBaptismCertX      = $cbcx;
            $this->copyBaptismCertY      = $cbcy;

            $this->communionCertX        = $ecx;
            $this->communionCertY        = $ecy;
            $this->copyCommunionCertX    = $cecx;
            $this->copyCommunionCertY    = $cecy;
            
            $this->confirmationCertX     = $ccx;
            $this->confirmationCertY     = $ccy;
            $this->copyConfirmationCertX = $cccx;
            $this->copyConfirmationCertY = $cccy;

            $this->marriageCertX         = $mcx;
            $this->marriageCertY         = $mcy;
            $this->marriageConstancyX    = $mbx;
            $this->marriageConstancyY    = $mby;
            $this->marriageNoticeX       = $mnx;
            $this->marriageNoticeY       = $mny;
            $this->marriageExhortX       = $mex;
            $this->marriageExhortY       = $mey;                
            $this->marriageTraslationX   = $mtx;
            $this->marriageTraslationY   = $mty;
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
        * Gets the value of baptismCertX.
        *
        * @author Jonathan Sandoval <jonathan_s_pisis@yahoo.com.mx>
        * @return mixed
        */
        public function getBaptismCertX()
        {
            return $this->baptismCertX;
        }
         
        /**
        * Sets the value of baptismCertX.
        *
        * @author Jonathan Sandoval <jonathan_s_pisis@yahoo.com.mx>
        * @param mixed $baptismCertX the baptism cert
        */
        public function setBaptismCertX($baptismCertX)
        {
            $this->baptismCertX = $baptismCertX;
        }
         
        /**
        * Gets the value of baptismCertY.
        *
        * @author Jonathan Sandoval <jonathan_s_pisis@yahoo.com.mx>
        * @return mixed
        */
        public function getBaptismCertY()
        {
            return $this->baptismCertY;
        }
         
        /**
        * Sets the value of baptismCertY.
        *
        * @author Jonathan Sandoval <jonathan_s_pisis@yahoo.com.mx>
        * @param mixed $baptismCertY the baptism cert
        */
        public function setBaptismCertY($baptismCertY)
        {
            $this->baptismCertY = $baptismCertY;
        }
         
        /**
        * Gets the value of copyBaptismCertX.
        *
        * @author Jonathan Sandoval <jonathan_s_pisis@yahoo.com.mx>
        * @return mixed
        */
        public function getCopyBaptismCertX()
        {
            return $this->copyBaptismCertX;
        }
         
        /**
        * Sets the value of copyBaptismCertX.
        *
        * @author Jonathan Sandoval <jonathan_s_pisis@yahoo.com.mx>
        * @param mixed $copyBaptismCertX the copy baptism cert
        */
        public function setCopyBaptismCertX($copyBaptismCertX)
        {
            $this->copyBaptismCertX = $copyBaptismCertX;
        }
         
        /**
        * Gets the value of copyBaptismCertY.
        *
        * @author Jonathan Sandoval <jonathan_s_pisis@yahoo.com.mx>
        * @return mixed
        */
        public function getCopyBaptismCertY()
        {
            return $this->copyBaptismCertY;
        }
         
        /**
        * Sets the value of copyBaptismCertY.
        *
        * @author Jonathan Sandoval <jonathan_s_pisis@yahoo.com.mx>
        * @param mixed $copyBaptismCertY the copy baptism cert
        */
        public function setCopyBaptismCertY($copyBaptismCertY)
        {
            $this->copyBaptismCertY = $copyBaptismCertY;
        }
         
        /**
        * Gets the value of communionCertX.
        *
        * @author Jonathan Sandoval <jonathan_s_pisis@yahoo.com.mx>
        * @return mixed
        */
        public function getCommunionCertX()
        {
            return $this->communionCertX;
        }
         
        /**
        * Sets the value of communionCertX.
        *
        * @author Jonathan Sandoval <jonathan_s_pisis@yahoo.com.mx>
        * @param mixed $communionCertX the communion cert
        */
        public function setCommunionCertX($communionCertX)
        {
            $this->communionCertX = $communionCertX;
        }
         
        /**
        * Gets the value of communionCertY.
        *
        * @author Jonathan Sandoval <jonathan_s_pisis@yahoo.com.mx>
        * @return mixed
        */
        public function getCommunionCertY()
        {
            return $this->communionCertY;
        }
         
        /**
        * Sets the value of communionCertY.
        *
        * @author Jonathan Sandoval <jonathan_s_pisis@yahoo.com.mx>
        * @param mixed $communionCertY the communion cert
        */
        public function setCommunionCertY($communionCertY)
        {
            $this->communionCertY = $communionCertY;
        }
         
        /**
        * Gets the value of copyCommunionCertX.
        *
        * @author Jonathan Sandoval <jonathan_s_pisis@yahoo.com.mx>
        * @return mixed
        */
        public function getCopyCommunionCertX()
        {
            return $this->copyCommunionCertX;
        }
         
        /**
        * Sets the value of copyCommunionCertX.
        *
        * @author Jonathan Sandoval <jonathan_s_pisis@yahoo.com.mx>
        * @param mixed $copyCommunionCertX the copy communion cert
        */
        public function setCopyCommunionCertX($copyCommunionCertX)
        {
            $this->copyCommunionCertX = $copyCommunionCertX;
        }
         
        /**
        * Gets the value of copyCommunionCertY.
        *
        * @author Jonathan Sandoval <jonathan_s_pisis@yahoo.com.mx>
        * @return mixed
        */
        public function getCopyCommunionCertY()
        {
            return $this->copyCommunionCertY;
        }
         
        /**
        * Sets the value of copyCommunionCertY.
        *
        * @author Jonathan Sandoval <jonathan_s_pisis@yahoo.com.mx>
        * @param mixed $copyCommunionCertY the copy communion cert
        */
        public function setCopyCommunionCertY($copyCommunionCertY)
        {
            $this->copyCommunionCertY = $copyCommunionCertY;
        }
         
        /**
        * Gets the value of confirmationCertX.
        *
        * @author Jonathan Sandoval <jonathan_s_pisis@yahoo.com.mx>
        * @return mixed
        */
        public function getConfirmationCertX()
        {
            return $this->confirmationCertX;
        }
         
        /**
        * Sets the value of confirmationCertX.
        *
        * @author Jonathan Sandoval <jonathan_s_pisis@yahoo.com.mx>
        * @param mixed $confirmationCertX the confirmation cert
        */
        public function setConfirmationCertX($confirmationCertX)
        {
            $this->confirmationCertX = $confirmationCertX;
        }
         
        /**
        * Gets the value of confirmationCertY.
        *
        * @author Jonathan Sandoval <jonathan_s_pisis@yahoo.com.mx>
        * @return mixed
        */
        public function getConfirmationCertY()
        {
            return $this->confirmationCertY;
        }
         
        /**
        * Sets the value of confirmationCertY.
        *
        * @author Jonathan Sandoval <jonathan_s_pisis@yahoo.com.mx>
        * @param mixed $confirmationCertY the confirmation cert
        */
        public function setConfirmationCertY($confirmationCertY)
        {
            $this->confirmationCertY = $confirmationCertY;
        }
         
        /**
        * Gets the value of copyConfirmationCertX.
        *
        * @author Jonathan Sandoval <jonathan_s_pisis@yahoo.com.mx>
        * @return mixed
        */
        public function getCopyConfirmationCertX()
        {
            return $this->copyConfirmationCertX;
        }
         
        /**
        * Sets the value of copyConfirmationCertX.
        *
        * @author Jonathan Sandoval <jonathan_s_pisis@yahoo.com.mx>
        * @param mixed $copyConfirmationCertX the copy confirmation cert
        */
        public function setCopyConfirmationCertX($copyConfirmationCertX)
        {
            $this->copyConfirmationCertX = $copyConfirmationCertX;
        }
         
        /**
        * Gets the value of copyConfirmationCertY.
        *
        * @author Jonathan Sandoval <jonathan_s_pisis@yahoo.com.mx>
        * @return mixed
        */
        public function getCopyConfirmationCertY()
        {
            return $this->copyConfirmationCertY;
        }
         
        /**
        * Sets the value of copyConfirmationCertY.
        *
        * @author Jonathan Sandoval <jonathan_s_pisis@yahoo.com.mx>
        * @param mixed $copyConfirmationCertY the copy confirmation cert
        */
        public function setCopyConfirmationCertY($copyConfirmationCertY)
        {
            $this->copyConfirmationCertY = $copyConfirmationCertY;
        }
         
        /**
        * Gets the value of marriageCertX.
        *
        * @author Jonathan Sandoval <jonathan_s_pisis@yahoo.com.mx>
        * @return mixed
        */
        public function getMarriageCertX()
        {
            return $this->marriageCertX;
        }
         
        /**
        * Sets the value of marriageCertX.
        *
        * @author Jonathan Sandoval <jonathan_s_pisis@yahoo.com.mx>
        * @param mixed $marriageCertX the marriage cert
        */
        public function setMarriageCertX($marriageCertX)
        {
            $this->marriageCertX = $marriageCertX;
        }
         
        /**
        * Gets the value of marriageCertY.
        *
        * @author Jonathan Sandoval <jonathan_s_pisis@yahoo.com.mx>
        * @return mixed
        */
        public function getMarriageCertY()
        {
            return $this->marriageCertY;
        }
         
        /**
        * Sets the value of marriageCertY.
        *
        * @author Jonathan Sandoval <jonathan_s_pisis@yahoo.com.mx>
        * @param mixed $marriageCertY the marriage cert
        */
        public function setMarriageCertY($marriageCertY)
        {
            $this->marriageCertY = $marriageCertY;
        }
         
        /**
        * Gets the value of marriageConstancyX.
        *
        * @author Jonathan Sandoval <jonathan_s_pisis@yahoo.com.mx>
        * @return mixed
        */
        public function getMarriageConstancyX()
        {
            return $this->marriageConstancyX;
        }
         
        /**
        * Sets the value of marriageConstancyX.
        *
        * @author Jonathan Sandoval <jonathan_s_pisis@yahoo.com.mx>
        * @param mixed $marriageConstancyX the marriage constancy
        */
        public function setMarriageConstancyX($marriageConstancyX)
        {
            $this->marriageConstancyX = $marriageConstancyX;
        }
         
        /**
        * Gets the value of marriageConstancyY.
        *
        * @author Jonathan Sandoval <jonathan_s_pisis@yahoo.com.mx>
        * @return mixed
        */
        public function getMarriageConstancyY()
        {
            return $this->marriageConstancyY;
        }
         
        /**
        * Sets the value of marriageConstancyY.
        *
        * @author Jonathan Sandoval <jonathan_s_pisis@yahoo.com.mx>
        * @param mixed $marriageConstancyY the marriage constancy
        */
        public function setMarriageConstancyY($marriageConstancyY)
        {
            $this->marriageConstancyY = $marriageConstancyY;
        }
         
        /**
        * Gets the value of marriageNoticeX.
        *
        * @author Jonathan Sandoval <jonathan_s_pisis@yahoo.com.mx>
        * @return mixed
        */
        public function getMarriageNoticeX()
        {
            return $this->marriageNoticeX;
        }
         
        /**
        * Sets the value of marriageNoticeX.
        *
        * @author Jonathan Sandoval <jonathan_s_pisis@yahoo.com.mx>
        * @param mixed $marriageNoticeX the marriage notice
        */
        public function setMarriageNoticeX($marriageNoticeX)
        {
            $this->marriageNoticeX = $marriageNoticeX;
        }
         
        /**
        * Gets the value of marriageNoticeY.
        *
        * @author Jonathan Sandoval <jonathan_s_pisis@yahoo.com.mx>
        * @return mixed
        */
        public function getMarriageNoticeY()
        {
            return $this->marriageNoticeY;
        }
         
        /**
        * Sets the value of marriageNoticeY.
        *
        * @author Jonathan Sandoval <jonathan_s_pisis@yahoo.com.mx>
        * @param mixed $marriageNoticeY the marriage notice
        */
        public function setMarriageNoticeY($marriageNoticeY)
        {
            $this->marriageNoticeY = $marriageNoticeY;
        }
         
        /**
        * Gets the value of marriageExhortX.
        *
        * @author Jonathan Sandoval <jonathan_s_pisis@yahoo.com.mx>
        * @return mixed
        */
        public function getMarriageExhortX()
        {
            return $this->marriageExhortX;
        }
         
        /**
        * Sets the value of marriageExhortX.
        *
        * @author Jonathan Sandoval <jonathan_s_pisis@yahoo.com.mx>
        * @param mixed $marriageExhortX the marriage exhort
        */
        public function setMarriageExhortX($marriageExhortX)
        {
            $this->marriageExhortX = $marriageExhortX;
        }
         
        /**
        * Gets the value of marriageExhortY.
        *
        * @author Jonathan Sandoval <jonathan_s_pisis@yahoo.com.mx>
        * @return mixed
        */
        public function getMarriageExhortY()
        {
            return $this->marriageExhortY;
        }
         
        /**
        * Sets the value of marriageExhortY.
        *
        * @author Jonathan Sandoval <jonathan_s_pisis@yahoo.com.mx>
        * @param mixed $marriageExhortY the marriage exhort
        */
        public function setMarriageExhortY($marriageExhortY)
        {
            $this->marriageExhortY = $marriageExhortY;
        }
         
        /**
        * Gets the value of marriageTraslationX.
        *
        * @author Jonathan Sandoval <jonathan_s_pisis@yahoo.com.mx>
        * @return mixed
        */
        public function getMarriageTraslationX()
        {
            return $this->marriageTraslationX;
        }
         
        /**
        * Sets the value of marriageTraslationX.
        *
        * @author Jonathan Sandoval <jonathan_s_pisis@yahoo.com.mx>
        * @param mixed $marriageTraslationX the marriage traslation
        */
        public function setMarriageTraslationX($marriageTraslationX)
        {
            $this->marriageTraslationX = $marriageTraslationX;
        }
         
        /**
        * Gets the value of marriageTraslationY.
        *
        * @author Jonathan Sandoval <jonathan_s_pisis@yahoo.com.mx>
        * @return mixed
        */
        public function getMarriageTraslationY()
        {
            return $this->marriageTraslationY;
        }
         
        /**
        * Sets the value of marriageTraslationY.
        *
        * @author Jonathan Sandoval <jonathan_s_pisis@yahoo.com.mx>
        * @param mixed $marriageTraslationY the marriage traslation
        */
        public function setMarriageTraslationY($marriageTraslationY)
        {
            $this->marriageTraslationY = $marriageTraslationY;
        }
    }

 ?>