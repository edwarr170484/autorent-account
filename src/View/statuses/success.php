<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="/assets/css/bootstrap.min.css" />
    <title>Личный кабинет</title>
    <style>
      html, body{height: 100%;}
    </style>
</head>
<body>
    <header class="p-3 text-bg-dark mb-3">
      <div class="container">
        <div class="d-flex flex-wrap align-items-center justify-content-center justify-content-lg-start">
          <a href="/" class="d-flex align-items-center mb-2 mb-lg-0 text-white text-decoration-none">
            <svg class="bi me-2" width="40" height="32" role="img" aria-label="Bootstrap"><use xlink:href="#bootstrap"></use></svg>
          </a>
          <div class="text-end ms-auto">
            <a class="btn btn-outline-light me-2" href="/logout">Выход</a>
          </div>
        </div>
      </div>
    </header>
    <div class="container my-5">
        <div class="position-relative p-5 text-center text-muted bg-body border border-dashed rounded-5">
            <svg class="bi mt-5 mb-3" width="48" height="48"><use xlink:href="#check2-circle"></use></svg>
            <h1 class="text-body-emphasis"><?php echo $title;?></h1>
            <p class="col-lg-6 mx-auto mb-4"><?php echo $text;?></p>
            <a class="btn btn-primary px-5 mb-5" href="/">Вернуться в кабинет</a>
        </div>
    </div>
    <script src="assets/js/jquery.min.js" type="text/javascript"></script>   
    <script src="assets/js/jquery.validate.min.js" type="text/javascript"></script>                
    <script src="assets/js/bootstrap.min.js" type="text/javascript"></script>
    <script src="assets/js/custom.js" type="text/javascript"></script>
</body>
</html>