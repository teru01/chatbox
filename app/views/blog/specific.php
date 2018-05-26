<?php
$this->setPageTitle('title', $article['user_name']);
print $this->render('blog/article', ['article' => $article, 'reactions' => $reactions]);

