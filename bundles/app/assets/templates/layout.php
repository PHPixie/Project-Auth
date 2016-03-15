<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="utf-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<meta name="viewport" content="width=device-width, initial-scale=1">

		<link href="//maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" rel="stylesheet">
		<link rel="stylesheet" href="//maxcdn.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css">
		<link href="/bundles/app/bootstrap.min.css" rel="stylesheet">
		<link href='//fonts.googleapis.com/css?family=Stint+Ultra+Condensed' rel='stylesheet' type='text/css'>
	</head>
	<body>
		<nav class="navbar navbar-default">
			<div class="container-fluid">
				<div class="navbar-header">
					<a class="navbar-brand" href="/">
						PHPixie
					</a>
				</div>

                <div class="nav navbar-nav navbar-right">
                    <?php if($user): ?>
                        <p class="navbar-text">
                            <?=$user->email?>
                            <a class="navbar-link" href="<?=$this->httpPath('app.logout')?>"> <span class="glyphicon glyphicon-log-out"></span></a>
                        </p>
                    <?php else: ?>
          		        <li><a href="<?=$this->httpPath('app.login')?>">Login</a></li>
                    <?php endif;?>
                </div>
			</div>
		</nav>

		<?php $this->childContent(); ?>

		<script src="//ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js"></script>
		<script src="//maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>
	</body>
</html>