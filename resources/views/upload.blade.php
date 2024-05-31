@extends('layouts.admin.default')
@section('content')

<div class="text-center">
  <h1> Generate QR-CODE </h1>
</div>

<div class="container text-center">
  <div class="row justify-content-center">
    <div class="col-xl-8">
      <div class="card mb-4" style="border-radius: 10px;">
        <div class="card-header" style="background-color: #40A2D8; border-radius: 10px">
          <p class="text-start" style="color: white">INPUT INFORMASI SERTIFIKAT</p>
        </div>
        <div class="card-body">
          <p class="text-start">Berikan Info Sertifikat Anda</p>
          <form id="certificateForm" method="POST" action="{{ route('process_certificate') }}" enctype="multipart/form-data">
            @csrf
            <div class="form-group" style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px;">
              <label for="inputNoSertifikat" style="margin-right: 100px;">No. Sertifikat</label>
              <input type="text" id="inputNoSertifikat" name="inputNoSertifikat" style="flex-grow: 1; border-radius: 5px; border: 1px solid #40A2D8;">
            </div>
            <div class="form-group" style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px;">
              <label for="inputNamaPeserta" style="margin-right: 100px;">Nama Peserta</label>
              <input type="text" id="inputNamaPeserta" name="inputNamaPeserta" style="flex-grow: 1; border-radius: 5px; border: 1px solid #40A2D8;">
            </div>
            <div class="form-group" style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px;">
              <label for="inputJenisPelatihan" style="margin-right: 100px;">Jenis Pelatihan</label>
              <input type="text" id="inputJenisPelatihan" name="inputJenisPelatihan" style="flex-grow: 1; border-radius: 5px; border: 1px solid #40A2D8;">
            </div>
            <div class="form-group" style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px;">
              <label for="inputTanggalTerbit" style="margin-right: 100px;">Tanggal Terbit</label>
              <input type="date" id="inputTanggalTerbit" name="inputTanggalTerbit" style="flex-grow: 1; border-radius: 5px; border: 1px solid #40A2D8;">
            </div>
            <div class="form-group" style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px;">
              <label for="inputPenandatangan" style="margin-right: 100px;">Nama yang Menandatangani</label>
              <input type="text" id="inputPenandatangan" name="inputPenandatangan" style="flex-grow: 1; border-radius: 5px; border: 1px solid #40A2D8;">
            </div>
            <div class="form-group" style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px;">
              <label for="inputPenandatangan" style="margin-right: 100px;">Jabatan</label>
              <input type="text" id="inputJabatan" name="inputJabatan" style="flex-grow: 1; border-radius: 5px; border: 1px solid #40A2D8;">
            </div>
            <button class="btn btn-primary" style="background-color: #40A2D8;" type="submit">Generate QR-CODE</button>
          </form>
        </div>
      </div>
    </div>
  </div>
</div>

<div class="text-center">
  <h1> Validate Certificate </h1>
</div>

<div class="container text-center">
  <div class="row justify-content-center">
    <div class="col-xl-8">
      <div class="card mb-4" style="border-radius: 10px;">
        <div class="card-header" style="background-color: #40A2D8; border-radius: 10px">
          <p class="text-start" style="color: white">VALIDATE SERTIFIKAT</p>
        </div>
        <div class="card-body">
          <p class="text-start">Verifikasi Sertifikat Anda</p>
          <form id="validateForm" method="POST" action="{{ route('validate_certificate') }}">
            @csrf
            <div class="form-group" style="margin-bottom: 20px;">
              <label for="inputNamaPeserta">Nama Peserta</label>
              <input type="text" id="inputNamaPeserta" name="name" style="flex-grow: 1; border-radius: 5px; border: 1px solid #40A2D8;">
            </div>
            <div class="form-group" style="margin-bottom: 20px;">
              <label for="inputJenisPelatihan">Jenis Pelatihan</label>
              <input type="text" id="inputJenisPelatihan" name="course" style="flex-grow: 1; border-radius: 5px; border: 1px solid #40A2D8;">
            </div>
            <div class="form-group" style="margin-bottom: 20px;">
              <label for="inputNoSertifikat">No. Sertifikat</label>
              <input type="text" id="inputNoSertifikat" name="id_course" style="flex-grow: 1; border-radius: 5px; border: 1px solid #40A2D8;">
            </div>
            <div class="form-group" style="margin-bottom: 20px;">
              <label for="inputPenandatangan">Nama yang Menandatangani</label>
              <input type="text" id="inputPenandatangan" name="name_asignee" style="flex-grow: 1; border-radius: 5px; border: 1px solid #40A2D8;">
            </div>
            <div class="form-group" style="margin-bottom: 20px;">
              <label for="inputTanggalTerbit">Tanggal Terbit</label>
              <input type="date" id="inputTanggalTerbit" name="date" style="flex-grow: 1; border-radius: 5px; border: 1px solid #40A2D8;">
            </div>
            <div class="form-group" style="margin-bottom: 20px;">
              <label for="inputJabatan">Jabatan</label>
              <input type="text" id="inputJabatan" name="jabatan" style="flex-grow: 1; border-radius: 5px; border: 1px solid #40A2D8;">
            </div>
            <div class="form-group" style="margin-bottom: 20px;">
              <label for="inputSignature">Signature</label>
              <input type="text" id="inputSignature" name="signature" style="flex-grow: 1; border-radius: 5px; border: 1px solid #40A2D8;">
            </div>
            <button class="btn btn-primary" style="background-color: #40A2D8;" type="submit">Validate Sertifikat</button>
          </form>
        </div>
      </div>
    </div>
  </div>
</div>

@stop
