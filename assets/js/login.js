$(document).ready(function () {
    $("#login-phone").validate({
        rules: {
            phone: {
                required: true,
                digits: true
            }
        },
        messages: {
            phone: ""
        }
    });

    $("#login-phone").on('submit', function (e) {
        e.preventDefault();

        if ($(this).valid()) {
            let data = new FormData(e.target);

            $.ajax({
                url: '/login/sms',
                type: 'post',
                contentType: "application/x-www-form-urlencoded",
                data: data,
                processData: false,
                contentType: false,
                success: function (data) {
                    $("main").html(data);
                    loginCodeFormInit();
                }
            });
        }
        return false;
    });
});

function loginCodeFormInit() {
    $("#login-code").validate({
        rules: {
            code: {
                required: true,
                digits: true,
                maxlength: 4
            }
        },
        messages: {
            phone: ""
        }
    });

    $("#login-code").on('submit', function (e) {
        e.preventDefault();

        if ($(this).valid()) {
            let data = new FormData(e.target);

            $.ajax({
                url: '/login/auth',
                type: 'post',
                contentType: "application/x-www-form-urlencoded",
                data: data,
                dataType: "json",
                processData: false,
                contentType: false,
                success: function (data) {
                    if (data.error) {
                        $(".form-message").addClass("mb-3").html(data.message);
                    }
                    else {
                        window.location.href = "/";
                    }
                }
            });
        }

        return false;
    });
}