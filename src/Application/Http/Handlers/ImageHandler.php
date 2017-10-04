<?php

namespace Wouterds\IkHaat\Application\Http\Handlers;

use Slim\Http\Request;
use Slim\Http\Response;

class ImageHandler
{
    private const IMAGE = APP_DIR . '/resources/assets/images/ik-haat-wandelen.jpg';
    private const FONT = APP_DIR . '/resources/assets/fonts/Primrose.ttf';

    /**
     * @param Request $request
     * @param Response $response
     * @return Response
     */
    public function __invoke(Request $request, Response $response): Response
    {
        // BUG: We should be able to get this from attributes
        $content = $request->getUri()->getPath();
        $content = explode('.jpg', $content);
        $content = reset($content);
        $content = substr($content, 1, strlen($content) - 1);
        $content = urldecode($content);

        $img = $this->loadJpgFromFile(self::IMAGE);

        if(isset($content) && !empty($content)) {
            $t = substr(strtoupper($content), 0, 55);
            $f = self::FONT;
            $fs = 20;
            $c = imagecolorallocate($img, 35, 35, 35);

            imagettftext($img, $fs, 0, 300, 120, $c, $f, $this->wrap($fs, $f, $t, 173));
        }

        // Generate image & cache output to variable
        ob_start();
        imagejpeg($img);
        $image = ob_get_contents();
        ob_end_clean();

        // Destroy image resource
        imagedestroy($img);

        // Write output
        $response->getBody()->write($image);

        // Render with correct content type
        return $response->withHeader('Content-Type', 'image/jpeg');
    }

    private function loadJpgFromFile($path)
    {
        $img = @imagecreatefromjpeg($path);

        if ($img) {
            return $img;
        }

        $img  = imagecreatetruecolor(150, 30);
        $bgc = imagecolorallocate($img, 255, 255, 255);
        $tc  = imagecolorallocate($img, 0, 0, 0);

        imagefilledrectangle($img, 0, 0, 150, 30, $bgc);
        imagestring($img, 2, 10, 10, 'Error loading ' . $path, $tc);

        return $img;
    }

    private function wrap($fontSize, $fontFace, $string, $width)
    {
        $ret = "";
        $arr = explode(' ', $string);

        foreach ( $arr as $word ){
            $teststring = $ret.' '.$word;
            $testbox = imagettfbbox($fontSize, 0, $fontFace, $teststring);
            if ( $testbox[2] > $width ){
                $ret.=($ret==""?"":"\n").$word;
            } else {
                $ret.=($ret==""?"":' ').$word;
            }
        }

        return $ret;
    }
}
