<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use setasign\Fpdi\Fpdi;
use Endroid\QrCode\Builder\Builder;
use Endroid\QrCode\Writer\PngWriter;
use phpseclib3\Crypt\RSA;
use Illuminate\Support\Str;
use Imagick;


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

        // Generate a unique filename for the output PDF
        $uniquePdfFilename = 'dcc_' . Str::random(10) . '.pdf';
        $outputfile = public_path($uniquePdfFilename);

        // Call the fillPDF function to generate the filled PDF
        $this->fillPDF(public_path('master/dcc.pdf'), $outputfile, $name, $course, $id_course, $name_asignee, $date, $jabatan);

        return response()->file($outputfile);
    }

    public function fillPDF($file, $outputfile, $name, $course, $id_course, $name_asignee, $date, $jabatan)
    {
        $fpdi = new FPDI;
        $fpdi->setSourceFile($file); // Load the template PDF
        $template = $fpdi->importPage(1); // Import the first page of the template
        $size = $fpdi->getTemplateSize($template);
        $fpdi->AddPage($size['orientation'], array($size['width'], $size['height']));
        $fpdi->useTemplate($template);

        // Define positions for the text fields
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

        // Set font and color for the text
        $fpdi->setFont('helvetica', '', 28);
        $fpdi->SetTextColor(25, 26, 26);

        // Add text to the PDF at the specified positions
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

        // Generate a unique filename for the QR code
        $uniqueQrCodeFilename = 'qr_code_' . Str::random(10) . '.png';
        $qrCodePath = public_path($uniqueQrCodeFilename);

        // Create Imagick object
        $imagick = new Imagick();

        // Set QR code options
        $imagick->setResolution(300, 300); // Set the resolution (dpi) for high-quality output
        $imagick->readImageBlob($qrCode->writeString());

        // Save the QR code image
        $imagick->setImageFormat('png');
        $imagick->writeImage($qrCodePath);
        $imagick->clear();
        $imagick->destroy();

        // $qrCode->saveToFile($qrCodePath);

        // Add QR code to the PDF
        $qrX = 20; // Adjust the position as needed
        $qrY = 140; // Adjust the position as needed
        $fpdi->Image($qrCodePath, $qrX, $qrY, 45, 45); // Adjust size as needed

        // Save the filled PDF to the output file
        return $fpdi->Output($outputfile, 'F');
    }
}
