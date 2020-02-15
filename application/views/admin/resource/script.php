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
             "url": "<?php echo BASE_URL?>admin/resource/indexjson",
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
                    "data": "type",
                    "render": function ( data, type, row, meta ) {
                      return row.type.toUpperCase();
                    }
                  },
                  {
                    "width": 200,
                    "data": "document_title" 
                  },
                  {
                   "data": "document_path",
                   "class": "text-justify" ,
                    "render": function ( data, type, row, meta ) {
                        if (row.type == 'pdf')
                        {
                            return '<a href="<?php echo ADMIN_RESOURCE?>'+row.type+'/'+row.document_path+'" target="_blank"><i class="fa fa-file-pdf-o fa-5x"></i><br> '+row.document_path+'</a>';
                        }
                        else if (row.type == 'banner')
                        {
                            return '<img src="<?php echo ADMIN_RESOURCE?>'+row.type+'/'+row.document_path+'" height="100px" width="100px" /><br> '+row.document_path;
                        }
                        else if (row.type == 'ppt')
                        {
                            return '<a href="<?php echo ADMIN_RESOURCE?>'+row.type+'/'+row.document_path+'" target="_blank"><i class="fa fa-file-powerpoint-o fa-5x"></i><br> '+row.document_path+'</a>';
                        }
                        else if (row.type == 'video')
                        {
                            return '<video width="240" height="240" controls><source src="<?php echo ADMIN_RESOURCE?>'+row.type+'/'+row.document_path+'" type="video/mp4">Your browser does not support the video tag.</video>';
                        }
                        else if (row.type == 'html')
                        {
                            return '<iframe src="<?php echo ADMIN_RESOURCE?>'+row.type+'/'+row.document_path+'" height="200" width="300"></iframe>';
                        }
                    }
                  },
                  {
                    "width": 200,
                    "data": "created" 
                  },
               ] ,
                "columnDefs": [ {
                    "targets": 5,
                    "data": "download_link",
                    "orderable": false,
                    "width": 150,
                    "render": function ( data, type, row, meta ) {
                        return '<a class="btn btn-sm btn-icon btn-primary" href="<?php echo BASE_URL?>admin/resource/edit/'+row.id+'" data-toggle="tooltip" title="Edit"><i class="fa fa-edit"></i></a>\
                                <a class="btn btn-sm btn-icon btn-danger " id="delete_btn" data-resourceid='+row.id+' data-toggle="tooltip" title="Delete"><i class="fa fa-trash"></i></a>';
                        //  return '<a class="btn btn-sm btn-icon btn-primary" href="#" disabled data-toggle="tooltip" title="Edit"><i class="fa fa-edit"></i></a>\
                        //         <a class="btn btn-sm btn-icon btn-danger " disabled id="delete_btn" data-resourceid='+row.id+' data-toggle="tooltip" title="Delete"><i class="fa fa-trash"></i></a>';
                    }
                } ] ,
                 
        });
        $(".dataTables_length").addClass("col-sm-6");
        //confirmation
         $(document).on('click', '#delete_btn', function() {
             var news_id = $(this).attr("data-resourceid");
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
                            url : '<?php echo BASE_URL?>admin/resource/delete',
                            method: 'post',
                            dataType: 'json',
                            data: {resource_id: news_id},
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

        //  $("#submitBtn").click(function(event){
        //     event.preventDefault();
        //     var messageLength = CKEDITOR.instances['description'].getData().replace(/<[^>]*>/gi, '').length;
        //     if(messageLength > 0)
        //       $("#edit_news_form").submit();
        //     else
        //       $("#ckeditor_required").show();
        // });
        $(document).on('change', '#document', function() {

              var filePath = document.getElementById('document').value;
                var type = document.getElementById('resource_type').value;
                if (type == 'banner')
                {
                    var allowedExtensions = /(\.jpg|\.jpeg|\.png|\.gif)$/i;
                }
                else if (type == 'video')
                {
                    var allowedExtensions = /(\.mp4|\.avi|\.wmv|\.3gp)$/i;
                }
                else if (type == 'ppt')
                {
                    var allowedExtensions = /(\.ppt|\.pptx)$/i;
                }
                else if (type == 'pdf')
                {
                    var allowedExtensions = /(\.pdf)$/i;
                }
                else if (type == 'html')
                {
                    var allowedExtensions = /(\.html)$/i;
                }
                if(!allowedExtensions.exec(filePath)){
                    $("#file_error_span").show();
                    document.getElementById('document').value = '';
                    return false;
                }
                else{
                    $("#file_error_span").hide();
                }
        })
      
              
    });
</script>