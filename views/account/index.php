<?php $this->setPageTitle('title', 'アカウント'); ?>
<div class="acount">
    <h1 class="page_title">アカウント情報</h1>
    <div class="user_id_and_image">
        <div class="user_image">
            <img src="/images/user_imgs/<?php print $this->escape($user['user_img']) ?>">
            <form method="post" action="<?php print $base_url; ?>/account/upload" enctype="multipart/form-data">
                <input type="file" name="user_img"><br>
                <input type="submit" value="アップロード">
            </form>
            <?php if (isset($errors) && count($errors) > 0){
                print $this->render('errors', ['errors' => $errors]);
            } ?>
        </div>
        <div class="user_id">
        <p>ユーザーID</p>
        <a href="<?php print $base_url; ?>/user/<?php print $this->escape($user['user_name']); ?>">
            <?php print $this->escape($user['user_name']); ?>
        </a>
        </div>
    </div>
</div>
<div class="f_user">
    <h3 class="sub_title">フォローしているユーザー</h3>
    <?php if (count($followingUsers) > 0): ?>
    <ul>
        <?php foreach ($followingUsers as $fuser): ?>
        <li>
            <a href="<?php print $base_url; ?>/user/<?php print $this->escape($fuser['user_name']); ?>">
                <?php print $this->escape($fuser['user_name']); ?>
            </a>
        </li>
        <?php endforeach; ?>
    </ul>
    <?php endif; ?>
</div>
