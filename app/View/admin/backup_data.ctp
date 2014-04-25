<?php echo $this->element('admin' . DS . 'page_breadcrumb'); ?>
<div class="row">
	<div class="col-md-6 ">
					<div class="padding-right-5 pull-left">
			            <input type="button" class="btn btn-xs btn-warning cancel pull-left" data-icon="check" value="リカバリ" onclick="confirm_alert_restore(this)"></input>
			        </div>
					<div class="padding-right-5 pull-left">
			            <input type="button" class="btn btn-info btn-xs button-save" data-icon="check" value="バックアップ" onclick="confirm_alert_backup(this)"></input>
			        </div>
        <div class="padding-5 align-right">
            <input type="button" class="btn btn-info btn-xs button-save" data-icon="check" value="自動バックアップ"
                   onclick="confirm_alert_autobackup(this)"></input>
        </div>
	</div>
</div>

<script type="text/javascript">
    function confirm_alert_backup(node) {
        if (confirm('データベースをバックアップしますか？')) {
            var url = "./backup";
            $(location).attr('href',url);
        } else {
// Do nothing!
        }
}

    function confirm_alert_autobackup(node) {
        if (confirm('自動提供にバックアップしますか？')) {
            var url = "./autobackup";
            $(location).attr('href',url);
        } else {
// Do nothing!
        }
    }

function confirm_alert_restore(node) {
    if (confirm('データベースを復元しますか？')) {
        var url = "./restore";
        $(location).attr('href',url);
    } else {
// Do nothing!
    }
}
</script>
