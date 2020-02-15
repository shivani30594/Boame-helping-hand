<input type="hidden" name="viewtype" id="viewtype" value="<?php echo $type; ?>" />
<input type="hidden" name="view_id" id="view_id" value="<?php echo $notification->id ?>"/>
<div class="form-group">
    <label for="name" class="form-control-label">
        Title:
    </label>
    <input class="form-control" id="name" type="text" name="name" disabled value="<?php echo $notification->notification_title ?>" />
</div>
<div class="form-group">
    <label for="name" class="form-control-label">
        Message:
    </label>
    <input class="form-control" id="name" type="text" name="name" disabled value="<?php echo $notification->notification_message ?>" />
</div>
