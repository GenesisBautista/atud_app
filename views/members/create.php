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
                <h2>Members Page!</h2>
                <div>
                    <form method="post" action="<?php echo URL; ?>members/runcreate">
                        <div>
                            <div class="row">
                                <div class="input-field col s12">
                                    <input type="text" name="fname" id="fname" />
                                    <label for="fname">First Name</label>
                                </div>
                            </div>
                            <div class="row">
                                <div class="input-field col s12">
                                    <input type="text" name="lname" id="lname" />
                                    <label for="lname">Last Name</label>
                                </div>
                            </div>
                            <div class="row">
                                <div class="input-field col s12">
                                    <input type="text" name="title" id="title" />
                                    <label for="title">Title</label>
                                </div>
                            </div>
                            <div class="row">
                                <div class="input-field col s12">
                                    <select name="company" id="company">
                                        <option value="" disabled>Select Company</option>
                                        <?php foreach( $this->companylist as $company): ?>
                                            <option value="<? echo $company['id']; ?>" <?php echo ($company['id']==$_POST['company'])? selected : ''; ?>><?php echo $company['name']; ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                    <label for="company">Select Company</label>
                                </div>
                            </div>
                            <div class="row">
                                <div class="input-field col s12">
                                    <input type="text" name="empid" id="empid" />
                                    <label for="empid">Employee ID</label>
                                </div>
                            </div>
                        </div>
                        <button class="btn waves-effect waves-light" type="submit" name="action">
                            Submit
                            <i class="material-icons right">done</i>
                        </button>
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
