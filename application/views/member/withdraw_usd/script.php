<script>
    $(document).ready(function () 
    {
        var timezone_offset_minutes = new Date().getTimezoneOffset();
        timezone_offset_minutes = timezone_offset_minutes == 0 ? 0 : -timezone_offset_minutes;
        $("#timezone").val(timezone_offset_minutes);
        
        table = $('#withdrawal_request').DataTable({
            "ordering": true,
            "order": [[3,'desc']],
             //"serverSorting": true,
            //"bStateSave": true,
            "fnStateSave": function (oSettings, oData) {
                localStorage.setItem('offersDataTables', JSON.stringify(oData));
            },
            "fnStateLoad": function (oSettings) {
                return JSON.parse(localStorage.getItem('offersDataTables'));
            },
            "lengthMenu": [[10, 25, 50,100], [10, 25, 50,100]],
            "processing": true,
            "serverSide": true,
            "pagingType": "full_numbers",
            "ajax":{
             "url": "<?php echo BASE_URL?>member/withdraw/usd_indexjson",
             "dataType": "json",
             "type": "POST",
             "data":{  '<?php echo $this->security->get_csrf_token_name(); ?>' : '<?php echo $this->security->get_csrf_hash(); ?>' }
                    },
            "columns": [
                  {
                    "width": 60,
                    "data": "id"
                  },
                  {
                    "width": 180,
                    "data": "withdraw_amount"
                  },
                   {
                    "width": 180,
                    "render": function ( data, type, row, meta ) {
                      var deducted_amount = (row.withdraw_amount * 3) / 100;
                      return (row.withdraw_amount - deducted_amount);
                    }
                  },
                  {
                    "width": 200,
                    "data": "type"
                  },
                  {
                    "width": 200,
                    "data": "address"
                  },
                  {
                    "width": 210,
                    "render": function ( data, type, row, meta ) {
                      if (row.is_withdraw == 'pending')
                      {
                        return "<span class='label label-info'>Pending</span>";
                      }
                      else if (row.is_withdraw == 'cancel')
                      {
                        return "<span class='label label-danger'>Cancel</span>";
                      }
                      else
                      {
                        return "<span class='label label-success'>Complete</span>";
                      }
                    }
                  },
                  {
                    "width": 200,
                    "sortable": 'desc',
                    "data": "withdraw_date"
                  },
                  {
                    "width": 180,
                  },
               ] ,
                "columnDefs": [ {
                    "targets": 7,
                    "data": "download_link",
                    "orderable": false,
                    "render": function ( data, type, row, meta ) {
                      if (row.is_withdraw == 'cancel' || row.is_withdraw == 'complete')
                      {
                        style = 'disabled';
                      }
                      else 
                      {
                        style = '';
                      }
                      return '<a class="btn btn-sm btn-icon btn-danger" '+style+' id="delete_btn" data-withdrawid='+row.id+' data-toggle="tooltip" title="Cancel Request"><i class="fas fa-close"></i></a>';
                    }
                } ] ,
                 
        });
        $(".dataTables_length").addClass("col-sm-6");
        $(document).on('blur', '#requested_amount', function() {
           var selValue = $('input[name=type]:checked').val();
            if (selValue == 'USD')
            {
                var value = 5;
                var message = 'Minimal withdrawal amount is USD5.';
            }
            else{
                var value = 20;
                var message = 'Minimal withdrawal amount is GHS20.';
            }
            if ($(this).val() < value)
            {
              $("#minimal_error").show();
              $("#minimal_error_span").text(message);
              $("#getting_div").hide();
              $(this).val('');
            }
            else
            {
              $("#minimal_error").hide();
              var charges = "<?php echo $transaction_charges;?>";
              amount = ($(this).val() *  charges) / 100;
              if (selValue == 'USD')
              {
                var msg = 'USD' + ($(this).val() - amount) ;
              }
              else{
                var msg = 'GHS' + ($(this).val() - amount) ;
              }
              $("#getting_amount").text(msg);
              $("#getting_div").show();
            }
        });
        //confirmation
         $(document).on('click', '#delete_btn', function() {
             var withdraw_id = $(this).attr("data-withdrawid");
                swal({
                    title: 'Are you sure?',
                    text: "You would like to cancel this request.",
                    type: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Yes, cancel it!'
                }).then(function (result) {
                    if( result == true){
                        jQuery.ajax({
                            url : '<?php echo BASE_URL?>member/withdraw/cancel',
                            method: 'post',
                            dataType: 'json',
                            data: {withdraw_id : withdraw_id},
                            success: function(response){
                              if (response.success == true)
                              {
                                table.ajax.reload();
                                swal("success", response.message, "success");
                              }
                              else
                              {
                                table.ajax.reload();
                                swal("error", response.message, "error");
                              }
                            }
                        });
                    }
                })
            });
            
            // $(document).on('click', '#withdraw_request_a', function() {
            //     var total_ewallet = "<?php echo $total_ewallet;?>";
            //     if (total_ewallet < 20)
            //     {
            //       swal("error", "You must have minimum 20 eWallet to make withdraw request.", "error");
            //     }else
            //     {
            //         $("#myModal").modal('show');
            //     }
                
            // });



            $(document).on('change', 'input[type="radio"]', function() {
              var selValue = $('input[name=type]:checked').val();
              if (selValue == 'USD')
              {
                  $("#address_div").show();
                  $('#address').prop('required',true);
              }
              else{
                  $('#address_div').hide();
                  $('#address').removeAttr('required');
              }
          })
    });
</script>