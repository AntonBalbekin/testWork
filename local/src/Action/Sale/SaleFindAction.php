<?
namespace App\Action\Sale;

use Psr\Container\ContainerInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use PhpAmqpLib\Connection\AMQPStreamConnection;
use PhpAmqpLib\Message\AMQPMessage;
use App\Renderer\JsonRenderer;

class SaleFindAction
{
    protected $container;

    public function __construct(ContainerInterface $container) {
        $this->container = $container;
    }
 
    public function __invoke(ServerRequestInterface $request, ResponseInterface $response, array $args): ResponseInterface
    {
         // your code to access items in the container... $this->container->get('');

         
         $connection = new AMQPStreamConnection('localhost', 5672, 'guest', 'guest');
         $channel = $connection->channel();
         $channel->queue_declare('hello', false, false, false, false); 
         $msg = new AMQPMessage('Hello World!');
         $channel->basic_publish($msg, '', 'hello');
         $channel->close();
         $connection->close();

         
         $response->getBody()->write('d');
         return $response;
    }

}