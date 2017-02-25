$(document).ready(function() {

    //inicializar tooltip jquery
    $('[data-toggle="tooltip"]').tooltip();

    // top bar active
    $('#navDashboard').addClass('active');


    //Date for the calendar events (dummy data)
    var date = new Date();
    var d = date.getDate(),
        m = date.getMonth(),
        y = date.getFullYear();

    $('#calendar').fullCalendar({
        header: {
            left: '',
            center: 'title',

        },
        buttonText: {
            today: 'Hoy'
        },
        viewRender: function(view, element) {
            //console.log(view.intervalStart.format());
            var res = view.intervalStart.format().split("-");
            nombreCalendario(res[1], res[0]);
        },
        dayRender: function(date, cell) {
            //console.log("date: " + date.format() + " cell: " + cell);

            var fecha = cell[0].getAttribute("data-date");

            obtenerMontoDelDia(cell, fecha);

            // if (moment().diff(date, 'days') > 0) {
            //     cell.css("background-color", "silver");
            // }

        }
    });




});

//Ingresa el monto vendido en el plugin FullCalendar segun la fecha indicada en el parametro 
function obtenerMontoDelDia(cell, fecha) {

    var fechaArray = fecha.split("-");

    var dia = fechaArray[2];
    var mes = fechaArray[1];
    var y = fechaArray[0];

    $.ajax({
        url: 'php_action/getTotalByDay.php',
        type: 'post',
        data: { day: dia, month: mes, year: y },
        dataType: 'json',
        success: function(response) {

            if (response.sumaTotal !== null) {
                cell[0].innerHTML = "<span class='label label-info'>$ " + response.sumaTotal + "</span>"
            }


        },
        error: function(xhr, ajaxOptions, thrownError) {
            console.log(xhr.status);
            console.log(thrownError);

        }


    });



}


function nombreCalendario(mes, y) {
    var mesActual = $(".fc-center h2").html();


    $.ajax({
        url: 'php_action/getTotalDelMes.php',
        type: 'post',
        data: { month: mes, year: y },
        dataType: 'json',
        success: function(response) {

            if (response.sumaTotal !== null) {
                $(".fc-center h2").html(mesActual + " <h4>Ingreso: $" + response.sumaTotal + "</h4>");
            }


        }

    });


}