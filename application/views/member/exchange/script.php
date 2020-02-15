<script>
    $(document).ready(function () 
    {
        table = $('#exchange_history').DataTable({
            "ordering": true,
            "order": [[3,'desc']],
             //"serverSorting": true,
            //"bStateSave": true,
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
             "url": "<?php echo BASE_URL?>member/exchange/history_indexjason",
             "dataType": "json",
             "type": "POST",
             "data":{  '<?php echo $this->security->get_csrf_token_name(); ?>' : '<?php echo $this->security->get_csrf_hash(); ?>' }
                    },
            "columns": [
                  {
                    "width": 60,
                    "data": "id"
                  },
                  {
                    "width": 160,
                    "render": function ( data, type, row, meta ) {
                      return Number.parseFloat(row.exchage_amount).toPrecision(4);
                    },
                  },
                  {
                    "width": 160,
                    "render": function ( data, type, row, meta ) {
                      return Number.parseFloat(row.getting_amount).toPrecision(4);
                    },
                  },
                  {
                    "width": 160,
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
                    "width": 150,
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
                    "width": 170,
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
                    "width": 160,
                    "sortable": 'desc',
                    "data": "created"
                  },
               ] ,
                 
        });
  
    function myfunc() {
        var amount = $("#amount").val();
        var type = $("#exchange_from").val();
        if (type == 'ghs')
        {
            var exchange_rate = "<?php echo config_setting_item('ghs_to_usd')?>"
            var cal_amount = (amount / exchange_rate).toPrecision(4);
            var text = "You would like to exchange GHS"+amount+" into USD"+cal_amount+" after applying "+exchange_rate+" exchange rate."
        }
        else{
            var exchange_rate = "<?php echo config_setting_item('usd_to_ghs')?>"
            var cal_amount = (amount * exchange_rate).toPrecision(4);
            var text = "You would like to exchange USD"+amount+" into GHS"+cal_amount+" after applying "+exchange_rate+" exchange rate."
        }
        swal({
          title: 'Are you sure?',
          text: text,
          type: 'warning',
          showCancelButton: true,
          confirmButtonColor: '#3085d6',
          cancelButtonColor: '#d33',
          confirmButtonText: 'Yes, Activate!'
          }).then(function (result) {
          if(result == true){
                jQuery.ajax({
                    type : 'POST',
                    url : '<?php echo BASE_URL?>member/exchange/exchange_ewallet',
                    data : {'amount':amount ,'type':type},
                    success: function(response){
                        if (response.error == 0)
                        {
                            swal({
                              title: 'success',
                              text: response.message,
                              type: 'success',
                              allowOutsideClick: false
                            }).then(function (result) {
                                    if( result == true){
                                    window.location.href ="<?php echo BASE_URL?>exchange";
                                }
                            });
                        }
                        else{
                            swal({
                              title: 'error',
                              text: response.message,
                              type: 'error',
                              allowOutsideClick: false
                            }).then(function (result) {
                                    if( result == true){
                                    window.location.href ="<?php echo BASE_URL?>exchange";
                                }
                            });
                        }
                    }
                });
            }
            else
            {
                swal("error", "You must have 150 GHS-BPoints OR 35 USD-BPoints to activate eProducts plan.", "error");
            }
      });
 }
document.getElementById('exchange_button').addEventListener('click', function(e){
    e.preventDefault();
    var amount = $("#amount").val();
    if (amount > 0) 
    {
        myfunc();
    }
    }, false);
});
</script>