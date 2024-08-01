@extends('admin.layout.master')
@section('content')

<div class="row">
  <div class="col-lg-3 col-md-6 col-sm-6 col-12">
    <div class="card card-statistic-1">
      <div class="card-icon bg-info">
        <i class="far fa-user"></i>
      </div>
      <div class="card-wrap">
        <div class="card-header">
          <h4>Today's Earnings</h4>
        </div>
        <div class="card-body">
          {{round($todayEarning)}} TK
        </div>
      </div>
    </div>
  </div>
  <div class="col-lg-3 col-md-6 col-sm-6 col-12">
    <div class="card card-statistic-1">
      <div class="card-icon bg-success">
        <i class="far fa-newspaper"></i>
      </div>
      <div class="card-wrap">
        <div class="card-header">
          <h4>This Month's Earnings</h4>
        </div>
        <div class="card-body">
        {{$monthEarning}} TK
        </div>
      </div>
    </div>
  </div>
  <div class="col-lg-3 col-md-6 col-sm-6 col-12">
    <div class="card card-statistic-1">
      <div class="card-icon bg-light">
        <i class="far fa-file"></i>
      </div>
      <div class="card-wrap">
        <div class="card-header">
          <h4>This Year's Earnings</h4>
        </div>
        <div class="card-body">
         {{round($yearEarning)}} TK
        </div>
      </div>
    </div>
  </div>
  <div class="col-lg-3 col-md-6 col-sm-6 col-12">
    <div class="card card-statistic-1">
      <div class="card-icon bg-warning">
        <i class="fas fa-circle"></i>
      </div>
      <div class="card-wrap">
        <div class="card-header">
          <h4>Total Earnings</h4>
        </div>
        <div class="card-body">
          {{round($totalEarnings)}} TK
        </div>
      </div>
    </div>
  </div>                  
</div>
@endsection