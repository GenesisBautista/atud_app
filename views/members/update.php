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
                <h2>Updated Member</h2>
                <div>
                    <form method="post" action="<?php echo URL; ?>members/runupdate">
                        <div>
                            <div class="row">
                                <div class="input-field col s12">
                                    <input type="text" name="fname" id="fname" value="<?= $this->memberinfo['2'] ?>" />
                                    <label for="fname">First Name</label>
                                </div>
                            </div>
                            <div class="row">
                                <div class="input-field col s12">
                                    <input type="text" name="lname" id="lname" value="<?= $this->memberinfo['3'] ?>" />
                                    <label for="lname">Last Name</label>
                                </div>
                            </div>
                            <div class="row">
                                <div class="input-field col s12">
                                    <input type="text" name="title" id="title" value="<?= $this->memberinfo['4'] ?>" />
                                    <label for="title">Title</label>
                                </div>
                            </div>
                            <div class="row">
                                <div class="input-field col s12">
                                    <select name="company" id="company">
                                        <option value="" disabled>Select Company</option>
                                        <?php foreach( $this->companylist as $company): ?>
                                            <option value="<? echo $company['id']; ?>" <?php echo ($company['id']==$this->memberinfo['1'])? 'selected' : ''; ?>><?php echo $company['name']; ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                    <label for="company">Select Company</label>
                                </div>
                            </div>
                            <div class="row">
                                <div class="input-field col s12">
                                    <input type="text" name="empid" id="empid" value="<?= $this->memberinfo['5'] ?>" />
                                    <label for="empid">Employee ID</label>
                                </div>
                            </div>
                            <div class="row">
                                <div class="input-field col s12">
                                    <textarea name="note" id="note" value="<?= $this->memberinfo['8'] ?>" class="materialize-textarea"></textarea>
                                    <label for="note">Notes</label>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col s12">
                                    <div class="row">
                                        <div class="input-field col s12">
                                            <select name="status" id="active">
                                                <option value="1" <?= ($this->memberinfo['6']==1)? 'selected' : ''; ?> >Active</option>
                                                <option value="2" <?= ($this->memberinfo['6']==0)? 'selected' : ''; ?> >Inactive</option>
                                            </select>
                                            <label for="active">Title</label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <input type="hidden" name="id" value="<?= $this->memberinfo['0'] ?>" />
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