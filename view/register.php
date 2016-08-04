<!doctype html>
<html lang="pt">
<head>
    <meta charset="UTF-8">
    <title><?php echo Language::get('register')['title'] ?></title>
    <link rel="stylesheet" href="<?php echo DOMAIN . "/libs/bootstrap/css/bootstrap.min.css" ?>">
</head>
<body>
    <br><br>
    <div class="col-md-4 col-md-offset-4">
        <div class="panel panel-primary">
            <div class="panel-heading">
                <h4 class="panel-title"><?php echo Language::get('register')['title'] ?></h4>
            </div>
            <form action="#" method="post">
                <div class="panel-body">
                    <label for="username"><?php echo Language::get('login')['username'] ?>:</label>
                    <input name="username" placeholder="<?php echo Language::get('login')['username'] ?>" value="<?php echo Post::get('username') ?>" required class="form-control" type="text" />

                    <label for="password"><?php echo Language::get('login')['password'] ?>:</label>
                    <input name="password" placeholder="<?php echo Language::get('login')['password'] ?>" required class="form-control" type="text" />
                </div>
                <div class="panel-footer text-right">
                    <?php echo $this->getVar('error') ?>
                    <input value="<?php echo Language::get('register')['btn'] ?>" class="btn btn-primary" type="submit" />
                </div>
            </form>
        </div>
    </div>
</body>
</html>