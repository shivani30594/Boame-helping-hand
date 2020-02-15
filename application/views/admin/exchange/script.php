<script>
    $(document).ready(function () 
    {
      var table = $('#exchange_history').DataTable({
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
             "url": "<?php echo BASE_URL?>admin/exchange/indexjson",
             "dataType": "json",
             "type": "POST",
             "data":{  '<?php echo $this->security->get_csrf_token_name(); ?>' : '<?php echo $this->security->get_csrf_hash(); ?>' }
              },
              "columns": [
                  {
                    "width": 10,
                    "data" : "id",
                    "targets" : 0
                  },
                  {
                    "width": 100,
                    "render": function ( data, type, row, meta ) {
                      data = row.name;
                      var str = data.replace(/[_-]/g, " ");
                      return str.replace(/\w\S*/g, function(txt){return txt.charAt(0).toUpperCase() + txt.substr(1).toLowerCase();});  
                    }
                  },
                  {
                    "width": 30,
                    "render": function ( data, type, row, meta ) {
                      return Number.parseFloat(row.exchage_amount).toPrecision(4);
                    },
                    "targets" : 2
                  },
                  {
                    "width": 30,
                    "render": function ( data, type, row, meta ) {
                      return Number.parseFloat(row.getting_amount).toPrecision(4);
                    },
                    "targets" : 3
                  },
                  {
                    "width": 70,
                    "render": function ( data, type, row, meta ) {
                      data = row.type;
                      var str = data.replace(/[_-]/g, " ").toUpperCase();
                      var str1 = str.substr(0, str.indexOf(' '));
                      if (str1 == 'USD')
                      {
                        return "<span class='label label-info'>"+str1+"</span>";  
                      }
                      else{
                        return "<span class='label label-success'>"+str1+"</span>";  
                      }
                    }
                  },
                  {
                    "width": 70,
                    "render": function ( data, type, row, meta ) {
                      data = row.type;
                      var str = data.replace(/[_-]/g, " ").toUpperCase();
                      var str1 =  str.substr(7, str.indexOf(' '));
                      if (str1 == "USD")
                      {
                        return "<span class='label label-info'>"+str1+"</span>";  
                      }
                      else{
                        return "<span class='label label-success'>"+str1+"</span>";  
                      }
                    }
                  },
                  {
                    "width": 70,
                    "render": function ( data, type, row, meta ) {
                      data = row.type;
                      var str = data.replace(/[_-]/g, " ").toUpperCase();
                      var substring =  str.substr(0, str.indexOf(" "));
                      if (substring == 'USD')
                      {
                        return "<?php echo config_setting_item('usd_to_ghs')?>";
                      }
                      else{
                        return "<?php echo config_setting_item('ghs_to_usd')?>";
                      }
                    }
                  },
                  {
                    "width": 10,
                    "data" : "created",
                    "targets" : 5
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