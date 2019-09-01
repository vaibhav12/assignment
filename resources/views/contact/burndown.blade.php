<!-- create.blade.php -->

@extends('master')
@section('content')


<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
    <script src="http://code.highcharts.com/highcharts.js"></script>
    <script src="http://code.highcharts.com/modules/exporting.js"></script>

<script type="text/javascript">

   $(function () {
  $('#burndown').highcharts({
    title: {
      text: 'Burndown Chart',
      x: -20 //center
    },
    colors: ['blue', 'red'],
    plotOptions: {
      line: {
        lineWidth: 3
      },
      tooltip: {
        hideDelay: 200
      }
    },
    subtitle: {
      x: -20
    },
    xAxis: {
      categories: <?php echo $aResult;?>
    },
    yAxis: {
      title: {
        text: 'No. Of Relation'
      },
      plotLines: [{
        value: 0,
        width: 1
      }]
    },
    tooltip: {
//      valueSuffix: ' hrs',
      crosshairs: true,
      shared: true
    },
    legend: {
      layout: 'vertical',
      align: 'right',
      verticalAlign: 'middle',
      borderWidth: 0
    },
    series: [{
      name: 'Actual Relation',
      color: 'rgba(0,120,200,0.75)',
      marker: {
        radius: 6
      },
      data: <?php echo $aCount ?>
    }]
  });
});

</script>

<div class="container">

    <div class="row">

        <div class="col-md-10 col-md-offset-1">

            <div class="panel panel-default">

                <div class="panel-body">

                    <div id="burndown"></div>

                </div>

            </div>

        </div>

    </div>
    <div class="form-group row">
      <div class="col-md-2"></div>
      <a href="{{ URL::previous() }}">Go Back</a>
    </div>

</div>

@endsection
</div>