<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <title>Document</title>
    <link href="<?php echo base_url('assets/css/login.css'); ?>" rel="stylesheet">
</head>

<body>
    <div class="main">
        <div class="container">
            <div class="row">
                <div class="col-md-4 offset-4">
                    <h2>Login</h2>
                    <span class="text-danger text-sm"><?= isset($login_fail) ? $login_fail: '' ?></span>

                    <form action="<?= base_url("login") ?>" method="post" class="form">
                        <input type="hidden" name="<?= csrf_token() ?>" value="<?= csrf_hash() ?>" />
                        <div class="form-group">

                            <label for="username">Email
                            </label>
                            <input type="text" value="<?= set_value('email') ?>" class="form-control" name="email" id="username">
                            <span class="text-danger text-sm"><?= isset($validation) ? display_form_errors($validation,'email'): '' ?></span>

                        </div>
                        <div class="form-group my-3">
                            <label for="password">Mật Khẩu
                            </label>
                            <input type="password" class="form-control" name="password" id="password">
                            <span class="text-danger text-sm"><?= isset($validation) ? display_form_errors($validation,'password'): '' ?></span>

                        </div>
                        <button type="submit" class="btn btn-primary">Đăng Nhập</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</body>

</html>