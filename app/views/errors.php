<ul class="error_list">
    <?php foreach ((array)$errors as $error): ?>
    <li><?php print self::escape($error); ?></li>
    <?php endforeach; ?>
</ul>