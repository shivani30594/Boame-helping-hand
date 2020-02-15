<script>
    $(document).ready(function () 
    {
        $('#edit_plan_form').validate({
          rules: {
              plan_name : { 
                  required :true,
              },
              plan_price : { 
                  required :true,
              },
              plan_duration : { 
                  required :true,
              },
              plan_description : { 
                  required :true,
              },
              plan_price_currency : { 
                  required :true,
              }
          },
          messages: {
              plan_name : {
                 required : 'Please enter plan name',
              },
              plan_price : {
                 required : 'Please enter plan price',
              },
              plan_duration : {
                 required : 'Please enter plan duration',
              },
              plan_description : {
                  required : 'please enter plan description'
              },
              plan_price_currency : {
                  required : 'please select one of the currency'
              }
          }
      });

        table = $('#subscription').DataTable({
            "bStateSave": true,
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
             "url": "<?php echo BASE_URL?>admin/subscription/indexjson",
             "dataType": "json",
             "type": "POST",
             "data":{  '<?php echo $this->security->get_csrf_token_name(); ?>' : '<?php echo $this->security->get_csrf_hash(); ?>' }
                    },
            "columns": [
                  {
                    "width": 100,
                    "data": "id" 
                  },
                  {
                    "width": 200,
                    "data": "plan_name" 
                  },
                  {
                    "width": 300,
                    "data": "plan_description" 
                  },
                  {
                    "width": 170,
                    "data": "plan_duration" 
                  },
                  {
                    "width": 160,
                    "data": "plan_price" 
                  },
                  {
                    "width": 160,
                    "data": "plan_price_currency" 
                  },
                  {
                    "width": 160,
                    "data": "created" 
                  },
                  {
                    "width": 160,
                    "data": "created" 
                  },
               ] ,
                "columnDefs": [ {
                    "targets": 7,
                    "data": "download_links",
                    "orderable": false,
                    "width": 150,
                    "render": function ( data, type, row, meta ) {
                      return '<a class="btn btn-sm btn-icon btn-primary" href="<?php echo BASE_URL?>admin/subscription/add/'+row.id+'" data-toggle="tooltip" title="Edit"><i class="fa fa-edit"></i></a>\
                              <a class="btn btn-sm btn-icon btn-danger " id="delete_btn" data-planid='+row.id+' data-toggle="tooltip" title="Delete"><i class="fa fa-trash"></i></a>';
                    }
                } ] ,
        });

         $(document).on('click', '#delete_btn', function() {
             var plan_id = $(this).attr("data-planid");
                swal({
                    title: 'Are you sure?',
                    text: "You would like to delete this plan.",
                    type: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Yes, delete it!'
                }).then(function (result) {
                    if( result == true){
                        jQuery.ajax({
                            url : '<?php echo BASE_URL?>admin/subscription/delete',
                            method: 'post',
                            dataType: 'json',
                            data: {plan_id: plan_id},
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
    });
</script>