@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Dashboard</div>

                <div class="card-body">
                    @if(auth()->user()->user_type_id == 1)
                    <canvas id="myChart" height="100px"></canvas>
                    @else
                    Hi Admin, You are logged in!
                    @endif

                </div>
            </div>
        </div>
    </div>
</div>

</script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script type="text/javascript">
    var labels = <?php echo $labels ?>;
    //alert(labels);
    var users = <?php echo $data ?>;

    const data = {
        labels: labels,
        datasets: [{
            label: 'Monthly Oreder Summary Report',
            backgroundColor: 'rgb(255, 99, 132)',
            borderColor: 'rgb(255, 99, 132)',
            data: users,
        }]
    };

    const config = {
        type: 'bar',
        data: data,
        options: {}
    };

    const myChart = new Chart(
        document.getElementById('myChart'),
        config
    );
</script>
@endsection