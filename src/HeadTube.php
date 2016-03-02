<?php

    namespace rmartignoni\StemCalculator;

    class HeadTube extends Calculator
    {
        /**
         * @var float
         */
        private $angle;

        /**
         * @var int
         */
        private $height;

        public function __construct($headAngle, $headHeight = 50)
        {
            $this->setAngle($headAngle);

            $this->setHeight($headHeight);
        }

        /**
         * @return float
         */
        public function getAngle()
        {
            $frontAngle = 180 - $this->angle;

            return $frontAngle;
        }

        /**
         * @param float $angle
         */
        public function setAngle($angle)
        {
            $this->angle = $angle;
        }

        /**
         * @param int $height
         */
        public function setHeight($height)
        {
            $this->height = $height;
        }

        public function addSpacers($spacers)
        {
            $height = $this->height + $spacers;

            $this->setHeight($height);
        }

        /**
         * @param int $spacers
         *
         * @return float
         */
        public function getHeight($spacers = 0)
        {
            $height = $this->height + $spacers;

            return $this->calculateHeight($this->angle, $height);
        }

        /**
         * @param int $spacers
         *
         * @return float
         */
        public function getLength($spacers = 0)
        {
            $height = $this->height + $spacers;

            return $this->calculateLength($this->angle, $height);
        }
    }
