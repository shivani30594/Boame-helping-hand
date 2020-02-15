<script>
    $(document).ready(function () 
    {
      $('#edit_product_form').validate({
          rules: {
              product_name : { 
                  required :true
              },
              product_type : { 
                  required :true
              },
              download_link : { 
                  required :true,
                  url: true
              }
          },
          messages: {
              product_name : {
                 required : 'Please enter Product name',
              },
              product_type : {
                 required : 'Please enter Product type',
              },
              download_link : {
                 required : 'Please enter download link',
              }
          }
      });
     
       table = $('#eProducts').DataTable({
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
             "url": "<?php echo BASE_URL?>admin/Eproducts/indexjson",
             "dataType": "json",
             "type": "POST",
             "data":{  '<?php echo $this->security->get_csrf_token_name(); ?>' : '<?php echo $this->security->get_csrf_hash(); ?>' }
                    },
            "columns": [
                  {
                    "width": 200,
                    "data": "product_name" 
                  },
                  {
                    "width": 200,
                    "data": "product_type" 
                  },
                  {
                   "data": "download_link",
                    "render": function ( data, type, row, meta ) {
                      return '<a target="_blank" href="'+data+'" style="color: #428bca;">'+data+'</a>';
                    }
                   
                  }
               ] ,
                "columnDefs": [ {
                    "targets": 3,
                    "data": "download_links",
                    "orderable": false,
                    "width": 150,
                    "render": function ( data, type, row, meta ) {
                      return '<a class="btn btn-sm btn-icon btn-primary" href="<?php echo BASE_URL?>admin/Eproducts/edit/'+row.id+'" data-toggle="tooltip" title="Edit"><i class="fa fa-edit"></i></a>\
                              <a class="btn btn-sm btn-icon btn-danger " id="delete_btn" data-productid='+row.id+' data-toggle="tooltip" title="Delete"><i class="fa fa-trash"></i></a>';
                    }
                } ] ,
                 
        });
        $(".dataTables_length").addClass("col-sm-6");
        //confirmation
         $(document).on('click', '#delete_btn', function() {
             var product_id = $(this).attr("data-productid");
                swal({
                    title: 'Are you sure?',
                    text: "You would like to delete this record.",
                    type: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Yes, delete it!'
                }).then(function (result) {
                    if( result == true){
                        jQuery.ajax({
                            url : '<?php echo BASE_URL?>admin/Eproducts/delete',
                            method: 'post',
                            dataType: 'json',
                            data: {product_id: product_id},
                            success: function(response){
//                              console.log(response);
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