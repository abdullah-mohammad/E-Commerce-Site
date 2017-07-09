<!DOCTYPE html>
<!--   
    #################################################
    # App version : 1.0                             #
    # Author      : Abdullah Al Mohammad            #
    # E-mail      : abdullah.almohammad@hotmail.com # 
    # Date        : 02.07.2017                      #
    #################################################
-->
<html>
    <head>
        <meta charset="UTF-8" />
        <title><?php getTitle() ?></title>
        <link rel="stylesheet" href="<?php echo $css; ?>bootstrap.min.css" />
        <link rel="stylesheet" href="<?php echo $css; ?>font-awesome.min.css" />
        <link rel="stylesheet" href="<?php echo $css; ?>jquery-ui.css" />
        <link rel="stylesheet" href="<?php echo $css; ?>jquery.selectBoxIt.css" />
        <link rel="stylesheet" href="<?php echo $css; ?>front.css" />
        <link href="https://fonts.googleapis.com/css?family=Quicksand" rel="stylesheet">
    <body>
    <div class="upper-bar">
        <div class="container">
        upper bar
        </div>
    </div>
    <nav class="navbar navbar-inverse">
      <div class="container">
        <div class="navbar-header ">
          <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#app-nav" aria-expanded="false">
            <span class="sr-only">Toggle navigation</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
          </button>
          <a class="navbar-brand" href="index.php">Home</a>
        </div>

        <div class="collapse navbar-collapse" id="app-nav">
          <ul class="nav navbar-nav navbar-right">

            <?php
            $categories = getCat();

            foreach ($categories as $cat) {
                echo '<li>
                        <a href="categories.php?pageid='.$cat['ID'].'&pagename='.str_replace(' ', '-', $cat['Name']).'">
                        '.$cat['Name'].'
                        </a>
                    </li>';
            }
            ?>
          </ul>
        </div>
      </div>
    </nav>