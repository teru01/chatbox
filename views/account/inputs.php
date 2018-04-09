<table>
    <tr>
        <th>ユーザーID</th>
        <td>
            <input type="text" name="user_name" value="<?php print $this->escape($user_name); ?>">
        </td>
    </tr>
    <tr>
        <th>パスワード</th>
        <td>
            <input type="password" name="password" value="<?php print $this->escape($password); ?>">
        </td>
    </tr>
</table>