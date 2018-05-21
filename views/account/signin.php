<?php $this->setPageTitle('title', 'サインイン'); ?>
<h1 class="page_title">サインイン</h1>
<div class="container">
<form action="<?php print $base_url; ?>/account/authenticate" method="post">
    <input type="hidden" name="_token" value="<?php print self::escape($_token); ?>">
    <?php if (isset($errors) && count($errors) > 0){
        print $this->render('errors', ['errors' => $errors]);
    }
    print $this->render('account/inputs', ['user_name' => $user_name, 'password' => $password,]);
    ?>
    <p><input class="btn-info" type="submit" value="サインイン"></p>
</form>
</div>

