<?php echo $header; ?><?php echo $column_left; ?>
<div id="content">
  <div class="page-header">
    <div class="container-fluid">
      <h1><?php echo $heading_title; ?></h1>
    </div>
  </div>
  <div class="container-fluid">
    <div class="panel panel-default">
      <div class="panel-heading">
        <h3 class="panel-title"><i class="fa fa-pencil"></i> <?php echo $text_shipping; ?></h3>
      </div>
      <div class="panel-body">
        <?php  
        if(isset($success)){
            ?><div class="alert alert-success"><?=$success?></div><?php
        }
        
        if(isset($error)){
            ?><div class="alert alert-danger"><?=$shipped?></div><?php
        }
        ?>
        <br />
        <a href="<?php $uri_parts = explode('?', $_SERVER['REQUEST_URI'], 2); echo (($_SERVER['HTTPS']) ? "https" : "http").'://'.$_SERVER["HTTP_HOST"].$uri_parts[0].'?route=sale/smsa/create&token='.$_GET['token'].'&order_id='.$_GET['order_id']; ?>" id="cancel_order" class="btn btn-danger" style="margin: 0 15px;">Back</a>
      </div>
    </div>
  </div>
</div>
<?php echo $footer; ?>