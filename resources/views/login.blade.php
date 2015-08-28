<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="description" content="A front-end template that helps you build fast, modern mobile web apps.">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Material Design Lite</title>

    <!-- Add to homescreen for Chrome on Android -->
    <meta name="mobile-web-app-capable" content="yes">
    <link rel="icon" sizes="192x192" href="images/touch/chrome-touch-icon-192x192.png">

    <!-- Add to homescreen for Safari on iOS -->
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-status-bar-style" content="black">
    <meta name="apple-mobile-web-app-title" content="Material Design Lite">
    <link rel="apple-touch-icon-precomposed" href="apple-touch-icon-precomposed.png">

    <!-- Tile icon for Win8 (144x144 + tile color) -->
    <meta name="msapplication-TileImage" content="images/touch/ms-touch-icon-144x144-precomposed.png">
    <meta name="msapplication-TileColor" content="#3372DF">

    <!-- SEO: If your mobile URL is different from the desktop URL, add a canonical link to the desktop page https://developers.google.com/webmasters/smartphone-sites/feature-phones -->
    <!--
    <link rel="canonical" href="http://www.example.com/">
    -->
    
    <link rel="stylesheet" href="app/bower_components/angular-material/angular-material.css">
    <link href="https://fonts.googleapis.com/css?family=Roboto:regular,bold,italic,thin,light,bolditalic,black,medium&amp;lang=en" rel="stylesheet">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <link rel="stylesheet" href="app/bower_components/vendor/material.min.css">
    <link rel="stylesheet" href="app/bower_components/vendor/styles.css">
    <style>
      body{
      	background: url('images/blue-grey-pentagonal-background.jpg') no-repeat top center;
      }
    </style>
  </head>
  <body>
    <div class="mdl-grid" style="min-height: 400px">
        <div class="mdl-cell mdl-cell--3-col"></div>
        <div class="mdl-cell mdl-cell--6-col mdl-cell--middle" >
            <div class="mdl-card mdl-shadow--2dp demo-card-wide" style="width: 100%">
              <div class="mdl-card__title">
                <h2 class="mdl-card__title-text">Welcome</h2>
              </div>
              <div class="mdl-card__supporting-text">
                <form action="#" method="POST">
                  <div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
                    <input class="mdl-textfield__input" type="text" id="login" />
                    <label class="mdl-textfield__label" for="senha">Text...</label>
                  </div>
                  <div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
                    <input class="mdl-textfield__input" type="password" id="senha" />
                    <label class="mdl-textfield__label" for="senha">Text...</label>
                  </div>
                </form>
              </div>
              <div class="mdl-card__actions mdl-card--border">
                <button class="mdl-button mdl-button--colored mdl-js-button mdl-js-ripple-effect">
                  Entrar no sistema
                </button>
              </div>
            </div>
        </div>
        <div class="mdl-cell mdl-cell--3-col"></div>
    </div>
  
    <script src="app/bower_components/material-design-lite/material.min.js"></script>
    
  </body>
</html>
<!-- Wide card with share menu button -->


