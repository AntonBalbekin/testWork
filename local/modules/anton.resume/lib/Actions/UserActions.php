<?
namespace Anton\Resume\Actions;

use PhpAmqpLib\Connection\AMQPStreamConnection;
use PhpAmqpLib\Message\AMQPMessage;

class UserActions
{
    public function addQuane():bool{
        
        $connection = new AMQPStreamConnection('localhost', 5672, 'guest', 'guest');
        if($connection ){
            $channel = $connection->channel();
            $channel->queue_declare('hello', false, false, false, false); 
            $msg = new AMQPMessage('Hello World!');
            $channel->basic_publish($msg, '', 'hello');
            $channel->close();
            $connection->close();
            return true;
        }else{
            return false;
        }

    }

}