<?php
/**
 * Created by PhpStorm.
 * User: Leonardo Vilarinho
 * Date: 13/07/2016
 * Time: 13:39
 */
?>
<div class="text-center"><?php echo $this->getVar('error') ?></div>
<form action="#" method="post">
    <table class="table">
        <tr>
            <td colspan="2">
                <p><?php echo Language::get('chapter')['title'] ?>:</p>
            </td>
            <td colspan="8">
                <input name="title" value="<?php echo Saved::get('title') ?>" placeholder="<?php echo Language::get('chapter')['title'] ?>" required type="text" class="form-control">
            </td>
        </tr>

        <tr>
            <td colspan="2">
                <p><?php echo Language::get('chapter')['pages'] ?>:</p>
            </td>
            <td colspan="4">
                <input name="pages" value="<?php echo Saved::get('pages') ?>" placeholder="<?php echo Language::get('chapter')['pages'] ?>" required type="number" class="form-control">
                <input name="book" value="<?php echo $this->param(0) ?>" required type="hidden">
                <input name="id" value="<?php echo Saved::get('id') ?>" required type="hidden">
            </td>
        </tr>

        <tr>
            <td colspan="10" class="text-center">
                <input value="<?php echo Language::get('chapter')['edit'] ?>" class="btn btn-primary" type="submit">
            </td>
        </tr>
    </table>
</form>
