<!DOCTYPE html>
<html lang="jp">
<head>
    <meta charset="UTF-8">
    <title>
        <?php if(isset($title)): print $this->escape($title) . ' - '; endif; ?>
        my掲示板
    </title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.0/css/bootstrap.min.css" integrity="sha384-9gVQ4dYFwwWSjIDZnLEWnxCjeSWFphJiwGPXr1jddIhOegiu1FwO5qRGvFXOdJZ4" crossorigin="anonymous">
    <link rel="stylesheet" type="text/css" href="/css/style.css">
</head>
<body>
<div id="header">
    <div class="container">
        <div class="row">
            <div class="col-xs-3">
                <a href="<?php print $base_url; ?>/"><img src="/images/logo.png"></a>
            </div>
            <div class="col-xs-6 col-md-offset-6">
                <p>
                    <?php if($session->isAuthenticated()): ?>
                    <button type="button" class="btn btn-success">
                        <a href="<?php print $base_url; ?>/">
                            トップページ
                        </a>
                    </button>
                    <button type="button" class="btn btn-primary">
                        <a href="<?php print $base_url; ?>/account">
                            アカウント
                        </a>
                    </button>

                    <?php else: ?>
                    <button type="button" class="btn btn-success">
                    <a href="<?php print $base_url; ?>/account/signin">
                        サインイン
                    </a>
                    </button>
                    <button type="button" class="btn btn-primary">
                    <a href="<?php print $base_url; ?>/account/signup">
                        アカウントを作成
                    </a>
                    </button>
                    <?php endif; ?>
                </p>
            </div>
        </div>
    </div>
<!--    <div class="sep"></div>-->
</div>
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
