@extends('frontend.layouts.master')
@section('second-title')
    | Liste des Merchandisers
@stop
@section('url-way')
    <li>
        <a href="#">Statistiques</a>
		<i class="fa fa-circle"></i>
    </li>
    <li>
        <a href="{{url('/merchandiser')}}">Merchandisers</a>
    </li>
@stop
@section('content')
    <div class="row">
        <div class="col-md-12">
            <!-- BEGIN EXAMPLE TABLE PORTLET-->
            <div class="portlet light bordered">
                <div class="portlet-title">
                    <div class="caption font-dark">
                        <i class="icon-info font-dark"></i>
                        <span class="caption-subject bold uppercase">Liste des Merchandisers </span>
                    </div>
                    <div class="tools">

                    </div>
                </div>
                <div class="portlet-body">
                    <div class="row" style="margin-top: 20px;">
						            <form id="myform" style="margin-bottom: 30px;">
                                                <table id="mytable1" style="margin:auto;">
                                                    <thead>
                                                    <tr>
                                                        <th></th>
                                                        <th></th>
                                                        <th></th>
                                                        <th></th>
                                                        <th></th>
                                                        <th></th>
                                                        <th></th>
                                                        <th></th>
                                                        <th></th>
                                                        <th></th>
                                                        <th></th>
                                                        <th></th>
                                                    </tr>
                                                    </thead>
                                                    <tbody>
                                                    <tr>
                                                        <td><label for="date" style="margin: 5px 20px 0 40px;">
                                                                Date </label></td>
                                                        <td style="padding-left:5px;" id="row2">
                                                            <input type="text"
                                                                   style="margin-bottom: 3px;"
                                                                   name="date" id="date"
                                                                   class="form-control form-control-inline date-picker"
                                                                   onchange="table.draw();"
                                                                   placeholder="De">
                                                            <input type="text" name="datefin" id="datefin"
                                                                   class="form-control form-control-inline  date-picker"
                                                                   onchange="table.draw();"
                                                                   placeholder="à"></td>

                                                        <td style="padding-left: 5px;text-align: center;">
                                                            <button class="btn dark" onclick="netoyer()"
                                                                    id="btn-reset">
                                                                Annuler
                                                            </button>
                                                        </td>

                                                    </tr>
                                                    </tbody>

                                                </table>
                                            </form>

                        <table class="table table-striped table-bordered table-hover" id="rapport_table">
                            <thead>
                            <th width="20%">Merchandiser</th>
                            <th width="20%">Email</th>
                            <th width="20%">Zone</th>
                            <th width="20%">Total visites</th>
                            <th width="5%">Anomalies</th>
                            <th width="20%" style="text-align: center">Profile</th>
                            </thead>
                        </table>

                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection


@section('footer')
    <script>
        $('.date-picker').datepicker();
		var today = new Date();
		var dd = today.getDate();
		var mm = today.getMonth()+1; //January is 0!
		var yyyy = today.getFullYear();
		if(dd<10){
			dd='0'+dd
		} 
		if(mm<10){
			mm='0'+mm
		} 
		var today = dd+'/'+mm+'/'+yyyy;
		
		var old = new Date();
		old.setMonth(old.getMonth() - 3);
		var ddp = old.getDate();
		var mmp = old.getMonth()+1; //January is 0!
		var yyyyp = old.getFullYear();
		if(ddp<10){
			ddp='0'+ddp
		} 
		if(mmp<10){
			mmp='0'+mmp
		} 

		var past = ddp+'/'+mmp+'/'+yyyyp;


		document.getElementById ('datefin').value = today ;
		document.getElementById('date').value = past;		
        
		
		$.fn.dataTable.ext.errMode = 'throw';
        var table = $('#rapport_table').DataTable({
            "processing": true,
            "serverSide": true,
            "lengthMenu": [[5, 10, 15, 20, 50], [5, 10, 15, 20, 50]],
            "iDisplayLength": 50,
            "bFilter": false,
            "bSort": false,
            "ajax": {
                'url': "{{ route('paginate.merchandiser') }}",
                'type': 'get',
                'data': function (d) {
                    d.page = Math.ceil(d.start / d.length) + 1;
					d.datedebut = document.getElementById('date').value;
                    d.datefin = document.getElementById('datefin').value;
                }
            },
            responsive: true
        });
		
		        function netoyer(id) {
            document.getElementById("myform").reset();
            $.fn.dataTable.ext.search.push(
                    function (settings, data, dataIndex) {


                        return true;
                    }
            );

            $.fn.dataTable.ext.search.splice($.fn.dataTable.ext.search.indexOf(function (settings, data, dataIndex) {

                return true;

            }));

            table.draw();
        }
		$('.form-control').change(function(){
			table.draw();
		});
    </script>
@endsection

@section('after-scripts-end')
@stop