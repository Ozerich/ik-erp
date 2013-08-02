<?php

    class note {
	
	/**
	 * path to the notes of the image
	 * @var string
	 * @access private
	 */	
	private $path;
	
	/**
	 * @description
	 * class constructor
	 *
	 * @param required	: string $folder // folder for notes
	 * @param required	: string $prefix // prefix
	 * @param required	: string $image // image
	 * @param required	: string $extension // extension for notes file
	 *
	 * @return		: none
	 *
	 * @access		: public
	 */
	public function __construct($folder, $prefix, $image, $extension) {
	    $this->path = $folder.$prefix.md5($image).$extension;
	}
	
	/**
	 * @description
	 * gets the note of the choosen image
	 *
	 * @param required	: none
	 *
	 * @return		: array
	 *
	 * @access		: public
	 */
	public function getNotes() {
	    
	    if (file_exists($this->path)) {
		
		$handle = fopen($this->path, 'r');
		
		$notes = $this->grabNotes(json_decode(fgets($handle)));
		
		fclose($handle);
		
		if (count($notes) > 0)
		    $notes = $this->sortNotes($notes);
		else
		    $notes = array();
		
	    } else
		$notes = array();
	    
	    return $notes;
	    
	}
	
	/**
	 * @description
	 * sort notes
	 *
	 * @param required	: array $notes // notes
	 *
	 * @return		: array
	 *
	 * @access		: private
	 */
	private function sortNotes($notes) {
	    
	    foreach ($notes as $key => $row)
		$x[$key] = sqrt($row['TOP']+$row['LEFT']);
	    
	    array_multisort($x, SORT_ASC, $notes);
	    
	    return $notes;
	    
	}
	
	/**
	 * @description
	 * grabs and transforms notes
	 *
	 * @param required	: array $notes // notes
	 *
	 * @return		: array
	 *
	 * @access		: private
	 */
	private function grabNotes($notes) {
	    
	    foreach ($notes as $note) {
		
		$newNotes[] = array(
		    'ID' => $note->ID,
		    'LEFT' => $note->LEFT,
		    'TOP' => $note->TOP,
		    'WIDTH' => $note->WIDTH,
		    'HEIGHT' => $note->HEIGHT,
		    'DATE' => $note->DATE,
		    'NOTE' => $note->NOTE,
		    'AUTHOR' => $note->AUTHOR,
		    'LINK' => $note->LINK
		);
		
	    }
	    
	    return $newNotes;
	    
	}
	
	/**
	 * @description
	 * adds a note to the choosen image
	 *
	 * @param required	: string $position // position of the note
	 * @param required	: string $note // value of the note
	 * @param required	: string $author // author of the note
	 * @param required	: string $link // link of the note
	 *
	 * @return		: none
	 *
	 * @access		: public
	 */
	public function addNote($position, $note, $author, $link) {
	    
	    $properties = $this->setNote($position, $note, $author, $link);
	    
	    if (!$properties)
		return false;
	    
	    $notes = $this->getNotes();
	    
	    $id = 0;
	    
	    foreach ($notes as $note) {
		
		if ($note['ID'] > $id)
		    $id = $note['ID'];
		
	    }
	    
	    $id++;
	    
	    $notes[] = array(
		'ID' => $id,
		'LEFT' => $properties['LEFT'],
		'TOP' => $properties['TOP'],
		'WIDTH' => $properties['WIDTH'],
		'HEIGHT' => $properties['HEIGHT'],
		'DATE' => $properties['DATE'],
		'NOTE' => $properties['NOTE'],
		'AUTHOR' => $properties['AUTHOR'],
		'LINK' => $properties['LINK']
	    );
	    
	    $this->saveNotes($notes);
	    
	    return true;
	
	}
	
	/**
	 * @description
	 * saves all notes to the *.note data
	 *
	 * @param required	: array $notes // notes
	 *
	 * @return		: none
	 *
	 * @access		: private
	 */
	private function saveNotes($notes) {
	    
	    $handle = fopen($this->path, 'w+');
	    
	    fwrite($handle, json_encode($notes));
	    
	    fclose($handle);
	    
	}
	
	/**
	 * @description
	 * deletes a note from the list of notes of the choosen image
	 *
	 * @param required	: int $id // id of the note
	 *
	 * @return		: none
	 *
	 * @access		: public
	 */
	public function deleteNote($id) {
	    
	    $notes = $this->getNotes();
	    
	    for ($i = 0; $i < count($notes); $i++) {
		
		if ($notes[$i]['ID'] == $id)
		    unset($notes[$i]);
		
	    }
	    
	    $this->saveNotes($notes);
	    
	    return true;
	    
	}
	
	/**
	 * @description
	 * edits the position and the value of a choosen note
	 *
	 * @param required	: int $id // id of the note
	 * @param required	: string $position // position of the note
	 * @param required	: string $note // value of the note
	 * @param required	: string $author // author of the note
	 * @param required	: string $link // link of the note
	 *
	 * @return		: none
	 *
	 * @access		: public
	 */
	public function editNote($id, $position, $note, $author, $link) {
	    
	    $properties = $this->setNote($position, $note, $author, $link);
	    
	    if (!$properties)
		return false;
	    
	    $notes = $this->getNotes();
	    
	    for ($i = 0; $i < count($notes); $i++) {
		
		if ($notes[$i]['ID'] == $id) {
		    
		    $notes[$i] = array(
			'ID' => $id,
			'LEFT' => $properties['LEFT'],
			'TOP' => $properties['TOP'],
			'WIDTH' => $properties['WIDTH'],
			'HEIGHT' => $properties['HEIGHT'],
			'DATE' => $properties['DATE'],
			'NOTE' => $properties['NOTE'],
			'AUTHOR' => $properties['AUTHOR'],
			'LINK' => $properties['LINK']
		    );
		    
		    break;
		    
		}
		
	    }
	    
	    $this->saveNotes($notes);
	    
	    return true;
	    
	}
	
	/**
	 * @description
	 * sets the position and the value of a new or edited note
	 *
	 * @param required	: string $position // position of the note
	 * @param required	: string $note // value of the note
	 * @param required	: string $author // value of the author
	 * @param required	: string $link // link of the note
	 *
	 * @return		: array
	 *
	 * @access		: private
	 */
	private function setNote($position, $note, $author, $link) {
	    
	    $position = explode(',', $position);
	    
	    if (count($position) != 4)
		return false;
	    
	    if (empty($note))
		$note = '';
	    
	    $note = str_replace("\n", ' ', $note);
	    
	    while(strstr($note, '  '))
		$note = str_replace('  ', ' ', $note);
	    
	    $note = trim($note, ' ');
	    
	    if (empty($author))
		$author = '';
	    
	    if (empty($link) || !$this->isValidLink($link))
		$link = '';
	    
	    if (empty($note) && empty($link))
		return false;
	    
	    return array(
		'LEFT' => $position[0],
		'TOP' => $position[1],
		'WIDTH' => $position[2],
		'HEIGHT' => $position[3],
		'DATE' => array(
		    'Y' => date('Y', time()),
		    'M' => date('m', time()),
		    'D' => date('d', time()),
		    'H' => date('H', time()),
		    'I' => date('i', time())
		),
		'NOTE' => $note,
		'AUTHOR' => $author,
		'LINK' => $link
	    );
	
	}
	
	/**
	 * @description
	 * check valid uri
	 *
	 * @param required	: string $link // link of note
	 *
	 * @return		: boolean
	 *
	 * @access		: private
	 */
	private function isValidLink($link) {
	    return preg_match('/^(https?:\/\/){1}+[a-z0-9-]+(\.[a-z0-9-]+)*\.([a-z]{2,6})(.*?)$/i', $link);
	}
	
    }

?>