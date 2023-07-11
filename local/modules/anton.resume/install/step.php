<?
use \Bitrix\Main\Localization\Loc;

if(!check_bitrix_sessid()){
    return;
}

Loc::loadMessages(__FILE__);
?>
<form action="<?=$APPLICATION->GetCurPage()?>">
<?=bitrix_sessid_post()?>
    <input type="hidden" name="lang" value="<?= LANGUAGE_ID ?>">
    <input type="hidden" name="id" value="anton.resume">
    <input type="hidden" name="install" value="Y">
    <input type="hidden" name="step" value="2">
    <p><?= Loc::getMessage("MOD_INST_OPTIONS")?></p>
    <p><input type="checkbox" name="delltable" id="delltable">
       <label for="delltable"><?=Loc::getMessage("MOD_INST_MESS")?></label>
    </p>
    <input type="submit" value="<?= Loc::getMessage("MOD_INST_OK")?>">

</form>

