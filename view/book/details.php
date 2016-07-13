<?php
/**
 * Created by PhpStorm.
 * User: Leonardo Vilarinho
 * Date: 13/07/2016
 * Time: 13:19
 */
?>
<div class="text-right">
    <a href="<?php echo DOMAIN . '/chapter/create/'. $this->getVar('book') ?>" class="btn btn-primary">
        <?php echo Language::get('chapter')['create'] ?>
    </a>
</div>
<table class="table table-responsive">
    <thead>
    <tr>
        <th><?php echo Language::get('chapter')['title'] ?></th>
        <th><?php echo Language::get('chapter')['pages'] ?></th>
        <th><?php echo Language::get('global')['actions'] ?></th>
    </tr>
    </thead>
    <tbody>
    <?php
    $chapters = $this->getVar('chapters');
    if(!empty($chapters)):
        foreach ($chapters as $chapter):
            echo '<tr>';
            echo '<td>' . $chapter->getTitle() . '</td>';
            echo '<td>' . $chapter->getPages() . '</td>';
            echo '<td><a href="' . DOMAIN . '/chapter/delete/'. $chapter->getId() . '/' . $this->getVar('book') . '" class="btn btn-primary"><i class="fa fa-trash"></i></a> '.
                '<a href="' . DOMAIN . '/chapter/edit/'. $chapter->getId()  . '/' . $this->getVar('book')  .'" class="btn btn-primary"><i class="fa fa-pencil"></i></a>'
                .'</td>';
            echo '</tr>';
        endforeach;
    else:
        echo "<div class='text-center'>" . Language::get('chapter')['empty'] . "</div>";
    endif;
    ?>
    </tbody>
</table>
