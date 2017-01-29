$(document).ready(function() {
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
        }



    });




});



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

    }); // /fetch the selected categories data


}