<?

namespace Anton\Resume;

use Bitrix\Main\ORM\Data\DataManager;
use Bitrix\Main\ORM\Fields;
use Bitrix\Main\ORM\Fields\Relations;
use \Bitrix\Main\Type;

class NotebookTable extends DataManager
{
    public static function getTableName()
    {
        return 'notebook_resume';
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
            new Fields\StringField('DESCRIPTION', array(
                'required' => true,
            )),
            new Fields\FloatField('PRICE',array(
                'required' => true,
            )
            ),
            new Fields\DateField('DateField', array(
                'default_value' => new Type\Date
            )),
            new Fields\IntegerField('PHOTO'),
            new Fields\IntegerField('MODEL_ID'),
            new Relations\Reference(
                'MODEL',
                '\Anton\Resume\ModelTable',
                array('=this.MODEL_ID' => 'ref.ID')
            ),
            new Fields\IntegerField('OPTION_ID'),
            new Relations\Reference(
                'OPTION',
                '\Anton\Resume\OptionsTable',
                array('=this.OPTION_ID' => 'ref.ID')
            )
        );
    }        
}