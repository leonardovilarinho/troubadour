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
                <p><?php echo Language::get('book')['name'] ?>:</p>
            </td>
            <td colspan="8">
                <input name="name" value="<?php echo Saved::get('name') ?>" placeholder="<?php echo Language::get('book')['name'] ?>" required type="text" class="form-control">
            </td>
        </tr>

        <tr>
            <td colspan="2">
                <p><?php echo Language::get('book')['author'] ?>:</p>
            </td>
            <td colspan="4">
                <input name="author" value="<?php echo Saved::get('author') ?>" placeholder="<?php echo Language::get('book')['author'] ?>" required type="text" class="form-control">
            </td>
            <td colspan="2">
                <p><?php echo Language::get('book')['price'] ?>:</p>
            </td>
            <td colspan="2">
                <input name="price" value="<?php echo Saved::get('price') ?>" placeholder="<?php echo Language::get('book')['price'] ?>" required type="text" class="form-control">
            </td>
        </tr>

        <tr>
            <td colspan="10" class="text-center">
                <input value="<?php echo Language::get('book')['create'] ?>" class="btn btn-primary" type="submit">
            </td>
        </tr>
    </table>
</form>
