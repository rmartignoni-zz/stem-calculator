<?php

    namespace rmartignoni\StemCalculator\Image;

    class ImageEncoder implements ImageAdapter
    {
        public function saveImage($image)
        {
            ob_start();

            imagepng($image);

            $data = ob_get_contents();

            ob_end_clean();

            return base64_encode($data);
        }
    }
