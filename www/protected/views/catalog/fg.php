<?php $form=$this->beginWidget('CActiveForm', array(
    'id'=>'products-prices-form',
    'enableAjaxValidation'=>false,
)); ?>

<?php echo $form->errorSummary($model); ?>

<div class="row" style="margin-bottom: 5px;">
    <?php echo $form->labelEx($model,'product_id'); ?>
    <b><?=$model->product->name?></b>
    <?php echo $form->error($model,'product_id'); ?>
</div>

<div class="row">
    <?php echo $form->labelEx($model,'milling'); ?>
    <?php echo $form->textField($model,'milling'); ?>
    <?php echo $form->error($model,'milling'); ?>
</div>

<div class="row">
    <?php echo $form->labelEx($model,'polishing'); ?>
    <?php echo $form->textField($model,'polishing'); ?>
    <?php echo $form->error($model,'polishing'); ?>
</div>

<div class="row">
    <?php echo $form->labelEx($model,'first_coat'); ?>
    <?php echo $form->textField($model,'first_coat'); ?>
    <?php echo $form->error($model,'first_coat'); ?>
</div>

<div class="row">
    <?php echo $form->labelEx($model,'painting'); ?>
    <?php echo $form->textField($model,'painting'); ?>
    <?php echo $form->error($model,'painting'); ?>
</div>

<div class="row">
    <?php echo $form->labelEx($model,'varnish'); ?>
    <?php echo $form->textField($model,'varnish'); ?>
    <?php echo $form->error($model,'varnish'); ?>
</div>

<div class="row">
    <?php echo $form->labelEx($model,'assembling'); ?>
    <?php echo $form->textField($model,'assembling'); ?>
    <?php echo $form->error($model,'assembling'); ?>
</div>

<div class="row">
    <?php echo $form->labelEx($model,'packing_joiner'); ?>
    <?php echo $form->textField($model,'packing_joiner'); ?>
    <?php echo $form->error($model,'packing_joiner'); ?>
</div>

<div class="row">
    <?php echo $form->labelEx($model,'cant'); ?>
    <?php echo $form->textField($model,'cant'); ?>
    <?php echo $form->error($model,'cant'); ?>
</div>

<div class="row">
    <?php echo $form->labelEx($model,'weldment'); ?>
    <?php echo $form->textField($model,'weldment'); ?>
    <?php echo $form->error($model,'weldment'); ?>
</div>

<div class="row">
    <?php echo $form->labelEx($model,'metalwork'); ?>
    <?php echo $form->textField($model,'metalwork'); ?>
    <?php echo $form->error($model,'metalwork'); ?>
</div>

<div class="row">
    <?php echo $form->labelEx($model,'painting_metal'); ?>
    <?php echo $form->textField($model,'painting_metal'); ?>
    <?php echo $form->error($model,'painting_metal'); ?>
</div>

<div class="row">
    <?php echo $form->labelEx($model,'packing_metal'); ?>
    <?php echo $form->textField($model,'packing_metal'); ?>
    <?php echo $form->error($model,'packing_metal'); ?>
</div>

<div class="row buttons">
    <?php echo CHtml::submitButton('Сохранить', array('class'=>'btn btn-mini btn-success btn-add-production')); ?>
</div>

<?php $this->endWidget(); ?>
