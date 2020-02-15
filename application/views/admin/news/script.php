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
             "url": "<?php echo BASE_URL?>admin/news/indexjson",
             "dataType": "json",
             "type": "POST",
             "data":{  '<?php echo $this->security->get_csrf_token_name(); ?>' : '<?php echo $this->security->get_csrf_hash(); ?>' }
                    },
            "columns": [
                  {
                    "width": 100,
                    render: function (row) {
                        return count++;
                      }
                  },
                  {
                    "width": 200,
                    "data": "image",
                    "render": function ( data, type, row, meta ) {
                      return '<img src="<?php echo ADMIN_NEWS?>'+row.image+'" alt="" height=100px width=100px/>';
                    }
                  },
                  {
                    "width": 200,
                    "data": "title" 
                  },
                  {
                   "data": "description",
                   "class": "text-justify" 
                  }
               ] ,
                "columnDefs": [ {
                    "targets": 4,
                    "data": "download_link",
                    "orderable": false,
                    "width": 150,
                    "render": function ( data, type, row, meta ) {
                      return '<a class="btn btn-sm btn-icon btn-primary" href="<?php echo BASE_URL?>admin/news/edit/'+row.id+'" data-toggle="tooltip" title="Edit"><i class="fa fa-edit"></i></a>\
                              <a class="btn btn-sm btn-icon btn-danger " id="delete_btn" data-newsid='+row.id+' data-toggle="tooltip" title="Delete"><i class="fa fa-trash"></i></a>';
                    }
                } ] ,
                 
        });
        $(".dataTables_length").addClass("col-sm-6");
        //confirmation
         $(document).on('click', '#delete_btn', function() {
             var news_id = $(this).attr("data-newsid");
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
                            url : '<?php echo BASE_URL?>admin/news/delete',
                            method: 'post',
                            dataType: 'json',
                            data: {news_id: news_id},
                            success: function(response){
                              console.log(response);
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

         $("#submitBtn").click(function(event){
            event.preventDefault();
            var messageLength = CKEDITOR.instances['description'].getData().replace(/<[^>]*>/gi, '').length;
            if(messageLength > 0)
              $("#edit_news_form").submit();
            else
              $("#ckeditor_required").show();
        });

    });
</script>