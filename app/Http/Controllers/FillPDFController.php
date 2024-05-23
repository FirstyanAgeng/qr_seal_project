<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use setasign\Fpdi\Fpdi;
use Endroid\QrCode\Builder\Builder;
use Endroid\QrCode\Writer\PngWriter;
use phpseclib3\Crypt\RSA;

class FillPDFController extends Controller
{
    public function process(Request $request)
    {
        $name = "Firstyan";
        $course = "WEB DEVELOPMENT";
        $id_course = "63453533466354";
        $name_asignee = "Mark Zuckerberg";
        $jabatan = "CEO OF GOOGLE";
        $date = "Mei 20, 2024";
        // $name = $request->post('name');
        $outputfile = public_path() . '/dcc.pdf';
        $this->fillPDF(public_path() . '/master/dcc.pdf', $outputfile, $name, $course, $id_course, $name_asignee, $jabatan, $date);
        return response()->file($outputfile);
    }

    public function fillPDF($file, $outputfile, $name, $course, $id_course, $name_asignee, $jabatan, $date)
    {
        $fpdi = new FPDI;
        $fpdi->setSourceFile($file);
        $template = $fpdi->importPage(1);
        $size = $fpdi->getTemplateSize($template);
        $fpdi->AddPage($size['orientation'], array($size['width'], $size['height']));
        $fpdi->useTemplate($template);
        $top = 102;
        $right = 135;
        $top_course = 130;
        $right_course = 100;
        $top_id = 145;
        $right_id = 110;
        $top_date = 192;
        $right_date = 15;
        $fpdi->setFont('helvetica', '', 28);
        $fpdi->SetTextColor(25, 26, 26);
        $fpdi->Text($right, $top, $name);
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
