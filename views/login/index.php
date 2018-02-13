<html>
<head>
    <?php require 'views/head.php'; ?>
</head>
<body>
<div class="container">
    <div class="section">
        <div class="row">
            <div class="col s8 m6 l4 offset-l4 offset-s2 offset-m3">
                <div class="card blue lighten-3">
                    <form action="<?php echo URL; ?>login/run" method="post">
                        <div class="card-content white-text">
                            <span class="card-title">Login</span>
                                <div class="row">
                                    <div class="input-field col s12">
                                        <input id="username" type="email" name="username">
                                        <label for="username">Email</label>
                                    </div>
                                    <div class="input-field col s12">
                                        <input id="password" type="password" name="password">
                                        <label for="password">Password</label>
                                    </div>
                                </div>
                        </div>
                        <div class="card-action">
                            <button class="btn waves-effect waves-light" type="submit" name="action">
                                Submit
                                <i class="material-icons right">send</i>
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<?php require 'views/footer.php'; ?>
</body>
</html>