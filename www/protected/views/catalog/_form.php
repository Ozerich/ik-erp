<?php $form=$this->beginWidget('CActiveForm', array(
    'id'=>'products-prices-form',
    'enableAjaxValidation'=>false,
)); ?>

<div id="order_form" class="modal" aria-hidden="true">
    <div class="modal-header">
        <a href="/catalog/page/<?=$_GET['page']?>">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
        </a>
        <h3 id="myModalLabel">Редактирование цен</h3>
    </div>
    <div class="row-fluid">

        <!--        <ul class="nav nav-tabs">
                    <li class="active"><a href="#order_params">Параметры</a></li>
                    <li><a href="#order_install">Монтаж</a></li>
                    <li><a href="#order_products">Продукция</a></li>
                </ul>-->

        <div class="tab-content">
            <div class="tab-pane active" id="order_params">

                <div class="block-fluid">
                    <?php
                    if ($model->hasErrors())
                    {
                    ?>
                    <div class="row-form">
                        <div class="span4">Ошибки:</div>
                        <div class="span8">
                            <?php echo $form->errorSummary($model); ?>
                        </div>
                    </div>
                    <?php
                    }
                    ?>
                    <div class="row-form">
                        <div class="span4">Наименование:</div>
                        <div class="span8">
                            <b><?php echo $model->product->name;?></b>
                        </div>
                    </div>
                    <div class="row-form" data-bind="css: {'error': errors.shipping_date_error().length}">
                        <div class="span4">Фрезеровка:</div>
                        <div class="span8">
                            <?php echo $form->textField($model,'milling'); ?>
                        </div>
                    </div>
                    <div class="row-form">
                        <div class="span4">Шлифовка:</div>
                        <div class="span8">
                            <?php echo $form->textField($model,'polishing'); ?>
                        </div>
                    </div>
                    <div class="row-form" data-bind="css: {'error': errors.worker_error().length}">
                        <div class="span4">Грунтовка:</div>
                        <div class="span8">
                            <?php echo $form->textField($model,'first_coat'); ?>
                        </div>
                    </div>
                    <div class="row-form" data-bind="css: {'error': errors.customer_error().length}">
                        <div class="span4">Покраска:</div>
                        <div class="span8">
                            <?php echo $form->textField($model,'painting'); ?>
                        </div>
                    </div>
                    <div class="row-form">
                        <div class="span4">Лак:</div>
                        <div class="span8">
                            <?php echo $form->textField($model,'varnish'); ?>
                        </div>
                    </div>
                    <div class="row-form">
                        <div class="span4">Сборка:</div>
                        <div class="span8">
                            <?php echo $form->textField($model,'assembling'); ?>
                        </div>
                    </div>
                    <div class="row-form">
                        <div class="span4">Упаковка и маркировка:</div>
                        <div class="span8">
                            <?php echo $form->textField($model,'packing_joiner'); ?>
                        </div>
                    </div>
                    <div class="row-form">
                        <div class="span4">ФОТ Брус:</div>
                        <div class="span8">
                            <?php echo $form->textField($model,'cant'); ?>
                        </div>
                    </div>
                    <div class="row-form">
                        <div class="span4">Сварка:</div>
                        <div class="span8">
                            <?php echo $form->textField($model,'weldment'); ?>
                        </div>
                    </div>
                    <div class="row-form">
                        <div class="span4">Слесарка:</div>
                        <div class="span8">
                            <?php echo $form->textField($model,'metalwork'); ?>
                        </div>
                    </div>
                    <div class="row-form">
                        <div class="span4">Малярные работы:</div>
                        <div class="span8">
                            <?php echo $form->textField($model,'painting_metal'); ?>
                        </div>
                    </div>
                    <div class="row-form">
                        <div class="span4">Упаковка и маркировка:</div>
                        <div class="span8">
                            <?php echo $form->textField($model,'packing_metal'); ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>
    <div class="modal-footer">
        <?php echo CHtml::submitButton('Сохранить', array('class'=>'btn btn-primary')); ?>
    </div>
</div>
<?php $this->endWidget(); ?>