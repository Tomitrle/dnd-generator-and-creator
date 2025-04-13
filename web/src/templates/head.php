<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">

  <!-- Arguably unnecessary, but included for completeness  -->
  <meta http-equiv="X-UA-Compatible" content="IE=edge">

  <title><?php
      if (isset($TITLE)) echo $TITLE;
      else echo "D&D Encounter Generator and Monster Creator";
  ?></title>
  <meta name="author" content="<?php
      if (isset($AUTHOR)) echo $AUTHOR;
      else echo "Brennen Muller & Tommy Le";
  ?>">
  <meta name="description" content="<?php
      if (isset($DESCRIPTION)) echo $DESCRIPTION;
      else echo "Create custom monsters and encounters for Dungeons & Dragons!";
  ?>">
  <meta name="keywords" content="<?php
      if (isset($KEYWORDS)) echo $KEYWORDS;
      else echo "dungeons and dragons, d&d, dnd, monster, encounter, custom, generator, creator, editor";
  ?>">

  <meta property="og:url" content="<?php
      if (isset($URI)) echo $URI;
      else echo __DIR__;
  ?>">
  <meta property="og:title" content="<?php
      if (isset($TITLE)) echo $TITLE;
      else echo "D&D Encounter Generator and Monster Creator";
  ?>">
  <meta property="og:description" content="<?php
      if (isset($DESCRIPTION)) echo $DESCRIPTION;
      else echo "Create custom monsters and encounters for Dungeons & Dragons!";
  ?>">
  <meta property="og:type" content="website">
  <!-- <meta property="og:image" content="">
  <meta property="og:image:type" content="image/png">
  <meta property="og:image:width" content="">
  <meta property="og:image:height" content=""> -->

  <!-- STYLESHEETS -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
  <link href="/styles/main.less" rel="stylesheet/less" type="text/css">
  <?php
  if (isset($LESS)) {
    foreach ($LESS as $stylesheet) {
      echo "<link href=\"$stylesheet\" rel=\"stylesheet/less\" type=\"text/css\">\n";
    }
  }
  ?>
  <script src="https://cdn.jsdelivr.net/npm/less"></script>
</head>