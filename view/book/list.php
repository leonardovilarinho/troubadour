<?php
/**
 * Created by PhpStorm.
 * User: Leonardo Vilarinho
 * Date: 13/07/2016
 * Time: 13:19
 */
?>
<div class="text-right">
    <a href="<?php echo DOMAIN . '/book/create/' ?>" class="btn btn-primary">
        <?php echo Language::get('book')['create'] ?>
    </a>
</div>
<table class="table table-responsive">
    <thead>
        <tr>
            <th><?php echo Language::get('book')['name'] ?></th>
            <th><?php echo Language::get('book')['author'] ?></th>
            <th><?php echo Language::get('book')['price'] ?></th>
            <th><?php echo Language::get('book')['chapters'] ?></th>
            <th><?php echo Language::get('global')['actions'] ?></th>
        </tr>
    </thead>
    <tbody>
    <?php
    $books = $this->getVar('books');
    if(!empty($books)):
        foreach ($books as $book):
            echo '<tr>';
            echo '<td>' . $book->getName() . '</td>';
            echo '<td>' . $book->getAuthor() . '</td>';
            echo '<td>' . $book->getPrice() . '</td>';
            echo '<td><a href="' . DOMAIN . '/details/'. $book->getId() .'" class="btn btn-primary">'
                    . Language::get('book')['chapters']
                 . '</a></td>';
            echo '<td><a href="' . DOMAIN . '/book/delete/'. $book->getId() .'" class="btn btn-primary"><i class="fa fa-trash"></i></a> '.
                 '<a href="' . DOMAIN . '/book/edit/'. $book->getId() .'" class="btn btn-primary"><i class="fa fa-pencil"></i></a>'
                .'</td>';
            echo '</tr>';
        endforeach;
    else:
        echo "<div class='text-center'>" . Language::get('book')['empty'] . "</div>";
    endif;
    ?>
    </tbody>
</table>
