<script>
    $(document).ready(function () 
    {
       // table.state.clear();
        var count = 1;
    	   var table = $('#news').DataTable({
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
             "url": "<?php echo BASE_URL?>admin/point/indexjson",
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
                    "data": "type" 
                  },
                  {
                   "data": "message",
                   "class": "text-justify" 
                  },
                  {
                    "data": "created",
                    "width": 200,
                    "type":  'datetime',
                     def:   function () { return new Date(); },
                    "format": 'D MMM YYYY HH:mm',
                    "fieldInfo": 'Euro style date with 24 hour clock'
                      }
               ] 
        });
        $(".dataTables_length").addClass("col-sm-6");

    });
</script>