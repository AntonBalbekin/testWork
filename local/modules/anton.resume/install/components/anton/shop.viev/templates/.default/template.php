<div class="mt-5">
    <div class="mt-3 mb-3">
        <h1><?=$arParams['notebook'];?></h1>
    </div>
    <div class="d-flex  border border-secondary text-center rounded">
        <div class="d-block col-3">
            <h2 class='p-3 text-light bg-dark'>Производитель</h2>
            <p><?=$arResult['bookInfo'][0]['MANUFAC'];?></p>
        </div>
        <div class="d-block col-2">
            <h2 class='p-3 text-light bg-dark'>Цена</h2>
            <p><?=$arResult['bookInfo'][0]['PRICE'];?></p>
        </div>
        <div class="d-block col-2">
            <h2 class='p-3 text-light bg-dark'>Модель</h2>
            <p><?=$arResult['bookInfo'][0]['MODELNAME'];?></p>
        </div>
        <div class="d-block col-2">
            <h2 class='p-3 text-light bg-dark'>Опция</h2>
            <p><?=$arResult['bookInfo'][0]['OPTIONNAME'];?></p>
        </div>
        <div class="d-block col-3">
            <h2 class='p-3 text-light bg-dark'>Дата поставки</h2>
            <p><?=$arResult['bookInfo'][0]['DateField']->format('d.m.Y');?></p>
        </div>
        
    </div>
    <div class="mt-5 justify-content-between border border-secondary rounded">
        <h2 class='p-3'>Описание</h2>
        <p class='p-3'>Lorem ipsum dolor, sit amet consectetur adipisicing elit.
             Voluptatum a debitis assumenda <?=$arResult['bookInfo'][0]['DESCRIPTION'];?> reprehenderit doloremque ullam soluta molestiae temporibus quos laboriosam quidem sunt error velit iure,
              laudantium officia ipsa. Ratione, itaque!</p>
    </div>
</div>
