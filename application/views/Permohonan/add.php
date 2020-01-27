<?php 
$csrf = array(
	'name' => $this->security->get_csrf_token_name(),
	'hash' => $this->security->get_csrf_hash()
);
?>
<style>.ui-state-error{padding: 0 10px;}</style>

<!-- CSS summernote -->
<link href="<?php echo base_url('assets/front'); ?>/plugins/editor.summernote/summernote.css" rel="stylesheet" type="text/css" />
<!-- JS summernote -->
<script type="text/javascript" src="<?php echo base_url('assets/front'); ?>/plugins/editor.summernote/summernote.min.js"></script>

<div class="page-title text-center">
    <h2 class="title"><?php echo @$title; ?></h2> 
    <h3 style="color: #fff;"><?php echo @$subtitle; ?></h3> 
</div>
<div class="breadcrumbs">
<?php echo $this->breadcrumbs->show(); ?>
</div>

<div class="container" style="padding-top: 10px; padding-bottom: 80px;">
    <form action="<?php echo site_url('permohonan/add'); ?>" method="POST" id="thisForm" class="form-horizontal" enctype="multipart/form-data">
	<input type="hidden" name="<?=$csrf['name'];?>" value="<?=$csrf['hash'];?>" />
    <input type="hidden" name="user_id" id="user_id" value="<?php echo $this->session->userdata('ses_ppid_user_id'); ?>">
    
    <!-- subjek -->
    <div class="form-group">
        <label class="col-sm-2 control-label" for="subjek">Subject Permohonan:</label>
        <div class="col-sm-10 formFieldSs <?php echo form_error('subjek') !='' ? 'error':''; ?>">
            <input name="subjek" id="subjek" placeholder="Subject Permohonan:" 
            class="form-control" 
            value="<?php echo set_value('subjek'); ?>"
            >
            <label class="ui-state-error"><?php echo form_error('subjek'); ?></label>
        </div>
    </div>
    <!-- info_req -->
    <div class="form-group">
        <label class="col-sm-2 control-label" for="compose-textarea">Informasi yang diperlukan:</label>
        <div class="col-sm-10 formFieldSs <?php echo form_error('info_req') !='' ? 'error':''; ?>">
            <textarea name="info_req" id="compose-textarea" style="height: 300px" placeholder="Informasi yang diperlukan:" class="summernote form-control" data-height="200" data-lang="en-US" ><?php echo set_value('info_req'); ?></textarea>
            <label class="ui-state-error"><?php echo form_error('info_req'); ?></label>
        </div>
    </div>
    <!-- info_tujuan -->
    <div class="form-group">
        <label class="col-sm-2 control-label" for="info_tujuan">Tujuan penggunaan informasi:</label>
        <div class="col-sm-10 formFieldSs <?php echo form_error('info_tujuan') !='' ? 'error':''; ?>">

            <textarea name="info_tujuan" id="info_tujuan" style="height: 300px" placeholder="Tujuan penggunaan informasi:" class="summernote form-control" data-height="200" data-lang="en-US" ><?php echo set_value('info_tujuan'); ?></textarea>
            <label class="ui-state-error"><?php echo form_error('info_tujuan'); ?></label>
        </div>
    </div>
    <!-- userfile -->
    <div class="form-group">
        <label class="col-sm-2 control-label">File Pendukung:<br>
        </label> 
        <div class="col-sm-10">
            <input type="file" name="userfile[]" class="form-control fileUpload" id="userfile" placeholder="File Pendukung" style="padding: 0">
            <div id="uploadField"></div>
            <!-- p class="help-block">Max. 32MB</p -->
            <button type="button" onclick="myFunction()" class="btn-xs btn-link"><i class="fa fa-plus"></i>Tambah lampiran</button>
        </div>
    </div>

    <div class="form-group">
        <label class="col-sm-2 control-label" ></label>
        <div class="col-sm-10"><button type="submit" class="btn btn-primary" id="btnUpload"><i class="fa fa-envelope-o"></i> Kirim</button></div>
    </div>

    </form>

</div>

<script>
function myFunction() {
    // var x = document.createElement("INPUT");
    // x.setAttribute("type", "file");
	uploadField = '<input type="file" name="userfile[]" class="form-control fileUpload" placeholder="File Pendukung" style="padding: 0">';
	$('#uploadField').append(uploadField);
    // document.body.appendChild(x);
}
</script>