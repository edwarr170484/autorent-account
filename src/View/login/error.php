<form method="POST" name="login-phone" id="login-phone">
    <h1 class="h3 mb-3 fw-normal text-center">Введите номер телефона</h1>
    <div class="form-floating mb-3">
        <input type="phone" class="form-control" placeholder="+375" name="phone" id="phone" value="<?php echo $phone;?>">
        <label for="floatingInput">Номер телефона</label>
    </div>
    <?php if ($message){?>
        <div class="form-message"><?php echo $message;?></div>
    <?php }?>
    <button class="btn btn-primary w-100 py-2" type="submit">Получить код по СМС</button>
</form>