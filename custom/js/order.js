var manageOrderTable;

$(document).ready(function() {

    var divRequest = $(".div-request").text();

    // top nav bar 
    $("#navOrder").addClass('active');

    if (divRequest == 'add') {
        // add order	

        loadAutoComplete();

        $("#barCode").focus();

        // top nav child bar 
        $('#topNavAddOrder').addClass('active');

        // order date picker
        $("#orderDate").datepicker();


        // create order form function
        $("#createOrderForm").unbind('submit').bind('submit', function() {

            //Si los campos de busqueda se encuentran con valores, cancela el submit para buscar y agregar si existeEnTabla
            //19/02/2017 Jose Campos
            if ($('#barCode').val() != '' || $('#productName').val() != '') {
                return false;
            }

            var form = $(this);

            $('.form-group').removeClass('has-error').removeClass('has-success');
            $('.text-danger').remove();


            validacionesForm();

            var orderDate = $("#orderDate").val();
            var clientName = $("#clientName").val();
            var clientContact = $("#clientContact").val();
            var paid = $("#paid").val();
            var discount = $("#discount").val();
            //var paymentType = $("#paymentType").val();
            var paymentStatus = $("#paymentStatus").val();
            $("#paymentStatusValue").val(paymentStatus);

            // form validation 
            if (orderDate == "") {
                $("#orderDate").after('<p class="text-danger"> El Campo Fecha es obligatorio. </p>');
                $('#orderDate').closest('.form-group').addClass('has-error');
            } else {
                $('#orderDate').closest('.form-group').addClass('has-success');
            } // /else


            if (paid == "") {
                $("#paid").after('<p class="text-danger"> The Paid field is required </p>');
                $('#paid').closest('.form-group').addClass('has-error');
            } else {
                $('#paid').closest('.form-group').addClass('has-success');
            } // /else

            if (discount == "") {
                $("#discount").after('<p class="text-danger"> The Discount field is required </p>');
                $('#discount').closest('.form-group').addClass('has-error');
            } else {
                $('#discount').closest('.form-group').addClass('has-success');
            } // /else

            console.log('primer log');
            if (orderDate && paid && discount && paymentStatus) {
                console.log('segundo log dentro del if');
                // create order button
                // $("#createOrderBtn").button('loading');
                console.log(form.serialize());

                $.ajax({
                    url: form.attr('action'),
                    type: form.attr('method'),
                    data: form.serialize(),
                    dataType: 'json',
                    success: function(response) {
                        console.log(response);

                        // reset button
                        $("#createOrderBtn").button('reset');

                        $(".text-danger").remove();
                        $('.form-group').removeClass('has-error').removeClass('has-success');

                        if (response.success == true) {

                            // create order button
                            $(".success-messages").html('<div class="alert alert-success">' +
                                '<button type="button" class="close" data-dismiss="alert">&times;</button>' +
                                '<strong><i class="glyphicon glyphicon-ok-sign"></i></strong> ' + response.messages +
                                ' <br /> <br /> <a type="button" onclick="printOrder(' + response.order_id + ')" class="btn btn-primary"> <i class="glyphicon glyphicon-print"></i> Imprimir </a>' +
                                '<a href="orders.php?o=add" class="btn btn-default" style="margin-left:10px;"> <i class="glyphicon glyphicon-plus-sign"></i> Realizar Nueva Venta </a>' +

                                '</div>');

                            $("html, body, div.panel, div.pane-body").animate({ scrollTop: '0px' }, 100);

                            // disabled te modal footer button
                            $(".submitButtonFooter").addClass('div-hide');
                            // remove the product row
                            $(".removeProductRowBtn").addClass('div-hide');

                            //Desabilita los textbox de busqueda de productos
                            $("#barCode, #productName").attr('disabled', 'disabled');

                        } else {
                            alert(response.messages);
                        }
                    }, //response
                    error: console.log("Error") //AjaxFailed
                }); // /ajax
            } // /if field validate is true


            return false;
        }); // /create order form function	

    } else if (divRequest == 'manord') {
        // top nav child bar 
        $('#topNavManageOrder').addClass('active');

        manageOrderTable = $("#manageOrderTable").DataTable({
            "language": {
                "lengthMenu": "Mostrar _MENU_ filas por paginas",
                "zeroRecords": "No se encontraron registros coincidentes",
                "info": "Mostrando pagina _PAGE_ de _PAGES_",
                "infoEmpty": "Sin registros disponibles",
                "infoFiltered": "(Se filtraron _MAX_ registros)",
                "sSearch": "Buscar:",
                "paginate": {
                    "previous": "Anterior",
                    "next": "Siguiente"
                }
            },
            'ajax': 'php_action/fetchOrder.php',
            'order': [0, "desc"]
                // "aoColumnDefs": [{
                //         "aTargets": [1],
                //         "sType": 'html'
                //     },
                //     {
                //         aTargets: [2],
                //         sType: 'num-fmt'
                //     }
                // ]
        });

    } else if (divRequest == 'editOrd') {
        $("#orderDate").datepicker();

        // edit order form function
        $("#editOrderForm").unbind('submit').bind('submit', function() {
            // alert('ok');
            var form = $(this);

            $('.form-group').removeClass('has-error').removeClass('has-success');
            $('.text-danger').remove();

            var orderDate = $("#orderDate").val();
            var clientName = $("#clientName").val();
            var clientContact = $("#clientContact").val();
            var paid = $("#paid").val();
            var discount = $("#discount").val();
            var paymentType = $("#paymentType").val();
            var paymentStatus = $("#paymentStatus").val();

            // form validation 
            if (orderDate == "") {
                $("#orderDate").after('<p class="text-danger"> The Order Date field is required </p>');
                $('#orderDate').closest('.form-group').addClass('has-error');
            } else {
                $('#orderDate').closest('.form-group').addClass('has-success');
            } // /else

            if (clientName == "") {
                $("#clientName").after('<p class="text-danger"> The Client Name field is required </p>');
                $('#clientName').closest('.form-group').addClass('has-error');
            } else {
                $('#clientName').closest('.form-group').addClass('has-success');
            } // /else

            if (clientContact == "") {
                $("#clientContact").after('<p class="text-danger"> The Contact field is required </p>');
                $('#clientContact').closest('.form-group').addClass('has-error');
            } else {
                $('#clientContact').closest('.form-group').addClass('has-success');
            } // /else

            if (paid == "") {
                $("#paid").after('<p class="text-danger"> The Paid field is required </p>');
                $('#paid').closest('.form-group').addClass('has-error');
            } else {
                $('#paid').closest('.form-group').addClass('has-success');
            } // /else

            if (discount == "") {
                $("#discount").after('<p class="text-danger"> The Discount field is required </p>');
                $('#discount').closest('.form-group').addClass('has-error');
            } else {
                $('#discount').closest('.form-group').addClass('has-success');
            } // /else

            if (paymentType == "") {
                $("#paymentType").after('<p class="text-danger"> The Payment Type field is required </p>');
                $('#paymentType').closest('.form-group').addClass('has-error');
            } else {
                $('#paymentType').closest('.form-group').addClass('has-success');
            } // /else

            if (paymentStatus == "") {
                $("#paymentStatus").after('<p class="text-danger"> The Payment Status field is required </p>');
                $('#paymentStatus').closest('.form-group').addClass('has-error');
            } else {
                $('#paymentStatus').closest('.form-group').addClass('has-success');
            } // /else


            // array validation
            var productName = document.getElementsByName('productName[]');
            var validateProduct;
            for (var x = 0; x < productName.length; x++) {
                var productNameId = productName[x].id;
                if (productName[x].value == '') {
                    $("#" + productNameId + "").after('<p class="text-danger"> Product Name Field is required!! </p>');
                    $("#" + productNameId + "").closest('.form-group').addClass('has-error');
                } else {
                    $("#" + productNameId + "").closest('.form-group').addClass('has-success');
                }
            } // for

            for (var x = 0; x < productName.length; x++) {
                if (productName[x].value) {
                    validateProduct = true;
                } else {
                    validateProduct = false;
                }
            } // for       		   	

            var quantity = document.getElementsByName('quantity[]');
            var validateQuantity;
            for (var x = 0; x < quantity.length; x++) {
                var quantityId = quantity[x].id;
                if (quantity[x].value == '') {
                    $("#" + quantityId + "").after('<p class="text-danger"> Product Name Field is required!! </p>');
                    $("#" + quantityId + "").closest('.form-group').addClass('has-error');
                } else {
                    $("#" + quantityId + "").closest('.form-group').addClass('has-success');
                }
            } // for

            for (var x = 0; x < quantity.length; x++) {
                if (quantity[x].value) {
                    validateQuantity = true;
                } else {
                    validateQuantity = false;
                }
            } // for       	


            if (orderDate && clientName && clientContact && paid && discount && paymentType && paymentStatus) {
                if (validateProduct == true && validateQuantity == true) {
                    // create order button
                    // $("#createOrderBtn").button('loading');

                    $.ajax({
                        url: form.attr('action'),
                        type: form.attr('method'),
                        data: form.serialize(),
                        dataType: 'json',
                        success: function(response) {
                                console.log(response);
                                // reset button
                                $("#editOrderBtn").button('reset');

                                $(".text-danger").remove();
                                $('.form-group').removeClass('has-error').removeClass('has-success');

                                if (response.success == true) {

                                    // create order button
                                    $(".success-messages").html('<div class="alert alert-success">' +
                                        '<button type="button" class="close" data-dismiss="alert">&times;</button>' +
                                        '<strong><i class="glyphicon glyphicon-ok-sign"></i></strong> ' + response.messages +
                                        '</div>');

                                    $("html, body, div.panel, div.pane-body").animate({ scrollTop: '0px' }, 100);

                                    // disabled te modal footer button
                                    $(".editButtonFooter").addClass('div-hide');
                                    // remove the product row
                                    $(".removeProductRowBtn").addClass('div-hide');

                                } else {
                                    alert(response.messages);
                                }
                            } // /response
                    }); // /ajax
                } // if array validate is true
            } // /if field validate is true

            return false;

        }); // /edit order form function	
    }

}); // /documernt

