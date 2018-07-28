<?php

namespace Wouterds\KabouterWesley\Application\Http\Handlers;

use Slim\Http\Request;
use Slim\Http\Response;

class TwitterBotImageHandler extends ViewHandler
{
    /**
     * @return string
     */
    public function getTemplate(): string
    {
        return 'twitter-bot.html.twig';
    }

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

        return $this->render($response, [
            'title' => $content . ' - ' . getenv('APP_NAME'),
            'content' => $content,
            'twitterAccount' => getenv('TWITTER_ACCOUNT'),
            'twitterImage' => getenv('APP_URL') . $request->getUri()->getPath() . '?fi=1',
            'url' => getenv('APP_URL'),
        ]);
    }
}
