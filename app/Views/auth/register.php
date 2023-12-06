
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
                    <h2>Register</h2>
                    
                    <span class="text-danger text-sm"><?= isset($validation_email) ? $validation_email: '' ?></span>

                    <form action="<?= base_url("register") ?>" method="post" class="form">
                        <input type="hidden" name="<?= csrf_token() ?>" value="<?= csrf_hash() ?>" />
                        <div class="form-group">

                            <label for="email">Email
                            </label>
                            <input value="<?= set_value('email') ?>" type="text" class="form-control" name="email" id="email">
                            <span class="text-danger text-sm"><?= isset($validation) ? display_form_errors($validation,'email'): '' ?></span>
                        </div>
                        <div class="form-group my-3">
                            <label for="name">Name
                            </label>
                            <input value="<?= set_value('name') ?>" type="text" class="form-control" name="name" id="name">

                            <span class="text-danger text-sm"><?= isset($validation) ? display_form_errors($validation,'name'): '' ?></span>

                        </div>
                        
                        <div class="form-group my-3">
                            <label for="password">Mật Khẩu
                            </label>
                            <input value="<?= set_value('password') ?>" type="password" class="form-control" name="password" id="password">
                            <span class="text-danger text-sm"><?= isset($validation) ? display_form_errors($validation,'password'): '' ?></span>

                        </div>
                        <div class="form-group my-3">
                            <label for="confirm">Nhập Lại Mật Khẩu
                            </label>
                            <input value="<?= set_value('confirm') ?>" type="password" class="form-control" name="confirm" id="confirm">
                            <span class="text-danger text-sm"><?= isset($validation) ? display_form_errors($validation,'confirm'): '' ?></span>

                        </div>
                        <button type="submit" class="btn btn-primary">Đăng Nhập</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</body>

</html>