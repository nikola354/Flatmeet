$(document).ready(function () {
    let code = $('#codeToCopy');

    code.on('click', function (){
        let $temp = $("<input>");
        $("body").append($temp);

        $temp.val(code.text()).select();

        document.execCommand("copy");

        $temp.remove();

    });

    code.on('mouseover', function (){
        $('#clickToCopyText').prop('hidden', false);
    });

    code.on('mouseout', function (){
        $('#clickToCopyText').prop('hidden', true);
    });
});
