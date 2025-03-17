<?php 
class MonsterEditorController {
  public function __construct() {}

  public function run() : void {
    // TODO: FIND BETTER WAYS TO HANDLE ALERTS
    $ALERTS = [
      "danger" => [], 
      "warning" => [], 
      "info" => [], 
      "success" => []
    ];

    switch ($_SERVER["REQUEST_METHOD"]) {
      case "GET":
        switch (isset($_GET["databaseID"])) {
          case true:
            if (!$this->isAuthenticated()) {
              $this->errorResponse(401, "You must be logged in to edit this resource.");
              return;
            }
    
            if (!$this->checkPermissions()) {
              $this->errorResponse(403, "You do not have permission to edit this resource.");
              return;
            }
  
            // TODO: LOAD PRE-POPULATED PAGE
            include "/opt/src/templates/monster-editor/monster-editor.php";
            return;

          case false:
            if ($this->isAuthenticated()) {
              // LOAD REGULAR PAGE
              include "/opt/src/templates/monster-editor/monster-editor.php";
              return;
            }
    
            // LOAD PAGE WITHOUT SAVE OPTION
            $ALERTS["warning"][] = "Your progress may not be saved.";
            include "/opt/src/templates/monster-editor/monster-editor.php";
            echo "
            <script>
              document.getElementById(\"saveButton\").remove();
            </script>
            ";
            return;
        }
        
      case "POST":
        var_dump($_POST);

        if (!$this->isAuthenticated()) {
          $this->errorResponse(401, "You must be logged in to edit this resource.");
          return;
        }

        if (!$this->formValidation()) {
          $this->errorResponse(400, "Your request to edit this resource was invalid or malformed.");
          return;
        }

        switch (!isset($_POST["databaseID"])) {
          case true:
            if (!$this->checkPermissions()) {
              $this->errorResponse(403, "You do not have permission to edit this resource");
              return;
            }  

            // TODO: CREATE A NEW DATABASE OBJECT
            // WHAT SHOULD BE RETURNED HERE? SHOULD THERE BE REDIRECTS? SHOULD THE RELOAD TARGET CHANGE?
            // HTTPS 200: OK
            return;

          case false:
            // TODO: UPDATE DATABASE MODEL
            return;
        }

      default: 
        $this->errorResponse(405, "This request method is not supported.");
        return;
    }
  }

  // TODO
  protected function isAuthenticated() : bool {
    return true;
  }

  // TODO
  protected function formValidation() : bool {
    foreach (
      [
        "name",
        "size",
        "type",
        "alignment",

        "armor",
        "armorClass", // ONLY IF NECESSARY
        "hitDice", // ONE OR OTHER
        "health",  // OTHER

        "speed",
        "speed#"
      ]
      as $inputField) if (!isset($_POST[$inputField])) return false;


    return true;
  }

  // TODO
  protected function checkPermissions() : bool {
    return false;
  }
  
  protected function errorResponse(int $code, string $message) : void {
    http_response_code($code);
    echo "
    <!DOCTYPE html>
    <html lang=\"en\">

    <head>
      <meta charset=\"UTF-8\">
      <meta name=\"viewport\" content=\"width=device-width, initial-scale=1\">
      <title>Error</title>
      <meta name=\"author\" content=\"Brennen Muller\">
    </head>

    <body>
      <h1>HTTP $code</h1>
      <p>$message</p>
    </body>

    </html>";
  }
}
?>