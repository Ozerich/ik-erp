<?php

class ProductionController extends Controller
{
    public function actionIndex()
    {
        $this->pageTitle = 'Производство';
        $this->pageId = 'production';

        if (isset($_POST['submit'])) {
            $order_id = (int)$_POST['order_id'];

            if (isset($_POST['doneArr'])) {
                foreach ($_POST['doneArr'] as $key => $value) {
                    if ($value == 0) continue;

                    $save = OrdersDone::model()->findByAttributes(array('order_id' => $order_id, 'product_id' => $key, 'date' => date('d.m')));
                    if (!$save) {
                        $save = new OrdersDone;
                        $save->product_id = $key;
                        $save->order_id = $order_id;
                        $save->date = date("d.m");
                    }

                    $save->done = $value;
                    $save->save();
                }
            }

            $this->redirect('/production');
        }
        $this->render('index');
    }

    public function actionAjaxDate()
    {
        if (Yii::app()->request->isAjaxRequest) {
            $id = Yii::app()->request->getPost('id');
            $order = Order::model()->findByPk($id);
            if ($order != NULL) {
                $order->shipping_date = $order->fact_shipping_date;
                $order->save();
            }
            Yii::app()->end();
        }
        $this->redirect(array('index'));
    }

    public function actionAjaxNewDate()
    {
        if (Yii::app()->request->isAjaxRequest) {
            $id = Yii::app()->request->getPost('id');
            $date = Yii::app()->request->getPost('date');
            $order = Order::model()->findByPk($id);
            if ($order != NULL) {
                if (!empty($date)) {
                    $order->date = $date;
                    $order->save();
                }
            }
            Yii::app()->end();
        }
        $this->redirect(array('index'));
    }

    public function actionPrint()
    {
        if (isset($_POST['print'])) {
            $html = $_POST['print'];
            Yii::import("application.extensions.MPDF56.mPDF");
            $mpdf = new mPDF('utf-8', 'A4', '15', '', 10, 10, 7, 7, 10, 10, 'l');
            $mpdf->debug = true;
            $mpdf->list_indent_first_level = 0;
            $mpdf->WriteHTML($html, 2);
            $mpdf->Output(iconv('UTF-8', 'CP1251', time()) . '.pdf', 'D');
        } else
            $this->render('print');

    }

    public function getMonthForTable($month)
    {
        $month = (int)$month;
        $monthArray = array(
            '1' => 'января',
            '2' => 'февраля',
            '3' => 'марта',
            '4' => 'апреля',
            '5' => 'мая',
            '6' => 'июня',
            '7' => 'июля',
            '8' => 'августа',
            '9' => 'сентября',
            '10' => 'октября',
            '11' => 'ноября',
            '12' => 'декабря',
        );
        return $monthArray[$month];
    }

    public function getDayForTable($day)
    {
        $days = array(
            '1' => 'пн',
            '2' => 'вт',
            '3' => 'ср',
            '4' => 'чт',
            '5' => 'пт',
            '6' => 'сб',
            '0' => 'вск',
        );
        return $days[$day];
    }

    public function getMonth($month)
    {
        $month = (int)$month;
        $monthArray = array(
            '1' => 'Январь',
            '2' => 'Февраль',
            '3' => 'Март',
            '4' => 'Апрель',
            '5' => 'Май',
            '6' => 'Июнь',
            '7' => 'Июль',
            '8' => 'Август',
            '9' => 'Сентябрь',
            '10' => 'Октябрь',
            '11' => 'Ноябрь',
            '12' => 'Декабрь',
        );
        return $monthArray[$month];
    }

    public function getDivision($id)
    {
        if ($id == 1) {
            return 'Красивый город Спб';
        } elseif ($id == 2) {
            return 'Красивый город Москва';
        } elseif ($id == 3) {
            return 'Петроплан';
        } else {
            return '';
        }
    }

    public function needInstall(Order $order)
    {
        if ($order->need_install) {
            return 'Монтаж: ' . $order->install_address;
        } else
            return 'Самовывоз';
    }
}