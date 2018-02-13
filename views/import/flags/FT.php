<html>
<head>

</head>
<body>
<?php require 'views/header.php'; ?>
New Members Page!
<div>
    <p>Members that do not have past </p>
</div>
<div>
    <form method="post" action="<?php echo URL; ?>import/runflags">
        <?php if( !empty($_SESSION['flaggedmemberinfo']) ): ?>
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
                        <td><input type="radio" name="member[<?php echo $i; ?>][flag]" value="new" <?php echo empty($members['possible_id']) ? 'checked' : ''; ?>>New Member</td>
                        <td>
                            <input type="radio" name="member[<?php echo $i; ?>][flag]" value="existing" <?php echo empty($members['possible_id']) ? '' : 'checked'; ?>>Existing Member
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
            <input type="submit" value="Apply Changes" name="submit">
        <?php else:?>
            <p><b>No new members</b></p>
            <input type="submit" value="Continue" name="submit">
        <?php endif; ?>
    </form>
</div>
</body>
</html>
