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
                <h2>Flagged imports</h2>
                <div>
                    <p>Please validate import</p>
                </div>
                <div>
                    <form method="post" action="<?php echo URL; ?>import/runflags/ftw">
                        <?php if( !empty($_SESSION['flaggedmemberinfo']) ): ?>
                            <div class="right">
                                <button class="btn waves-effect waves-light" type="submit" name="submit">
                                    Apply changes
                                    <i class="material-icons right">trending_flat</i>
                                </button>
                            </div>
                            <table>
                                <tr>
                                    <th></th>
                                    <th>Company ID</th>
                                    <th>Name</th>
                                    <th colspan="2">Actions</th>
                                </tr>
                                <?php $i = 1;
                                foreach( $_SESSION['flaggedmemberinfo'] as $members ): ?>
                                    <tr>
                                        <td><?= $i; ?></td>
                                        <td><?= $members['employee_id']; ?></td>
                                        <td><?= $members['fname'].' '.$members['lname']; ?></td>
                                        <td>
                                            <input type="radio" name="member[<?php echo $i; ?>][flag]" value="new" <?php echo empty($members['possible_id']) ? 'checked' : ''; ?> id="newmember<?php echo $i; ?>">
                                            <label for="newmember<?php echo $i; ?>">New Member</label>
                                            <input type="radio" name="member[<?php echo $i; ?>][flag]" value="existing" <?php echo empty($members['possible_id']) ? '' : 'checked'; ?> id="existingmember<?php echo $i; ?>">
                                            <label for="existingmember<?php echo $i; ?>">Existing Member</label>
                                        </td>
                                        <td>
                                            <select name="member[<?php echo $i; ?>][member_id]">
                                                <option value="0">Select an existing member</option>
                                                <?php foreach( $this->currentmembers as $current ): ?>
                                                    <option value="<?= $current['id'] ?>" <?= $members['possible_id'] == $current['id'] ? 'selected' : ''; ?>><?= $current['firstname'].' '.$current['lastname'] ?></option>
                                                <?php endforeach; ?>
                                            </select>
                                        </td>
                                        <input type="hidden" name="member[<?php echo $i; ?>][fname]" value="<?= $members['fname']; ?>" />
                                        <input type="hidden" name="member[<?php echo $i; ?>][lname]" value="<?= $members['lname']; ?>" />
                                        <input type="hidden" name="member[<?php echo $i; ?>][title]" value="<?= $members['title']; ?>" />
                                        <input type="hidden" name="member[<?php echo $i; ?>][dues]" value="<?= $members['dues']; ?>" />
                                        <input type="hidden" name="member[<?php echo $i; ?>][date]" value="<?= $members['date']; ?>" />
                                        <input type="hidden" name="member[<?php echo $i; ?>][employee_id]" value="<?= $members['employee_id']; ?>" />
                                    </tr>
                                    <?php $i++;
                                endforeach; ?>
                            </table>
                            <div class="right">
                                <button class="btn waves-effect waves-light" type="submit" name="submit">
                                    Apply Changes
                                    <i class="material-icons right">trending_flat</i>
                                </button>
                            </div>
                        <?php else:?>
                            <div class="card teal lighten-3">
                                <div class="card-content">
                                    <span class="card-title">No New Members</span>
                                    <p>No new members found in this import</p>
                                </div>
                                <div class="card-action">
                                    <button class="btn waves-effect waves-light" type="submit" name="submit">
                                        Continue
                                        <i class="material-icons right">trending_flat</i>
                                    </button>
                                </div>
                            </div>
                        <?php endif; ?>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<?php require 'views/footer.php'; ?>
<script type="text/javascript">
    $(document).ready(function() {
        $('select').material_select();
    });
</script>
</body>
</html>
