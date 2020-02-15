<script>
$(document).ready(function () 
{
    $(document).on('change',"#auto_sub_checkbox",function()
    {   
        var status = document.getElementById("auto_sub_checkbox").checked;

        if (status == true)
        {
            swal({
                    title: 'Are you sure?',
                    text: "Are you sure want to request for Auto-Subscription.It will deduct the default subscription plan price from USD-eWallet if it contains or else it will check into USD-bPoints and renew default subscription plan for you.",
                    type: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Yes, Proceed!'
                }).then(function (result) 
                {
                    if( result == true){
                        jQuery.ajax({
                            url : '<?php echo BASE_URL ?>'+'change_auto_subscription',
                            method: 'post',
                            dataType: 'json',
                            data: {auto_subscription: status},
                            success: function(response){
                                if (response.success == true)
                                {
                                    swal("success", response.message, "success");
                                }
                                else
                                {
                                    swal("error", response.message, "error");
                                }
                            }
                        });
                    }
            })
        }
        else
        {
            swal({
                    title: 'Are you sure?',
                    text: "Are you sure remove from auto-subscription?",
                    type: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Yes, Want to Remove!'
                }).then(function (result) 
                {
                    if( result == true){
                        jQuery.ajax({
                            url : '<?php echo BASE_URL ?>'+'change_auto_subscription',
                            method: 'post',
                            dataType: 'json',
                            data: {auto_subscription: status},
                            success: function(response){
                                if (response.success == true)
                                {
                                    swal("success", response.message, "success");
                                }
                                else
                                {
                                    swal("error", response.message, "error");
                                }
                            }
                        });
                    }
                })
        }
    });

    $('.dropdown-menu a').click(function(){
        // var value = $("input[type='radio']").val();
        // alert($("input[name='b']:checked").val());
        // if (value == 'ghs_bpoints')
        // {
        //     var type = 'GHS-bPoints';
        // }
        // else if (value == 'usd_bpoints')
        // {
        //     var type = 'USD-bPoints';
        // }
        // else if (value == 'ghs_ewallet')
        // {
        //     var type = 'GHS-eWallet';
        // }
        // else{
        //     var type = 'USD-eWallet';
        // }
        swal({
                title: 'Are you sure?',
                text: "Are you sure want to activate BOAME FOREX ?",
                type: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, Want to Pay!'
            }).then(function (result) 
            {
                var value = $("input[name='b']:checked").val();
                if(result == true) {
                    jQuery.ajax({
                        url : '<?php echo BASE_URL.'select_plan'?>',
                        method: 'post',
                        dataType: 'json',
                        data: {plan_id: $("#plan_id").val(), payment_mode:value},
                        success: function(response){
                            if (response.success == true)
                            {
                                swal("success", response.message, "success");
                                $('#activate_eproduct_choose').modal('toggle');
                                if (response.isDownload == true)
                                {
                                    location.href = "<?php echo BASE_URL?>member/subscription/download";
                                }
                                else{
                                    setTimeout(function(){
                                        location.href = "<?php echo BASE_URL?>subscription";
                                    }, 3000)
                                }
                            }
                            else
                            {
                                swal("error", response.message, "error");
                                $('#activate_eproduct_choose').modal('toggle');
                                setTimeout(function(){
                                    location.href = "<?php echo BASE_URL?>subscription";
                                }, 3000)
                            }
                        }
                    });
                }
            })
    })

    $(document).on("click", ".open-AddBookDialog", function () {
        var subscriptionid = $(this).data('subscriptionid');
        $(".modal-body #plan_id").val( subscriptionid );
        $(".modal-body #amountf").val( $(this).data('price') );
        $(".modal-body #user_id").val( $(this).data('userid') );
        jQuery.ajax({
            url : '<?php echo BASE_URL.'member/subscription/get_upgrade_plan_details'?>',
            method: 'post',
            dataType: 'json',
            data: {plan_id: $("#plan_id").val()},
            success: function(response){
                if (response.success == true)
                {
                    $("#text_content").html(response.message);
                }
            }
        });

    });

     $(document).on("click", "#bpoints_Btn", function () {
            swal({
                title: 'Are you sure?',
                text: "Are you sure want to activate BOAME FOREX using bpoints?",
                type: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, Want to Pay!'
            }).then(function (result) 
            {
                if(result == true) {
                    jQuery.ajax({
                        url : '<?php echo BASE_URL.'select_plan'?>',
                        method: 'post',
                        dataType: 'json',
                        data: {plan_id: $("#plan_id").val(), payment_mode:$("#payment_mode").val()},
                        success: function(response){
                            if (response.success == true)
                            {
                                swal("success", response.message, "success");
                                $('#activate_eproduct_choose').modal('toggle');
                                if (response.isDownload == true)
                                {
                                    location.href = "<?php echo BASE_URL?>member/subscription/download";
                                }
                                else{
                                    setTimeout(function(){
                                        location.href = "<?php echo BASE_URL?>subscription";
                                    }, 2000)
                                }
                            }
                            else
                            {
                                swal("error", response.message, "error");
                                $('#activate_eproduct_choose').modal('toggle');
                                setTimeout(function(){
                                    location.href = "<?php echo BASE_URL?>subscription";
                                }, 2000)
                            }
                        }
                    });
                }
            })
    });

   $(document).on("click", "#download_link", function () {
        $('#activate_eproduct_choose').modal('toggle');
            setTimeout(function(){
                location.href = "<?php echo BASE_URL?>subscription";
            }, 2000)
   });
     $(document).on("click", "#upgrade_btn", function () {
            swal({
                title: 'Are you sure?',
                text: "Are you sure want to Upgrade the plan?",
                type: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, Want to Upgrade!'
            }).then(function (result) 
            {
                if(result == true) {
                    jQuery.ajax({
                        url : '<?php echo BASE_URL.'select_plan'?>',
                        method: 'post',
                        dataType: 'json',
                        data: {plan_id: $("#plan_id").val(), payment_mode:$("#payment_mode").val()},
                        success: function(response){
                            if (response.success == true)
                            {
                                swal("success", response.message, "success");
                            }
                            else
                            {
                                swal("error", response.message, "error");
                            }
                        }
                    });
                }
            })
    });

    table = $('#sub_history').DataTable({
        "bStateSave": true,
        "fnStateSave": function (oSettings, oData) {
        localStorage.setItem('offersDataTables', JSON.stringify(oData));
        },
        "fnStateLoad": function (oSettings) {
        return JSON.parse(localStorage.getItem('offersDataTables'));
        },
        "order": [[7,'desc']],
        "lengthMenu": [[10, 25, 50,100], [10, 25, 50,100]],
        "processing": true,
        "serverSide": true,
        "pagingType": "full_numbers",
        "ajax":{
            "url": "<?php echo BASE_URL?>member/subscription/indexjson",
            "dataType": "json",
            "type": "POST",
            "data":{  '<?php echo $this->security->get_csrf_token_name(); ?>' : '<?php echo $this->security->get_csrf_hash(); ?>' }
                },
        "columns": [
            {
                "width": 120,
                "data": "plan_name" 
            },
            {
                "width": 200,
                "render": function ( data, type, row, meta ) {
                      return row.plan_description.substring(0,100);
                }
            },
            {
                "width": 140,
                "data": "plan_price" 
            },
            {
                "width": 180,
                "render": function ( data, type, row, meta ) {
                    data = row.payment_mode;
                    var str = data.replace(/[_-]/g, " ");
                    return "<span class='label label-warning'>"+str.replace(/\w\S*/g, function(txt){ return txt.charAt(0).toUpperCase() + txt.substr(1).toLowerCase();})+"</span>"; 
                }
            },
            {
                "width": 180,
                "render": function ( data, type, row, meta ) {
                    if (row.address != '')
                    {
                        return row.address;
                    }
                    else
                    {
                        return '------------------------------';
                    }
                }
            },
            {
                "width": 120,
                "render": function ( data, type, row, meta ) {
                     if (row.status == 'pending')
                     {
                         return '<span class="label label-warning">Pending</span>';
                     }
                     else if (row.status == 'in-progress')
                     {
                        return '<span class="label label-info">In-progress</span>';
                     }
                     else if (row.status == 'complete')
                     {
                        return '<span class="label label-success">Complete</span>';
                     }
                     else 
                     {
                        return '<span class="label label-danger">Cancel</span>';
                     }
                }
            },
            {
                "width": 200,
                "data": "start_date" 
            },
            {
                "width": 200,
                "data": "end_date" 
            },
        ] 
        });
        $(".dataTables_length").addClass("col-sm-6");

});
</script>