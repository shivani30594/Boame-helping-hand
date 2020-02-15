<script>
    $(document).ready(function () 
    {
       table = $('#report').DataTable({
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
             "url": "<?php echo BASE_URL?>admin/report/indexjson",
             "dataType": "json",
             "type": "POST",
             "data":{  '<?php echo $this->security->get_csrf_token_name(); ?>' : '<?php echo $this->security->get_csrf_hash(); ?>' }
                    },
            "columns": [
                  {
                    "width": 70,
                    "data":"id"
                  },
                  {
                    "width": 150,
                    "data": "reported_by",
                  },
                  {
                    "width": 150,
                    "data": "reported_to" 
                  },
                  {
                   "data": "report_comment",
                  },
                  {
                    "width": 150,
                    "render": function (data, event, row, method)
                    {
                      if (row.transaction_id == '0')
                      {
                        return '------';
                      }
                      else
                      {
                        return row.transaction_id ;
                      }
                    }
                  },
                  {
                    "width": 160,
                   "data": "created",
                  }
               ] ,
        });
        $(".dataTables_length").addClass("col-sm-6");
    });
</script>