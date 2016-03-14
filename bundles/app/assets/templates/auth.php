<?php $this->layout('app:layout');?>
<div class="container">
    <div class="row">
        <div class="col-sm-4 col-sm-offset-4"

            <!-- Nav tabs -->
            <?php $activeTab = $this->get('activeTab', 'login'); ?>
            <ul class="nav nav-tabs" role="tablist">
                <li role="presentation" class="<?=$activeTab=='login' ? 'active' : ''?>">
                    <a href="#login" aria-controls="login" role="tab" data-toggle="tab">Login</a>
                </li>
                <li role="presentation" class="<?=$activeTab=='signUp' ? 'active' : ''?>">
                    <a href="#signUp" aria-controls="signUp" role="tab" data-toggle="tab">Sign Up</a>
                </li>
            </ul>

            <!-- Tab panes -->
            <div class="tab-content">
                <div role="tabpanel" class="tab-pane <?=$activeTab=='login' ? 'active' : ''?>" id="login">
                    <form method="POST" action="<?=$this->httpPath('app.login')?>">
                        <?php if($this->get('loginFailed')): ?>
                            <div class="form-group">
                                <div class="alert alert-warning" role="alert">Login failed</div>
                            </div>
                        <?php endif; ?>

                        <div class="form-group">
                            <label for="loginEmail">Email address</label>
                            <input type="email" name="email" class="form-control" id="loginEmail" placeholder="Email">
                        </div>

                        <div class="form-group">
                            <label for="loginPassword">Password</label>
                            <input type="password" name="password" class="form-control" id="loginPassword" placeholder="Password">
                        </div>

                        <div class="form-group">
                            <div class="checkbox">
                                <label>
                                    <input type="checkbox" name="rememberMe"> Remember me
                                </label>
                            </div>
                        </div>

                        <button type="submit" class="btn btn-default">Submit</button>

                    </form>
                </div>
                <div role="tabpanel" class="tab-pane <?=$activeTab=='signUp' ? 'active' : ''?>" id="signUp">
                    <form method="POST" action="<?=$this->httpPath('app.login')?>">

                        <div class="form-group">
                            <?php $field = isset($signupResult) ? $signupResult->field('email') : null; ?>
                            <label for="signupEmail">Email address</label>
                            <input type="email" value="<?=$field ? $field->getValue() : ''?>" name="email"  class="form-control" id="signupEmail" placeholder="Email">
                            <?php
                                if($field && !$field->isValid()):
                            ?>
                                <span class="help-block text-danger">
                                    <?php if($field->errors()[0]->type() == 'emailInUse'): ?>
                                        Email already in use.
                                    <?php else: ?>
                                        Not a valid email.
                                    <?php endif; ?>
                                </span>
                            <?php endif; ?>
                        </div>

                        <div class="form-group">
                            <?php $field = isset($signupResult) ? $signupResult->field('password') : null; ?>
                            <label for="signupPassword">Password</label>
                            <input type="password" name="password" value="<?=$field ? $field->getValue() : ''?>" class="form-control" id="signupEmail" placeholder="Password">
                            <?php if($field && !$field->isValid()): ?>
                                <span class="help-block text-danger">Must be at least 8 characters long.</span>
                            <?php endif; ?>
                        </div>

                        <div class="form-group">
                            <?php $field = isset($signupResult) ? $signupResult->field('passwordConfirm') : null; ?>
                            <label for="signupPasswordConfirm">Confirm Password</label>
                            <input type="password" name="passwordConfirm" class="form-control" id="signupPasswordConfirm" placeholder="Confirm Password">
                            <?php if($field && !$field->isValid()): ?>
                                <span class="help-block text-danger">Passwords don't match.</span>
                            <?php endif; ?>
                        </div>

                        <input type="hidden" name="signup" value="1" />
                        <button type="submit" class="btn btn-default">Submit</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>