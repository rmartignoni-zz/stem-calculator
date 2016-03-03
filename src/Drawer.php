<?php

    namespace rmartignoni\StemCalculator;

    abstract class Drawer extends Color
    {
        /**
         * @var int
         */
        private $width;

        /**
         * @var int
         */
        private $height;

        private $fontPath;

        public function __construct($width, $height)
        {
            $this->setWidth($width);

            $this->setHeight($height);

            $this->createImage();

            $this->setFontPath(null);
        }

        private function createImage()
        {
            $this->image = imagecreate($this->width, $this->height);

            if ($this->image === false) {
                throw new \Exception;
            }

            imagecolorallocate($this->image, 0, 0, 0);
        }

        private function setFontPath($fontPath)
        {
            if (empty($fontPath) || !is_file($fontPath)) {
                $fontPath = __DIR__ . '/../resources/OpenSans-Regular.ttf';
            }

            $this->fontPath = $fontPath;
        }

        /**
         * @param $width
         *
         * @throws \Exception
         */
        public function setWidth($width)
        {
            if (!is_numeric($width)) {
                throw new \Exception;
            }

            $this->width = $width;
        }

        /**
         * @param $height
         *
         * @throws \Exception
         */
        public function setHeight($height)
        {
            if (!is_numeric($height)) {
                throw new \Exception;
            }

            $this->height = $height;
        }

        /**
         * @param HeadTube $headTube
         * @param string   $color
         * @param int      $thickness
         *
         * @return bool
         */
        protected function drawTube(HeadTube $headTube, $color, $thickness = 10)
        {
            $x1 = ($this->width / 5) * 2;
            $y1 = $this->height + 10;

            $x2 = $x1 - $headTube->getLength();
            $y2 = $this->height - $headTube->getHeight();

            $color = $this->createColor($color);

            $this->draw($x1, $y1, $x2, $y2, $color, $thickness);
        }

        /**
         * @param Stem     $stem
         * @param HeadTube $headTube
         * @param          $color
         *
         * @return bool
         */
        protected function drawStem(Stem $stem, HeadTube $headTube, $color)
        {
            $spacers = $stem->getSpacers();

            $x1 = (($this->width / 5) * 2) - $headTube->getLength($spacers);
            $y1 = $this->height - $headTube->getHeight($spacers);

            $x2 = $x1 + $stem->getLength();
            $y2 = $y1 - $stem->getHeight();

            if ($spacers > 0) {
                $virtualHeadTube = clone($headTube);

                $virtualHeadTube->addSpacers($spacers);

                $this->drawTube($virtualHeadTube, $color, 8);
            }

            $color = $this->createColor($color);

            $this->draw($x1, $y1, $x2, $y2, $color, 8);
        }

        /**
         * @param Stem $stemOne
         * @param Stem $stemTwo
         */
        protected function drawComparison(Stem $stemOne, Stem $stemTwo, HeadTube $headTube)
        {
            $comparison = $stemOne->compare($stemTwo, $headTube);

            $line  = 1;
            $color = imagecolorallocate($this->image, 255, 255, 255);

            foreach ($comparison as $text) {
                imagettftext($this->image, 12, 0, 5, ($line * 20), $color, $this->fontPath, $text);
                $line++;
            }
        }

        /**
         * @param     $x1
         * @param     $y1
         * @param     $x2
         * @param     $y2
         * @param     $color
         * @param int $thick
         */
        private function draw($x1, $y1, $x2, $y2, $color, $thick = 1)
        {
            if ($thick == 1) {
                imageline($this->image, $x1, $y1, $x2, $y2, $color);

                return;
            }

            $t = $thick / 2 - 0.5;

            $k = ($y2 - $y1) / ($x2 - $x1); //y = kx + q
            $a = $t / sqrt(1 + pow($k, 2));

            $points = [
                round($x1 - (1 + $k) * $a),
                round($y1 + (1 - $k) * $a),
                round($x1 - (1 - $k) * $a),
                round($y1 - (1 + $k) * $a),
                round($x2 + (1 + $k) * $a),
                round($y2 - (1 - $k) * $a),
                round($x2 + (1 - $k) * $a),
                round($y2 + (1 + $k) * $a),
            ];

            imagefilledpolygon($this->image, $points, 4, $color);

            imagepolygon($this->image, $points, 4, $color);

            return;
        }

        public function saveImage($path)
        {
            return imagepng($this->image, $path);
        }
    }
