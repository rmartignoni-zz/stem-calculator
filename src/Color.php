<?php

    namespace rmartignoni\StemCalculator;

    abstract class Color
    {
        const BLUE = 'blue';

        const RED = 'red';

        const WHITE = 'white';

        /**
         * @var resource
         */
        protected $image;

        protected function createColor($color)
        {
            switch ($color) {
                case self::BLUE:
                    $color = imagecolorallocatealpha($this->image, 0, 0, 255, 0);
                    break;

                case self::RED:
                    $color = imagecolorallocatealpha($this->image, 255, 0, 0, 0);
                    break;

                case self::WHITE:
                    $color = imagecolorallocatealpha($this->image, 255, 255, 255, 0);
                    break;

                default:
                    $color = imagecolorallocatealpha($this->image, 46, 46, 46, 0);
                    break;
            }

            return $color;
        }
    }
