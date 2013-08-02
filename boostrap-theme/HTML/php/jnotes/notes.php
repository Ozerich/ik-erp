<?php

    include 'notes.class.php';

    if (isset($_POST['image']) && !empty($_POST['image']))
	$oNote = new note('../../assets/notes/', '', (string) strip_tags($_POST['image']), '.note');
    
    if (isset($_POST['id']) && !empty($_POST['id']))
	$id = (int) strip_tags($_POST['id']);
    
    if (isset($_POST['position']) && !empty($_POST['position']))
	$position = $_POST['position'];
    
    if (isset($_POST['note']) && !empty($_POST['note']))
	$note = (string) strip_tags($_POST['note']);
    
    if (isset($_POST['author']) && !empty($_POST['author']))
	$link = (string) strip_tags($_POST['author']);
    
    if (isset($_POST['link']) && !empty($_POST['link']))
	$link = (string) strip_tags($_POST['link']);
    
    if (isset($_POST['author']) && !empty($_POST['author']))
	$author = (string) strip_tags($_POST['author']);
    
    if (isset($_POST['get']) && !empty($_POST['get']))
	echo json_encode($oNote->getNotes());
    
    if (isset($_POST['add']) && !empty($_POST['add']))
	echo json_encode($oNote->addNote($position, $note, $author, $link));
    
    if (isset($_POST['delete']) && !empty($_POST['delete']))
	echo json_encode($oNote->deleteNote($id));
    
    if (isset($_POST['edit']) && !empty($_POST['edit']))
	echo json_encode($oNote->editNote($id, $position, $note, $author, $link));

?>