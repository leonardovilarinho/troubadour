<?php
/**
 * Created by PhpStorm.
 * User: Leonardo Vilarinho
 * Date: 04/07/2016
 * Time: 12:55
 */
?>

<article class="col-md-2">
    <hr/>
    <div class="text-center">
        <?php
        echo "<a href='" . DOMAIN ."/language/change/1'>PT</a>";
        echo " | ";
        echo "<a href='" . DOMAIN ."/language/change/2'>EN</a>";
        ?>
        <h3><a href="<?php echo DOMAIN ?>"><?php echo $this->getTitle() ?></a></h3>
        <p><?php echo Session::get('username') ?></p>
        <?php
        echo "<p>" . Language::get('menu')['description'] . "</p>";
        ?>
    </div>
    <hr/>
    <div class="text-right">
        <a href="<?php echo DOMAIN . '/user/logout' ?>"><i class="fa fa-sign-out"></i> <?php echo Language::get('global')['exit'] ?></a>
    </div>
    <hr/>
    <ul class="list list-unstyled text-center">
        <?php
        $links = View::getAllLinks();

        if(!empty($links)):
            foreach ($links as $key => $v):
                foreach ($links[$key] as $value)
                {
        ?>
                    <li>
                        <a href="<?php echo DOMAIN . "/{$key}/{$value}" ?>" class="item">
                            <strong><i class="fa fa-list"></i> <?php echo ucfirst($key ). " / " . ucfirst($value) ?></strong>
                        </a>
                    </li>
                    <hr/>
        <?php
                }
            endforeach;
        endif;
        ?>

    </ul>
</article>
