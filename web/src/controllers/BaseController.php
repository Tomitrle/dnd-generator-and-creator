<?php
class BaseController
{
  public function __construct() {}

  // TODO: Handle authentication
  final protected function isAuthenticated(): bool
  {
    return true;
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
    </body>

    </html>";
  }
}
