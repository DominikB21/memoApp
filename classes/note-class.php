<?php

class Note extends DbHandler{

//---------- CREATE NOTE METHOD ----------  

  protected function setNote($userId, $content, $visibility){
    $stmt = $this->connect()->prepare('INSERT INTO notes (fk_user_id, content, visibility) VALUES (?, ?, ?);');

    if(!$stmt->execute(array($userId, $content, $visibility))){
      $stmt = null;
      header("location: ../home.php?error=stmtFailed");
      exit();
    }

    $stmt = null;
  }

//---------- READ NOTES FUNCTION ----------

  protected function getNotes($userId){
    $stmt = $this->connect()->prepare('SELECT * FROM notes WHERE visibility = "public" OR fk_user_id = ?;');

    if(!$stmt->execute(array($userId))){
      $stmt = null;
      header("location: ../home.php?error=stmtFailed");
      exit();
    }

    return $stmt->fetchAll(PDO::FETCH_ASSOC);
  }

//---------- UPDATE NOTE METHOD ----------

  protected function updateNote($content, $visibility, $noteId, $userId){
    $stmt = $this->connect()->prepare('UPDATE notes SET content = ? , visibility = ? WHERE id = ? AND fk_user_id = ?;');

    if(!$stmt->execute(array($content, $visibility, $noteId, $userId))){
      $stmt = null;
      header("location: ../home.php?error=stmtFailed");
      exit();
    }

    $stmt = null;
  }

//---------- DELETE NOTE METHOD ----------

  protected function deleteNote($noteId, $userId){
    $stmt = $this->connect()->prepare('DELETE FROM notes WHERE id = ? AND fk_user_id = ?;');

    if(!$stmt->execute(array($noteId, $userId))){
      $stmt = null;
      header("location: ../home.php?error=stmtFailed");
      exit();
    }

    $stmt = null;
  }

}