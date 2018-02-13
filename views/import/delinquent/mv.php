<html>
<head>
    <?php require 'views/head.php'; ?>
</head>
<body>
<?php require 'views/header.php'; ?>
<div class="container">
    <div class="section">
        <div class="row">
            <div class="col s12 m12 l12">
                <h2>Delinquent Members</h2>
                <div>
                    <p>Please validate delinquent members</p>
                </div>
                <div>
                    <form method="post" action="<?php echo URL; ?>import/rundelinquents/mv">
                        <div class="right">
                            <button class="btn waves-effect waves-light" type="submit" name="submit">
                                Apply Changes
                                <i class="material-icons right">trending_flat</i>
                            </button>
                        </div>
                        <table>
                            <tr>
                                <th></th>
                                <th>Member ID</th>
                                <th>Name</th>
                                <th colspan="2">Actions</th>
                            </tr>
                            <?php $i = 1;
                            if( !empty($this->delinquentmem) ):
                                foreach( $this->delinquentmem as $members ): ?>
                                    <tr>
                                        <td><?= $i; ?></td>
                                        <td><?= $members['company_id']; ?></td>
                                        <td><?= $members['firstname'].' '.$members['lastname']; ?></td>
                                        <td>
                                            <input type="radio" name="member[<?= $i; ?>][action]" value="delinquent" id="delinquent<?= $i; ?>" >
                                            <label for="delinquent<?= $i; ?>">Delinquent this month</label>
                                            <input type="radio" name="member[<?= $i; ?>][action]" value="deactivate" id="deactivate<?= $i; ?>">
                                            <label for="deactivate<?= $i; ?>">Deactivate member</label>
                                        </td>
                                        <input type="hidden" name="member[<?= $i; ?>][id]" value="<?= $members['id']; ?>" />
                                        <?php $n=0;
                                        foreach( $this->delinquentdate as $date ): ?>
                                            <input type="hidden" name="member[<?= $i; ?>][date][<?= $n; ?>]" value="<?= $date; ?>">

                                        <?php $n++; endforeach; ?>
                                    </tr>
                                    <?php $i++;
                                endforeach;
                            else: ?>
                                <tr>
                                    <td colspan="5">
                                        No Deliquents
                                    </td>
                                </tr>
                            <?php endif;?>
                        </table>
                        <input type="hidden" name="company_id" value="<?= $this->delinquentmem[0]['company_fk']; ?>">
                        <div class="right">
                            <button class="btn waves-effect waves-light" type="submit" name="submit">
                                Apply Changes
                                <i class="material-icons right">trending_flat</i>
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<?php require 'views/footer.php'; ?>
</body>
</html>
