<?php
namespace  Anton\Resume\ReadMassage;
use PhpAmqpLib\Connection\AMQPStreamConnection;
use \Bitrix\Main\Loader;
Loader::includeModule('pull');
class ReadMassage
{

    public function readMessage(){
        $connection = new AMQPStreamConnection('localhost', 5672, 'guest', 'guest');
        $channel = $connection->channel();
        $channel->queue_declare('hello', false, false, false, false);
        $channel->basic_consume('hello', '', false, true, false, false, self::setMessage());
        while ($channel->is_open()) {
            $channel->wait();
        }
        
        $channel->close();
        $connection->close();
    }

    public static function setMessage(){

        return [
            'MODULE_ID' => "anton.resume",
            'USE' => Array("PUBLIC_SECTION")
        ];

    }


}

?>