function validacionesForm() {

}


// print order function
function printOrder(orderId = null) {
    if (orderId) {

        $.ajax({
            url: 'php_action/printOrder.php',
            type: 'post',
            data: { orderId: orderId },
            dataType: 'text',
            success: function(response) {

                    var mywindow = window.open('', 'Sistema de Administracion de Stock', 'height=400,width=600');
                    mywindow.document.write('<html><head><title>Factura de Venta</title>');
                    mywindow.document.write('</head><body>');
                    mywindow.document.write(response);
                    mywindow.document.write('</body></html>');

                    mywindow.document.close(); // necessary for IE >= 10
                    mywindow.focus(); // necessary for IE >= 10

                    mywindow.print();
                    mywindow.close();

                } // /success function
        }); // /ajax function to fetch the printable order
    } // /if orderId
} // /print order function


//Cargar los nombres de los productos para el autocompletado del campo #productName
//18/02/2017 - Jose Campos
function loadAutoComplete() {

    $.ajax({
        url: 'php_action/fetchProductData.php',
        type: 'post',
        dataType: 'json',
        success: function(response) {
                var available = [];

                $.each(response, function(i) {

                    available[i] = response[i][1];

                });

                $("#productName").autocomplete({
                    source: available
                });

            } // /success
    }); // get the product data

}

