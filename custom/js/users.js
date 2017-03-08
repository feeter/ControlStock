//SE UTILIZA COMO PLANTILA EL JAVASCRIPT DE LAS MARCAS (BRAND) PARA CREAR EL DE LOS usuarios
//07/03/2017 JOSE CAMPOS

var manageUserTable;

$(document).ready(function() {
    // main menu
    $("#navSetting").addClass('active');
    // sub manin    
    $("#topNavUser").addClass('active');

    // Inicalizar la tabla de los usuarios
    manageUserTable = $("#manageUserTable").DataTable({
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
        'ajax': 'php_action/fetchUser.php',
        'order': []
    });

    // Submit del formulario para crear usuarios
    $("#submitUserForm").unbind('submit').bind('submit', function() {
        // remove the error text
        $(".text-danger").remove();
        // remove the form error
        $('.form-group').removeClass('has-error').removeClass('has-success');

        var userName = $("#tbUserName");
        var clave = $("#tbUserPass").val();
        var clave2 = $("#tbUserPass2").val();
        var userEmail = $("#tbUserEmail").val();
        var perfil = $("#ddlUserPerfil");


        if (perfil.val() == "") {
            perfil.after('<p class="text-danger">Debe ingresar un perfil</p>');
            perfil.closest('.form-group').addClass('has-error');
        } else {
            // remov error text field
            perfil.find('.text-danger').remove();
            // success out for form 
            perfil.closest('.form-group').addClass('has-success');
        }



        if (userName.val() == "" || /\s/.test(userName.val())) {
            userName.after('<p class="text-danger">Nombre de usuario es obligatorio y no debe contener espacios</p>');
            userName.closest('.form-group').addClass('has-error');
        } else {
            // remov error text field
            userName.find('.text-danger').remove();
            // success out for form 
            userName.closest('.form-group').addClass('has-success');
        }

        if (clave == "" || clave2 == "") {
            $("#tbUserPass, #tbUserPass2").after('<p class="text-danger">Debe ingresar una clave</p>');

            $('#tbUserPass, #tbUserPass2').closest('.form-group').addClass('has-error');
        } else {
            // remov error text field
            $("#tbUserPass, #tbUserPass2").find('.text-danger').remove();
            // success out for form 
            $("#tbUserPass, #tbUserPass2").closest('.form-group').addClass('has-success');
        }

        if (clave != clave2) {
            $("#tbUserPass, #tbUserPass2").after('<p class="text-danger">Las claves ingresadas deben ser iguales</p>');

            $('#tbUserPass, #tbUserPass2').closest('.form-group').addClass('has-error');
        } else {
            // remov error text field
            $("#tbUserPass, #tbUserPass2").find('.text-danger').remove();
            // success out for form 
            $("#tbUserPass, #tbUserPass2").closest('.form-group').addClass('has-success');
        }

        if (userName.val() || perfil.val() || clave || clave2) {
            var form = $(this);
            // button loading
            $("#btnCreateUser").button('loading');

            console.log(form.serialize());

            $.ajax({
                url: form.attr('action'),
                type: form.attr('method'),
                data: form.serialize(),
                dataType: 'json',
                success: function(response) {
                        // button loading
                        $("#btnCreateUser").button('reset');

                        //if (response.success == true) {
                        // reload the manage member table 
                        manageUserTable.ajax.reload(null, false);

                        //console.log(response.messages);

                        // reset the form text
                        $("#submitUserForm")[0].reset();
                        // remove the error text
                        $(".text-danger").remove();
                        // remove the form error
                        $('.form-group').removeClass('has-error').removeClass('has-success');

                        $('#add-user-messages').html('<div class="alert alert-success">' +
                            '<button type="button" class="close" data-dismiss="alert">&times;</button>' +
                            '<strong><i class="glyphicon glyphicon-ok-sign"></i></strong> ' + response.messages +
                            '</div>');

                        $(".alert-success").delay(500).show(10, function() {
                            $(this).delay(3000).hide(10, function() {
                                $(this).remove();
                            });
                        }); // /.alert
                        //} // if

                    } // /success
            }); // /ajax	
        } // if

        return false;
    }); // /submit brand form function

});

