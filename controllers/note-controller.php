<?php

class NoteController extends Note{
  private $userId;
  private $content;
  private $visibility;
  private $noteId;

  public function __construct($userId, $content, $visibility, $noteId){
    $this->userId = $userId;
    $this->content = $content;
    $this->visibility = $visibility;
    $this->noteId = $noteId;
  }

  public function createNote(){
    if(!$this->emptyInput()){
      header("location: ../home.php?error=emptyInput");
      exit();
    }

    if(!$this->visibilityInput()){
      header("location: ../home.php?error=invalidVisibilityInput");
      exit();
    }

    $this->setNote($this->userId, $this->content, $this->visibility);

  }

  public function showNotes(){
    return $this->getNotes($this->userId);
  }

  public function changeNote(){
    if(!$this->emptyInput()){
      header("location: ../home.php?error=emptyInput");
      exit();
    }

    if(!$this->visibilityInput()){
      header("location: ../home.php?error=invalidVisibilityInput");
      exit();
    }

    if(!$this->invalidNoteId()){
      header("location: ../home.php?error=invalidNoteId");
      exit();
    }

    $this->updateNote($this->content, $this->visibility, $this->noteId, $this->userId);
  }

  public function removeNote(){
  
    if(!$this->invalidNoteId()){
      header("location: ../home.php?error=invalidNoteId");
      exit();
    }
  

    $this->deleteNote($this->noteId, $this->userId);
  }

// ------- ERROR HANDLERS ------

  // Checking for empty input

  private function emptyInput(){
    $result = false;

    if(empty($this->content)){
      $result = false;
    }else{
      $result = true;
    }

    return $result;
  }

  // Checking visibility input

  private function visibilityInput(){
    $result = false;

    
    if($this->visibility == "private" || $this->visibility == "public"){
      $result = true;
    }else{
      $result = false;
    }

    return $result;
  }

  // Checking noteId type

  private function invalidNoteId(){
    $result = false;

    if(!is_numeric($this->noteId)){
      $result = false;
    }else{
      $result = true;
    }

    return $result;
  }

}