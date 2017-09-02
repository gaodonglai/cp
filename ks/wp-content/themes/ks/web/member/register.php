<?php
/**
 * Created by PhpStorm.
 * User: ggbx
 * Date: 2017/8/22
 * Time: 18:53
 */


?>

<form action="<?=home_url('member/register/save')?>" method="post">
    <div>
        <label for="username">Userphone <strong>*</strong></label>
        <input type="text" name="userphone">
    </div>

    <div>
        <label for="password">Password <strong>*</strong></label>
        <input type="password" name="password" >
    </div>

    <div>
        <label for="nickname">Nickname</label>
        <input type="text" name="display_name">
    </div>

    <input type="submit" name="submit" value="Register"/>
</form>
