<?php require_once 'includes/header.php'; ?>


<div class="row">
	<div class="col-md-12">

		<ol class="breadcrumb">
		  <li><a href="dashboard.php">Home</a></li>		  
		  <li class="active">Usuarios</li>
		</ol>

		<div class="panel panel-default">
			<div class="panel-heading">
				<div class="page-heading"> <i class="glyphicon glyphicon-edit"></i> Gestion de Usuarios</div>
			</div> <!-- /panel-heading -->
			<div class="panel-body">

				<div class="remove-messages"></div>

				<div class="div-action pull pull-right" style="padding-bottom:20px;">
					<button class="btn btn-default button1" data-toggle="modal" data-target="#addUserModel"> <i class="glyphicon glyphicon-plus-sign"></i> Agregar Usuarios </button>
				</div> <!-- /div-action -->				
				
				<table class="table" id="manageUserTable">
					<thead>
						<tr>							
							<th>Nombre Usuarios</th>
							<th>Email</th>
							<th style="width:15%;">Perfil</th>
                            <th style="width:15%;">Opciones</th>
						</tr>
					</thead>
				</table>
				<!-- /table -->

			</div> <!-- /panel-body -->
		</div> <!-- /panel -->		
	</div> <!-- /col-md-12 -->
</div> <!-- /row -->

<div class="modal fade" id="addUserModel" tabindex="-1" role="dialog">
  <div class="modal-dialog">
    <div class="modal-content">
    	
    	<form class="form-horizontal" id="submitUserForm" action="php_action/createUser.php" method="POST">
	      <div class="modal-header">
	        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
	        <h4 class="modal-title"><i class="fa fa-plus"></i> Agregar Usuarios</h4>
	      </div>
	      <div class="modal-body">

	      	<div id="add-user-messages"></div> <!-- Mensaje obtenido por jquery segun resulato al guardar  -->

	        <div class="form-group">
	        	<label class="col-sm-3 control-label">Nombre: </label>
				    <div class="col-sm-8">
				      <input type="text" class="form-control" id="tbUserName" placeholder="Nombre Usuarios" name="tbUserName">
				    </div>
	        </div> <!-- /form-group-->


					<!-- MODIFICAR PARA OBTENERLOS DE LA BASE DE DATOS DIRECTAMENTE 07/03/2017 JCP -->
					<div class="form-group">
	        	<label class="col-sm-3 control-label">Perfil: </label>
				    <div class="col-sm-8">
				      <select class="form-control" id="ddlUserPerfil" name="ddlUserPerfil">
				      	<option value="">--Seleccionar--</option>
				      	<option value="1">Administrador</option>
				      	<option value="2">Vendedor</option>
				      </select>
				    </div>
	        </div> <!-- /form-group-->	

            <div class="form-group">
	        	<label class="col-sm-3 control-label">Clave: </label>
				    <div class="col-sm-8">
				      <input type="text" class="form-control" id="tbUserPass" placeholder="Clave" name="tbUserPass">
				    </div>
	        </div> <!-- /form-group-->

          <div class="form-group">
	        	<label class="col-sm-3 control-label">Repita Clave: </label>
				    <div class="col-sm-8">
				      <input type="text" class="form-control" id="tbUserPass2" placeholder="Repita Clave" name="tbUserPass2">
				    </div>
	        </div> <!-- /form-group-->

	        <div class="form-group">
	        	<label class="col-sm-3 control-label">Email: </label>
				    <div class="col-sm-8">
				      <input type="text" class="form-control" id="tbUserEmail" placeholder="Ingrese Email" name="tbUserEmail">
				    </div>
	        </div> <!-- /form-group-->


	      </div> <!-- /modal-body -->
	      
	      <div class="modal-footer">
	        <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
	        
	        <button type="submit" class="btn btn-primary" id="btnCreateUser" data-loading-text="Cargando..." autocomplete="off">Guardar</button>
	      </div>
	      <!-- /modal-footer -->
     	</form>
	     <!-- /.form -->
    </div>
    <!-- /modal-content -->
  </div>
  <!-- /modal-dailog -->
</div>
<!-- / add modal -->

<!-- edit User (pensar si usar o no ) -->
<div class="modal fade" id="editUserModel" tabindex="-1" role="dialog">
  <div class="modal-dialog">
    <div class="modal-content">
    	
    	<form class="form-horizontal" id="editBrandForm" action="php_action/editBrand.php" method="POST">
	      <div class="modal-header">
	        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
	        <h4 class="modal-title"><i class="fa fa-edit"></i> Editar Usuarios</h4>
	      </div>
	      <div class="modal-body">

	      	<div id="edit-brand-messages"></div>

	      	<div class="modal-loading div-hide" style="width:50px; margin:auto;padding-top:50px; padding-bottom:50px;">
						<i class="fa fa-spinner fa-pulse fa-3x fa-fw"></i>
						<span class="sr-only">Cargando...</span>
					</div>

		      <div class="edit-brand-result">
		      	<div class="form-group">
		        	<label for="editBrandName" class="col-sm-3 control-label">Nombre: </label>
		        	<label class="col-sm-1 control-label">: </label>
					    <div class="col-sm-8">
					      <input type="text" class="form-control" id="editBrandName" placeholder="Nombre Usuarios" name="editBrandName" autocomplete="off">
					    </div>
		        </div> <!-- /form-group-->	         	        
		        <div class="form-group">
		        	<label for="editBrandStatus" class="col-sm-3 control-label">Estado: </label>
		        	<label class="col-sm-1 control-label">: </label>
					    <div class="col-sm-8">
					      <select class="form-control" id="editBrandStatus" name="editBrandStatus">
					      	<option value="">~~SELECT~~</option>
					      	<option value="1">Disponible</option>
					      	<option value="2">No Disponible</option>
					      </select>
					    </div>
		        </div> <!-- /form-group-->	
		      </div>         	        
		      <!-- /edit brand result -->

	      </div> <!-- /modal-body -->
	      
	      <div class="modal-footer editBrandFooter">
	        <button type="button" class="btn btn-default" data-dismiss="modal"> <i class="glyphicon glyphicon-remove-sign"></i> Cerrar</button>
	        
	        <button type="submit" class="btn btn-success" id="editBrandBtn" data-loading-text="Loading..." autocomplete="off"> <i class="glyphicon glyphicon-ok-sign"></i> Actualizar</button>
	      </div>
	      <!-- /modal-footer -->
     	</form>
	     <!-- /.form -->
    </div>
    <!-- /modal-content -->
  </div>
  <!-- /modal-dailog -->
</div>
<!-- / add modal -->
<!-- /edit brand -->

<!-- remove brand -->
<div class="modal fade" tabindex="-1" role="dialog" id="removeMemberModal">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title"><i class="glyphicon glyphicon-trash"></i> Eliminar Usuario</h4>
      </div>
      <div class="modal-body">
        <p>¿Desea eliminar el usuario seleccionado?</p>
      </div>
      <div class="modal-footer removeBrandFooter">
        <button type="button" class="btn btn-default" data-dismiss="modal"> <i class="glyphicon glyphicon-remove-sign"></i> Cerrar</button>
        <button type="button" class="btn btn-primary" id="removeUserBtn" data-loading-text="Loading..."> <i class="glyphicon glyphicon-ok-sign"></i> Eliminar</button>
      </div>
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->
<!-- /remove users -->

<!--<script src="custom/js/brand.js"></script>-->
<script src="custom/js/users.js"></script>

<?php require_once 'includes/footer.php'; ?>