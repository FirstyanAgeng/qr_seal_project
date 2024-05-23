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
            <div class="form-group">
              <label for="signatureCanvas">Tanda Tangan</label>
              <canvas id="signatureCanvas" name="signatureCanvas" width="600" height="200" style="border: 1px solid #40A2D8; border-radius: 5px;"></canvas>
              <input type="hidden" id="signature" name="signature">
            </div>
            {{-- <div class="form-group" style="margin-bottom: 20px;">
              <label for="uploadFile">Upload File</label>
              <input type="file" id="uploadFile" name="inputImage" style="border-radius: 5px; border: 1px solid #40A2D8;">
            </div> --}}
            <button class="btn btn-primary" style="background-color: #40A2D8;" type="button" onclick="clearSignature()">Clear Tanda Tangan</button>
            <button class="btn btn-primary" style="background-color: #40A2D8;" type="submit">Generate QR-CODE</button>
          </form>
        </div>
      </div>
    </div>
  </div>
</div>

<script>
  const canvas = document.getElementById('signatureCanvas');
  const context = canvas.getContext('2d');
  let drawing = false;
  let lastX = 0;
  let lastY = 0;

  canvas.addEventListener('mousedown', (event) => {
    drawing = true;
    lastX = event.offsetX;
    lastY = event.offsetY;
  });

  canvas.addEventListener('mouseup', () => {
    drawing = false;
    context.beginPath(); // Begin a new path to avoid connecting lines
  });

  canvas.addEventListener('mousemove', drawSignature);
  canvas.addEventListener('mouseleave', () => { drawing = false });

  function drawSignature(event) {
    if (!drawing) return;
    context.lineWidth = 2;
    context.lineCap = 'round';
    context.strokeStyle = '#000000';

    context.beginPath();
    context.moveTo(lastX, lastY);
    context.lineTo(event.offsetX, event.offsetY);
    context.stroke();
    context.closePath();

    lastX = event.offsetX;
    lastY = event.offsetY;
  }

  function clearSignature() {
    context.clearRect(0, 0, canvas.width, canvas.height);
  }

  document.getElementById('certificateForm').addEventListener('submit', function(event) {
    const signatureDataUrl = canvas.toDataURL();
    document.getElementById('signature').value = signatureDataUrl;
  });
</script>

@stop