$('#barCode, #productName').keyup(function(e) {
    if (e.keyCode == 13) {
        addProduct();

    }
});

//Metodo que agrega producto en forma de labels al momento de obtener los datos del producto en los textbox principales (#barCode y #productName) 
//18-02-2017 Jose Campos
function addProduct() {
    var barCode = $("#barCode").val();
    var productName = $("#productName").val();


    $.ajax({
        url: 'php_action/fetchSelectedProduct.php',
        type: 'post',
        data: { barCode: barCode, productName: productName },
        dataType: 'json',
        success: function(response) {

            if (response != null) {
                addProductSuccess(response);
                validaFinalizarPago();
            } else {
                alert('No existe el producto');
            }

        }, // /success
        error: function(xhr, ajaxOptions, thrownError) {
            alert('No existe el producto');

            // alert(xhr.status);
            // alert(thrownError);
        }
    }); // /ajax function to fetch the product data	

    $("#barCode").focus();

    //  $("#productTable tbody").append(trData);

} //addProduct()

function addProductSuccess(response) {
    var cantidad = 0;

    var existeEnTabla = $("td").filter(function() {
        return $(this).text() == response.product_name;
    }).closest("tr");

    if (existeEnTabla.length > 0) {
        cantidad = existeEnTabla[0].childNodes[3].innerText;
    }

    cantidad++;
    //Validacion del stock disponible actualmente al ingresar un producto
    //mejorable con metodo verifyStock() para mostrarlo de mejor forma al usuario 19/02/2017 Jose Campos
    if (response.quantity > 0 && cantidad <= response.quantity) {

        if (existeEnTabla.length > 0) {

            var total = cantidad * response.rate;

            existeEnTabla[0].childNodes[3].innerHTML = cantidad + '<input type="hidden" name="quantity[]" value="' + cantidad + '" />';
            existeEnTabla[0].childNodes[4].innerText = total;



        } else {
            var tableRow = $("#productTable tbody tr:last").attr('id');
            var numFila = 1;

            if (typeof tableRow != 'undefined') {
                numFila = tableRow.substring(3);
                numFila = Number(numFila) + 1;
            }

            var trData = '<tr id="row' + numFila + '">' +
                '<td>' + response.bar_code + '<input type="hidden" name="barCodeValue[]" value="' + response.bar_code + '" /></td>' +
                '<td>' + response.product_name + '</td>' +
                '<td>' + response.rate + '</td>' +
                '<td>' + cantidad + '<input type="hidden" name="quantity[]" value="' + cantidad + '" /></td>' +
                '<td id="total' + numFila + '">' + response.rate + '</td>' +
                '<td><button class="btn btn-default removeProductRowBtn" type="button" id="removeProductRowBtn" onclick="removeProductRow(' + numFila + ')"><i class="glyphicon glyphicon-trash"></i></button></td>' +
                '</tr>';

            $("#productTable tbody").append(trData);

        }



    } else {
        alert("Stock insuficiente...");
    }


    $('#barCode, #productName').val('');

    CalculoFinal();
} //addProductSuccess

