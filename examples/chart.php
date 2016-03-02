<?php

    use rmartignoni\StemCalculator\Chart;
    use rmartignoni\StemCalculator\HeadTube;
    use rmartignoni\StemCalculator\Stem;

    require(__DIR__ . '/../vendor/autoload.php');

    $imageFile = __DIR__ . '/chart.png';

    $headTube = new HeadTube(70);
    $stemOne = new Stem(100, 6, 5, $headTube);
    $stemTwo = new Stem(120, 3, 10, $headTube);

    $chart = new Chart(500, 500);
    $chart->createChart($headTube, $stemOne, $stemTwo, $imageFile);
