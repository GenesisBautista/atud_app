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
                <h2>Update Company</h2>
                <div>
                    <form method="post" action="<?php echo URL; ?>companies/runupdate">
                        <div>
                            <div>
                                <input type="text" name="name" value="<?php echo $this->companyinfo['1']; ?>" id="name" />
                                <label for="name">Company Name: </label>
                            </div>
                            <div>
                                <select name="active" id="active">
                                    <option value="1" <?= ($this->companyinfo['2']==1)? 'selected' : ''; ?> >Active</option>
                                    <option value="0" <?= ($this->companyinfo['2']==0)? 'selected' : ''; ?> >Inactive</option>
                                </select>
                                <label for="active">Status</label>
                            </div>
                        </div>
                        <input type="hidden" name="id" value="<?php echo $this->companyinfo['0']; ?>">
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