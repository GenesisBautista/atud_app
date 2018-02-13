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
                <form action="<?php echo URL; ?>members/runtest" method="post">
                    <h2>View Members</h2>
                    <?php if( !empty($_SESSION['memberfunction']) ): ?>
                        <div class="red-text">
                            <?php echo $_SESSION['memberfunction']; ?>
                        </div>
                    <?php endif; ?>
                    <div class="row">
                        <div class="input-field col s12">
                            <input type="text" name="name" id="name" value="<?= ( $this->searchparam[2] == 'empty' ? NULL : $this->searchparam[2] ); ?>" />
                            <label for="name">Name</label>
                        </div>
                    </div>
                    <div class="row">
                        <div class="input-field col s12 m6 l6">
                            <select name="company" id="company">
                              <option value="">All Companies</option>
                              <?php foreach( $this->companylist as $company): ?>
                                <option value="<? echo $company['id']; ?>" <?php echo ($company['id']==$this->searchparam[1])? selected : ''; ?>><?php echo $company['name']; ?></option>
                              <?php endforeach; ?>
                            </select>
                            <label for="company">Company</label>
                        </div>
                        <div class="input-field col s6 m3 l3">
                            <input type="checkbox" id ="acitve" name="active" value="1" <?php echo ( $this->searchparam[0] )? 'checked': ''; ?> />
                            <label for="acitve">Include inactive members</label>
                        </div>
                        <div class="input-field col s6 m3 l3">
                            <button class="btn waves-effect waves-light" type="submit" name="search" value="1">
                                Search
                                <i class="material-icons right">search</i>
                            </button>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col s12 card blue lighten-5 z-depth-1">
                            <div class="card-content">
                                <span class="card-title"><?= Session::get('resultcount') ?> Results</span>
                                <ul class="pagination center-align">
                                    <li class="waves-effect">
                                        <button name="prev" type="submit" value=<?= $this->searchparam[3]-1 ?> class="blue lighten-5" style="border: 0;">
                                            <i class="material-icons">chevron_left</i>
                                        </button>
                                    </li>
                                    <input type="hidden" value="<?= $this->searchparam[3]; ?>" name="page">
                                    <?php foreach( $this->pages as $page=>$status ): ?>
                                        <li <?= $status == 'page' ? 'class="waves-effect"' : 'class="active"'; ?>>
                                            <button name="page" type="submit" value=<?= $page ?> class="blue lighten-5" style="border: 0;">
                                                <?= $page ?>
                                            </button>
                                        </li>
                                    <?php endforeach; ?>
                                    <li class="waves-effect">
                                        <button name="next" type="submit" value=<?= $this->searchparam[3]+1 ?> class="blue lighten-5" style="border: 0;">
                                            <i class="material-icons">chevron_right</i>
                                        </button>
                                    </li>
                                </ul>
                                <table class="striped bordered">
                                    <thead>
                                        <tr>
                                            <th>Company</th>
                                            <th>Name</th>
                                            <th>Role</th>
                                            <th>Status</th>
                                            <th colspan="3">Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php foreach( $this->memberslist as $members ): ?>
                                            <tr>
                                                <td><?php echo $members['company']; ?></td>
                                                <td><?php echo $members['firstname'].' '.$members['lastname']; ?></td>
                                                <td><?php echo $members['title']; ?></td>
                                                <td><?php echo ($members['active']==0)? 'Inactive': 'Active'; ?></td>
                                                <td><a href="<?php echo URL; ?>members/update/<?php echo $members['id'] ?>">Edit</a></td>
                                                <td><a href="<?php echo URL; ?>members/dues/<?php echo $members['id'] ?>">Dues</a></td>
                                                <?php if( $members['active']==1 ): ?>
                                                    <td><a href="<?php echo URL; ?>members/deactivate/<?php echo $members['id'] ?>">Deactivate</a></td>
                                                <?php else: ?>
                                                    <td><a href="<?php echo URL; ?>members/reactivate/<?php echo $members['id'] ?>">Reactivate</a></td>
                                                <?php endif ?>
                                            </tr>
                                        <?php endforeach; ?>
                                    </tbody>
                                </table>
                                <ul class="pagination center-align">
                                    <li class="waves-effect">
                                        <button name="prev" type="submit" value=<?= $this->searchparam[3]-1 ?> class="blue lighten-5" style="border: 0;">
                                            <i class="material-icons">chevron_left</i>
                                        </button>
                                    </li>
                                    <?php foreach( $this->pages as $page=>$status ): ?>
                                        <li <?= $status == 'page' ? 'class="waves-effect"' : 'class="active"'; ?>>
                                            <button name="page" type="submit" value=<?= $page ?> class="blue lighten-5" style="border: 0;">
                                                <?= $page ?>
                                            </button>
                                        </li>
                                    <?php endforeach; ?>
                                    <li class="waves-effect">
                                        <button name="next" type="submit" value=<?= $this->searchparam[3]+1 ?> class="blue lighten-5" style="border: 0;">
                                            <i class="material-icons">chevron_right</i>
                                        </button>
                                    </li>
                                </ul>
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
