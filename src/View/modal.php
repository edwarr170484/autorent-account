<div class="modal fade" id="contractPayment" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <form action="" id="payment_form" name="payment_form">
        <div class="modal-content">
        <div class="modal-header">
            <h1 class="modal-title fs-5" id="exampleModalLabel">Пролонгировать договор</h1>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
            <div class="alert alert-primary mb-3" role="alert">
                <div class="mb-1"><b>Номер договора: </b><span id="contract_number"></span></div>
                <div class="mb-3"><b>Сумма: </b><span id="contract_label"></span>&nbsp;руб.</div>
                <p>Вы можете оплатить эту сумму онлайн выбрав способ оплаты в выпадающем списке.</p>
            </div>
            <div>
                <label for="payment_gate" class="form-label">Выберите платежную систему</label>
                <select class="form-select" id="payment_gate" name="contract[payment]">
                    <option value="BestPay">Best2Pay</option>
                    <option value="Wirebank">Wirebank</option>
                    <option value="Vepay">Vepay</option>
                </select>
            </div>
        </div>
        <div class="modal-footer">
            <input type="hidden" name="contract[uid]" id="contract_uid">
            <input type="hidden" name="contract[sum]" id="contract_sum">
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Отмена</button>
            <button type="submit" class="btn btn-primary">Оплатить</button>
        </div>
        </div>
    </form>
  </div>
</div>