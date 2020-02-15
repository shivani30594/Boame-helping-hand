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
             "url": "<?php echo BASE_URL?>admin/pledge/indexjson",
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
                    "width": 160,
                    "data": "acceptores_name"
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
                    "data":"created",
                  },
                  {
                    "width": 100,
                    "data":"pledge_date",
                    "orderable":false,
                    "render": function ( data, type, row, meta ) {
                      return '<a class="btn btn-sm btn-icon btn-primary" data-toggle="tooltip" title="View Matching Details" href="<?php echo BASE_URL?>admin/pledge/active_pledge_view/'+row.id+'"><i class="fa fa-eye"></i></a>';
                      }
                  },
               ] ,
                 
        });
      /*  table.on('order.dt search.dt', function () {
           table.column(0, { search: 'applied', order: 'applied' }).nodes().each(function (cell, i) {
               cell.innerHTML = i + 1;
           });
        }).draw();*/

        $(".dataTables_length").addClass("col-sm-6");

    });
</script>