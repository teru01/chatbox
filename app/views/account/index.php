<?php $this->setPageTitle('title', 'アカウント'); ?>
<div class="acount">
    <h1 class="page_title">アカウント情報</h1>
    <div class="user_id_and_image">
        <div class="user_image">
            <img src="<?php print self::escape($user['user_img']) ?>">
            <form method="post" action="<?php print $base_url; ?>/account/upload" enctype="multipart/form-data">
                <input class="file_select" type="file" name="upload"><br>
                <input class="btn-info" type="submit" value="アップロード">
            </form>

        </div>
        <div class="user_id">
        <p>ユーザーID</p>
        <a href="<?php print $base_url; ?>/user/<?php print self::escape($user['user_name']); ?>">
            <?php print self::escape($user['user_name']); ?>
        </a>
        </div>
        <div class="sep"></div>
        <?php if (isset($errors) && count($errors) > 0){
            print $this->render('errors', ['errors' => $errors]);
        } ?>
    </div>
</div>
<div class="f_user">
    <h3 class="sub_title">フォローしているユーザー</h3>
    <ul>
        <?php foreach ((array)$followingUsers as $fuser): ?>
        <li>
            <a href="<?php print $base_url; ?>/user/<?php print self::escape($fuser['user_name']); ?>">
                <?php print self::escape($fuser['user_name']); ?>
            </a>
        </li>
        <?php endforeach; ?>
    </ul>
</div>
<div class="other_users">
    <h2>その他のユーザー</h2>
    <ul>
    <?php foreach ((array)$others as $someone): ?>
        <li>
            <a href="<?php print $base_url; ?>/user/<?php print self::escape($someone['user_name']); ?>">
                <?php print self::escape($someone['user_name']); ?>
            </a>
        </li>
    <?php endforeach; ?>
    </ul>
</div>