//Metodo queda inabilitado ya que se cambiara la forma de agregar productos al metodo addProduct() - 20170218 jcp
function addRow() {
    $("#addRowBtn").button("loading");

    var tableLength = $("#productTable tbody tr").length;

    var tableRow;
    var arrayNumber;
    var count;

    if (tableLength > 0) {
        tableRow = $("#productTable tbody tr:last").attr('id');
        arrayNumber = $("#productTable tbody tr:last").attr('class');
        count = tableRow.substring(3);
        count = Number(count) + 1;
        arrayNumber = Number(arrayNumber) + 1;
    } else {
        // no table row
        count = 1;
        arrayNumber = 0;
    }

    $.ajax({
        url: 'php_action/fetchProductData.php',
        type: 'post',
        dataType: 'json',
        success: function(response) {
                $("#addRowBtn").button("reset");

                var tr = '<tr id="row' + count + '" class="' + arrayNumber + '">' +
                    '<td style="padding-left:20px;">' +
                    '<input type="text" name="barCode[]" id="barCode' + count + '" onkeypress="getProductDataByBarCode(event, ' + count + ')"  class="form-control" />' +
                    '<input type="hidden" name="barCodeValue[]" id="barCodeValue' + count + '" autocomplete="off" class="form-control" />' +
                    '<input type="hidden" name="productIdValue[]" id="productIdValue' + count + '" autocomplete="off" class="form-control" />' +
                    '</td>' +

                    '<td style="margin-left:20px;">' +
                    '<input type="text" name="productName[]" disabled="true" id="productName' + count + '" class="form-control" />' +
                    '<input type="hidden" name="productNameValue[]" id="productNameValue' + count + '" autocomplete="off" class="form-control" />' +
                    '</td>' +

                    '<td style="padding-left:20px;"">' +
                    '<input type="text" name="rate[]" id="rate' + count + '" autocomplete="off" disabled="true" class="form-control" />' +
                    '<input type="hidden" name="rateValue[]" id="rateValue' + count + '" autocomplete="off" class="form-control" />' +
                    '</td style="padding-left:20px;">' +

                    '<td style="padding-left:20px;">' +
                    '<div class="form-group">' +
                    '<input type="number" name="quantity[]" id="quantity' + count + '" onchange="getTotal(' + count + ')" autocomplete="off" class="form-control" min="1" />' +
                    '</div>' +
                    '</td>' +

                    '<td style="padding-left:20px;">' +
                    '<input type="text" name="total[]" id="total' + count + '" autocomplete="off" class="form-control" disabled="true" />' +
                    '<input type="hidden" name="totalValue[]" id="totalValue' + count + '" autocomplete="off" class="form-control" />' +
                    '</td>' +
                    '<td>' +
                    '<button class="btn btn-default removeProductRowBtn" type="button" onclick="removeProductRow(' + count + ')"><i class="glyphicon glyphicon-trash"></i></button>' +
                    '</td>' +
                    '</tr>';
                if (tableLength > 0) {
                    $("#productTable tbody tr:last").after(tr);
                } else {
                    $("#productTable tbody").append(tr);
                }

            } // /success
    }); // get the product data

} // /add row

