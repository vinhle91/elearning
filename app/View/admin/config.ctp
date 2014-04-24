<?php echo $this->element('admin' . DS . 'page_breadcrumb'); ?>
<?php $this->log($list_user)?>
<div class="row">
	<div class="col-md-6 ">
					<div class="padding-right-5 pull-right">
			            <input type="button" class="btn btn-xs btn-warning cancel pull-right" data-icon="check" value="リカバリ" onclick="confirm_alert_restore(this)"></input>
			        </div>
					<div class="padding-right-5 pull-right">
			            <input type="button" class="btn btn-info btn-xs button-save" data-icon="check" value="バックアップ" onclick="confirm_alert_backup(this)"></input>
			        </div>
	</div>
</div>

<script type="text/javascript">
    function confirm_alert_backup(node) {
        if (confirm('Are you sure you want to back up database?')) {
            var url = "./backup";
            $(location).attr('href',url);
        } else {

        }
}

function confirm_alert_restore(node) {
    if (confirm('Are you sure you want to restore database?')) {
        var url = "./restore";
        $(location).attr('href',url);
    } else {

    }
}
</script>

