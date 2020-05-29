function validate_form() {
    let valid_card = 0;
    let valid = false;
    let card_cvc = $('#card_cvc').val();
    let card_expiry_month = $('#card_expiry_month').val();
    let card_expiry_year = $('#card_expiry_year').val();
    let card_holder_number = $('#card_holder_number').val();
    let email_address = $('#email_address').val();
    let customer_name = $('#customer_name').val();
    let customer_address = $('#customer_address').val();
    let customer_city = $('#customer_city').val();
    let customer_pin = $('#customer_pin').val();
    let customer_country = $('#customer_country').val();
    let name_expression = /^[a-z ,.'-]+$/i;
    let email_expression = /^([a-z0-9\+_\-]+)(\.[a-z0-9\+_\-]+)*@([a-z0-9\-]+\.)+[a-z]{2,6}$/;
    let month_expression = /^01|02|03|04|05|06|07|08|09|10|11|12$/;
    let year_expression = /^2020|2021|2022|2023|2024|2025|2026|2027|2028|2029|2030|2031$/;
    let cvv_expression = /^[0-9]{3,3}$/;

    $('#card_holder_number').validateCreditCard(function (result) {
        if (result.valid) {
            $('#card_holder_number').removeClass('require');
            $('#error_card_number').text('');
            valid_card = 1;
        } else {
            $('#card_holder_number').addClass('require');
            $('#error_card_number').text('Invalid Card Number');
            valid_card = 0;
        }
    });

    if (valid_card == 1) {
        if (!month_expression.test(card_expiry_month)) {
            $('#card_expiry_month').addClass('require');
            $('#error_card_expiry_month').text('Invalid Data');
            valid = false;
        } else {
            $('#card_expiry_month').removeClass('require');
            $('#error_card_expiry_month').text('');
            valid = true;
        }

        if (!year_expression.test(card_expiry_year)) {
            $('#card_expiry_year').addClass('require');
            $('#error_card_expiry_year').error('Invalid Data');
            valid = false;
        } else {
            $('#card_expiry_year').removeClass('require');
            $('#error_card_expiry_year').error('');
            valid = true;
        }

        if (!cvv_expression.test(card_cvc)) {
            $('#card_cvc').addClass('require');
            $('#error_card_cvc').text('Invalid Data');
            valid = false;
        } else {
            $('#card_cvc').removeClass('require');
            $('#error_card_cvc').text('');
            valid = true;
        }
        if (!name_expression.test(customer_name)) {
            $('#customer_name').addClass('require');
            $('#error_customer_name').text('Invalid Name');
            valid = false;
        } else {
            $('#customer_name').removeClass('require');
            $('#error_customer_name').text('');
            valid = true;
        }

        if (!email_expression.test(email_address)) {
            $('#email_address').addClass('require');
            $('#error_email_address').text('Invalid Email Address');
            valid = false;
        } else {
            $('#email_address').removeClass('require');
            $('#error_email_address').text('');
            valid = true;
        }

        if (customer_address == '') {
            $('#customer_address').addClass('require');
            $('#error_customer_address').text('Enter Address Detail');
            valid = false;
        } else {
            $('#customer_address').removeClass('require');
            $('#error_customer_address').text('');
            valid = true;
        }

        if (customer_city == '') {
            $('#customer_city').addClass('require');
            $('#error_customer_city').text('Enter City');
            valid = false;
        } else {
            $('#customer_city').removeClass('require');
            $('#error_customer_city').text('');
            valid = true;
        }

        if (customer_pin == '') {
            $('#customer_pin').addClass('require');
            $('#error_customer_pin').text('Enter Zip code');
            valid = false;
        } else {
            $('#customer_pin').removeClass('require');
            $('#error_customer_pin').text('');
            valid = true;
        }

        if (customer_country == '') {
            $('#customer_country').addClass('require');
            $('#error_customer_country').text('Enter Country Detail');
            valid = false;
        } else {
            $('#customer_country').removeClass('require');
            $('#error_customer_country').text('');
            valid = true;
        }


    }
    return valid;
}

Stripe.setPublishableKey('pk_test_0ZNFRCxwqh6nRz8Z7tmYzRyg00R6iW6ao7');

/*
 * attr --> set value and attribute
 * html --> set on message error
 */
function stripeResponseHandler(status, response) {
    if (response.error) {
        $('#button_action').attr('disabled', false);
        $('#message').html(response.error.message).show();
    } else {
        var token = response['id'];
        $('#order_process_form').append("<input type='hidden' name='token' value='" + token + "' />");
        $('#order_process_form').submit();
    }
}

function stripePay(event) {
    // Vérifie si les éléments ont été traités
    event.preventDefault();

    if (validate_form() == true) {
        $('#button_action').attr('disabled', 'disabled');
        $('#button_action').val('Paiement en cours....');
        Stripe.createToken({
            number: $('#card_holder_number').val(),
            cvc: $('#card_cvc').val(),
            exp_month: $('#card_expiry_month').val(),
            exp_year: $('#card_expiry_year').val()
        }, stripeResponseHandler);
        return false;
    }
}