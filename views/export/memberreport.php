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
                <h2>Individual Reports</h2>
                <div>
                    <form action="<?php echo URL; ?>export/memberreport" method="post">
                        <label>Name</label><input type="text" name="name" value="<?php echo ( !empty($_POST['name']) ) ? $_POST['name'] : NULL; ?>" /><br />
                        <label>Company</label>
                        <select name="company">
                            <option value="">All Companies</option>
                            <?php foreach( $this->companylist as $company): ?>
                                <option value="<? echo $company['id']; ?>" <?php echo ($company['id']==$_POST['company'])? selected : ''; ?>><?php echo $company['name']; ?></option>
                            <?php endforeach; ?>
                        </select><br />
                        <input type="checkbox" id ="acitve" name="active" value="1" <?php echo ( $_POST['active'] )? 'checked': ''; ?> />
                        <label for="acitve">Include inactive members</label>
                        <div>
                            <button class="btn waves-effect waves-light" type="submit" name="action">
                                Search
                                <i class="material-icons right">search</i>
                            </button>
                        </div>
                    </form>
                </div>
                <div class="col s12">
                    <table class="center">
                        <tr>
                            <th>Company</th>
                            <th>Name</th>
                            <th>Employee ID</th>
                            <th>Actions</th>
                        </tr>
                        <?php foreach( $this->memberslist as $members ): ?>
                            <tr>
                                <td><?php echo $members['company']; ?></td>
                                <td><?php echo $members['firstname'].' '.$members['lastname']; ?></td>
                                <td><?php echo $members['company_id']; ?></td>
                                <td><a class="waves-effect waves-light btn" href="<?= URL; ?>export/generatememberreport/<?= $members['id']; ?>"><i class="material-icons right">input</i>Generate Report</a></td>
                            </tr>
                        <?php endforeach; ?>
                    </table>
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
