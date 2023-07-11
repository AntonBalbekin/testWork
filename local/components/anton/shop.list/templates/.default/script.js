$(document).ready(function () {
    $('#addManuf').on('click',function(){
        let content=`<div>
                        <h2>
                            Добавить компанию    
                        </h2>
                    </div>
                    <div class="ui-ctl ui-ctl-textbox ">
                        <div class="ui-ctl-tag">новый</div>
                        <input id="company_name" type="text" class="ui-ctl-element">
                    </div>`;
        var popup = BX.PopupWindowManager.create("popup-add",null,{
            content:content,
            width:300,
            height:200,
            closeByEsc: true,
            closeIcon: {
                 opacity: 1
            },
            overlay: {
                // объект со стилями фона
                backgroundColor: 'black',
                opacity: 500
            }, 
            buttons: [
                new BX.PopupWindowButton({
                    text: 'Добавить', // текст кнопки
                    id: 'save-btn', // идентификатор
                    className: 'btn btn-ligt', // доп. классы
                    events: {
                    click: function() {
                        let data=[];
                        data.push($('#company_name').val());
                        BX.ajax.runComponentAction('anton:shop.list','addManufactere',{
                            mode:'class',
                            data:{data}
                        }).then(function(response){
                            console.log(response)
                            if(response.data.error){
                                alert(response.data.error)
                            }else{
                                alert('Компания добавлена')
                                popup.close();
                            }
                        }),function(response){
                        }    
                        
                    }
                    }
                })
            ]   
            })
        popup.show(); 
    })
});