function editUser(userId = null) {

    if (userId) {
        // remove hidden brand id text
        $('#brandId').remove();

        // remove the error 
        $('.text-danger').remove();
        // remove the form-error
        $('.form-group').removeClass('has-error').removeClass('has-success');

        // modal loading
        $('.modal-loading').removeClass('div-hide');
        // modal result
        $('.edit-brand-result').addClass('div-hide');
        // modal footer
        $('.editBrandFooter').addClass('div-hide');

        $.ajax({
            url: 'php_action/fetchSelectedBrand.php',
            type: 'post',
            data: { brandId: userId },
            dataType: 'json',
            success: function(response) {
                    // modal loading
                    $('.modal-loading').addClass('div-hide');
                    // modal result
                    $('.edit-brand-result').removeClass('div-hide');
                    // modal footer
                    $('.editBrandFooter').removeClass('div-hide');

                    // setting the brand name value 
                    $('#editBrandName').val(response.brand_name);
                    // setting the brand status value
                    $('#editBrandStatus').val(response.brand_active);
                    // brand id 
                    $(".editBrandFooter").after('<input type="hidden" name="brandId" id="brandId" value="' + response.brand_id + '" />');

                    // update brand form 
                    $('#editBrandForm').unbind('submit').bind('submit', function() {

                        // remove the error text
                        $(".text-danger").remove();
                        // remove the form error
                        $('.form-group').removeClass('has-error').removeClass('has-success');

                        var brandName = $('#editBrandName').val();
                        var brandStatus = $('#editBrandStatus').val();

                        if (brandName == "") {
                            $("#editBrandName").after('<p class="text-danger">Brand Name field is required</p>');
                            $('#editBrandName').closest('.form-group').addClass('has-error');
                        } else {
                            // remov error text field
                            $("#editBrandName").find('.text-danger').remove();
                            // success out for form 
                            $("#editBrandName").closest('.form-group').addClass('has-success');
                        }

                        if (brandStatus == "") {
                            $("#editBrandStatus").after('<p class="text-danger">Brand Name field is required</p>');

                            $('#editBrandStatus').closest('.form-group').addClass('has-error');
                        } else {
                            // remove error text field
                            $("#editBrandStatus").find('.text-danger').remove();
                            // success out for form 
                            $("#editBrandStatus").closest('.form-group').addClass('has-success');
                        }

                        if (brandName && brandStatus) {
                            var form = $(this);

                            // submit btn
                            $('#editBrandBtn').button('loading');

                            $.ajax({
                                url: form.attr('action'),
                                type: form.attr('method'),
                                data: form.serialize(),
                                dataType: 'json',
                                success: function(response) {

                                        if (response.success == true) {
                                            console.log(response);
                                            // submit btn
                                            $('#editBrandBtn').button('reset');

                                            // reload the manage member table 
                                            manageUserTable.ajax.reload(null, false);
                                            // remove the error text
                                            $(".text-danger").remove();
                                            // remove the form error
                                            $('.form-group').removeClass('has-error').removeClass('has-success');

                                            $('#edit-brand-messages').html('<div class="alert alert-success">' +
                                                '<button type="button" class="close" data-dismiss="alert">&times;</button>' +
                                                '<strong><i class="glyphicon glyphicon-ok-sign"></i></strong> ' + response.messages +
                                                '</div>');

                                            $(".alert-success").delay(500).show(10, function() {
                                                $(this).delay(3000).hide(10, function() {
                                                    $(this).remove();
                                                });
                                            }); // /.alert
                                        } // /if

                                    } // /success
                            }); // /ajax												
                        } // /if

                        return false;
                    }); // /update brand form

                } // /success
        }); // ajax function

    } else {
        alert('error!! Refresh the page again');
    }
} // /edit brands function

function removeUser(userId = null) {
    if (userId) {
        $("#removeUserBtn").unbind('click').bind('click', function() {

            $("#removeUserBtn").button('loading');


            $.ajax({
                url: 'php_action/removeUser.php',
                type: 'post',
                data: { userId: userId },
                dataType: 'json',
                success: function(response) {
                        console.log(response);
                        // button loading
                        $("#removeUserBtn").button('reset');
                        if (response.success == true) {

                            // hide the remove modal 
                            $('#removeMemberModal').modal('hide');

                            // reload the brand table 
                            manageUserTable.ajax.reload(null, false);

                            $('.remove-messages').html('<div class="alert alert-success">' +
                                '<button type="button" class="close" data-dismiss="alert">&times;</button>' +
                                '<strong><i class="glyphicon glyphicon-ok-sign"></i></strong> ' + response.messages +
                                '</div>');

                            $(".alert-success").delay(500).show(10, function() {
                                $(this).delay(3000).hide(10, function() {
                                    $(this).remove();
                                });
                            }); // /.alert
                        } else {

                        } // /else
                    } // /response messages
            }); // /ajax function to remove the user


        });

        //$('.removeBrandFooter').after();
    } else {
        alert('error!! Refresh the page again');
    }
} // /remove brands function