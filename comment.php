<?php 
require_once 'includes/header.php'; 
date_default_timezone_set('America/Santiago'); 
setlocale(LC_TIME, 'spanish');
$fecha=strftime("%A, %d de %B de %Y");
?>

<form>
  <div class="form-group">
    <label id="lblEmail">Email</label>
    <input type="email" class="form-control" id="tbEmail" placeholder="nombre@ejemplo.com">
  </div>

  <div class="form-group">
    <label id="lblComentario">Comentario</label>
    <textarea class="form-control" id="tbComentario" rows="3"></textarea>
  </div>

  <a href="#" class="btn btn-primary btn-lg active" role="button" aria-pressed="true">Enviar</a>
</form>

<script src="custom/js/comment.js"></script>
<?php require_once 'includes/footer.php'; ?>