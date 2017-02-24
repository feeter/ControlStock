$(document).ready(function() {

    $("#startDate, #endDate").datetimepicker({
        format: 'dd/mm/yyyy',
        language: 'es',
        minView: 2,
        autoclose: true,
        weekStart: 1
    });

    $("#getOrderReportForm").unbind('submit').bind('submit', function() {

        var startDate = $("#startDate").val();
        var endDate = $("#endDate").val();

        if (startDate == "" || endDate == "") {
            if (startDate == "") {
                $("#startDate").closest('.form-group').addClass('has-error');
                $("#startDate").after('<p class="text-danger">The Start Date is required</p>');
            } else {
                $(".form-group").removeClass('has-error');
                $(".text-danger").remove();
            }

            if (endDate == "") {
                $("#endDate").closest('.form-group').addClass('has-error');
                $("#endDate").after('<p class="text-danger">The End Date is required</p>');
            } else {
                $(".form-group").removeClass('has-error');
                $(".text-danger").remove();
            }
        } else {
            $(".form-group").removeClass('has-error');
            $(".text-danger").remove();

            var form = $(this);

            //console.log(form.serialize());

            $.ajax({
                url: form.attr('action'),
                type: form.attr('method'),
                data: form.serialize(),
                dataType: 'text',
                success: function(response) {
                        var mywindow = window.open('', 'Sistema de Administracion de Stock', 'height=400,width=600');
                        mywindow.document.write('<html><head><title>Informe de Ventas</title>');
                        mywindow.document.write('</head><body>');
                        mywindow.document.write(response);
                        mywindow.document.write('</body></html>');

                        mywindow.document.close(); // necessary for IE >= 10
                        mywindow.focus(); // necessary for IE >= 10

                        mywindow.print();
                        mywindow.close();
                    } //success
                    //error: ajaxFailed // FAILED

            }); // /ajax

        } // /else

        return false;
    });

});