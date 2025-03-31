<?php

session_start();

if(!isset($_SESSION["status"])){
  header("location: ./index.php");
}

include "./classes/db_connect.php";
include "./classes/note-class.php";
include "./controllers/note-controller.php";

$notes = new NoteController($_SESSION["id"],"","","");
$allNotes = $notes->showNotes();



?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Notes</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
  <link rel="icon" type="image/svg" href="https://www.svgrepo.com/show/484546/notepad.svg">
  <style>
    <?php include "style.scss"; ?>
  </style>
</head>
<body>

<div class="page-container">
<div class="content-wrap">

<!-- Navbar -->

<div id="navbar">
  <nav class="navbar bg-dark border-bodys">
    <div class="container-fluid justify-content-between">
      <a class="navbar-brand text-light" href="./home.php">Memo-App</a>
   
     <div class="d-flex align-items-center">
       <p class="text-light me-3" id="userBtn"><?php echo $_SESSION["firstName"] . " " . $_SESSION["lastName"]; ?></p>

       <!-- Delete button modal -->

       <button type="button" class="btn btn-outline-danger me-2" data-bs-toggle="modal" data-bs-target="#deleteAccountModal">Delete account</button>
       
       <div class="modal fade" id="deleteAccountModal" tabindex="-1" aria-labelledby="deleteAccountLabel" aria-hidden="true">
        <div class="modal-dialog">
          <div class="modal-content">
            <div class="modal-header">
              <h1 class="modal-title fs-5" id="deleteAccountModalLabel">
                Are you sure?
              </h1>
              <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
              After deleting your account all your notes will be permanently removed.
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
              <a href="./delete-account.php" class="btn btn-danger me-2" type="button">Delete account</a>
            </div>
          </div>
        </div>
       </div>

       <a href="./logout.php" class="btn btn-outline-primary me-2" type="button">Log out</a>

      </div>
    </div>
  </nav>
</div>

<!-- Create note modal btn -->

<div class="mt-3 d-flex justify-content-center">
  <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#createNoteModal">
    + Create new note
  </button>
</div>

<!-- Modal with form -->

<div class="modal fade" id="createNoteModal" tabindex="-1" aria-labelledby="createNoteModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h1 class="modal-title fs-5" id="createNoteModalLabel">Create new note</h1>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">

        <!-- Form for creating notes -->

        <form action="./createNote.php" method="POST">
          <div class="mb-3">
            <label for="contentInput" class="form-label">Content:</label>
            <textarea class="form-control" name="contentInput" id="contentInput" rows="5" placeholder="Write your note here" aria-required="true" required></textarea>
          </div>

          <div class="mb-3">
            <div class="form-check">
              <input class="form-check-input" type="radio" name="radioVisibility" id="radioPrivate" value="private" checked>
             <label class="form-check-label" for="radioPrivate">
              Private
              </label>
            </div>

            <div class="form-check">
              <input class="form-check-input" type="radio" name="radioVisibility" id="radioPublic" value="public">
             <label class="form-check-label" for="radioPublic">
              Public
              </label>
            </div>
          </div>

          <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
        <button type="submit" name="createNote" class="btn btn-primary">Create note</button>
      </div>

        </form>
      </div>

      

    </div>
  </div>
</div>

<!-- Content -->

<div class="row row-cols-1 row-cols-md-2 g-4 p-3">
  <?php

  foreach($allNotes as $key => $value){

    echo
    '<div class="col">
    <div class="card">
      <div class="card-body">
        <p class="card-text">'
          . $value["content"] .
        '</p>
      </div>
      ';

      // Adds edit and delete buttons if logged in user created note
        
      if($value["fk_user_id"] == $_SESSION["id"]){
        echo
        '<div class="card-footer d-flex justify-content-between">

        <!-- Edit note modal btn -->

        <div>
          <button type="button" class="btn btn-outline-primary" data-bs-toggle="modal" data-bs-target="#editNoteModal-'. $value["id"] . '">
            Edit note
          </button>
        </div>
        
        <!-- Modal with filled in form -->
        
        <div class="modal fade" id="editNoteModal-'. $value["id"] . '" tabindex="-1" aria-labelledby="editNoteModalLabel" aria-hidden="true">
          <div class="modal-dialog">
            <div class="modal-content">
              <div class="modal-header">
                <h1 class="modal-title fs-5" id="editNoteModalLabel">Edit your note</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
              </div>
              <div class="modal-body">
        
                <!-- Form for updating notes -->
        
                <form action="./updateNote.php" method="POST">
                  <div class="mb-3">
                    <label for="contentInput" class="form-label">Content:</label>
                    <textarea class="form-control" name="contentInput" id="contentInput" rows="5" placeholder="Write your note here" aria-required="true" required>'
                      . $value["content"] .
                    '</textarea>
                  </div>
        
                  <div class="mb-3">
                    <div class="form-check">
                      <input class="form-check-input" type="radio" name="radioVisibility" id="radioPrivate" value="private"' . ($value["visibility"] == "private" ? "checked" : "") . '>
                     <label class="form-check-label" for="radioPrivate">
                      Private
                      </label>
                    </div>
        
                    <div class="form-check">
                      <input class="form-check-input" type="radio" name="radioVisibility" id="radioPublic" value="public"' . ($value["visibility"] == "public" ? "checked" : "") . '>
                     <label class="form-check-label" for="radioPublic">
                      Public
                      </label>
                    </div>
                  </div>

                  <input type="hidden" name="noteId" value="' . $value["id"] . '">
        
                  <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <button type="submit" name="updateNote" class="btn btn-primary">Update note</button>
              </div>
        
                </form>
              </div>
        
              
        
            </div>
          </div>
        </div>

          <form action="./deleteNote.php" method="POST">
            <input type="hidden" name="noteId" value="' . $value["id"] . '">
            <button type="submit" name="deleteNote" class="btn btn-outline-danger">
              Delete Note
            </button>
          </form>
        </div>';
      }

    echo
    '</div>
</div>';
  }

  ?>
  


</div>

</div>

<div class="d-flex justify-content-center bg-dark" id="footer">
  <p class="text-light m-2">© 2025 Dominik Burycz</p>
</div>

</div>
</body>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</html>