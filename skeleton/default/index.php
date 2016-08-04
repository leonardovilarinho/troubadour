<?php
/**
 * Created by PhpStorm.
 * User: Leonardo Vilarinho
 * Date: 04/07/2016
 * Time: 12:55
 */
?>
<?php $this->template->header(); ?>
<div class="container-fluid">
    <section class="row">
        <?php require_once 'menu.php'; ?>
        <article class="col-md-10">
            <hr/>
           <?php $this->getView(); ?>
        </article>
    </section>
</div>
<?php $this->template->scripts(); ?>
