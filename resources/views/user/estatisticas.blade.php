@extends('layouts.app')
@section('content')

<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            
            <div class="row">
                
                <div class="col-md-5 justify-content-center">
                    <div class="card">
                        <div class="card-header">Peso Relativo de Cada Conta</div>    
                        <div class="card-body">
                            <h6 style="margin-left: 5px">Saldo Total: {{$saldoTotal}}€</h6>
                            <div id="piechart" style="width: 423px; height: 364px;"></div>
                        </div>
                    </div>
                </div>
                <div class="col-md-7">
                    <div class="card">
                        <div class="card-header">Despesas VS Receitas</div>
                        <div class="card-body">
                            <form action="{{route ('me.estatisticas')}}" method="GET">
                                <div class="input-group">
                                    <input type="date" name="data1" class="form-control" id="data1" placeholder="Data" value="{{ request()->input('data1') }}">
                                    
                                    <input type="date" name="data2" class="form-control" id="data2" placeholder="Data" value="{{ request()->input('data2') }}">
                                    <div class="input-group-append">
                                        <button class="btn btn-outline-secondary" type="submit">Filtrar</button>
                                    </div> 
                                </div> 
                   
                            <div id="chart_div" style="width: 550px; height: 350px;"></div>
                        </div>
                    </div>
                </div>
            </div>
            
          </div>
    </div>
</div>

<script type="text/javascript">
    google.charts.load('current', {'packages':['corechart']});
    google.charts.setOnLoadCallback(drawChart);

    function drawChart() {

        
        var data = google.visualization.arrayToDataTable([
        ['Conta', 'Saldo Atual'],
        @foreach ($contas as $conta)
        ['{{$conta->nome}}', {{$conta->saldo_atual}}],
        @endforeach
      ]);


      var chart = new google.visualization.PieChart(document.getElementById('piechart'));

      chart.draw(data);
    }

   
    google.charts.load('current', {'packages':['corechart']});
    google.charts.setOnLoadCallback(drawVisualization);

    function drawVisualization() {
    // Some raw data (not necessarily accurate)

    var data = google.visualization.arrayToDataTable([
        ['Month', 'Receita', 'Despesa'],
        (
        ({{ request()->input('data1') ?? 0 }}) || 
        ({{ request()->input('data2') ?? 0 }}) ? ['{{ request()->input('data1')}} {{request()->input('data2')}}', {{$receitaTotal}}, {{$despesaTotal}}] : ['Desde Sempre',  {{$receitaTotal}}, {{$despesaTotal}}])
    ]);

    var options = {
        
        vAxis: {title: 'Euros (€)'},
        hAxis: {title: 'Intervalo de Tempo'},
        seriesType: 'bars',
        series: {5: {type: 'line'}}        };

    var chart = new google.visualization.ComboChart(document.getElementById('chart_div'));
    chart.draw(data, options);
    }
   

</script>




@endsection