//Elimina una fila de la tabla donde "row" es el numero de fila mayor a 0 
function removeProductRow(row = null) {
    if (row) {
        $("#row" + row).remove();
        CalculoFinal();
    } else {
        alert('Error, favor refresque la pagina!');
    }
}

function getProductDataByBarCode(e, row) {

    tecla = (document.all) ? e.keyCode : e.which;
    if (tecla == 13) {
        var barCode = $("#barCode" + row).val();

        if (barCode != "") {

            $.ajax({
                url: 'php_action/fetchSelectedProduct.php',
                type: 'post',
                data: { barCode: barCode, productId: "" },
                dataType: 'json',
                success: function(response) {
                    // setting the rate value into the rate input field



                    $("#productName" + row).val(response.product_name);
                    $("#barCodeValue" + row).val(response.bar_code);


                    $("#productIdValue" + row).val(response.product_id);


                    $("#rate" + row).val(response.rate);
                    $("#rateValue" + row).val(response.rate);

                    $("#quantity" + row).val(1);

                    verifyStock(row);

                    var total = Number(response.rate) * 1;
                    total = total.toFixed(0);


                    $("#total" + row).val(total);
                    $("#totalValue" + row).val(total);


                    $("#discount").val(0);



                    CalculoFinal();
                }, // /success
                error: function(xhr, ajaxOptions, thrownError) {
                    alert('No existe el producto');

                    // alert(xhr.status);
                    // alert(thrownError);
                }
            }); // /ajax function to fetch the product data	

        }
    }

}

