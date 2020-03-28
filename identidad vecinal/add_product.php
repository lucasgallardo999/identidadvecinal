<?php
  $page_title = 'Agregar producto';
  require_once('includes/load.php');
  // Checkin What level user has permission to view this page
  page_require_level(2);
  $all_categories = find_all('categories');
?>
<?php
 if(isset($_POST['add_product'])){
   $req_fields = array('product-title','product-categorie','product-quantity','date');
   validate_fields($req_fields);
   if(empty($errors)){
     $p_name  = remove_junk($db->escape($_POST['product-title']));
     $p_cat   = remove_junk($db->escape($_POST['product-categorie']));
     $p_qty   = remove_junk($db->escape($_POST['product-quantity']));
     $p_buy   = remove_junk($db->escape($_POST['buying-price']));
     $date   = remove_junk($db->escape($_POST['date']));
     
     $query  = "INSERT INTO products (";
     $query .=" name,quantity,buy_price,categorie_id,date";
     $query .=") VALUES (";
     $query .=" '{$p_name}', '{$p_qty}', '{$p_buy}', '{$p_cat}', '{$date}'";
     $query .=")";
     $query .=" ON DUPLICATE KEY UPDATE name='{$p_name}'";
     if($db->query($query)){
       $session->msg('s',"Producto agregado exitosamente. ");
       redirect('add_product.php', false);
     } else {
       $session->msg('d',' Lo siento, registro falló.');
       redirect('product.php', false);
     }

   } else{
     $session->msg("d", $errors);
     redirect('add_product.php',false);
   }

 }

?>
<?php include_once('layouts/header.php'); ?>
<div class="row">
  <div class="col-md-12">
    <?php echo display_msg($msg); ?>
  </div>
</div>
  <div class="row">
  <div class="col-md-9">
      <div class="panel panel-default">
        <div class="panel-heading">
          <strong>
            <span class="glyphicon glyphicon-th"></span>
            <span>Agregar producto</span>
         </strong>
        </div>
        <div class="panel-body">
         <div class="col-md-12">
          <form method="post" action="add_product.php" class="clearfix">
              <div class="form-group">
                <div class="input-group">
                  <span class="input-group-addon">
                   <i class="glyphicon glyphicon-th-large"></i>
                  </span>
                  <input type="text" class="form-control" name="product-title" placeholder="Mercaderia">
               </div>
              </div>
              <div class="form-group">
                <div class="row">
                  <div class="col-md-6">
                    <select class="form-control" name="product-categorie">
                      <option value="">Selecciona una categoría</option>
                    <?php  foreach ($all_categories as $cat): ?>
                      <option value="<?php echo (int)$cat['id'] ?>">
                        <?php echo $cat['name'] ?></option>
                    <?php endforeach; ?>
                    </select>
                    </div>
                </div>
              </div>

              <div class="form-group">
               <div class="row">
                 <div class="col-md-4">
                  <label for="qty">Cantidad</label>
                   <div class="input-group">
                     <span class="input-group-addon">
                      <i class="glyphicon glyphicon-list"></i>
                     </span>
                     <input type="number" class="form-control" name="product-quantity" placeholder="Cantidad">
                  </div>
                 </div>
                 <div class="col-md-4">
                  <label for="buy_price">Fecha de Vencimiento</label>
                   <div class="input-group">
                    
                     <span class="input-group-addon">
                       <i class="glyphicon glyphicon-calendar"></i>
                     </span>
                     <input type="date" class="form-control" name="buying-price" placeholder="Fecha de Vencimiento">
                  </div>
                 </div>
                 <div class="col-md-4">
                  <label for="price">Fecha de Ingreso</label>
                   <div class="input-group">
                    
                     <span class="input-group-addon">
                       <i class="glyphicon glyphicon-calendar"></i>
                     </span>
                     <input type="date" class="form-control" name="date" placeholder="Fecha de ingreso">
                  </div>
                 </div>
               </div>
              </div>
              <button type="submit" name="add_product" class="btn btn-danger">Agregar mercadería</button>
          </form>
         </div>
        </div>
      </div>
    </div>
  </div>

<?php include_once('layouts/footer.php'); ?>
