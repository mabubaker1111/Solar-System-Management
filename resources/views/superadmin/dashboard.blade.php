@extends('superadmin.layout')
@section('title', 'Dashboard')

@section('content')
<h3 class="fw-bold mb-4 text-center ">Dashboard</h3>

<div class="row ">

    <!-- Cards -->
    <div class="row ">
        <div class="col-md-3">
            <div class="card shadow-sm p-3 border-start border-primary border-2  rounded-3 card-hover">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h6 class="text-muted mb-1">Total Clients</h6>
                        <h3 class="mb-0">{{ $clients->count() }}</h3>
                    </div>
                    <i class="bi bi-people fs-2 text-primary icon-hover"></i>
                </div>
            </div>
        </div>

        <div class="col-md-3">
            <div class="card shadow-sm p-3 border-start border-success border-2 rounded-3 card-hover">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h6 class="text-muted mb-1">Total Businesses</h6>
                        <h3 class="mb-0">{{ $businesses->count() }}</h3>
                    </div>
                    <i class="bi bi-building fs-2 text-success icon-hover"></i>
                </div>
            </div>
        </div>

        <div class="col-md-3">
            <div class="card shadow-sm p-3 border-start border-warning border-2 rounded-3 card-hover">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h6 class="text-muted mb-1">Total Workers</h6>
                        <h3 class="mb-0">{{ $workers->count() }}</h3>
                    </div>
                    <i class="bi bi-person-workspace fs-2 text-warning icon-hover"></i>
                </div>
            </div>
        </div>

        <div class="col-md-3">
            <div class="card shadow-sm p-3 border-start border-danger border-2 rounded-3 card-hover">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h6 class="text-muted mb-1">Pending Worker</h6>
                        <h3 class="mb-0">{{ $workerRequests->count() }}</h3>
                    </div>
                    <i class="bi bi-hourglass-split fs-2 text-danger icon-hover"></i>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="mt-5 d-flex justify-content-center">
    <a href="{{ route('superadmin.requests.client') }}" class="btn btn-primary shadow-sm">
        <i class="bi bi-eye me-1"></i> View Client Requests
    </a>
</div>

<!-- Charts Row -->
<div class="row mt-5">
    <div class="col-xl-8 col-lg-7 mb-4">
        <div class="card shadow">
            <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                <h6 class="m-0 font-weight-bold text-primary">Earnings Overview</h6>
            </div>
            <div class="card-body">
                <canvas id="earningsAreaChart"></canvas>
            </div>
        </div>
    </div>

    <div class="col-xl-4 col-lg-5 mb-4">
        <div class="card shadow">
            <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                <h6 class="m-0 font-weight-bold text-primary">Revenue Sources</h6>
            </div>
            <div class="card-body">
                <canvas id="revenuePieChart"></canvas>
                <div class="mt-4 text-center small">
                    <span class="mr-2"><i class="fas fa-circle text-primary"></i> Direct</span>
                    <span class="mr-2"><i class="fas fa-circle text-success"></i> Social</span>
                    <span class="mr-2"><i class="fas fa-circle text-info"></i> Referral</span>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Latest Client Requests Table -->
<h3 class=" text-center my-4">Latest Client Requests</h3>
<div class="table-container boxshadow bg-none">
    <table class="responsive-table ">
        
        <caption class="fs-6">Latest Client Requests</caption>
        <thead>
            <tr>
                <th scope="col">ID</th>
                <th scope="col">Client</th>
                <th scope="col">Business</th>
                <th scope="col">Service</th>
                <th scope="col">Status</th>
            </tr>
        </thead>
        <tbody>
            @foreach($clientRequests as $req)
            <tr>
                <th scope="row">{{ $req->id }}</th>
                <td data-title="Client">{{ $req->client->name ?? '-' }}</td>
                <td data-title="Business">{{ $req->business->business_name ?? '-' }}</td>
                <td data-title="Service">{{ $req->service->name ?? '-' }}</td>
                <td data-title="Status">
                    <span class="badge 
                        @if($req->status=='pending') bg-warning 
                        @elseif($req->status=='approved') bg-success 
                        @elseif($req->status=='rejected') bg-danger 
                        @else bg-secondary @endif">
                        {{ ucfirst($req->status) }}
                    </span>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
<div class="d-flex justify-content-center">
    {{ $clientRequests->links('vendor.pagination.bootstrap-5') }}
