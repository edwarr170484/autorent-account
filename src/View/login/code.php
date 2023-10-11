<main class="form-signin w-100 m-auto">
    <form method="POST" action="/login/auth" name="login-code" id="login-code" onsubmit="return false">
        <h6 class="h6 mb-3 fw-normal text-center"><?php echo $message;?></h6>
        <div class="form-floating mb-3">
            <input type="text" class="form-control" name="code" placeholder="Код из SMS">
            <label for="floatingInput">Код из SMS</label>
        </div>
        <div class="form-message"></div>
        <input type="hidden" class="form-control" name="phone" value="<?php echo $phone;?>">
        <button class="btn btn-primary w-100 py-2" type="submit">Войти</button>
    </form>
</main>