<nav class="light-red lighten-1" role="navigation">
    <header>
        <div class="nav-wrapper container">
            <a id="logo-container" href="<?= URL; ?>dashboard" class="brand-logo">ATU Dues</a>
            <ul class="right hide-on-med-and-down">
                <li>
                    <a href="<?= URL; ?>user">user</a>
                </li>
                <li><div class="divider"></div></li>
                <li>
                    <a href="<?= URL; ?>import">import</a>
                </li>
                <li>
                    <a href="<?= URL; ?>export">export</a>
                </li>
                <li><div class="divider"></div></li>
                <li>
                    <a href="<?= URL; ?>members">members</a>
                </li>
                <li>
                    <a href="<?= URL; ?>companies">companies</a>
                </li>
                <li><div class="divider"></div></li>
                <? if($_SESSION['userinfo'][4] == 1 ): ?>
                    <li>
                        <a href="<?= URL; ?>admin">admin</a>
                    </li>
                <? endif; ?>
                <li><div class="divider"></div></li>
                <li>
                    <a href="<?= URL; ?>logout">logout</a>
                </li>
            </ul>
            <ul id="slide-out" class="side-nav">
                <li><div class="userView">
                        <div class="background">
                            <img src="images/slidenavbg.jpg" style="width: 100%;">
                        </div>
                        <a href="<?= URL; ?>user"><img class="circle" src="<?= $_SESSION['userinfo'][4]==1? 'images/admincircle.jpg' : 'images/usercircle.jpg'; ?>"></a>
                        <a href="<?= URL; ?>user"><span class="white-text name"><?= $_SESSION['userinfo'][2].' '.$_SESSION['userinfo'][3] ?></span></a>
                        <a href="<?= URL; ?>user"><span class="grey-text text-lighten-3 email"><?= $_SESSION['userinfo'][1] ?></span></a>
                    </div></li>
                <li>
                    <a href="<?= URL; ?>dashboard">dashboard</a>
                </li>
                <li>
                    <a href="<?= URL; ?>user">user</a>
                </li>
                <li><div class="divider"></div></li>
                <li>
                    <a href="<?= URL; ?>import">import</a>
                </li>
                <li>
                    <a href="<?= URL; ?>export">export</a>
                </li>
                <li><div class="divider"></div></li>
                <li>
                    <a href="<?= URL; ?>members">members</a>
                </li>
                <li>
                    <a href="<?= URL; ?>companies">companies</a>
                </li>
                <li><div class="divider"></div></li>
                <? if($_SESSION['userinfo'][4] == 1 ): ?>
                    <li>
                        <a href="<?= URL; ?>admin">admin</a>
                    </li>
                <? endif; ?>
                <li><div class="divider"></div></li>
                <li>
                    <a href="<?= URL; ?>logout">logout</a>
                </li>
            </ul>
            <a href="#" data-activates="slide-out" class="button-collapse"><i class="material-icons">menu</i></a>
        </div>
    </header>
</nav>
