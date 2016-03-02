<?php

    namespace rmartignoni\StemCalculator;

    class Chart extends Drawer
    {
        public function __construct($width, $height)
        {
            parent::__construct($width, $height);
        }

        public function createChart(HeadTube $headtube, Stem $stemOne, Stem $stemTwo, $chartPath)
        {
            $this->drawStem($stemOne, $headtube, self::RED);
            $this->drawStem($stemTwo, $headtube, self::BLUE);
            $this->drawTube($headtube, self::WHITE);
            $this->drawComparison($stemOne, $stemTwo);

            $this->saveImage($chartPath);
        }
    }