</div>

<style>
.boxshadow {
    box-shadow: 1px 2px 15px 0px;
}
.table-container {
    width: calc(100%);
    overflow-x: auto;
    max-height: 550px;
    /* padding: 1em 0; */
}

/* Scrollbar Styling */
.table-container::-webkit-scrollbar {
    height: 6px;
}
.table-container::-webkit-scrollbar-thumb {
    background-color: rgba(0, 0, 0, 0.2);
    border-radius: 3px;
}

/* Responsive Table */
.responsive-table {
    width: 100%;
    border-collapse: collapse;
    /* margin-bottom: 1.5em; */
    font-family: sans-serif;
}

.responsive-table caption {
    font-size: 1.2em;
    font-weight: bold;
    margin-bottom: 0.5em;
    text-align: center;
}

.responsive-table th,
.responsive-table td {
    padding: 0.75em 0.5em;
    border: 1px solid rgba(134,188,37,1);
    text-align: center;
    vertical-align: middle;
}

.responsive-table thead th {
    background: linear-gradient( #4e73df, #1cc88a);
    color: white;
}

/* Zebra Striping */
.responsive-table tbody tr:nth-of-type(even) {
    background-color: rgba(0,0,0,.05);
}

/* Mobile View */
@media (max-width: 768px) {
    .table-container {
        width: 100%;
        margin-left: 0;
    }

    .responsive-table thead {
        position: absolute;
        clip: rect(1px 1px 1px 1px); 
        padding: 0;
        border: 0;
        height: 1px; 
        width: 1px; 
        overflow: hidden;
    }

    .responsive-table tbody,
    .responsive-table tr,
    .responsive-table th,
    .responsive-table td {
        display: block;
        width: 100%;
        text-align: left;
    }

    .responsive-table td[data-title]:before {
        content: attr(data-title);
        font-weight: bold;
        float: left;
    }

    .responsive-table td {
        padding-left: 50%;
        position: relative;
    }

    .responsive-table td[data-title]:before {
        position: absolute;
        left: 0;
        top: 0;
        padding-left: 0.5em;
    }
}


.card-hover { transition: transform 0.3s ease, box-shadow 0.3s ease; cursor: pointer; background: linear-gradient(145deg,#fff,#f0f3f8);}
.card-hover:hover { transform: translateY(-6px) scale(1.03); box-shadow:0 8px 20px rgba(0,0,0,0.15);}
.icon-hover { transition: transform 0.3s ease, color 0.3s ease;}
.card-hover:hover .icon-hover { transform: rotate(15deg) scale(1.2); color:#0d6efd;}
.card-hover h6 { letter-spacing:0.5px; font-weight:500;}
.card-hover h3 { font-weight:700;}
</style>

@section('scripts')
<script>
document.addEventListener("DOMContentLoaded", function() {
    // Area Chart
    const ctxArea = document.getElementById('earningsAreaChart').getContext('2d');
    new Chart(ctxArea, {
        type: 'line',
        data: {
            labels: {!! json_encode($months ?? ['Jan','Feb','Mar','Apr','May','Jun']) !!},
            datasets: [{
                label: 'Earnings',
                data: {!! json_encode($monthlyEarnings ?? [0,0,0,0,0,0]) !!},
                backgroundColor: 'rgba(78,115,223,0.05)',
                borderColor: 'rgba(78,115,223,1)',
                borderWidth: 2,
                fill: true,
                tension: 0.4,
                pointBackgroundColor: 'rgba(78,115,223,1)',
                pointRadius: 3
            }]
        },
        options: {
            responsive: true,
            plugins: { legend: { display: false } },
            scales: { x: { grid: { display: false } }, y: { beginAtZero: true } }
        }
    });

    // Pie Chart
    const ctxPie = document.getElementById('revenuePieChart').getContext('2d');
    new Chart(ctxPie, {
        type: 'doughnut',
        data: {
            labels: ['Direct','Social','Referral'],
            datasets:[{
                data:{!! json_encode($revenueSources ?? [55,30,15]) !!},
                backgroundColor:['#4e73df','#1cc88a','#36b9cc'],
                hoverOffset:10
            }]
        },
        options:{ responsive:true, plugins:{ legend:{ position:'bottom' } } }
    });
});
</script>
@endsection
@endsection
