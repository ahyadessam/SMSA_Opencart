<?php echo $header; ?><?php echo $column_left; ?>
<div id="content">
  <div class="page-header">
    <div class="container-fluid">
      <div class="pull-right">
        <button type="submit" form="form-fedex" data-toggle="tooltip" title="<?php echo $button_save; ?>" class="btn btn-primary"><i class="fa fa-save"></i></button>
        <a href="<?php echo $cancel; ?>" data-toggle="tooltip" title="<?php echo $button_cancel; ?>" class="btn btn-default"><i class="fa fa-reply"></i></a></div>
      <h1><?php echo $heading_title; ?></h1>
      <ul class="breadcrumb">
        <?php foreach ($breadcrumbs as $breadcrumb) { ?>
        <li><a href="<?php echo $breadcrumb['href']; ?>"><?php echo $breadcrumb['text']; ?></a></li>
        <?php } ?>
      </ul>
    </div>
  </div>
  <div class="container-fluid">
    <?php if ($error_warning) { ?>
    <div class="alert alert-danger"><i class="fa fa-exclamation-circle"></i> <?php echo $error_warning; ?>
      <button type="button" class="close" data-dismiss="alert">&times;</button>
    </div>
    <?php } ?>
    <div class="panel panel-default">
      <div class="panel-heading">
        <h3 class="panel-title"><i class="fa fa-pencil"></i> <?php echo $text_edit; ?></h3>
      </div>
      <div class="panel-body">
        <form action="<?php echo $action; ?>" method="post" enctype="multipart/form-data" id="form-fedex" class="form-horizontal">
          <div class="form-group required">
            <label class="col-sm-2 control-label" for="input-key"><?php echo $entry_username; ?></label>
            <div class="col-sm-10">
              <input type="text" name="smsa_username" value="<?php echo $smsa_username; ?>" id="input-key" class="form-control" />
              <?php if ($error_username) { ?>
              <div class="text-danger"><?php echo $error_username; ?></div>
              <?php } ?>
            </div>
          </div>
          <div class="form-group required">
            <label class="col-sm-2 control-label" for="input-password"><?php echo $entry_password; ?></label>
            <div class="col-sm-10">
              <input type="text" name="smsa_password" value="<?php echo $smsa_password; ?>"  id="input-password" class="form-control" />
              <?php if ($error_password) { ?>
              <div class="text-danger"><?php echo $error_password; ?></div>
              <?php } ?>
            </div>
          </div>
		  
          <div class="form-group required">
            <label class="col-sm-2 control-label" for="input-account"><?php echo $entry_passkey; ?></label>
            <div class="col-sm-10">
              <input type="text" name="smsa_passkey" value="<?php echo $smsa_passkey; ?>" id="input-account" class="form-control" />
              <?php if ($error_passkey) { ?>
              <div class="text-danger"><?php echo $error_passkey; ?></div>
              <?php } ?>
            </div>
          </div>
          <div class="form-group required">
            <label class="col-sm-2 control-label" for="input-meter"><?php echo $entry_rate; ?></label>
            <div class="col-sm-10">
              <input type="text" name="smsa_rate" value="<?php echo $smsa_rate; ?>" id="input-meter" class="form-control" />
              <?php if ($error_rate) { ?>
              <div class="text-danger"><?php echo $error_rate; ?></div>
              <?php } ?>
            </div>
          </div>
          
          <div class="form-group required">
            <label class="col-sm-2 control-label" for="entry_sName"><?php echo $entry_sName; ?></label>
            <div class="col-sm-10">
              <input type="text" name="smsa_sName" value="<?php echo $smsa_sName; ?>" id="entry_sName" class="form-control" />
            </div>
          </div>
          <div class="form-group required">
            <label class="col-sm-2 control-label" for="input-sContact"><?php echo $entry_sContact; ?></label>
            <div class="col-sm-10">
              <input type="text" name="smsa_sContact" value="<?php echo $smsa_sContact; ?>" id="input-sContact" class="form-control" />
            </div>
          </div>
          <div class="form-group required">
            <label class="col-sm-2 control-label" for="input-sAddr"><?php echo $entry_sAddr; ?></label>
            <div class="col-sm-10">
              <input type="text" name="smsa_sAddr" value="<?php echo $smsa_sAddr; ?>" id="input-sAddr" class="form-control" />
            </div>
          </div>
          <div class="form-group required">
            <label class="col-sm-2 control-label" for="input-sCity"><?php echo $entry_sCity; ?></label>
            <div class="col-sm-10">
              <input type="text" name="smsa_sCity" value="<?php echo $smsa_sCity; ?>" id="input-sCity" class="form-control" />
            </div>
          </div>
          <div class="form-group required">
            <label class="col-sm-2 control-label" for="input-sPhone"><?php echo $entry_sPhone; ?></label>
            <div class="col-sm-10">
              <input type="text" name="smsa_sPhone" value="<?php echo $smsa_sPhone; ?>" id="input-sPhone" class="form-control" />
            </div>
          </div>
          <div class="form-group required">
            <label class="col-sm-2 control-label" for="input-sCntry"><?php echo $entry_sCntry; ?></label>
            <div class="col-sm-10">
              <input type="text" name="smsa_sCntry" value="<?php echo $smsa_sCntry; ?>" id="input-sCntry" class="form-control" />
            </div>
          </div>
          
		  <div class="form-group required">
            <label class="col-sm-2 control-label" for="input-status"><?php echo $entry_status; ?></label>
            <div class="col-sm-10">
              <select name="smsa_status" id="input-status" class="form-control">
                <?php if ($smsa_status) { ?>
                <option value="1" selected="selected"><?php echo $text_enabled; ?></option>
                <option value="0"><?php echo $text_disabled; ?></option>
                <?php } else { ?>
                <option value="1"><?php echo $text_enabled; ?></option>
                <option value="0" selected="selected"><?php echo $text_disabled; ?></option>
                <?php } ?>
              </select>
            </div>
          </div>
          <div class="form-group">
            <label class="col-sm-2 control-label" for="input-order"><?php echo $entry_order; ?></label>
            <div class="col-sm-10">
              <input type="text" name="smsa_sort_order" value="<?php echo $smsa_sort_order; ?>" id="input-order" class="form-control" />
            </div>
          </div>
          
        </form>
      </div>
    </div>
  </div>
</div>
<?php echo $footer; ?>