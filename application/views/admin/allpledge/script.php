<script>
    $(document).ready(function () 
    {
      //table.state.clear();
      var table = $('#pledge_queue').DataTable({
            //"bStateSave": true,
            "order" : [[ 4, 'desc']],
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
             "url": "<?php echo BASE_URL?>admin/allpledge/indexjson",
             "dataType": "json",
             "type": "POST",
             "data":{  '<?php echo $this->security->get_csrf_token_name(); ?>' : '<?php echo $this->security->get_csrf_hash(); ?>' }
              },
              "columns": [
                  {
                    "width": 60,
                    "data" : "id",
                    "targets" : 0
                  },
                  {
                    "width": 140,
                    "data": "name"
                  },
                   {
                    "width": 140,
                    "data": "pledge_type"
                  },
                  {
                    "width": 340,
                    "data": "pledge_title"
                  },
                  {
                    "width": 160,
                    "data":"pledge_date",
                  },
                   {
                    "width": 100,
                  },
               ] ,
                 "columnDefs": [ {
                    "targets": 5,
                    "orderable": false,
                    "render": function ( data, type, row, meta ) {
                      if (row.is_confirmed == 'Y')
                      {
                        var style ="disabled";
                      }
                      else
                      {
                        var style = '';
                      }
                      return '<a href="<?php echo BASE_URL?>admin/allpledge/confirm_payment/'+row.id+'" '+style+' data-toggle="tooltip" title="View Point Transactions" class="btn btn-sm btn-icon btn-primary"><i class="fa fa-check"></i></a>';
                    }
                } ]  ,
        });
      /*  table.on('order.dt search.dt', function () {
           table.column(0, { search: 'applied', order: 'applied' }).nodes().each(function (cell, i) {
               cell.innerHTML = i + 1;
           });
        }).draw();*/

        $(".dataTables_length").addClass("col-sm-6");

    });
</script>