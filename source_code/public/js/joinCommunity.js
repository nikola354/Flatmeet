$(document).ready(function () {
    let codeBtn = $('#inputCode input[type=submit]');
    let codeInput = $('#inputCode input[type=text]');
    let codeSpan = $('#inputCode .input-group-text');


    let apNumBtn = $('#inputApNum input[type=submit]');
    let apNumInput = $('#inputApNum input[type=text]');
    let apNumSpan = $('#inputApNum .input-group-text');

    let floorInput = $('#inputFloor input[type=text]');
    let floorSpan = $('#inputFloor .input-group-text');

    let familyInput = $('#inputFamily input[type=text]');
    let familySpan = $('#inputFamily .input-group-text');

    let joinBtn = $('#joinBtn');

    let code;
    let ap;
    let floor;
    let family;
    let isFirst;
    codeInput.on('input', function (event) {
        event.preventDefault();
        if (codeInput.val().length == 6) codeBtn.prop('disabled', false);
        else codeBtn.prop('disabled', true);
    });

    apNumInput.on('input', function (event) {
        event.preventDefault();
        if (apNumInput.val().length == 0) apNumBtn.prop('disabled', true);
        else apNumBtn.prop('disabled', false);
    });

    codeBtn.on('click', function () {
        if (isNaN(codeInput.val())) {
            $('#jsonErrorsModal p').text("Кодът трябва да съдържа само цифри!");
            $('#jsonErrorsModal').modal('show');

            codeInput.val('');
            codeBtn.prop('disabled', true);
        } else {
            $.ajax({
                method: 'POST',
                url: '/post/check/code',
                data: {
                    code: codeInput.val(),
                    '_token': token
                },
                success: function (data) {
                    if (data.ok) {
                        code = codeInput.val();

                        apNumInput.prop('disabled', false);
                        apNumSpan.removeClass('disabled');

                        codeBtn.prop('disabled', true);
                        codeInput.prop('disabled', true);
                        codeSpan.addClass('disabled');
                    } else {
                        $('#jsonErrorsModal p').text(data.error + ".");
                        $('#jsonErrorsModal').modal('show');

                        codeInput.val('');
                        codeBtn.prop('disabled', true);
                    }
                }
            });
        }
    });

    apNumBtn.on('click', function () {
        ap = Number(apNumInput.val());
        let ok = true;
        let error = "";
        if (isNaN(ap)) {
            ok = false;
            error = "Номерът на апартамента трябва да съдържа само цифри!";

        } else if (ap > 500) {
            ok = false;
            error = "Номерът на апартамента не може да бъде повече от 500!";
        }

        if (!ok) {
            $('#jsonErrorsModal p').text(error);
            $('#jsonErrorsModal').modal('show');

            apNumInput.val('');
            apNumBtn.prop('disabled', true);
        } else {
            apNumInput.val(ap);
            $.ajax({
                method: 'POST',
                url: '/post/check/apartment',
                data: {
                    code: code,
                    ap: ap,
                    '_token': token
                },
                success: function (data) {
                    apNumInput.prop('disabled', true);
                    apNumSpan.addClass('disabled');
                    apNumBtn.prop('disabled', true);
                    isFirst = data.isFirst;
                    if (isFirst) {
                        floorInput.prop('disabled', false);
                        floorSpan.removeClass('disabled');

                        familyInput.prop('disabled', false);
                        familySpan.removeClass('disabled');

                        $('#explanationText').text('Ако не зададеш фамилно име, полето ще бъде запълнено автоматично с твоите имена.');

                    } else {
                        floorInput.val("Етаж: " + data.floor)
                        familyInput.val("Фамилно име: " + data.family);
                        $('#explanationText').text('Вече има потребител, регистриран в този вход и апартамент.' +
                            ' Ще бъдеш регистриран с неговите етаж и фамилно име по подразбиране.' +
                            ' Ако това не са данните на твоя апартамент, консултирай се с домоуправителя си.');

                        joinBtn.prop('disabled', false);
                    }

                },
            });
        }
    });

    floorInput.on('input', function (event) {
        event.preventDefault();
        if (floorInput.val().length > 0) {
            joinBtn.prop('disabled', false);
        } else {
            joinBtn.prop('disabled', true);
        }
    });

    joinBtn.on('click', function () {
        if(isFirst){
            floor = Number(floorInput.val());
            family = familyInput.val();
            let ok = true;
            let error = "";
            if (isNaN(floor)) {
                ok = false;
                error = "Етажът трябва да съдържа само цифри!";
            } else if (floor > 100) {
                ok = false;
                error = "Етажът не може да бъде повече от 100!";
            }

            if (!ok) {
                $('#jsonErrorsModal p').text(error);
                $('#jsonErrorsModal').modal('show');

                floorInput.val('');
                joinBtn.prop('disabled', true);
            } else if (family !== "" && (family.length < 2 || family.length > 80)) {
                $('#jsonErrorsModal p').text("Фамилното име трябва да съдържа между 2 и 80 символа!");
                $('#jsonErrorsModal').modal('show');

                familyInput.val('');
            } else {
                joinCommunity();
            }
        }else{
            joinCommunity();
        }
    });

    function joinCommunity(){
        $.ajax({
            method: 'POST',
            url: '/post/enter/waiting/room',
            data: {
                code: code,
                ap: ap,
                floor: floor,
                family: family,
                '_token': token
            },
            success: function (data) {
                if (data.ok) {
                    $('#jsonInfoModal p').text(data.msg);
                    $('#jsonInfoModal').modal('show');
                } else {
                    $('#jsonErrorsModal p').text(data.error + ".");
                    $('#jsonErrorsModal').modal('show');

                }
                $('#clearBtn').click();
            }
        });
    }

    $('#clearBtn').on('click', function () {
        codeInput.val('');
        codeInput.prop('disabled', false);
        codeBtn.prop('disabled', true);
        codeSpan.removeClass('disabled');

        apNumInput.val('');
        apNumInput.prop('disabled', true);
        apNumBtn.prop('disabled', true);
        apNumSpan.addClass('disabled');

        floorInput.val('');
        floorInput.prop('disabled', true);
        floorSpan.addClass('disabled');

        familyInput.val('');
        familyInput.prop('disabled', true);
        familySpan.addClass('disabled');

        joinBtn.prop('disabled', true);
    });

});
