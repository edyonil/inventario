<!doctype html>
<!--
  Material Design Lite
  Copyright 2015 Google Inc. All rights reserved.

  Licensed under the Apache License, Version 2.0 (the "License");
  you may not use this file except in compliance with the License.
  You may obtain a copy of the License at

      https://www.apache.org/licenses/LICENSE-2.0

  Unless required by applicable law or agreed to in writing, software
  distributed under the License is distributed on an "AS IS" BASIS,
  WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
  See the License for the specific language governing permissions and
  limitations under the License
-->
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="description" content="A front-end template that helps you build fast, modern mobile web apps.">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Material Design Lite</title>

    <!-- Add to homescreen for Chrome on Android -->
    <meta name="mobile-web-app-capable" content="yes">
    <link rel="icon" sizes="192x192" href="/templates/blog/images/touch/chrome-touch-icon-192x192.png">

    <!-- Add to homescreen for Safari on iOS -->
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-status-bar-style" content="black">
    <meta name="apple-mobile-web-app-title" content="Material Design Lite">

    <!-- Tile icon for Win8 (144x144 + tile color) -->
    <meta name="msapplication-TileColor" content="#3372DF">

    <!-- SEO: If your mobile URL is different from the desktop URL, add a canonical link to the desktop page https://developers.google.com/webmasters/smartphone-sites/feature-phones -->
    <!--
    <link rel="canonical" href="http://www.example.com/">
    -->

    <link href="https://fonts.googleapis.com/css?family=Roboto:regular,bold,italic,thin,light,bolditalic,black,medium&amp;lang=en" rel="stylesheet">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <link rel="stylesheet" href="/templates/blog/material.min.css">
    <link rel="stylesheet" href="/templates/blog/styles.css">
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
</head>
<body>
<div class="demo-blog mdl-layout mdl-js-layout has-drawer is-upgraded">
    <main class="mdl-layout__content">
        <div class="demo-blog__posts mdl-grid">
            <div class="mdl-card on-the-road-again mdl-cell mdl-cell--12-col">
                <div class="mdl-card__media mdl-color-text--grey-50" style="height: 300px;">
                    <h3>Login</h3>
                </div>
                <div class="mdl-color-text--grey-600 mdl-card__supporting-text">
                    <form method="POST" action="/auth/login" role="form" class="ls-form ls-login-form" action="#">
                        {!! csrf_field() !!}

                        <div class="mdl-textfield mdl-js-textfield">
                            <input class="mdl-textfield__input" type="text" id="email" name="email" />
                            <label class="mdl-textfield__label" for="email" >Email...</label>
                        </div>
                        <div class="mdl-textfield mdl-js-textfield">
                            <input class="mdl-textfield__input" type="password" id="email" name="password" />
                            <label class="mdl-textfield__label" for="password">Senha...</label>
                        </div>
                        <hr style="visibility: hidden"/>
                        <button class="mdl-button mdl-js-button mdl-button--raised mdl-button--colored">
                            Enviar
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </main>
</div>
<script src="/app/bower_components/vendor/material.min.js"></script>
</body>
<script>
    Array.prototype.forEach.call(document.querySelectorAll('.mdl-card__media'), function(el) {
        var link = el.querySelector('a');
        if(!link) {
            return;
        }
        var target = link.getAttribute('href');
        if(!target) {
            return;
        }
        el.addEventListener('click', function() {
            location.href = target;
        });
    });
</script>
</html>