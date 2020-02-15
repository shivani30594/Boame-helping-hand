<script>
    $(document).ready(function () 
    {
      jQuery.validator.addMethod('lettersonly', function (value, element) 
      {
        return this.optional(element) || /^[a-zA-Z ]+$/i.test(value);
      }, 'Letters only please'); 

      jQuery.validator.addMethod('customphone', function (value, element) {
        return this.optional(element) || /^\d{10}$/.test(value);
      }, "Please enter a valid phone number");

      $('#edit_profile_form').validate({
          rules: {
              first_name : { 
                  required :true,
                  lettersonly : true
              },
              last_name : { 
                  required :true,
                  lettersonly : true
              },
              email : {
                email:true,
                required : true
              },
              mtn_account_number : { 
                  required :true,
                  number :true
              },
              mtn_mobile_name : { 
                  required :true,
                  lettersonly : true
              }
          },
          messages: {
              first_name : {
                 required : 'Please enter firstname',
                 lettersonly : 'Firstname contains only characters',
              },
              last_name : {
                 required : 'Please enter lastname',
                 lettersonly : 'Last name contains only characters',
              },
              email : {
                email:'Please enter valid emailID',
                required : 'Please enter emailID'
              },
              mtn_account_number : {
                 required : 'Please enter MTN account number'
              },
              mtn_mobile_name : {
                 required : 'Please enter MTN account name',
                 lettersonly: 'MTN account name contains only characters'
              }
          }
      });
      
         table = $('#posts').DataTable({
            "lengthMenu": [[10, 25, 50,100], [10, 25, 50,100]],
            "processing": true,
            "serverSide": true,
            "pagingType": "full_numbers",
            "bStateSave": true,
            "fnStateSave": function (oSettings, oData) {
                localStorage.setItem('offersDataTables', JSON.stringify(oData));
            },
            "fnStateLoad": function (oSettings) {
                return JSON.parse(localStorage.getItem('offersDataTables'));
            },
            "ajax":{
             "url": "<?php echo BASE_URL?>admin/user/indexjson",
             "dataType": "json",
             "type": "POST",
             "data":{  '<?php echo $this->security->get_csrf_token_name(); ?>' : '<?php echo $this->security->get_csrf_hash(); ?>' }
                           },
            "columnDefs": [ {
              "searchable": false,
              "orderable": false,
              "targets": 0
            } ],
            "order": [[ 1, 'asc' ]],
            "columns": [
                  /*{
                    "width": 10,
                    "data" : "id"
                  },*/
                  {
                    "width": 110,
                    "data": "first_name" ,
                    "order":[[1, 'asc']]
                  },
                  {
                    "width": 110,
                    "data": "last_name" 
                  },
                  {
                    "width": 100,
                   "data": "gender" 
                  },
                  {
                      "width": 100,
                      "data": "email" 
                  },
                  {
                      "width": 100,
                      "data": "mtn_mobile_number" 
                  },
                  {
                      "width": 150,
                      "data": "mtn_mobile_name" 
                  },
                  {
                      "width": 100,
                      "data": "created" ,
                      "name": "created"
                  },
                  {
                    "width": 160,
                     "data": "action" 
                  }
               ] ,
               "columnDefs": [ {
                    "targets": 7,
                    "data": "download_link",
                    "orderable": false,
                    "width": 130,
                    "render": function ( data, type, row, meta ) {
                      if(row.is_deleted == 'N')
                      {
                         status = 'unlock';
                         class_name = 'success'
                      }
                      else
                      {
                          status = 'lock';
                          class_name = 'danger'
                      }
                      return '<a href="<?php echo BASE_URL?>admin/user/point_history/'+row.id+'" data-toggle="tooltip" title="View Point Transactions" class="btn btn-sm btn-icon btn-warning"><i class="fa fa-info"></i></a>\
                              <a href="<?php echo BASE_URL?>admin/user/view_tree/'+row.id+'" data-toggle="tooltip" title="View Tree" class="btn btn-sm btn-icon btn-info"><i class="i i-flow-tree"></i></a>\
                              <a class="btn btn-sm btn-icon btn-primary" href="<?php echo BASE_URL?>admin/user/edit/'+row.id+'" data-toggle="tooltip" title="Edit"><i class="fa fa-edit"></i></a>\
                              <a href="#" id="add_point_btn" data-id='+row.id+' title="Add Points" data-toggle="modal" data-target="#myModal" class="btn btn-sm btn-icon btn-dark"><i class="fa fa-plus"></i></a>\
                              <a class="btn btn-sm btn-icon btn-'+class_name+'" href="<?php echo BASE_URL?>admin/user/action/'+(row.id)+'" data-toggle="tooltip" title="Active/Inactive"><i class="fa fa-'+ status+'"></i></a>';
                    }
                } ]  ,
              "aaSorting": [[ 6, "desc" ]]

        });
        $(".dataTables_length").addClass("col-sm-6");
        // table.on('order.dt search.dt', function () {
        //      table.column(0, { search: 'applied', order: 'applied' }).nodes().each(function (cell, i) {
        //          cell.innerHTML = i + 1;
        //      });
        //   }).draw();
    });

    $(document).on("click", "#add_point_btn", function () {
         var myBookId = $(this).data('id');
         $("#userid").val( myBookId );
    });
</script>