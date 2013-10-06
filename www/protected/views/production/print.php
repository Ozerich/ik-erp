<div id="printBody">
    <div style="width: 680px; background: #ffffff; text-align: center; margin: 0 auto;">
        <div>
            <img src="<?=Yii::app()->baseUrl?>/img/logo.jpg" style="float: left;">
            <h2 style="float: right;"><?=$this->getMonth(date('m'))?> <?=date('Y')?></h2>
        </div>

        <div style="clear:both;"></div>

        <?php
        if (isset($_POST['printArr']))
        {
            foreach($_POST['printArr'] as $id)
            {
                $order = Order::model()->findByPk($id);
                $dateStart = explode('-',$order->date_start);
                $dateFact = explode('-',$order->shipping_date);
                ?>
                <table border="1" style="margin-bottom 20px; border-color: black;border-collapse: collapse;">
                    <tr>
                        <td style="background: #bfbfbf; font-size: 18px; text-align: center"><?=$dateFact[2].".".$dateFact[1]?></td>
                        <td style="background: #bfbfbf; font-size: 18px; text-align: center">Заказ № <?=$id?> от <?=$dateStart[2]?>.<?=$dateStart[1]?></td>
                        <td style="background: #bfbfbf; font-size: 18px; text-align: center" colspan="2"><?=$this->getDivision($order->division)?>,<?=$order->customer?></td>
                        <td style="background: #bfbfbf; font-size: 18px;  text-align: center" colspan="4"><?=$this->needInstall($order)?></td>
                    </tr>
                    <tr>
                        <td style="background: #bfbfbf; text-align: center">Арт.</td>
                        <td style="background: #bfbfbf; text-align: center">Наименование</td>
                        <td style="background: #bfbfbf; text-align: center">Кол-во</td>
                        <td style="background: #bfbfbf; text-align: center">Отгружено</td>
                        <td style="background: #bfbfbf; text-align: center">Коментарии</td>
                        <td style="background: #bfbfbf; text-align: center">Ф</td>
                        <td style="background: #bfbfbf; text-align: center">М</td>
                        <td style="background: #bfbfbf; text-align: center">Д</td>
                    </tr>
                    <?php
                    foreach($order->order_products as $item)
                    {
                    ?>
                    <tr>
                        <td><?=$item->product->articul?></td>
                        <td><?=$item->product->name?></td>
                        <td><?=$item->count?></td>
                        <td>0</td>
                        <td><?=$item->comment?></td>
                        <td style="<?=($item->state_1)?"background: #bfbfbf":""?>"></td>
                        <td style="<?=($item->state_2)?"background: #bfbfbf":""?>"></td>
                        <td style="<?=($item->state_3)?"background: #bfbfbf":""?>"></td>
                    </tr>
                    <?php
                    }
                    ?>
                </table>
                <div style="margin: 5px;"></div>
                <?php
            }
        }
        ?>
    </div>
</div>
<div>
    <form method="POST" id="print">
        <textarea style="display:none;" name="print" id="contentPrint"></textarea>
        <input type="submit" class="btn btn-primary" style="float: right" value="Печать документа">
    </form>
</div>

<script type="text/javascript">
    $(document).ready(function(){
        $('#contentPrint').html($('#printBody').html());
    });
</script>