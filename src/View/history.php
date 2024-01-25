<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="/assets/css/bootstrap.min.css" />
    <title>Личный кабинет</title>
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
    <div class="container">
      <div class="row">
        <div class="col">
          <h2 class="pb-3">История по договору <?php echo $data["Номер"];?></h2>
          <div class="table-responsive small">
            <table class="table table-striped table-bordered">
              <tbody>
                <?php if($data && !$data["ЕстьОшибка"]){ ?>
                  <tr>
                    <td colspan="2"><b>Документ</b></td>
                    <td><b>Сумма</b></td>
                  </tr>
                  <tr>
                    <td colspan="2">Договор <?php echo $data["Номер"];?> от <?php echo explode(" ", $data["Дата"])[0];?></td>
                    <td><?php echo $data["Сумма"];?></td>
                  </tr>
                  <?php if(count($data['ПодчиненныеДокументы']) > 0){?>
                    <?php foreach($data['ПодчиненныеДокументы'] as $document){?>
                      <tr>
                        <td style="width: 50px"></td>
                        <td><?php echo $document['ВидДокумента'];?> <?php echo $document["Номер"];?> от <?php echo explode(' ', $document["Дата"])[0];?></td>
                        <td><?php echo $document["Сумма"];?></td>
                      </tr>
                    <?php }?>
                  <?php }?>
                <?php }else{?>
                <tr>
                  <td colspan="2"><?php echo $data["ТекстОшибки"];?></td>
                </tr>
                <?php }?>
              </tbody>
            </table>
          </div>
        </div>
      </div>
    </div>
    <script src="assets/js/bootstrap.min.js" type="text/javascript"></script>
</body>
</html>