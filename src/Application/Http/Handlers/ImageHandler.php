<?php

namespace Wouterds\KabouterWesley\Application\Http\Handlers;

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
    public function __invoke(Request $request, Response $response, string $text): Response
    {
        $img = $this->loadJpgFromFile(self::IMAGE);

        if (!empty($text)) {
            $t = substr(strtoupper($text), 0, 55);
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

    /**
     * @param string $path
     * @return resource
     */
    private function loadJpgFromFile(string $path)
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

    /**
     * @param int $fontSize
     * @param string $fontFace
     * @param string $text
     * @param int $maxWidth
     * @return string
     */
    private function wrap(int $fontSize, string $fontFace, string $text, int $maxWidth): string
    {
        // Split words by space
        $words = explode(' ', $text);

        $wrappedText = '';
        foreach ($words as $word ) {
            $testText = $wrappedText . ' ' . $word;
            $testBox = imagettfbbox($fontSize, 0, $fontFace, $testText);

            if ($testBox[2] > $maxWidth ) {
                $wrappedText .= (empty($wrappedText) ?  '' : PHP_EOL) . $word;
                continue;
            }

            $wrappedText .= (empty($wrappedText) ?  '' : ' ') . $word;
        }

        return $wrappedText;
    }
}
