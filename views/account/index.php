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
    <h3>フォローしているユーザー</h3>
    <?php if (count($followingUsers) > 0): ?>
    <ul>
        <?php foreach ($followingUsers as $fuser): ?>
        <li>
            <a href="<?php print $base_url; ?>/account/<?php print $this->escape($fuser['user_name']); ?>">
                <?php print $this->escape($fuser['user_name']); ?>
            </a>
        </li>
        <?php endforeach; ?>
    </ul>
    <?php endif; ?>
</div>
