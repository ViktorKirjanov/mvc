$(document).ready(function () {

    $('.selectpicker').selectpicker({
        size: 10
    });

    $(".enable_offer, .disable_offer").on("click", function () {
        event.preventDefault();
        var button = $(this);
        var status = button.data("status");
        var url = button.attr("href");
        $.ajax({
            datatype: "json",
            url: url,
            success: function (data) {
                if (data.status) {
                    if (status == 1) {
                        button.removeClass('btn-success').addClass('btn-danger');
                        button.data("status", 0).text("Disabled");
                    }
                    else {
                        button.removeClass('btn-danger').addClass('btn-success');
                        button.data("status", 1).text("Enabled");
                    }
                    button.attr('href', data.url);

                }
            }
        });
    });

    $('#amount_btc').on('input', function () {
        var input = $(this);
        if (input.val() <= 0) {
            $('#start-trade-btn').prop('disabled', true);
        }
        else {
            $('#start-trade-btn').prop('disabled', false);
        }
    });

    $('#amount_fiat').on('input', function () {
        var input = $(this);
        if (input.val() <= 0) {
            $('#start-trade-btn').prop('disabled', true);
        }
        else {
            $('#start-trade-btn').prop('disabled', false);
        }
    });


    $(".amount_fiat").on('input', function () {
        var input = $(this);
        var margin = input.data("margin");
        var id = input.data("id");
        var min = input.data("min");
        var max = input.data("max");
        var rate = input.data("rate");
        var current_amount_btc = input.val() / (800 * margin * rate);
        current_amount_btc = current_amount_btc.toFixed(8);
        current_amount_btc = parseFloat(current_amount_btc);

        if (input.val() < min) {
            $('.btc-' + id)
                .addClass("text-danger")
                .text("min amount = " + min);
            $('.input-group-' + id).addClass('has-error');
            $('.btn-' + id).prop('disabled', true);
        } else if (input.val() > max) {
            $('.btc-' + id)
                .addClass("text-danger")
                .text("max amount = " + max);
            $('.input-group-' + id).addClass('has-error');
            $('.btn-' + id).prop('disabled', true);
        } else {
            $('.btc-' + id)
                .removeClass("text-danger")
                .text(current_amount_btc + ' BTC');
            $('.input-group-' + id).removeClass('has-error');
            $('.btn-' + id).prop('disabled', false);
        }
    });


    $('#payment_method_group').change(function () {
        var item = $(this);
        var group_id = item.val();
        var payment_method_group_id = $("#payment_method").find(':selected').data('group_id');
        if (group_id != payment_method_group_id) {
            $("#payment_method").val("");
            $('#payment_method').selectpicker('refresh');
        }
    });

    $('#payment_method').change(function () {
        var group_id = $(this).find(':selected').data('group_id');
        $('#payment_method_group').val(group_id);
        $('#payment_method_group').selectpicker('refresh');

    });

    $("#clear_payment_method_group").click(function () {
        event.preventDefault();
        $('#payment_method_group').val("");
        $('#payment_method_group').selectpicker('refresh');
    });

    $("#clear_payment_method").click(function () {
        event.preventDefault();
        $("#payment_method").val("");
        $('#payment_method').selectpicker('refresh');
    });


    $('#edit_form form, #create_form form').change(function () {
        findBtcAmount()
    }).keyup(function () {
        findBtcAmount()
    }).click(function () {
        findBtcAmount()
    });

    function findBtcAmount() {
        var max_amount = $('#max_amount').val();
        var min_amount = $('#min_amount').val();
        var margin = $('#margin').val();
        var rate = $("#currency").find(':selected').data('rate');

        if (max_amount && margin && min_amount && (parseInt(max_amount) >= parseInt(min_amount))) {
            var max_btc_amount = max_amount / (800 * margin * rate);
            var min_btc_amount = min_amount / (800 * margin * rate);
            min_btc_amount = min_btc_amount.toFixed(8);
            max_btc_amount = max_btc_amount.toFixed(8);
            min_btc_amount = parseFloat(min_btc_amount);
            max_btc_amount = parseFloat(max_btc_amount);
            $(".help-block").text("Max: " + max_btc_amount + " BTC / Min: " + min_btc_amount + " BTC");
        }
        else {
            $(".help-block").text("0 BTC");
        }
    };
});


