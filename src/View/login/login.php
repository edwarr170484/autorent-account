<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="/assets/css/bootstrap.min.css" />
    <link rel="stylesheet" href="/assets/css/login.css" />
    <title>Личный кабинет - Вход</title>
</head>
    <body class="d-flex align-items-center py-4 bg-body-tertiary">
        <main class="form-signin w-100 m-auto">
            <form method="POST" name="login-phone" id="login-phone">
                <h1 class="h3 mb-3 fw-normal text-center">Введите номер телефона</h1>
                <div class="form-floating mb-3">
                    <input type="phone" class="form-control" placeholder="+375" name="phone" id="phone">
                    <label for="floatingInput">Номер телефона</label>
                </div>
                <?php if ($message){?>
                    <div class="form-message mb-3"><?php echo $message;?></div>
                <?php }?>
                <button class="btn btn-primary w-100 py-2" type="submit">Получить код по СМС</button>
            </form>
        </main>
    <script src="assets/js/jquery.min.js" type="text/javascript"></script>   
    <script src="assets/js/jquery.validate.min.js" type="text/javascript"></script>  
    <script src="assets/js/bootstrap.min.js" type="text/javascript"></script>
    <script src="assets/js/login.js" type="text/javascript"></script>
</body>
</html>