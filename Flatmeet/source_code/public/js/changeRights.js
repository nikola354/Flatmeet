$(document).ready(function () {
    let options = $('.options');
    let email;
    let code;
    let newRights;
    options.change(function () {
        newRights = $(this).val();
        email = $(this).data('email');
        code = $(this).data('code');
        if(newRights === "kickOut"){
            $('#notSureModal .content').text('Сигурен ли си, че искаш да изгониш този съсед? След потвърждаване няма да можеш да се върнеш назад!')
        }else{
            $('#notSureModal .content').text('Сигурен ли си, че искаш да промениш правата на този съсед? След потвърждаване е възможно да не можеш да върнеш промените назад!')
        }
        $('#notSureModal').modal('show');
    });
    $('#confirmBtn').on('click', function () {
        $.ajax({
            method: 'POST',
            url: '/post/change/rights',
            data: {
                code: code,
                email: email,
                newRights: newRights,
                '_token': token
            },
            success: function (data) {
                if (data.ok) {
                    location.reload();
                } else {
                    $('#jsonErrorsModal p').text(data.error + ".");
                    $('#jsonErrorsModal').modal('show');

                }
            }
        });

    });
});
