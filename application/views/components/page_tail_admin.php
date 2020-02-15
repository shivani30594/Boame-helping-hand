 <div class="modal fade" id="m_modal_1" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleEventLabel">
                        Notification Details
                    </h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">
                            ×
                        </span>
                    </button>
                </div>
                <div class="modal-body ajaxview" id="ajaxview">

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">
                        Close
                    </button>
                    <button type="button" class="btn btn-danger " id="dismiss">
                        Dismiss
                    </button>
                </div>
            </div>
        </div>
    </div>
    <script>
        
        document.addEventListener('DOMContentLoaded', function () {
            if (!("Notification" in window)) {
                return;
            }
            if (Notification.permission !== "granted") {
                Notification.requestPermission();
            } else {
                //user has given permission
            }
        });

        var notifications = new Array();
        jQuery(document).on('click', '#dismiss', function () {
            var postData = {
                'type': jQuery('#viewtype').val(),
                'id': jQuery('#view_id').val()
            };
            jQuery('#dismiss').addClass('m-loader m-loader--light m-loader--right');
            jQuery.ajax({
                url: '<?php echo BASE_URL ?>admin/notifications/check_status',
                method: 'post',
                data: postData,
                dataType: 'json',
                success: function (res) {
                    jQuery('#dismiss').removeClass('m-loader m-loader--light m-loader--right');
                    jQuery('#m_modal_1').modal("hide");
                },
                error: function (xhr) {
                    jQuery('#dismiss').removeClass('m-loader m-loader--light m-loader--right');
                    jQuery('#m_modal_1').modal("hide");
                }
            });

        });
        function checkNotification() {
            var timestamp = Math.floor(Date.now() / 1000);
            jQuery.ajax({
                url: '<?php echo BASE_URL ?>admin/notifications',
                method: 'post',
                data: {date: timestamp},
                dataType: 'json',
                success: function (res) {
                    if (res.notifications) 
                    {
                        jQuery.each(res.notifications, function (index, value) {
                            var options = {
                                icon: '<?php echo ADMIN_IMAGES?>BOAME-transparent.png',
                                body: value.notification_title + "\n" + value.admin_notification + "\n",
                                data : {type: value.notification_type, id: value.id, title:value.notification_title}
                            };      
                            var notification = new Notification("Notification", options);
                            //setTimeout(notification.close.bind(notification), 1000); 
                            notification.addEventListener('click', function (event) 
                            {
                                notification.close();
                                jQuery.ajax({
                                    url: '<?php echo BASE_URL ?>admin/notifications/ajaxview',
                                    method: 'post',
                                    data: notification.data,
                                    dataType: 'json',
                                    success: function (res) {
                                        $('#ajaxview').html(res.html);
                                        $('#exampleEventLabel').html(res.notification_title);
                                        $('#m_modal_1').modal("show");
                                    },
                                    error: function (errror)
                                    {
                                        console.log(errror);
                                    }
                                });                 
                            });   
                            notifications.push(parseInt(value.id));
                        });
                    }
                },
                error: function (xhr) {
                }
            });
        }
    setInterval(function(){ checkNotification(); }, 9000);
</script>