<div class="article">

    <div class="article_content">
        <p>
            <a href="<?php print $base_url; ?>/user/<?php print self::escape($article['user_name']); ?>">
                <?php print self::escape($article['user_name']); ?>
            </a>
        </p>
        <div class="message"><?php print self::escape($article['message']); ?></div>
    </div>
    <div>
        <div class="arrow_wrapper">
        <?php if($user['user_name'] === $article['user_name']): ?>
            <a href="#" class="arrow"><img src="/images/navi_icons/arrow.gif"></a>
        <?php endif; ?>
        </div>
        <a href="<?php print $base_url; ?>/user/<?php print self::escape($article['user_name']); ?>/article/<?php print self::escape($article['id']); ?>">
            <?php print self::escape($article['time_stamp']); ?>
        </a>
        <?php foreach($reactions as $key => $r_id): ?>
            <button type='button' value="<?php print $base_url; ?>/article/<?php print self::escape($article['id']); ?>/<?php print $r_id; ?>" class="reaction_icons">
                <img src="<?php print("/images/reaction_icons/".$key.".png"); ?>">
            </button>
            <div class="reaction_counter">
                <?php print self::escape($article["reaction"][$r_id]) ?>
            </div>
        <?php endforeach; ?>
    </div>

    <div class="article_menu_wrapper" style="display: none">
        <ul class="article_menu">
            <li><a href="#">記事の編集</a></li>
            <li><a href="#">記事の削除</a></li>
        </ul>
    </div>
</div>
