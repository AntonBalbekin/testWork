<?
namespace App\Action\User;

use Psr\Container\ContainerInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use App\Renderer\JsonRenderer;

class UserFindAction
{
    protected $container;

    public function __construct(ContainerInterface $container) {
        $this->container = $container;
    }
 
    public function __invoke(ServerRequestInterface $request, ResponseInterface $response, array $args): ResponseInterface
    {
         // your code to access items in the container... $this->container->get('');
         $response->getBody()->write("Hello, actions");
         sleep(15);
         return $response;
    }

}