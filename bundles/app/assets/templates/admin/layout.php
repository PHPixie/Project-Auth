<?php $this->layout('app:html');?>
<nav class="navbar navbar-default">
    <div class="container-fluid">
        <div class="navbar-header">
            <a class="navbar-brand" href="/">
                Admin Dashboard
            </a>
        </div>

        <div class="nav navbar-nav navbar-right">
            <p class="navbar-text">
                <?=$admin->username?>
                <a class="navbar-link" href="<?=$this->httpPath(
                    'app.admin.action',
                    array('adminProcessor' => 'auth', 'action' => 'logout')
                )?>"> <span class="glyphicon glyphicon-log-out"></span></a>
            </p>
        </div>
    </div>
</nav>

<?php $this->childContent(); ?>