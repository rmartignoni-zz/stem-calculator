<?php

    namespace rmartignoni\StemCalculator;

    class Stem extends Calculator
    {
        /**
         * @var int
         */
        private $stemLength;

        /**
         * @var float
         */
        private $angle;

        /**
         * @var int
         */
        private $spacers;

        /**
         * @var HeadTube
         */
        private $headTube;

        /**
         * Stem constructor.
         *
         * @param int      $stemLength - Stem length in millimeters
         * @param float    $stemAngle  - Stem angle in degrees
         * @param int      $spacers    - Spacers stack height used below the stem (in millimeters)
         * @param HeadTube $headTube   - HeadTube object which will be used to calculate stack and reach
         */
        public function __construct($stemLength, $stemAngle, $spacers, HeadTube $headTube)
        {
            $this->stemLength = $stemLength;

            $this->setStemAngle($stemAngle);

            $this->spacers = $spacers;

            $this->headTube = $headTube;
        }

        /**
         * @param float $angle
         */
        public function setStemAngle($angle)
        {
            // Calculate the angle the stem makes with the head tube
            $angle = 180 - (90 + $angle);

            $this->angle = $angle;
        }

        /**
         * @return float
         */
        public function getAngle()
        {
            $angle = $this->headTube->getAngle() - $this->angle;

            return $angle;
        }

        /**
         * @return int
         */
        public function getSpacers()
        {
            return $this->spacers;
        }

        /**
         * @param int $spacers
         */
        public function setSpacers($spacers)
        {
            $this->spacers = $spacers;
        }

        /**
         * @return float
         */
        public function getHeight()
        {
            $height = $this->calculateHeight($this->getAngle(), $this->stemLength);

            return $height;
        }

        /**
         * @return float
         */
        public function getLength()
        {
            return $this->calculateLength($this->getAngle(), $this->stemLength);
        }

        /**
         * @param Stem $stem
         * @param HeadTube $headTube
         *
         * @return array
         */
        public function compare(Stem $stem, HeadTube $headTube)
        {
            // Calculate the offset the spacers will cause in the stem
            $currentSpacersOffsetX = ($headTube->getLength($this->getSpacers()) - $headTube->getLength());
            $currentSpacersOffsetY = ($headTube->getHeight($this->getSpacers()) - $headTube->getHeight());

            $currentStemLength = $this->getLength() - $currentSpacersOffsetX;
            $currentStemHeight = $this->getHeight() + $currentSpacersOffsetY;

            $comparedSpacersOffsetX = ($headTube->getLength($stem->getSpacers()) - $headTube->getLength());
            $comparedSpacersOffsetY = ($headTube->getHeight($stem->getSpacers()) - $headTube->getHeight());

            $comparedStemLength = $stem->getLength() - $comparedSpacersOffsetX;
            $comparedStemHeight = $stem->getHeight() + $comparedSpacersOffsetY;

            $length = number_format($currentStemLength - $comparedStemLength, 1);

            // $lengthStr = 'The 1st stem is ' . abs($length) . 'mm longerlonger than de 2nd one';
            $lengthStr = 'longer';

            if ($length < 0) {
                $lengthStr = 'shorter';
            }

            $height = number_format($currentStemHeight - $comparedStemHeight, 1);

            $heightStr = 'higher';

            if($height < 0) {
                $heightStr = 'lower';
            }

            $comparison = [
                'length' => 'The red stem is ' . abs($length) . 'mm ' . $lengthStr . ' than de blue one',
                'height' => 'The red stem is ' . abs($height) . 'mm ' . $heightStr . ' than de blue one',
            ];

            return $comparison;
        }
    }
