let contract = {
  showForm(uid, num, sum) {
    $("#contract_uid").val(uid);
    $("#contract_number").html(num);
    $("#contract_sum").val(sum);
    $("#contract_label").html(sum);
    $("#contractPayment").modal("show");
  },
};

let notifications = {
  show() {
    Array.from(document.querySelectorAll(".toast")).forEach((toastNode) => {
      let toast = new bootstrap.Toast(toastNode);
      toast.show();
    });

    setTimeout(() => {
      $(".toast-container").remove();
    }, 6000);
  },
};

$(document).ready(function () {
  $("#payment_form").on("submit", function (e) {
    e.preventDefault();

    notifications.show();

    if ($(this).valid()) {
      let data = new FormData(e.target);

      $.ajax({
        url: "/payment/create",
        type: "post",
        contentType: "application/x-www-form-urlencoded",
        data: data,
        processData: false,
        contentType: false,
        dataType: "json",
        success: function (data) {
          if (data.error) {
            $("#contractPayment").modal("hide");

            $("body").append(
              `<div class="toast-container bottom-0 end-0 p-3"></div>`
            );

            data.messages.forEach((message) => {
              $(".toast-container")
                .append(`<div class="toast align-items-center text-bg-danger border-0" role="alert" aria-live="assertive" aria-atomic="true">
                    <div class="d-flex">
                    <div class="toast-body">
                        ${message}
                    </div>
                    <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast" aria-label="Close"></button>
                    </div>
                </div>`);
            });

            notifications.show();
          } else {
            window.location.href = data;
          }
        },
      });
    }
    return false;
  });
});
