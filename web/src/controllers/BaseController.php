<?php
class BaseController
{
  protected $database;

  public function __construct()
  {
    session_start();
    $this->database = new Database();

    if (!isset($GLOBALS['src']))
      $GLOBALS['src'] = __DIR__ . "/../";

    if (!isset($_SESSION["messages"]))
      $this->resetMessages();
  }

  protected function resetMessages(): void
  {
    $_SESSION["messages"] = [
      "info" => [],
      "success" => [],
      "warning" => [],
      "danger" => []
    ];
  }

  protected function addMessage(string $type, string $message): void
  {
    $_SESSION["messages"][$type][] = $message;
  }

  protected function isAuthenticated(): bool
  {
    return isset($_SESSION["userID"]);
  }

  protected function errorResponse(int $code, string $message): void
  {
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
    ";

    require "{$GLOBALS['src']}/templates/alerts.php";

    echo "
    </body>
    </html>
    ";

    $this->resetMessages();
    exit();
  }
}
