<?php $this->layout('app:html');?>
<div class="container">
    <div class="row">
        <div class="col-sm-4 col-sm-offset-4">
            <h1>Login</h1>
            <form method="POST" action="<?=$this->httpPath(
                'app.admin.processor',
                array('adminProcessor' => 'auth')
            )?>?>">
                <?php if($this->get('loginFailed')): ?>
                    <div class="form-group">
                        <div class="alert alert-warning" role="alert">Login failed</div>
                    </div>
                <?php endif; ?>

                <div class="form-group">
                    <label for="username">Username</label>
                    <input type="text" name="username" class="form-control" id="username" placeholder="Username">
                </div>

                <div class="form-group">
                    <label for="password">Password</label>
                    <input type="password" name="password" class="form-control" id="password" placeholder="Password">
                </div>

                <button type="submit" class="btn btn-default">Submit</button>
            </form>
        </div>
    </div>
</div>