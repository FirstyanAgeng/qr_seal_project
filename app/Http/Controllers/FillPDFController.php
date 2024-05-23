<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use setasign\Fpdi\Fpdi;
use Endroid\QrCode\Builder\Builder;
use Endroid\QrCode\Writer\PngWriter;
use phpseclib3\Crypt\RSA;

class FillPDFController extends Controller
{
    public function create()
    {
        return view('upload');
    }

    public function process(Request $request)
    {
        $name = $request->input('inputNamaPeserta');
        $course = $request->input('inputJenisPelatihan');
        $id_course = $request->input('inputNoSertifikat');
        $name_asignee = $request->input('inputPenandatangan');
        $date = $request->input('inputTanggalTerbit');
        $jabatan = $request->input('inputJabatan');
        $signatureDataUrl = $request->input('signature');

        // Decode the base64 encoded signature image
        $signatureImage = base64_decode(preg_replace('#^data:image/\w+;base64,#i', '', $signatureDataUrl));
        $signaturePath = public_path('signature.png');
        file_put_contents($signaturePath, $signatureImage);

        $outputfile = public_path('dcc.pdf');
        $this->fillPDF(public_path('master/dcc.pdf'), $outputfile, $name, $course, $id_course, $name_asignee, $date, $jabatan);

        return response()->file($outputfile);
    }

    public function fillPDF($file, $outputfile, $name, $course, $id_course, $name_asignee, $date, $jabatan)
    {
        $fpdi = new FPDI;
        $fpdi->setSourceFile($file);
        $template = $fpdi->importPage(1);
        $size = $fpdi->getTemplateSize($template);
        $fpdi->AddPage($size['orientation'], array($size['width'], $size['height']));
        $fpdi->useTemplate($template);
        $top = 105;
        $right = 128;
        $top_name_asignee = 175;
        $right_name_asignee = 110;
        $top_jabatan = 192;
        $right_jabatan = 90;
        $top_course = 125;
        $right_course = 115;
        $top_id = 145;
        $right_id = 110;
        $top_date = 192;
        $right_date = 15;
        $fpdi->setFont('helvetica', '', 28);
        $fpdi->SetTextColor(25, 26, 26);
        $fpdi->Text($right, $top, $name);
        $fpdi->Text($right_name_asignee, $top_name_asignee, $name_asignee);
        $fpdi->Text($right_jabatan, $top_jabatan, $jabatan);
        $fpdi->Text($right_course, $top_course, $course);
        $fpdi->Text($right_id, $top_id, $id_course);
        $fpdi->Text($right_date, $top_date, $date);

        // Encrypt data using RSA public key
        $publicKey = file_get_contents(storage_path('rsa_public.pem'));
        $rsa = RSA::loadPublicKey($publicKey);
        $plaintext = $name_asignee . ' - ' . $jabatan;
        $ciphertext = $rsa->encrypt($plaintext);

        // Generate QR code with encrypted data
        $qrCode = Builder::create()
            ->writer(new PngWriter())
            ->data(base64_encode($ciphertext)) // Encode to base64 to ensure it's a valid string for the QR code
            ->size(100)
            ->margin(5)
            ->build();

        $qrCodePath = public_path('qr_code.png');
        $qrCode->saveToFile($qrCodePath);


        // Add QR code to the PDF
        $qrX = 20; // Adjust the position as needed
        $qrY = 140; // Adjust the position as needed
        $fpdi->Image($qrCodePath, $qrX, $qrY, 45, 45); // Adjust size as needed

        return $fpdi->Output($outputfile, 'F');
    }
}
