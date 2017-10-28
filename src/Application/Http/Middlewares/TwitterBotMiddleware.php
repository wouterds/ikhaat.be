<?php

namespace Wouterds\KabouterWesley\Application\Http\Middlewares;

use Slim\Http\Request;
use Slim\Http\Response;
use Wouterds\KabouterWesley\Application\Http\Handlers\TwitterBotImageHandler;

class TwitterBotMiddleware
{
    /**
     * @var TwitterBotImageHandler
     */
    private $twitterBotImageHandler;

    /**
     * @param TwitterBotImageHandler $twitterBotImageHandler
     */
    public function __construct(TwitterBotImageHandler $twitterBotImageHandler)
    {
        $this->twitterBotImageHandler = $twitterBotImageHandler;
    }

    /**
     * @param Request $request
     * @param Response $response
     * @param Callable $next
     * @return Response
     */
    public function __invoke(Request $request, Response $response, $next): Response
    {
        $forceImage = !empty($request->getParam('fi'));

        // Can we do our magic?
        if ($forceImage !== true) {
            // Get UA
            $userAgent = reset($request->getHeader('User-Agent'));

            // Twitter bot
            if (stripos($userAgent, 'TwitterBot') !== false) {
                $next = $this->twitterBotImageHandler;
            }
        }

        return $next($request, $response);
    }
}