// select on product data
function getProductData(row = null) {

    if (row) {
        var productId = $("#productName" + row).val();

        if (productId == "") {
            $("#rate" + row).val("");

            $("#quantity" + row).val("");
            $("#total" + row).val("");

        } else {
            $.ajax({
                url: 'php_action/fetchSelectedProduct.php',
                type: 'post',
                data: { productId: productId },
                dataType: 'json',
                success: function(response) {
                        // setting the rate value into the rate input field

                        $("#rate" + row).val(response.rate);
                        $("#rateValue" + row).val(response.rate);

                        $("#quantity" + row).val(1);

                        var total = Number(response.rate) * 1;
                        total = total.toFixed(2);
                        $("#total" + row).val(total);
                        $("#totalValue" + row).val(total);

                        // check if product name is selected
                        // var tableProductLength = $("#productTable tbody tr").length;					
                        // for(x = 0; x < tableProductLength; x++) {
                        // 	var tr = $("#productTable tbody tr")[x];
                        // 	var count = $(tr).attr('id');
                        // 	count = count.substring(3);

                        // 	var productValue = $("#productName"+row).val()

                        // 	if($("#productName"+count).val() != productValue) {
                        // 		// $("#productName"+count+" #changeProduct"+count).addClass('div-hide');	
                        // 		$("#productName"+count).find("#changeProduct"+productId).addClass('div-hide');								
                        // 		console.log("#changeProduct"+count);
                        // 	}											
                        // } // /for

                        CalculoFinal();
                    } // /success
            }); // /ajax function to fetch the product data	
        }

    } else {
        alert('no row! please refresh the page');
    }
} // /select on product data

// table total
function getTotal(row = null) {
    if (row) {
        var total = Number($("#rate" + row).val()) * Number($("#quantity" + row).val());
        total = total.toFixed();
        $("#total" + row).val(total);
        $("#totalValue" + row).val(total);

        verifyStock(row);

        CalculoFinal();

    } else {
        alert('no row !! please refresh the page');
    }


    validaFinalizarPago();

}

//Valida si permite finalizar la venta habilitando o desabilitando el textbox createOrderBtn
function validaFinalizarPago() {
    if ($("#dueValue").val() <= 0 && $(".text-danger").length === 0) {

        $("#paymentStatus").val("1");
        $("#createOrderBtn").removeAttr("disabled");
    } else {
        $("#paymentStatus").val("3");
        $("#createOrderBtn").attr("disabled", true);
    }

    var isVuelto = Number($("#due").val());

    if (isVuelto < 0) {
        $("label[for='due']").text("Vuelto");

    } else {
        $("label[for='due']").text("Faltan");
    }

}


function verifyStock(row) {
    $barCode = $("#barCode" + row).val();
    $toBuy = $("#quantity" + row).val();

    $.ajax({
        url: 'php_action/verifyStock.php',
        type: 'post',
        data: { barCode: $barCode, toBuy: $toBuy },
        dataType: 'json',
        success: function(response) {
            $('#row' + row + ' > td > div').removeClass('has-error');
            $('#row' + row + ' > td > div > .text-danger').remove()
            if (!response) {
                //alert("No hay Stock Suficiente");


                $("#quantity" + row).after('<p class="text-danger"> No hay Stock Suficiente. </p>');
                $('#quantity' + row).closest('.form-group').addClass('has-error');


            } else {
                // $('.form-group').removeClass('has-error').removeClass('has-success');
                // $('.text-danger').remove();
                $('.form-group > #quantity' + row).removeClass('has-error');

            } // /else
        }, // /success
        error: function(xhr, ajaxOptions, thrownError) {
            alert('No existe el producto');

            // alert(xhr.status);
            // alert(thrownError);
        }
    });

}


