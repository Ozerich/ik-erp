<?php

class PaymentsController extends Controller
{
    public function actionIndex()
    {
        $this->pageTitle = 'Оплата труда';
        $this->pageId = 'production';

        if (isset($_GET['year'])) {
            $year = $_GET['year'];
        } else
            $year = date("Y");
        if (isset($_GET['month'])) {
            $month = $_GET['month'];
            if ($month == 0) {
                $month = 12;
                $year--;
                $_GET['month'] = $month;
                $_GET['year'] = $year;
            } elseif ($month == 13) {
                $month = 1;
                $year++;
                $_GET['month'] = $month;
                $_GET['year'] = $year;
            }
            if ($month < 10)
                $month = '0' . $month;
        } else
            $month = date("m");
        $date = $year . '-' . $month . '-';
        $date = addcslashes($date, '%_');
        $criteria = new CDbCriteria(array(
            'condition' => 'date_status LIKE :date',
            'order' => 'date_status',
            'params' => array(
                ':date' => $date . '%',
            ),
        ));
        $orders_all = Order::model()->findAll($criteria);
        $orders = array();
        foreach ($orders_all as $order) {
            if ($order->isShipped) {
                $orders[] = $order;
            }
        }
        $this->render('index', array(
            'orders' => $orders,
            'month' => $month,
            'year' => $year,
        ));
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

    public function getDivision($division)
    {
        if ($division == 1)
            return 'Красивый город Спб';
        elseif ($division == 2)
            return 'Красивый город Москва'; else
            return 'Петроплан';
    }

}