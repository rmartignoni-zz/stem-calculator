<?php

    namespace rmartignoni\StemCalculator;

    abstract class Calculator
    {
        /**
         * @param float $angle
         * @param int   $hypotenuse
         *
         * @return float
         */
        protected function calculateLength($angle, $hypotenuse)
        {
            $rad = deg2rad($angle);

            return cos($rad) * $hypotenuse;
        }

        /**
         * @param float $angle
         * @param int   $hypotenuse
         *
         * @return float
         */
        protected function calculateHeight($angle, $hypotenuse)
        {
            $rad = deg2rad($angle);

            return sin($rad) * $hypotenuse;
        }
    }
