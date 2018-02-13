<?php if( $this->totalresults >= 1 ): ?>
    <ul class="pagination center-align">
        <?php $totalpages = ceil($this->totalresults/50); ?>
        <li class="<?= ($this->searchparam[0]-1 > 1) ? 'waves-effect' : 'disabled'; ?>">
            <a href="<?= URL; ?>members/search/<?= ($this->searchparam[0]-1).':'.
                    $this->searchparam[1].':'.
                    $this->searchparam[2].':'.
                    $this->searchparam[3].':'.
                    $this->searchparam[4].':'.
                    $this->searchparam[5]; ?>">
                <i class="material-icons">chevron_left</i>
            </a>
        </li>
        <?php foreach( $this->pages as $page=>$status ): ?>
            <li class="<?= ($status == 'page') ? 'waves-effect' : 'active'; ?>">
                <a href="<?= URL; ?>members/search/<?= ($page).':'.
                        $this->searchparam[1].':'.
                        $this->searchparam[2].':'.
                        $this->searchparam[3].':'.
                        $this->searchparam[4].':'.
                        $this->searchparam[5]; ?>">
                    <?= $page; ?>
                </a>
            </li>
        <?php endforeach; ?>
        <li class="<?= ($this->searchparam[0]+1 < $totalpages) ? 'waves-effect' : 'disabled'; ?>">
            <a href="<?= URL; ?>members/search/<?= ($this->searchparam[0]+1).':'.
                    $this->searchparam[1].':'.
                    $this->searchparam[2].':'.
                    $this->searchparam[3].':'.
                    $this->searchparam[4].':'.
                    $this->searchparam[5]; ?>">
                <i class="material-icons">chevron_right</i>
            </a>
        </li>
    </ul>
<?php endif; ?>
