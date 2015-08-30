<html lang="en" ng-app="JobCondDev">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="description" content="A front-end template that helps you build fast, modern mobile web apps.">
    <meta name="viewport" content="width=device-width, initial-scale=1">
      <title ng-bind="'SI - ' + $root.title">Sistema de Inventário</title>

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
      <link href="https://fonts.googleapis.com/css?family=Roboto:regular,bold,italic,thin,light,bolditalic,black,medium&amp;lang=en" rel="stylesheet">
      <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
      <link rel="stylesheet" href="/app/bower_components/material-design-lite/material.css">
      <link rel="stylesheet" href="/app/bower_components/angular-material/angular-material.css">
      <link rel="stylesheet" href="/app/bower_components/angular-material-data-table/dist/md-data-table.css">
      <link rel="stylesheet" href="/app/bower_components/vendor/styles.css">

        <!-- Before body closing tag -->
    <script src="/app/bower_components/jquery/dist/jquery.js"></script>
    <script src="/app/bower_components/angular/angular.js"></script>
    <script src="/app/bower_components/angular-animate/angular-animate.js"></script>
    <script src="/app/bower_components/angular-route/angular-route.js"></script>
    <script src="/app/bower_components/angular-aria/angular-aria.js"></script>
    <script src="/app/bower_components/angular-messages/angular-messages.js"></script>
    <script src="/app/bower_components/angular-resource/angular-resource.js"></script>
    <script src="/app/bower_components/angular-cookies/angular-cookies.js"></script>
    <script src="/app/bower_components/angular-material/angular-material.js"></script>
    <script src="/app/bower_components/vendor/material.min.js"></script>
    <script src="/app/bower_components/angular-material-data-table/dist/md-data-table.js"></script>
    <script src="/app/bower_components/angulartics/src/angulartics.js"></script>
    <script src="/app/bower_components/angulartics/src/angulartics-piwik.js"></script>


<!--     Inicio do projeto -->
    <script src="/app/job/app.js"></script>
    <script src="/app/job/system/filters/segment_url_filter.js"></script>
    <script src="/app/job/modulo_inventario/inventario_app.js"></script>
    <script src="/app/job/modulo_inventario/controllers/inventario_controller.js"></script>
    <script src="/app/job/modulo_inventario/factories/inventario_factory.js"></script>
    <script src="/app/job/modulo_inventario/controllers/kit_detalhe_controller.js"></script>
    <script src="/app/job/modulo_inventario/controllers/localizar_item_controller.js"></script>

      <script src="/app/job/modulo_relatorio/relatorio_app.js"></script>
      <script src="/app/job/modulo_relatorio/controllers/relatorio_controller.js"></script>

    <style>
    #view-source {
      position: fixed;
      display: block;
      right: 0;
      bottom: 0;
      margin-right: 40px;
      margin-bottom: 40px;
      z-index: 900;
    }
    </style>

      <!-- Piwik -->
      <script type="text/javascript">
          var _paq = _paq || [];
          _paq.push(['trackPageView']);
          _paq.push(['enableLinkTracking']);
          (function() {
              var u="//piwik.dev/";
              _paq.push(['setTrackerUrl', u+'piwik.php']);
              _paq.push(['setSiteId', 1]);
              var d=document, g=d.createElement('script'), s=d.getElementsByTagName('script')[0];
              g.type='text/javascript'; g.async=true; g.defer=true; g.src=u+'piwik.js'; s.parentNode.insertBefore(g,s);
          })();
      </script>
      <noscript><p><img src="//piwik.dev/piwik.php?idsite=1" style="border:0;" alt="" /></p></noscript>
      <!-- End Piwik Code -->

  </head>
  <body>
  <div class="demo-layout mdl-layout mdl-js-layout mdl-layout--fixed-drawer mdl-layout--fixed-header">
      <header class="demo-header mdl-layout__header mdl-color--white mdl-color--grey-100 mdl-color-text--grey-600">
        <div class="mdl-layout__header-row">
          <span class="mdl-layout-title">Home</span>
          <div class="mdl-layout-spacer"></div>
        </div>
      </header>
      <div class="demo-drawer mdl-layout__drawer mdl-color--blue-grey-900 mdl-color-text--blue-grey-50">
        <header class="demo-drawer-header">
          <img src="images/user.jpg" class="demo-avatar">
        </header>
        <nav class="demo-navigation mdl-navigation mdl-color--blue-grey-800">
            <a class="mdl-navigation__link" href=""><i class="mdl-color-text--blue-grey-400 material-icons">home</i>Home</a>
            <a class="mdl-navigation__link" href="#/inventario"><i class="mdl-color-text--blue-grey-400 material-icons">assignment</i>Inventário</a>
            <a class="mdl-navigation__link" href="#/relatorio"><i class="mdl-color-text--blue-grey-400 material-icons">assessment</i>Relatório</a>
            <a class="mdl-navigation__link" href="#/relatorio"><i class="mdl-color-text--blue-grey-400 material-icons">power_settings_new</i>Sair</a>
            <div class="mdl-layout-spacer"></div>
          <a class="mdl-navigation__link" href=""><i class="mdl-color-text--blue-grey-400 material-icons">help_outline</i></a>
        </nav>
      </div>
      <main class="mdl-layout__content mdl-color--grey-100">
        <div class="mdl-grid demo-content" ng-view>
        </div>
      </main>
    </div>
  </body>
</html>
