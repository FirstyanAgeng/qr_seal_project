@extends('layouts.admin.default')
@section('content')

  <div class="text-center">
    <h1>HASIL QR-CODE</h1>
  </div>

<div class="container text-center">
  <div class="row justify-content-center">
<div class="col-xl-8">
            <!-- Account details card-->
            <div class="card mb-4" style="border-radius: 10px;">
                <div class="card-header" style="background-color: #40A2D8; border-radius: 10px"><p class="text-start" style="color: white">INPUT INFORMASI SERTIFIKAT</p></div>
                <div class="card-body">
                  <p class="text-start">Sertifikat</p>
                    <form enctype="multipart/form-data">
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
                            <label for="inputPenandatangan" style="margin-right: 100px;">Nama yang Menandatangani </label>
                            <input type="text" id="inputPenandatangan" name="inputPenandatangan" style="flex-grow: 1; border-radius: 5px; border: 1px solid #40A2D8;">
                        </div>
                        <div class="form-group">
                            <label for="signatureCanvas">Tanda Tangan</label>
                            <canvas id="signatureCanvas" name="signatureCanvas" width="600" height="40" style="border: 1px solid #40A2D8; border-radius: 5px;"></canvas>
                        </div>
                        <div class="form-group" style="margin-bottom: 20px;">
                            <label for="uploadFile">Upload File</label>
                            <input type="file" id="uploadFile" name="inputImage" style="border-radius: 5px; border: 1px solid #40A2D8;">
                        </div>
                        <!-- Save changes button-->
                        <button class="btn btn-primary" style="background-color: #40A2D8;" type="button">Tanda Tangan</button>
                        <button class="btn btn-primary" style="background-color: #40A2D8;" type="button">Generate QR-CODE</button>
                    </form>
                </div>
            </div>
        </div>
      </div>
      </div>
</div>
@stop
