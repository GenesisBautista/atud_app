<html>
<head>
    <?php require 'views/head.php'; ?>
</head>
<body>
<?php require 'views/header.php'; ?>
<div class="container">
    <div class="section">
        <div class="row">
            <div class="col s12 m8 l6 offset-l3 offset-m2">
                <h2>Import Data</h2>
                <?php if( !empty($_SESSION['importmessage']) ): ?>
                    <div class="red-text">
                        <?php echo $_SESSION['importmessage']; ?>
                    </div>
                <?php endif; ?>
                <div>
                    <form method="post" action="<?php echo URL; ?>import/run" enctype="multipart/form-data">
                        <div>
                            <div class="input-field col s12">
                                <select name="company" id="company">
                                    <option value="" disabled>Select Company</option>
                                    <?php foreach( $this->companylist as $company): ?>
                                        <option value="<? echo $company['id']; ?>" <?php echo ($company['id']==$this->memberinfo['1'])? 'selected' : ''; ?>><?php echo $company['name']; ?></option>
                                    <?php endforeach; ?>
                                </select>
                                <label for="company">Select a Company</label>
                            </div>
                            <p>Please upload a company xlsx or xls</p>
                            <div class="file-field input-field">
                                <div class="btn">
                                    <span>File</span>
                                    <input type="file" name="importfile">
                                </div>
                                <div class="file-path-wrapper">
                                    <input class="file-path validate" type="text">
                                </div>
                            </div>
                            <input type="hidden" name="verifier" value="<?php echo $this->verifier; ?>">
                        </div>
                        <div class="right">
                            <button class="btn waves-effect waves-light" type="submit" name="submit">
                                Start Import
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
<script type="text/javascript">
    $(document).ready(function() {
        $('select').material_select();
    });
</script>
</body>
</html>
