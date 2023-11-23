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
    <div class="container-fluid">
      <div class="row">
        <div class="col">
          <h2>Договоры</h2>
          <div class="table-responsive small">
            <table class="table table-striped table-bordered" >
              <thead>
                <tr>
                  <th scope="col">№ и дата договора</th>
                  <th scope="col">
                    <label for="">Статус</label>
                    <select class="form-select" id="select-status">
                      <option value="all">Все</option>
                      <option value="active">Действующие</option>
                    </select>
                  </th>
                  <th scope="col">Дата последнего продления</th>
                  <th scope="col">Сумма пролонгации (предварительно)</th>
                  <th scope="col">Сумма выкупа (предварительно)</th>
                  <th>Действия</th>
                </tr>
              </thead>
              <tbody id="contract-list">
                <?php if($items && count($items) > 0){ ?>
                  <?php foreach($items as $item){ ?>
                    <tr class="<?php echo $item["Класс"];?>">
                      <td>
                        <?php echo $item["Номер"];?> от <?php echo $item["Дата"];?>
                      </td>
                      <td><?php echo $item["СтатусПодробно"];?></td>
                      <td><?php echo $item["ДатаПоследнегоПродления"];?></td>
                      <td><?php echo $item["СуммаПролонгации"];?> руб.</td>
                      <td><?php echo $item["СуммаЗакрытия"];?> руб.</td>
                      <td>
                        <button class="btn btn-primary mb-1" onclick="contract.showForm('<?php echo $item["УИД"]?>', '<?php echo $item["Номер"];?>', '<?php echo $item["Дата"];?>')">Пролонгировать</button><br/>
                        <a class="btn btn-info" href="/history?UID=<?php echo $item["УИД"];?>">История</a>
                      </td>
                    </tr>
                    <?php if (count($item["Номенклатура"]) > 0){ ?>
                      <tr>
                        <td>
                          <b>Номенклатура: </b>
                          <?php foreach($item["Номенклатура"] as $stuff){?>
                            <?php echo $stuff["Наименование"] . ","; ?>
                          <?php }?>
                        </td>
                      </tr>
                    <?php }?>
                  <?php }?> 
                <?php }else{?>
                <tr>
                  <td colspan="8" class="text-center"><?php echo $text;?></td>
                </tr>
                <?php }?>
              </tbody>
            </table>
          </div>
        </div>
      </div>
    </div>
    <?php include('modal.php');?>
    <script src="assets/js/jquery.min.js" type="text/javascript"></script>   
    <script src="assets/js/jquery.validate.min.js" type="text/javascript"></script>                
    <script src="assets/js/bootstrap.min.js" type="text/javascript"></script>
    <script src="assets/js/custom.js" type="text/javascript"></script>
</body>
</html>