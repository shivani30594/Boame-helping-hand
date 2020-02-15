<script>
    $(document).ready(function () 
    {
      var table = $('#contact_inquiries').DataTable({
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
             "url": "<?php echo BASE_URL?>admin/contact/indexjson",
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
                    "data": "name"
                  },
                   {
                    "width": 140,
                    "data": "email"
                  },
                  {
                    "width": 340,
                    "data": "subject"
                  },
                  {
                    "data": "message"
                  },
                  {
                    "width": 160,
                    "data":"created",
                    "render": function ( data, type, row, meta ) {
                    //  return '<?php echo date("M-d,Y", strtotime("'+row.created+'"))?>';
                      return row.created;
                    }
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