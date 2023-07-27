<?php

use CodeIgniter\Pager\PagerRenderer;

/**
 * @var PagerRenderer $pager
 */
$pager->setSurroundCount(2);
?>

<ul class="uk-pagination uk-flex-right" uk-margin>
    <?php if ($pager->hasPrevious()) { ?>
        <li><a href="<?= $pager->getFirst() ?>"><span uk-icon="chevron-double-left"></span></a></li>
        <li><a href="<?= $pager->getPrevious() ?>"><span uk-icon="chevron-left"></span></a></li>
    <?php } else { ?>
        <li class="uk-disabled"><span uk-icon="chevron-double-left"></span></li>
        <li class="uk-disabled"><span uk-icon="chevron-left"></span></li>
    <?php } ?>

    <?php
    foreach ($pager->links() as $link) {
        if ($link['active'] === true) {
            echo '<li class="uk-active">'.$link['title'].'</li>';
        } else {
            echo '<li><a href="'.$link['uri'].'">'.$link['title'].'</a></li>';
        }
    }
    ?>

    <?php if ($pager->hasNext()) { ?>
        <li><a href="<?= $pager->getNext() ?>"><span uk-icon="chevron-right"></span></a></li>
        <li><a href="<?= $pager->getLast() ?>"><span uk-icon="chevron-double-right"></span></a></li>
    <?php } else { ?>
        <li class="uk-disabled"><span uk-icon="chevron-right"></span></li>
        <li class="uk-disabled"><span uk-icon="chevron-double-right"></span></li>
    <?php } ?>
</ul>