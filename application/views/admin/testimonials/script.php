<script>
    $(document).ready(function () 
    {
      $('#edit_news_form').validate({
          rules: {
              title : { 
                  required :true,
              },
              description : { 
                  required :true,
              }
          },
          messages: {
              title : {
                 required : 'Please enter news title',
              },
              description : {
                 required : 'Please enter description',
              }
          }
      });
      var count = 1;
       table = $('#news').DataTable({
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
             "url": "<?php echo BASE_URL?>admin/testimonial/indexjson",
             "dataType": "json",
             "type": "POST",
             "data":{  '<?php echo $this->security->get_csrf_token_name(); ?>' : '<?php echo $this->security->get_csrf_hash(); ?>' }
                    },
            "columns": [
                  {
                    "width": 130,
                    "data": "image",
                    "orderable": false,
                    "render": function ( data, type, row, meta ) {
                      return '<img src="<?php echo ADMIN_TESTIMONIALS?>'+row.image+'" alt="" height=100px width=100px/>';
                    }
                  },
                  {
                    "width": 180,
                    "data": "full_name" 
                  },
                  {
                   "data": "message",
                   "class": "text-justify" 
                  },
                  {
                   "data": "status",
                   "width" :  150,
                   "render": function ( data, type, row, meta ) {
                       if (row.status == 'in_progress')
                       {
                            return "<span class='label label-primary'>In Progress</span>";
                       }
                       else if (row.status == 'approved')
                       {
                            return "<span class='label label-success'>Approved</span>";
                       }
                       else
                       {
                            return "<span class='label label-danger'>Cancelled</span>";
                       }
                   }
                  },
                  {
                   "width" :  150
                  }
               ] ,
                "columnDefs": [ {
                    "targets": 4,
                    "data": "download_link",
                    "orderable": false,
                    "width": 150,
                    "render": function ( data, type, row, meta ) {
                      return '<a class="btn btn-sm btn-icon btn-primary" href="<?php echo BASE_URL?>admin/testimonial/edit/'+row.user_id+'" data-toggle="tooltip" title="Edit"><i class="fa fa-edit"></i></a>\
                              <a class="btn btn-sm btn-icon btn-danger" id="delete_btn" data-newsid='+row.user_id+' data-toggle="tooltip" title="Delete"><i class="fa fa-trash"></i></a>';
                    }
                } ] ,
                 
        });
        $(".dataTables_length").addClass("col-sm-6");
        //confirmation
         $(document).on('click', '#delete_btn', function() {
             var test_user_id = $(this).attr("data-newsid");
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
                            url : '<?php echo BASE_URL?>admin/testimonial/delete',
                            method: 'post',
                            dataType: 'json',
                            data: {test_user_id: test_user_id},
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