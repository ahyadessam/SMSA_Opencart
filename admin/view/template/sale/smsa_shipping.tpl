<?php echo $header; ?><?php echo $column_left; ?>
<div id="content">
  <div class="page-header">
    <div class="container-fluid">
      <h1><?php echo $heading_title; ?></h1>
      <ul class="breadcrumb">
        <?php foreach ($breadcrumbs as $breadcrumb) { ?>
        <li><a href="<?php echo $breadcrumb['href']; ?>"><?php echo $breadcrumb['text']; ?></a></li>
        <?php } ?>
      </ul>
    </div>
  </div>
  <div class="container-fluid">
    <?php if (isset($error_warning)) { ?>
    <div class="alert alert-warning"><i class="fa fa-exclamation-circle"></i> <?php echo $error_warning; ?>
      <button type="button" class="close" data-dismiss="alert">&times;</button>
    </div>
    <?php } 
    if(isset($success)){
        ?><div class="alert alert-success"><?=$success?></div><?php
    }
    
    if(isset($shipped)){
        ?><div class="alert alert-info"><?=$shipped?></div><?php
    }
    ?>
    <div class="panel panel-default">
      <div class="panel-heading">
        <h3 class="panel-title"><i class="fa fa-pencil"></i> <?php echo $text_shipping; ?></h3>
      </div>
      <div class="panel-body">
        <?php
        if(isset($not_found)){
            ?>
            <div class="alert alert-danger"><?=$not_found?></div>
            <?php
        }else{
            ?>
            <div class="row">
                <div class="col-xs-12">
                    <h3><?=$order_details?></h3>
                </div>
            </div>
            <div class="row">
                <div class="col-sm-3 col-xs-12">
                    <strong><?=$name?></strong>
                </div>
                <div class="col-sm-9 col-xs-12">
                    <?php 
                    echo $order['shipping_firstname'].' '.$order['shipping_lastname'];
                    ?>
                </div>
            </div>
            <div class="row">
                <div class="col-sm-3 col-xs-12">
                    <strong><?=$address?></strong>
                </div>
                <div class="col-sm-9 col-xs-12">
                    <?php
                    echo $order['shipping_address_1'].'<br />'.$order['shipping_address_2'];
                    ?>
                </div>
            </div>
            <div class="row">
                <div class="col-sm-3 col-xs-12">
                    <strong><?=$phone?></strong>
                </div>
                <div class="col-sm-9 col-xs-12"><?php echo $order['telephone']; ?></div>
            </div>
            <div class="row">
                <div class="col-sm-3 col-xs-12">
                    <strong><?=$mail?></strong>
                </div>
                <div class="col-sm-9 col-xs-12"><?php echo $order['email']; ?></div>
            </div>
            <div class="row">
                <form method="post">
                    <div class="form-group">
                        <div class="col-xs-12">
                            <div class="checkbox">
                                <label>
                                    <input type="checkbox" name="send_mail" value="yes" /> <?=$send_to_client?>
                                </label>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-xs-12 text-center">
                            <?php
                            if(isset($awd)){
                                ?>
                                <a href="<?php $uri_parts = explode('?', $_SERVER['REQUEST_URI'], 2); echo (($_SERVER['HTTPS']) ? "https" : "http").'://'.$_SERVER["HTTP_HOST"].$uri_parts[0].'?route=sale/smsa/cancel&token='.$_GET['token'].'&order_id='.$_GET['order_id'].'&awb='.$awd; ?>" id="cancel_order" class="btn btn-danger" style="margin: 0 15px;"><?=$cancel_shipping?></a>
                                <script>
                                    $('#cancel_order').click(function(){
                                       var sure = confirm('<?=$cancel_confirm?>');
                                       if(sure == false)
                                        return false; 
                                    });
                                </script>
                                <?php
                            }
                            ?>
                            <input type="submit" name="do_shipping" value="<?=$text_shipping?>" class="btn btn-success" />
                        </div>
                    </div>
                </form>
            </div>
            <?php
        }
        ?>
      </div>
    </div>
  </div>
</div>
<?php echo $footer; ?>