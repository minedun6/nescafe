
$(document).ready(function() {

    var table =$('#rapport_table').DataTable({
        "columnDefs": [

            {
                "targets": [0],
                "type": 'date-eu'
            }
        ],
        "order": [
            [0, 'desc']
        ]
    });
    // Event listener to the two range filtering inputs to redraw on input
    function tri() {


        $.fn.dataTable.ext.search.push(
            function( settings, data, dataIndex ) {
                var date= document.getElementById("date").value;
                var entree = date;
                console.log(date);
                var type =  data[0]  ; // use data for the age column
                console.log(data[0]);
                if ( entree==type )
                {
                    return true;
                }

                return false;
            }
        );

        /*$.fn.dataTable.ext.search.splice($.fn.dataTable.ext.search.indexOf(function( settings, data, dataIndex ) {
            var date= document.getElementById("date").value;
            var entree = date;
            var type =  data[0]  ; // use data for the age column
            console.log(data[0]);
            if ( entree==type )
            {
                return true;
            }

            return false;
        }, 1));*/




        $.fn.dataTable.ext.search.push(
            function( settings, data, dataIndex ) {
                var date= document.getElementById("code").value;
                var entree = date;
                console.log(date);
                var type =  data[1]  ; // use data for the age column
                console.log(data[1]);
                if (( entree==type ) || (entree==""))
                {
                    return true;
                }

                return false;
            }
        );
      /*  table.draw();*/
       /* $.fn.dataTable.ext.search.splice($.fn.dataTable.ext.search.indexOf(function( settings, data, dataIndex ) {
            var date= document.getElementById("code").value;
            var entree = date;
            var type =  data[1]  ; // use data for the age column
            console.log(data[1]);
            if (( entree==type ) || (entree==""))
            {
                return true;
            }

            return false;
        }, 1));*/
    table.draw();
    }
} );