<?php
declare(strict_types=1);

namespace App\Application\Actions\Auth;

use App\Application\Middlewares\LoginAuth;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Log\LoggerInterface;
use Slim\Views\Twig;
use SlimSession\Helper as Session;

final class LoginAuthAction extends AuthAction
{
    /** @var Session $session */
    private $session;

    public function __construct(LoggerInterface $logger, Twig $twig, Session $session)
    {
        parent::__construct($logger, $twig);
        $this->session = $session;
    }

    protected function action(): Response
    {
        $this->session->set(LoginAuth::SESSION_KEY, 1);
        $referer = $this->request->getServerParams()['HTTP_REFERER'];
        return $this->response->withHeader('Location', $referer);
    }
}
