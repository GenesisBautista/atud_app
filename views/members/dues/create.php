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
                <h2>Create Dues for <?= $this->memberinfo[2].' '.$this->memberinfo[3]; ?></h2>
                <div>
                    <form method="post" action="<?php echo URL; ?>members/runduescreate">
                        <div>
                            <div class="row">
                                <div class="input-field col s12">
                                    <input type="date" class="datepicker" id="date" name="date" value="">
                                    <label for="date">Date</label>
                                </div>
                            </div>
                            <div class="row">
                                <div class="input-field col s12">
                                    <input type="text" name="paid" id="paid" value="" />
                                    <label for="paid">Paid</label>
                                </div>
                            </div>
                        </div>
                        <input type="hidden" name="memberid" value="<?= $this->memberid ?>" />
                        <input type="hidden" name="companyid" value="<?= $this->memberinfo[1] ?>" />
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
    $('.datepicker').pickadate({
        selectMonths: true, // Creates a dropdown to control month
        selectYears: 15 // Creates a dropdown of 15 years to control year
    });
</script>
</body>
</html>