@extends('layouts.user.default')
@section('content')

<div class="text-center">
    <h1>Generate QR-CODE & Validasi </h1>
  </div>

<div class="container container-body px-4">
  <div class="row gx-3">
    <div class="col-sm-6 text-center">
     <div class="row p-5 text-center display-flex">
      <div class="card" >
        <h5 class="card-title">Generate QR CODE</h5>
        <img src="{{ asset('/img/Generate.png')}}" class="card-img-top img fluid" alt="Generate Qr-code" >
        <div class="card-body">
        <a href="#" class="btn btn-primary" style="width: 70%">Upload</a>
        </div>
      </div>
     </div>
    </div>

    <div class="col-sm-6">
      <div class="row p-5 text-center">
        <div class="card">
          <h5 class="card-title">Validasi File</h5>
          <img src="{{ asset('/img/validasi.png')}}" class="card-img-top" alt="...">
          <div class="card-body">
          <a href="#" class="btn btn-primary" style="width: 70% ">Upload</a>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
@stop
