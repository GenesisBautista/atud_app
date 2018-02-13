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
                <h2>Updated Dues</h2>
                <div>
                    <form method="post" action="<?php echo URL; ?>members/runduesupdate">
                        <div>
                            <div class="row">
                                <div class="input-field col s12">
                                    <input type="date" class="datepicker" id="date" name="date" data-value="<?= $this->duesinfo['3'] ?>">
                                    <label for="date">Date</label>
                                </div>
                            </div>
                            <div class="row">
                                <div class="input-field col s12">
                                    <input type="text" name="paid" id="paid" value="<?= $this->duesinfo['4'] ?>" />
                                    <label for="paid">Paid</label>
                                </div>
                            </div>
                        </div>
                        <input type="hidden" name="id" value="<?= $this->duesinfo['0'] ?>" />
                        <input type="hidden" name="memberid" value="<?= $this->duesinfo['1'] ?>" />
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
    var $date = "<?= $this->duesinfo['3'] ?>";
    var $datepicker = $('.datepicker').pickadate({
        selectMonths: true, // Creates a dropdown to control month
        selectYears: 15, // Creates a dropdown of 15 years to control year
        format: 'dd mmmm, yyyy',
        today: 'Today',
        clear: 'Clear',
        close: 'OK',
        formatSubmit: 'yyyy-mm-dd'
    });
</script>
</body>
</html>