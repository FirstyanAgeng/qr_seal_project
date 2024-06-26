<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use setasign\Fpdi\Fpdi;
use phpseclib3\Crypt\RSA;
use phpseclib3\Crypt\PublicKeyLoader;
use Illuminate\Support\Str;
use BaconQrCode\Renderer\ImageRenderer;
use BaconQrCode\Renderer\Image\ImagickImageBackEnd;
use BaconQrCode\Renderer\RendererStyle\RendererStyle;
use BaconQrCode\Writer;
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
        $fpdi->AddPage($size['orientation'], [$size['width'], $size['height']]);
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

        // Concatenate the data to be signed
        $dataToSign = "$name|$course|$id_course|$name_asignee|$date|$jabatan";

        // Load the private key to sign the data
        $privateKey = file_get_contents(storage_path('rsa_private.pem'));
        $rsa = PublicKeyLoader::loadPrivateKey($privateKey);
        $signature = $rsa->sign($dataToSign);

        // Generate QR code with the signature
        $renderer = new ImageRenderer(
            new RendererStyle(400),
            new ImagickImageBackEnd()
        );
        $writer = new Writer($renderer);
        $qrCodeString = $writer->writeString(base64_encode($signature));

        // Save the QR code image to a temporary file with a proper extension
        $imagick = new Imagick();
        $imagick->readImageBlob($qrCodeString);
        $imagick->setImageFormat('png');

        // Ensure image is 8-bit
        $imagick->setImageDepth(8);

        $tmpFile = tempnam(sys_get_temp_dir(), 'qrcode') . '.png';
        $imagick->writeImage($tmpFile);

        // Add QR code to the PDF
        $qrX = 20; // Adjust the position as needed
        $qrY = 140; // Adjust the position as needed
        $fpdi->Image($tmpFile, $qrX, $qrY, 45, 45); // Adjust size as needed

        unlink($tmpFile);

        // Save the filled PDF to the output file
        return $fpdi->Output($outputfile, 'F');
    }
    public function validateCertificate(Request $request)
    {
        $name = $request->input('name');
        $course = $request->input('course');
        $id_course = $request->input('id_course');
        $name_asignee = $request->input('name_asignee');
        $date = $request->input('date');
        $jabatan = $request->input('jabatan');
        $signature = base64_decode($request->input('signature'));

        // Concatenate the data to be verified
        $dataToVerify = "$name|$course|$id_course|$name_asignee|$date|$jabatan";

        // Load the public key to verify the signature
        $publicKey = file_get_contents(storage_path('rsa_public.pem'));
        $rsa = PublicKeyLoader::loadPublicKey($publicKey);

        // Verify the signature
        $isValid = $rsa->verify($dataToVerify, $signature);

        return response()->json(['valid' => $isValid]);
    }
}
