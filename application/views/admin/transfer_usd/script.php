<script>
    $(document).ready(function () 
    {
       table1 = $('#credited_points').DataTable({
            "destroy": true,
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
             "url": "<?php echo BASE_URL?>admin/transfer/indexjson_usd",
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
                    "data" : "message"
                  },
                  {
                    "width": 160,
                    "render": function ( data, type, row, meta ) {
                      data = row.type;
                      if (data == 'credited_points_usd')
                      {
                        return "<span class='label label-info'> Credited</span>";
                      }
                      else
                      {
                        return "<span class='label label-warning'> Debited</span>";
                      }
                    }
                  },
                   {
                    "width": 190,
                    "data": "created"
                  }
               ]
        });

    });
</script>