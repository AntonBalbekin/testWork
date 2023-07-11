<?

namespace Anton\Resume;

use Bitrix\Main\ORM\Data\DataManager;
use Bitrix\Main\ORM\Fields;
use Bitrix\Main\ORM\Fields\Relations;

class ModelTable extends DataManager
{
    public static function getTableName()
    {
        return 'model_resume';
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
            new Fields\IntegerField('MANUFACTURER_ID'),
            new Relations\Reference(
                'MANUFACTURER',
                '\Anton\Resume\ManufacturerTable',
                array('=this.MANUFACTURER_ID' => 'ref.ID')
            )
        );
    }        
}