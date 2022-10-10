$(document).ready(function() {
    let btn = $('#receiptBtn');

    btn.find('button').on('mouseover', function (){
        btn.find('span').text("Виж касовата бележка");
    });
    btn.find('button').on('mouseout', function (){
        btn.find('span').text("");
    });

    btn.find('button').on('click', function (){
        $("#receiptModal").modal("show");
    });
});