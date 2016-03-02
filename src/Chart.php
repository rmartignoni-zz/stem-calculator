<?php

    namespace rmartignoni\StemCalculator;

    use rmartignoni\StemCalculator\Image\ImageAdapter;

    class Chart extends Drawer
    {
        public function __construct($width, $height)
        {
            parent::__construct($width, $height);
        }

        public function createChart(HeadTube $headtube, Stem $stemOne, Stem $stemTwo, ImageAdapter $imageAdapter)
        {
            $this->drawStem($stemOne, $headtube, self::RED);
            $this->drawStem($stemTwo, $headtube, self::BLUE);
            $this->drawTube($headtube, self::WHITE);
            $this->drawComparison($stemOne, $stemTwo);

            return $imageAdapter->saveImage($this->image);
        }
    }
