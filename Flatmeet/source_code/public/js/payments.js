$(document).ready(function () {
    const priceInput = $('#addPaymentBox input[name="price"]');
    const selectType = $('#selectType');
    const selectShare = $('#selectShare');
    const apPills = $(".apPills");
    const allInhabitants = apPills.data('number');

    let singlePrice;

    priceInput.on('input', function () {
        changeHidden();
    });
    selectType.change(function () {
        changeHidden();
    });
    selectShare.change(function () {
        changeHidden();
    });

    function changeHidden() {
        if (selectType.val() !== 'default' && selectShare.val() !== 'default' && priceInput.val().length > 0) {
            if (selectShare.val() === 'amongApartments') {
                singlePrice = priceInput.val() / apPills.children().length;

                apPills.children().find('input').val(Math.ceil(singlePrice * 100) / 100);
            } else {
                singlePrice = Number(priceInput.val()) / allInhabitants;

                apPills.children().each(function () {
                    $(this).find('input').val(Math.ceil(singlePrice * $(this).data('inhabitants') * 100) / 100);
                });
            }

            apPills.children().attr('hidden', false);
            checkDisabledButton();
        } else {
            apPills.children().attr('hidden', true);
        }
    }

    priceInput.add(apPills.children().find('input')).on('keypress', function (e) {
        if (e.which === 43 || e.which === 45) {
            return false;
        }

        if (e.which === 46 && $(this).val().length === 0) {
            return false;
        }

        let dotPlace = $(this).val().indexOf(".")

        if (dotPlace !== -1 && $(this).val().substring(dotPlace).length >= 3) {
            return false;
        }

    });

    apPills.children().find('input').on('input', function () {
        checkDisabledButton();

        if (Number($(this).val()) > Number(priceInput.val())) {
            $('#warningText').text('Единичната сума не може да бъде по-голяма от общата!');
        } else {
            $('#warningText').text('');
            if ($(this).val().length !== 0) {
                let normalPayings = 0;
                let specialPrices = 0;

                if (selectShare.val() === 'amongApartments') {
                    apPills.children().each(function () {
                        let price = Number($(this).find('input').val());

                        if (price == Math.ceil(singlePrice * 100) / 100) normalPayings++;
                        else specialPrices += price;

                    });
                } else {
                    apPills.children().each(function () {
                        let price = Number($(this).find('input').val());

                        if (price == Math.ceil(singlePrice * $(this).data('inhabitants') * 100) / 100) normalPayings += $(this).data('inhabitants');
                        else specialPrices += price;

                    });
                }


                if (specialPrices > Number(priceInput.val())) {
                    $('#warningText').text('Сборът на ръчно въведените суми не може да надхвърля стойността на общия разход!');
                } else {
                    $('#warningText').text('');

                    let oldSinglePrice = singlePrice;
                    singlePrice = (Number(priceInput.val()) - specialPrices) / normalPayings;

                    if (selectShare.val() === 'amongApartments') {
                        apPills.children().each(function () {
                            let price = $(this).find('input').val();
                            if (price == Math.ceil(oldSinglePrice * 100) / 100) {
                                $(this).find('input').val(Math.ceil(singlePrice * 100) / 100);
                            }
                        });
                    } else {
                        apPills.children().each(function () {
                            let price = $(this).find('input').val();
                            if (price == Math.ceil(oldSinglePrice * $(this).data('inhabitants') * 100) / 100) {
                                $(this).find('input').val(Math.ceil(singlePrice * $(this).data('inhabitants') * 100) / 100);
                            }
                        });
                    }


                }
            }
        }
    });
    function checkDisabledButton(){
        let ok = true;
        apPills.children().each(function (){
            if ($(this).find('input').val() === '') ok = false;
        });

        if(ok){
            $('#addPaymentBtn').attr('disabled', false);
        }else{
            $('#addPaymentBtn').attr('disabled', true);
        }
    }


    // show all payments for a community

    const monthInputTable = $('.paymentsInput input');
    const typeSelectTable =  $('.paymentsInput select');

    typeSelectTable.change(function(){
        if($(this).val() !== 'default' && monthInputTable.val() != ""){
            paymentsRedirect();
        }
    });

    monthInputTable.change(function (){

       if(typeSelectTable.val() !== 'default'){
           paymentsRedirect();
       }
    });

    function paymentsRedirect(){
        let baseUrl = window.location.href.substring(0, window.location.href.indexOf('payments')+8);

        window.location.href = baseUrl + "/" + monthInputTable.val() + "/" + typeSelectTable.val();
    }
});
