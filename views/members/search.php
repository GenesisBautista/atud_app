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
                <form action="<?php echo URL; ?>members/search" method="post">
                    <h2>View Members</h2>
                    <?php if( !empty($_SESSION['memberfunction']) ): ?>
                        <div class="red-text">
                            <?php echo $_SESSION['memberfunction']; ?>
                        </div>
                    <?php endif; ?>
                    <div class="row">
                        <div class="input-field col s12">
                            <input type="text" name="name" id="name" value="<?= ( $this->searchparam[5] == 'empty' ? NULL : $this->searchparam[5] ); ?>" />
                            <label for="name">Name</label>
                        </div>
                    </div>
                    <div class="row">
                        <div class="input-field col s12 m6 l6">
                            <select name="company" id="company">
                              <option value="0">All Companies</option>
                              <?php foreach( $this->companylist as $company): ?>
                                <option value="<? echo $company['id']; ?>" <?php echo ($company['id']==$this->searchparam[4])? selected : ''; ?>><?php echo $company['name']; ?></option>
                              <?php endforeach; ?>
                            </select>
                            <label for="company">Company</label>
                        </div>
                        <div class="input-field col s6 m3 l3">
                            <input type="checkbox" id ="acitve" name="active" value="1" <?php echo ( $this->searchparam[3] )? 'checked': ''; ?> />
                            <label for="acitve">Include inactive members</label>
                        </div>
                        <div class="input-field col s6 m3 l3">
                            <input type="hidden" value="<?= $this->searchparam[0]; ?>" name="page">
                            <input type="hidden" value="<?= $this->searchparam[1]; ?>" name="sort">
                            <input type="hidden" value="<?= $this->searchparam[2]; ?>" name="sorttype">
                            <button class="btn waves-effect waves-light" type="submit" name="search" value="1">
                                Search
                                <i class="material-icons right">search</i>
                            </button>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col s12 card blue lighten-5 z-depth-1">
                            <div class="card-content">
                                <span class="card-title"><?= $this->totalresults ?> Results</span>

                                <?php View::renderComponent('pagination'); ?>

                                <?php View::renderComponent('search/membersearchresult'); ?>

                                <?php View::renderComponent('pagination'); ?>

                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<?php require 'views/footer.php'; ?>
<div class="fixed-action-btn">
    <a href="<?php echo URL ?>members/create" class="btn-floating btn-large waves-effect waves-light red"><i class="material-icons">add</i></a>
</div>
<script type="text/javascript">
    $(document).ready(function() {
        $('select').material_select();
    });
</script>
</body>
</html>
