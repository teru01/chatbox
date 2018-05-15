<div class="form-group">
    <div class="row">
    <label for="name">ユーザーID</label>
    <input type="text" class="form-control" name="user_name" value="<?php print self::escape($user_name); ?>">
    </div>
</div>
<div class="form-group">
    <div class="row">
    <label for="name">パスワード</label>
    <input type="password" class="form-control" name="password" value="<?php print self::escape($password); ?>">
    </div>
</div>