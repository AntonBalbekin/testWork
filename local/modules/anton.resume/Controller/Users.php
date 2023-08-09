<?
namespace Anton\Resume\Controller;

use \Bitrix\Main\Engine\Controller;
use Bitrix\Main\Engine\ActionFilter;
use Bitrix\Main\HttpResponse;
use Anton\Resume\Actions\UserActions;

class Users extends Controller
{



    public function getDefaultPreFilters(): array
    {
        return [
            new ActionFilter\Authentication(),
           /* new ActionFilter\HttpMethod(
                [ActionFilter\HttpMethod::METHOD_GET, ActionFilter\HttpMethod::METHOD_POST]
            )*/
            //new ActionFilter\Csrf(),
        ];
    }

    public function getAction(){
        $test=$this->request;
        $action=new UserActions;
        
        if($action->addQuane()){
            $response= new HttpResponse;
            $response->setStatus('201');
            $response->addHeader('test','qwasa');
            return $response;
        }else{
            $response= new HttpResponse;
            $response->setStatus('401');
            $response->addHeader('test','qwasa');
            return $response;
        }

    }

}