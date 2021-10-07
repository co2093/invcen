<div class="tab-pane fade" id="panel-bitacora">
	<div class="panel-body">
		<div class="the-box full no-border">
			<div class="container-fluid">
				<div class="table-responsive">         
          <table class="table table-hover table-striped table-bordered table-condensed" width="100%">
            <thead>
              <tr>
                <th>FECHA</th>                
                <th>RESPONSABLE</th>
                <th>ESTADO</th>
              </tr>
            </thead>
            <tbody>
              @foreach($equipo->bitacora as $bitacora)
              <tr>
                <td>{{date_format(date_create($bitacora->created_at),'d-m-Y')}}</td>
                <td>{{$bitacora->responsable}}</td>
                <td>{{$bitacora->estadob['estado']}}</td>
              </tr>
              @endforeach
            </tbody>
          </table>             
        </div>
			</div>		
		</div>
	</div>
</div>