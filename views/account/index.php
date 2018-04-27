<?php $this->setPageTitle('title', 'アカウント'); ?>
<div class="acount">
    <h1 class="page_title">アカウント情報</h1>
    <p>
        ユーザーID:
        <a href="<?php print $base_url; ?>/user/<?php print $this->escape($user['user_name']); ?>">
            <?php print $this->escape($user['user_name']); ?>
        </a>
    </p>
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
