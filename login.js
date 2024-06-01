$(document).ready(function() {

    $(window).on('beforeunload', function() {
        navigator.sendBeacon('exit.php');
    });

    // Toggle between login and register forms
    $('#to-register-form').click(function() {
        $('#login-form').hide();
        $('#register-form').show();
        // clear the login form
        $('#user').val('');
        $('#password').val('');
        $('.alert').html('');
    });
    $('#to-login-form').click(function() {
        $('#register-form').hide();
        $('#login-form').show();
        //  clear the register form
        $('#new-user').val('');
        $('#new-password').val('');
        $('#confirm-password').val('');
        $('.alert').html('');
    });

    // Login form validation
    // validate user input when blur
    $('#user').blur(function() {
        if ($(this).val().match(/^[a-z0-9._%+\-]+@connect.hku.hk/)){
            let email = $(this).val();
            $.ajax({
                url: 'check.php',
                type: 'GET',
                data: { 'email': email },
                success: function(response) {
                    if (response === 'exists') {
                        $('.alert').html(''); 
                    } else {
                        $('.alert').html('Cannot find your email record');
                    }
                },
                error: function(xhr, status, error) {
                    console.error("An error occurred: " + error);
                    $('.alert').html('Error checking email record');
                }
            });
        }
        else {
            $('.alert').html('Please enter a valid HKU @connect email address');
        }
    });
    // validate after login button is clicked
    $('#login-bttn').click(function(event) {
        let valid = true;
        let msg = '';
        if ($('#user').val().length == 0){
            msg += 'Missing email address!!<br>';
            valid = false;
        }
        else if (!$('#user').val().match(/^[a-z0-9._%+\-]+@connect.hku.hk/)){
            msg += 'Please enter a valid HKU @connect email address<br>';
            valid = false;
        }
        if ($('#password').val().length == 0){
            msg += 'Please provide the password';
            valid = false;
        }
        if (!valid){
            event.preventDefault();
        }
        $('.alert').html(msg);
    });

    $('#password').on('input', function() {
        if ($(this).val().length > 0){
            if ($('#user').val().match(/^[a-z0-9._%+\-]+@connect.hku.hk/)){
                let email = $('#user').val();
                $.ajax({
                    url: 'check.php',
                    type: 'GET',
                    data: { 'email': email },
                    success: function(response) {
                        if (response === 'exists') {
                            $('.alert').html(''); 
                        }
                    },
                    error: function(xhr, status, error) {
                        console.error("An error occurred: " + error);
                    }
                });
            }
        }
    });

    $('#confirm-password').on('input', function() {
        if ($(this).val().length > 0 && $('#new-password').val().length > 0){
            if ($('#new-user').val().match(/^[a-z0-9._%+\-]+@connect.hku.hk/)){
                let email = $('#new-user').val();
                $.ajax({
                    url: 'check.php',
                    type: 'GET',
                    data: { 'email': email },
                    success: function(response) {
                        if (response !== 'exists') {
                            $('.alert').html(''); 
                        }
                    },
                    error: function(xhr, status, error) {
                        console.error("An error occurred: " + error);
                    }
                });
            }
        }
    });



    // Register form validation
    // validate user input when blur
    $('#new-user').blur(function() {
        if ($(this).val().match(/^[a-z0-9._%+\-]+@connect.hku.hk/)){

            let email = $(this).val();
            $.ajax({
                url: 'check.php',  // The URL to the PHP script
                type: 'GET',       // The HTTP method
                data: { 'email': email },  // Data you want to send to the server
                success: function(response) {
                    if (response === 'exists') {
                        $('.alert').html('You have registered before!!'); 
                    } else {
                        $('.alert').html('');
                    }
                },
                error: function(xhr, status, error) {
                    console.error("An error occurred: " + error);
                    $('.alert').html('Error checking email record');
                }
            });
        }
        else {
            $('.alert').html('Please enter a valid HKU @connect email address');
        }
    });

    // validate after register button is clicked
    $('#register-bttn').click(function(event) {
        let valid = true;
        let msg = '';
        if ($('#new-user').val().length == 0){
            msg += 'Missing email address!!<br>';
            valid = false;
        }
        else if (!$('#new-user').val().match(/^[a-z0-9._%+\-]+@connect.hku.hk/)){
            msg += 'Please enter a valid HKU @connect email address<br>';
            valid = false;
        }
        if ($('#new-password').val().length == 0){
            msg += 'Please provide the password';
            valid = false;
        }
        else if ($('#new-password').val() != $('#confirm-password').val()){
            msg += 'Mismatched passwords!!';
            valid = false;
        }
        if (!valid){
            event.preventDefault();
        }
        $('.alert').html(msg);
    });
});
