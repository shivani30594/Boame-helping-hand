<script>
    $(document).ready(function () 
    {
      var table = $('#Bonus_point_table').DataTable({
            "lengthMenu": [[10, 25, 50,100], [10, 25, 50,100]],
            "processing": true,
            "serverSide": true,
            'order' : [[4, 'desc']],
            "pagingType": "full_numbers",
            "ajax":{
             "url": "<?php echo BASE_URL?>member/report/indexjson",
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
                    "width": 200,
                    "data": "type",
                    "render": function ( data, type, row, meta ) {
                      var str = data.replace(/[_-]/g, " ");
                      return str.replace(/\w\S*/g, function(txt){return txt.charAt(0).toUpperCase() + txt.substr(1).toLowerCase();});  
                    }
                  },
                  {
                    "data": "name" 
                  },
                  {
                    "width": 180,
                    "data": "points",
                    "type": "date",
                    "format": "MM/DD/YYYY",
                    "class": "text-justify" 
                  },
                  {
                     "width": 200,
                    "data": "edate"
                  }
               ] 
        });
        table.on('order.dt search.dt', function () {
           table.column(0, { search: 'applied', order: 'applied' }).nodes().each(function (cell, i) {
               cell.innerHTML = i + 1;
           });
        }).draw();

        $(".dataTables_length").addClass("col-sm-6");

    });
</script>