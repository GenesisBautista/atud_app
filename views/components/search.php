<table class="striped bordered">
    <thead>
        <tr>
            <th><a href="<?= URL; ?>members/search/<?=
                    $this->searchparam[0].':'.
                    'company'.':'.
                    ($this->searchparam[1] == 'company' && $this->searchparam[2] == 'asc' ?
                        'desc' :
                        'asc').':'.
                    $this->searchparam[3].':'.
                    $this->searchparam[4].':'.
                    $this->searchparam[5].':'; ?>">Company</a></th>
            <th><a href="<?= URL; ?>members/search/<?=
                    $this->searchparam[0].':'.
                    'name'.':'.
                    ($this->searchparam[1] == 'name' && $this->searchparam[2] == 'asc' ?
                        'desc' :
                        'asc').':'.
                    $this->searchparam[3].':'.
                    $this->searchparam[4].':'.
                    $this->searchparam[5]; ?>">Name</a></th>
            <th><a href="<?= URL; ?>members/search/<?=
                    $this->searchparam[0].':'.
                    $this->searchparam[1].':'.
                    $this->searchparam[2].':'.
                    $this->searchparam[3].':'.
                    'title'.':'.
                    ($this->searchparam[4] == 'title' && $this->searchparam[5] == 'asc' ?
                        'desc' :
                        'asc'); ?>">Title</a></th>
            <th><a href="<?= URL; ?>members/search/<?=
                    $this->searchparam[0].':'.
                    'status'.':'.
                    ($this->searchparam[1] == 'status' && $this->searchparam[2] == 'asc' ?
                        'desc' :
                        'asc').':'.
                    $this->searchparam[3].':'.
                    $this->searchparam[4].':'.
                    $this->searchparam[5]; ?>">Status</a></th>
            <th colspan="3">Actions</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach( $this->memberslist as $members ): ?>
            <tr>
                <td><?php echo $members['company']; ?></td>
                <td><?php echo $members['name']; ?></td>
                <td><?php echo $members['title']; ?></td>
                <td><?php echo ($members['status']==0)? 'Inactive': 'Active'; ?></td>
                <td><a href="<?php echo URL; ?>members/update/<?php echo $members['id'] ?>">Edit</a></td>
                <td><a href="<?php echo URL; ?>members/dues/<?php echo $members['id'] ?>">Dues</a></td>
                <?php if( $members['status']==1 ): ?>
                    <td><a href="<?php echo URL; ?>members/deactivate/<?php echo $members['id'] ?>">Deactivate</a></td>
                <?php else: ?>
                    <td><a href="<?php echo URL; ?>members/reactivate/<?php echo $members['id'] ?>">Reactivate</a></td>
                <?php endif ?>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>