//Obtiene el valor total de todos los productos agregados a la tabla calculando el "Monto" total y agregarlo al textbox 
function CalculoFinal() {
    var tableProductLength = $("#productTable tbody tr").length;
    var totalSubAmount = 0;
    for (x = 0; x < tableProductLength; x++) {
        var tr = $("#productTable tbody tr")[x];
        var count = $(tr).attr('id');
        count = count.substring(3);

        totalSubAmount = Number(totalSubAmount) + Number($("#total" + count)[0].innerHTML);
    } // /for

    totalSubAmount = totalSubAmount.toFixed(0);

    // sub total
    $("#subTotal").val(totalSubAmount);
    $("#subTotalValue").val(totalSubAmount);

    var discount = $("#discount").val();
    if (discount) {
        var grandTotal = Number($("#subTotal").val()) - Number(discount);
        grandTotal = grandTotal.toFixed(0);
        $("#grandTotal").val(grandTotal);
        $("#grandTotalValue").val(grandTotal);
    } else {
        // $("#grandTotal").val(totalAmount);
        // $("#grandTotalValue").val(totalAmount);
    } // /else discount	

    var paidAmount = $("#paid").val();
    if (paidAmount) {
        paidAmount = Number($("#grandTotal").val()) - Number(paidAmount);
        paidAmount = paidAmount.toFixed(0);
        $("#due").val(paidAmount);
        $("#dueValue").val(paidAmount);
    } else {
        $("#due").val($("#grandTotal").val());
        $("#dueValue").val($("#grandTotal").val());
    } // else

} // /sub total amount

function discountFunc() {
    var discount = $("#discount").val();

    var grandTotal;
    if (discount) {
        grandTotal = Number($("#subTotal").val()) - (Number($("#subTotal").val()) * (Number($("#discount").val() / 100)));
        grandTotal = grandTotal.toFixed(0);

        $("#grandTotal").val(grandTotal);
        $("#grandTotalValue").val(grandTotal);
    }

    var paid = $("#paid").val();

    var dueAmount;
    if (paid) {
        dueAmount = Number($("#grandTotal").val()) - Number($("#paid").val());
        dueAmount = dueAmount.toFixed(0);

        $("#due").val(dueAmount);
        $("#dueValue").val(dueAmount);
    } else {
        $("#due").val($("#grandTotal").val());
        $("#dueValue").val($("#grandTotal").val());
    }

    validaFinalizarPago();

} // /discount function

//Calcula el campo "Vuelto"
function paidAmount() {
    var grandTotal = $("#grandTotal").val();

    if (grandTotal) {
        var dueAmount = Number($("#grandTotal").val()) - Number($("#paid").val());
        dueAmount = dueAmount.toFixed(0);
        $("#due").val(dueAmount);
        $("#dueValue").val(dueAmount);


        validaFinalizarPago();


    } // /if
} // /paid amoutn function


function resetOrderForm() {
    // reset the input field
    $("#createOrderForm")[0].reset();
    // remove remove text danger
    $(".text-danger").remove();
    // remove form group error 
    $(".form-group").removeClass('has-success').removeClass('has-error');

    //Eliminatodos  los productos agregados con anterioridad
    $("#productTable tbody tr").remove();
} // /reset order form


// remove order from server
function removeOrder(orderId = null) {
    if (orderId) {
        $("#removeOrderBtn").unbind('click').bind('click', function() {
            $("#removeOrderBtn").button('loading');

            $.ajax({
                url: 'php_action/removeOrder.php',
                type: 'post',
                data: { orderId: orderId },
                dataType: 'json',
                success: function(response) {
                        $("#removeOrderBtn").button('reset');

                        if (response.success == true) {

                            manageOrderTable.ajax.reload(null, false);
                            // hide modal
                            $("#removeOrderModal").modal('hide');
                            // success messages
                            $("#success-messages").html('<div class="alert alert-success">' +
                                '<button type="button" class="close" data-dismiss="alert">&times;</button>' +
                                '<strong><i class="glyphicon glyphicon-ok-sign"></i></strong> ' + response.messages +
                                '</div>');

                            // remove the mesages
                            $(".alert-success").delay(500).show(10, function() {
                                $(this).delay(3000).hide(10, function() {
                                    $(this).remove();
                                });
                            }); // /.alert	          

                        } else {
                            // error messages
                            $(".removeOrderMessages").html('<div class="alert alert-warning">' +
                                '<button type="button" class="close" data-dismiss="alert">&times;</button>' +
                                '<strong><i class="glyphicon glyphicon-ok-sign"></i></strong> ' + response.messages +
                                '</div>');

                            // remove the mesages
                            $(".alert-success").delay(500).show(10, function() {
                                $(this).delay(3000).hide(10, function() {
                                    $(this).remove();
                                });
                            }); // /.alert	          
                        } // /else

                    } // /success
            }); // /ajax function to remove the order

        }); // /remove order button clicked


    } else {
        alert('error! refresh the page again');
    }
}
// /remove order from server

