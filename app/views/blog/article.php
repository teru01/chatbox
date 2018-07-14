<div class="article">
    <div class="arrow_icon"><a href="#" class="arrow"><img src="/images/navi_icons/arrow.gif"></a></div>
    <div class="article_menu" style="display: none">
        <ul>
            <li><a href="#">ts</a></li>
            <li><a href="#">ts</a></li>
        </ul>
    </div>
    <div class="article_content">
        <p>
            <a href="<?php print $base_url; ?>/user/<?php print self::escape($article['user_name']); ?>">
                <?php print self::escape($article['user_name']); ?>
            </a>
        </p>
        <?php print self::escape($article['message']); ?>
    </div>
    <div>
        <a href="<?php print $base_url; ?>/user/<?php print self::escape($article['user_name']); ?>/article/<?php print self::escape($article['id']); ?>">
            <?php print self::escape($article['time_stamp']); ?>
        </a>
        <?php foreach($reactions as $key => $r_id): ?>
            <a href="<?php print $base_url; ?>/article/<?php print self::escape($article['id']); ?>/<?php print $r_id; ?>" class="reaction_icons">
                <img src="<?php print("/images/reaction_icons/".$key.".png"); ?>">
            </a>
            <div class="reaction_counter">
                <?php print self::escape($article["reaction"][$r_id]) ?>
            </div>
        <?php endforeach; ?>
    </div>
</div>
