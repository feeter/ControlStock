$(document).ready(function() {

    //inicializar tooltip jquery
    $('[data-toggle="tooltip"]').tooltip();

    // top bar active
    $('#navDashboard').addClass('active');

    //Inicializa el chart de los productos mas vendidos
    google.charts.load('current', { 'packages': ['corechart'] });
    //google.charts.setOnLoadCallback(drawChart);   


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

            //Dibujar el grafico de los productos mas vendidos
            drawChart(res[1], res[0]);
        },
        dayRender: function(date, cell) {
            //console.log("date: " + date.format() + " cell: " + cell);

            var fecha = cell[0].getAttribute("data-date");

            obtenerMontoDelDia(cell, fecha);

        }
    });




});

//Ingresa el monto vendido en el plugin FullCalendar segun la fecha indicada en el parametro  por dia
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


//Obtiene el total mensual y lo agrega en el titulo del calendario
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

//funcion para obtener los datos de los productos mas vendidos y pintarlos en pantalla
function drawChart(mes, y) {

    var data = null;

    $.ajax({
        url: 'php_action/GetProductMostSold.php',
        type: 'post',
        data: { month: mes, year: y },
        dataType: 'json',
        success: function(response) {

            //for que convierte el valor de la "cantidad vendida" en numerico y crea un "newArray" con los mismos datos
            var newArray = [];
            for (x = 0; x < response.length; x++) {
                newArray[x] = [response[x][0], Number(response[x][1])];
            }

            //Agrega el primer array el indicador de que es cada valor
            newArray.splice(0, 0, ['Producto', 'Cantidad Vendida']);

            data = google.visualization.arrayToDataTable(newArray);


            var options = {
                title: 'Productos mas Vendidos del mes'
            };

            var chart = new google.visualization.PieChart(document.getElementById('piechart'));

            chart.draw(data, options);

        }

    });


    // var data = google.visualization.arrayToDataTable([
    //     ['Task', 'Hours per Day'],
    //     ['Work', 11],
    //     ['Eat', 2],
    //     ['Commute', 2],
    //     ['Watch TV', 2],
    //     ['Sleep', 7]
    // ]);


}