<?php

/** Tests for facedetection */
return function () : Generator {
    /** An image with a face gets detected */
    yield function () {
        $detector = new Sensi\Facial\Detector;
        $result = $detector->faceDetect(dirname(__DIR__).'/resources/face.jpg');
        assert($result === true);
    };

    /** An image without a face returns false */
    yield function () {
        $detector = new Sensi\Facial\Detector;
        $result = $detector->faceDetect(dirname(__DIR__).'/resources/noface.jpg');
        assert($result === false);
    };
};