// Payment ORDER
function paymentOrder(orderId = null) {
    if (orderId) {

        $("#orderDate").datepicker();

        $.ajax({
            url: 'php_action/fetchOrderData.php',
            type: 'post',
            data: { orderId: orderId },
            dataType: 'json',
            success: function(response) {

                    // due 
                    $("#due").val(response.order[10]);

                    // pay amount 
                    $("#payAmount").val(response.order[10]);

                    var paidAmount = response.order[9]
                    var dueAmount = response.order[10];
                    var grandTotal = response.order[8];

                    // update payment
                    $("#updatePaymentOrderBtn").unbind('click').bind('click', function() {
                        var payAmount = $("#payAmount").val();
                        var paymentType = $("#paymentType").val();
                        var paymentStatus = $("#paymentStatus").val();

                        if (payAmount == "") {
                            $("#payAmount").after('<p class="text-danger">El campo Cantidad de pago se requiere</p>');
                            $("#payAmount").closest('.form-group').addClass('has-error');
                        } else {
                            $("#payAmount").closest('.form-group').addClass('has-success');
                        }

                        if (paymentType == "") {
                            $("#paymentType").after('<p class="text-danger">El campo Cantidad de pago se requiere</p>');
                            $("#paymentType").closest('.form-group').addClass('has-error');
                        } else {
                            $("#paymentType").closest('.form-group').addClass('has-success');
                        }

                        if (paymentStatus == "") {
                            $("#paymentStatus").after('<p class="text-danger">El campo Cantidad de pago se requiere</p>');
                            $("#paymentStatus").closest('.form-group').addClass('has-error');
                        } else {
                            $("#paymentStatus").closest('.form-group').addClass('has-success');
                        }

                        if (payAmount && paymentType && paymentStatus) {
                            $("#updatePaymentOrderBtn").button('loading');
                            $.ajax({
                                url: 'php_action/editPayment.php',
                                type: 'post',
                                data: {
                                    orderId: orderId,
                                    payAmount: payAmount,
                                    paymentType: paymentType,
                                    paymentStatus: paymentStatus,
                                    paidAmount: paidAmount,
                                    grandTotal: grandTotal
                                },
                                dataType: 'json',
                                success: function(response) {
                                        $("#updatePaymentOrderBtn").button('loading');

                                        // remove error
                                        $('.text-danger').remove();
                                        $('.form-group').removeClass('has-error').removeClass('has-success');

                                        $("#paymentOrderModal").modal('hide');

                                        $("#success-messages").html('<div class="alert alert-success">' +
                                            '<button type="button" class="close" data-dismiss="alert">&times;</button>' +
                                            '<strong><i class="glyphicon glyphicon-ok-sign"></i></strong> ' + response.messages +
                                            '</div>');

                                        // remove the mesages
                                        $(".alert-success").delay(500).show(10, function() {
                                            $(this).delay(3000).hide(10, function() {
                                                $(this).remove();
                                            });
                                        }); // /.alert	

                                        // refresh the manage order table
                                        manageOrderTable.ajax.reload(null, false);

                                    } //

                            });
                        } // /if

                        return false;
                    }); // /update payment			

                } // /success
        }); // fetch order data
    } else {
        alert('Error ! Refresh the page again');
    }
}