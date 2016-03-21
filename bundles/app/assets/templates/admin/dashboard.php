<?php $this->layout('app:admin/layout');?>

<div class="container">
    <div class="row">
        <div class="col-sm-4 col-sm-offset-4">
            <h3>Impersonate user</h3>
            <form method="POST" target="_blank" action="<?=$this->httpPath(
                'app.admin.action',
                array('adminProcessor' => 'dashboard', 'action' => 'impersonate')
            )?>">
                <p>
                    Log in as any existing user. Since admin and user authorization is completely separated,
                    this will not log you out of your admin account.
                </p>
                <div class="form-group">
                    <select name="id" class="form-control">
                        <?php foreach($users as $user): ?>
                            <option value="<?=$_($user->id)?>"><?=$_($user->email)?></option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <button type="submit" class="btn btn-default">Impersonate</button>
            </form>
        </div>
    </div>
</div>
