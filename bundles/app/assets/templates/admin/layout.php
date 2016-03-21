<?php $this->layout('app:html');?>
<nav class="navbar navbar-default">
    <div class="container-fluid">
        <div class="navbar-header">
            <a class="navbar-brand" href="/">
                Admin Dashboard
            </a>
        </div>

        <div class="nav navbar-nav navbar-right">
            <?php if($admin): ?>
                <p class="navbar-text">
                    <?=$admin->username?>
                    <a class="navbar-link" href="<?=$this->httpPath(
                        'app.admin.action',
                        array('processor' => 'auth', 'action' => 'logout')
                    )?>"> <span class="glyphicon glyphicon-log-out"></span></a>
                </p>
            <?php else: ?>
                <li><a href="<?=$this->httpPath(
                        'app.admin.processor',
                        array('processor' => 'auth')
                    )?>">Login</a></li>
            <?php endif;?>
        </div>
    </div>
</nav>

<?php $this->childContent(); ?>