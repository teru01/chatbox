<?php $this->setPageTitle('title', 'アカウント'); ?>
<div class="acount">
    <h2>アカウント情報</h2>
    <p>
        ユーザーID:
        <a href="<?php print $base_url; ?>/user/<?php print $this->escape($user['user_name']); ?>">
            <?php print $this->escape($user['user_name']); ?>
        </a>
    </p>
    <ul>
        <li>
            <a href="<?php print $base_url; ?>/account/signout">サインアウト</a>
        </li>
    </ul>
</div>
<div class="f_user">
</div>
