<div class="article">

    <div class="article_content">
        <p>
            <a href="<?php print $base_url; ?>/user/<?php print self::escape($article['user_name']); ?>">
                <?php print self::escape($article['user_name']); ?>
            </a>
        </p>
        <div class="message" >
            <p>
                <?php print self::escape($article['message']); ?>
            </p>
        </div>
    </div>
    <div class="article_info">
        <div class="arrow_wrapper">
        <?php if($user['user_name'] === $article['user_name']): ?>
            <a href="#" class="arrow"><img src="/images/navi_icons/arrow.gif"></a>
        <?php endif; ?>
        </div>
        <a href="<?php print $base_url; ?>/user/<?php print self::escape($article['user_name']); ?>/article/<?php print self::escape($article['id']); ?>">
            <?php print self::escape($article['time_stamp']); ?>
        </a>
        <?php foreach($reactions as $key => $r_id): ?>
            <input type='image'
                   class="reaction_icons"
                   src="<?php print("/images/reaction_icons/".$key.".png"); ?>"
                   value="<?php print $base_url; ?>/article/<?php print self::escape($article['id']); ?>/<?php print $r_id; ?>">
            <div class="reaction_counter">
                <?php print self::escape($article["reaction"][$r_id]) ?>
            </div>
        <?php endforeach; ?>
    </div>

    <?php if($user['user_name'] === $article['user_name']): ?>
        <div class="article_menu_wrapper" style="display: none">
            <ul class="article_menu">
                <li><a class="edit_article" href="#">記事の編集</a></li>
                <li><a class="delete_article" href="#">記事の削除</a></li>
            </ul>
        </div>
    <?php endif; ?>
</div>
