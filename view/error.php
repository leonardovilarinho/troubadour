<?php
/**
 * Created by PhpStorm.
 * User: Leonardo Vilarinho
 * Date: 04/07/2016
 * Time: 23:17
 */
?>

<div class="text-center text-danger">
    <?php
    echo '<h4>';
    echo $this->getVar('error');
    echo '</h4>';
    echo '<a href="' . $this->getVar('link'). '" class="btn btn-primary"><<<</a>';
    ?>

</div>
