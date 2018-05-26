<?php
require '../app/bootstrap.php';
require '../app/BlogApp.php';
$app = new BlogApp(true);
$app->run();