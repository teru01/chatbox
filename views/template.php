<!DOCTYPE html>
<html lang="jp">
<head>
    <meta charset="UTF-8">
    <title>
        <?php if(isset($title)): print $this->escape($title) . ' - '; endif; ?>
        chatbox
    </title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.0/css/bootstrap.min.css" integrity="sha384-9gVQ4dYFwwWSjIDZnLEWnxCjeSWFphJiwGPXr1jddIhOegiu1FwO5qRGvFXOdJZ4" crossorigin="anonymous">
    <link rel="stylesheet" type="text/css" href="/css/style.css">
</head>
<body>
<div id="header">
    <a href="<?php print $base_url; ?>/"><img src="/images/logo.png"></a>
    <div id="nav">
        <?php if($session->isAuthenticated()): ?>
            <a href="<?php print $base_url; ?>/" class="btn btn-success">
                トップページ
            </a>
            <a href="<?php print $base_url; ?>/account" class="btn btn-primary">
                アカウント
            </a>
            <a href="<?php print $base_url; ?>/account/signout" class="btn">
                サインアウト
            </a>
        <?php else: ?>
            <a href="<?php print $base_url; ?>/account/signin" class="btn btn-success">
                サインイン
            </a>
            <a href="<?php print $base_url; ?>/account/signup" class="btn btn-primary">
                アカウントを作成
            </a>
        <?php endif; ?>
    </div>
</div>
<div class="sep"></div>
<div class="container">
<div id="main">
    <?php print $_content; ?>
</div>
</div>
<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.0/umd/popper.min.js" integrity="sha384-cs/chFZiN24E4KMATLdqdvsezGxaGsi4hLGOzlXwp5UZB1LY//20VyM2taTB4QvJ" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.0/js/bootstrap.min.js" integrity="sha384-uefMccjFJAIv6A+rW+L4AHf99KvxDjWSu1z9VI8SKNVmz4sk7buKt/6v9KI65qnm" crossorigin="anonymous"></script>
</body>
</html>
