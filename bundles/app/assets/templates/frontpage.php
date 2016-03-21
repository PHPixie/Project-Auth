<?php $this->layout('app:layout');?>

<div class="container">
    <div class="jumbotron">
        <h1>Welcome!</h1>
        <p>PHPixie authorization skeleton app</p>
        <p>
            <?php if($user): ?>
                <a class="btn btn-primary btn-lg" href="<?=$this->httpPath(
                    'app.processor',
                    array('processor' => 'dashboard')
                )?>" role="button">Dashboard</a>
            <?php else: ?>
                <a class="btn btn-primary btn-lg" href="<?=$this->httpPath(
                    'app.processor',
                    array('processor' => 'auth')
                )?>" role="button">Login</a>
            <?php endif;?>
        </p>
    </div>
</div>