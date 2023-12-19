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
                    <td colspan="2">Договор <?php echo $data["Номер"];?> от <?php echo $data["Дата"];?></td>
                    <td><?php echo $data["Сумма"];?></td>
                  </tr>
                  <tr>
                    <td style="width: 50px"></td>
                    <td>Пролонгация <?php echo $data["Номер"];?> от <?php echo $data["ДатаПоследнегоПродления"];?></td>
                    <td><?php echo $data["СуммаПролонгации"];?></td>
                  </tr>
                  <tr>
                    <td style="width: 50px"></td>
                    <td>Закрытие договора <?php echo $data["Номер"];?> от <?php echo $data["ДатаВыкупа"];?></td>
                    <td><?php echo $data["СуммаЗакрытия"];?></td>
                  </tr>
                  <!--<tr><td><b>Номер договора</b></td><td><?php echo $data["Номер"];?></td></tr>
                  <tr><td><b>Дата договора</b></td><td><?php echo $data["Дата"];?></td></tr>
                  <tr><td><b>УИД договора</b></td><td><?php echo $data["УИД"];?></td></tr>
                  <tr><td><b>Вид договора</b></td><td><?php echo $data["ВидДоговора"];?></td></tr>
                  <tr><td><b>Дата выкупа</b></td><td><?php echo $data["ДатаВыкупа"];?></td></tr>
                  <tr><td><b>Дата последнего продления</b></td><td><?php echo $data["ДатаПоследнегоПродления"];?></td></tr>
                  <tr><td><b>Тариф</b></td><td><?php echo $data["Тариф"];?></td></tr>
                  <tr><td><b>Статус</b></td><td><?php echo $data["Статус"];?></td></tr>
                  <tr><td><b>Статус подробно</b></td><td><?php echo $data["СтатусПодробно"];?></td></tr>
                  <tr><td><b>Сумма</b></td><td><?php echo $data["Сумма"];?> руб.</td></tr>
                  <tr><td><b>Сумма пролонгации</b></td><td><?php echo $data["СуммаПролонгации"];?> руб.</td></tr>
                  <tr><td><b>Сумма закрытия</b></td><td><?php echo $data["СуммаЗакрытия"];?> руб.</td></tr>
                  <tr><td><b>УИД контрагента</b></td><td><?php echo $data["Контрагент_УИД"];?></td></tr>
                  <tr><td><b>Ф.И.О.</b></td><td><?php echo $data["Контрагент_ФИО"];?></td></tr>
                  <tr><td><b>Дата рождения</b></td><td><?php echo $data["Контрагент_ДатаРождения"];?></td></tr>
                  <tr><td><b>Телефон</b></td><td><?php echo $data["Контрагент_Телефон"];?></td></tr>
                  <tr><td><b>УИД подразделения</b></td><td><?php echo $data["Подразделение_УИД"];?></td></tr>
                  <tr><td><b>Наименование подразделения</b></td><td><?php echo $data["Подразделение_Наименование"];?></td></tr>
                  <tr><td><b>Код подразделения</b></td><td><?php echo $data["Подразделение_Код"];?></td></tr>-->
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