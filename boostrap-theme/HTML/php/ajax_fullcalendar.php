<?php
/*
* Full calendar ajax load events example
* Virgo admin template
* by Aqvatarius
*/

    $hour  = date('H');
    $min   = date('i');
    $month = date('m');
    $day   = date('d');
    $year  = date('Y');
    
    $data = array();
    $data[] = array('id'=>'1','title'=>'Ajax event (:','start'=>mktime($hour,$min,0,$month,5,$year),'className'=>'green');
    $data[] = array('id'=>'2','title'=>'Ajax long event','start'=>mktime($hour,$min,0,$month,8,$year),'end'=>mktime($hour,$min,0,$month,15,$year),'className'=>'red');    
    $data[] = array('id'=>'3','title'=>'Me gusta','start'=>mktime($hour,$min,0,$month,18,$year),'className'=>'orange');
    $data[] = array('id'=>'4','title'=>'Today :)','start'=>mktime($hour,$min,0,$month,$day,$year));
    $data[] = array('id'=>'5','title'=>'Make an amazing template','start'=>mktime($hour,$min,0,$month,26,$year),'end'=>mktime($hour,$min,0,$month,29,$year),'className'=>'purple');
    
    echo json_encode($data);

?>