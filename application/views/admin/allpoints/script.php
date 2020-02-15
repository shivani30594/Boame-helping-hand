<script>
    $(document).ready(function () 
    {
      var table = $('#all_points').DataTable({
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
             "url": "<?php echo BASE_URL?>admin/all/indexjson",
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
                    "render": function ( data, type, row, meta ) {
                      data = row.type;
                      var str = data.replace(/[_-]/g, " ");
                      return str.replace(/\w\S*/g, function(txt){return txt.charAt(0).toUpperCase() + txt.substr(1).toLowerCase();});  
                    }
                  },
                  {
                    "data": "message"
                  },
                  {
                    "width": 190,
                    "data": "created"
                  },
               ] ,
                 
        });
        table.on('order.dt search.dt', function () {
           table.column(0, { search: 'applied', order: 'applied' }).nodes().each(function (cell, i) {
               cell.innerHTML = i + 1;
           });
        }).draw();
        $(".dataTables_length").addClass("col-sm-6");

    });
</script>