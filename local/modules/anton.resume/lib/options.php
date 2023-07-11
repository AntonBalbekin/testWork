<?

namespace Anton\Resume;

use Bitrix\Main\ORM\Data\DataManager;
use Bitrix\Main\ORM\Fields;

class OptionsTable extends DataManager
{
    public static function getTableName()
    {
        return 'options_resume';
    }
    public static function getMap()
    {
        return array(
            new Fields\IntegerField('ID', array(
                'primary' => true,
                'autocomplete' => true
            )),
            //Название
            new Fields\StringField('NAME', array(
                'required' => true,
            )),
        );
    } 
}