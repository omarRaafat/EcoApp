<?php
namespace App\Services;

use App\Models\User;
use ArPHP\I18N\Arabic;
use setasign\Fpdi\Fpdi;
use Illuminate\Support\Str;
use setasign\Fpdi\PdfParser\PdfParserException;
use setasign\Fpdi\PdfReader\PdfReaderException;
use setasign\Fpdi\PdfParser\Type\PdfTypeException;
use setasign\Fpdi\PdfParser\Filter\FilterException;
use setasign\Fpdi\PdfParser\CrossReference\CrossReferenceException;
use setasign\Fpdi\PdfParser\StreamReader;

class VendorAgreement {
    private const textWidth = 3.5;
    private const numberWidth = 8.5;
    private const spaceWidth = 10;
    private const pagePadding = 50;
    private const numberYaxis = 20;
    private const textYaxis = 32;
    private const textFontSize = 12;
    private const numberFontSize = 20;
    private const rightPadding = 30;

    /**
     * @param string $filePath
     * @param User $vendorUser
     * @param string $approvedDateTime
     * @return string
     * @throws CrossReferenceException
     * @throws FilterException
     * @throws PdfParserException
     * @throws PdfReaderException
     * @throws PdfTypeException
     */
    public function fillPdfFile(
        string $filePath,
        User $vendorUser,
        string $approvedDateTime = ""
    ) : string {
        $Arabic = new Arabic('Glyphs');

        $font = public_path("cairoreg.ttf");
        $boldFont = public_path("cairobold.ttf");
        $vendorSign = $Arabic->utf8Glyphs('طرف ثاني');
        $text = $Arabic->utf8Glyphs($vendorUser->vendor->getTranslation("name", "ar"));

        $pdfPageWidth = 793.7008;
        $now = $approvedDateTime ? $approvedDateTime : now()->toDateTimeString();
        $dateString = $Arabic->utf8Glyphs('بتاريخ');
        $columnString = " : ";

        // Create the image
        $im = imagecreatetruecolor($pdfPageWidth, 60);

        // Create some colors
        $white = imagecolorallocate($im, 255, 255, 255);
        $black = imagecolorallocate($im, 0, 0, 0);
        imagefilledrectangle($im, 0, 0, $pdfPageWidth, 60, $white);

        // Add Left Text
        imagestring(
            $im,
            self::numberFontSize,
            self::pagePadding,
            self::numberYaxis,
            $now,
            $black
        );
        imagestring(
            $im,
            self::numberFontSize,
            self::pagePadding + self::spaceWidth + (strlen($now) * self::numberWidth),
            self::numberYaxis,
            $columnString,
            $black
        );
        imagettftext(
            $im,
            self::textFontSize,
            0,
            self::pagePadding + self::spaceWidth + (strlen($now) * self::numberWidth) + self::spaceWidth + (strlen($columnString) * self::textWidth),
            self::textYaxis,
            $black,
            $boldFont,
            $dateString
        );

        // Add Right Text
        imagettftext(
            $im,
            self::textFontSize,
            0,
            ($pdfPageWidth + self::rightPadding) - (self::pagePadding + (strlen($vendorSign) * self::textWidth)),
            self::textYaxis,
            $black,
            $boldFont,
            $vendorSign
        );
        imagestring(
            $im,
            self::numberFontSize,
            ($pdfPageWidth + self::rightPadding) - (self::pagePadding + (strlen($vendorSign) * self::textWidth) + (strlen($columnString) * self::textWidth) + self::spaceWidth),
            self::numberYaxis,
            $columnString,
            $black
        );
        imagettftext(
            $im,
            self::textFontSize,
            0,
            ($pdfPageWidth + self::rightPadding) - (self::pagePadding + (strlen($vendorSign) * self::textWidth) + (strlen($text) * self::textWidth) - self::spaceWidth + 3),
            self::textYaxis,
            $black,
            $font,
            $text
        );

        $signatureImagename = time() ."-". Str::random(8) .".png";
        // Using imagepng() results in clearer text compared with imagejpeg()
        imagepng($im, public_path($signatureImagename));
        imagedestroy($im);

        $fpdi = new Fpdi();

        $fileContent = file_get_contents($filePath);
        $count = $fpdi->setSourceFile(StreamReader::createByString($fileContent));

        for ($i=1; $i<=$count; $i++) {
            $template = $fpdi->importPage($i);
            $lastPageSize = $fpdi->getTemplateSize($template);
            $fpdi->AddPage($lastPageSize['orientation'], array($lastPageSize['width'], $lastPageSize['height']));
            $fpdi->useTemplate($template);
            $fpdi->Image(public_path("$signatureImagename"), 0, $lastPageSize['height'] - 15);
        }

        unlink(public_path("$signatureImagename"));

        return $fpdi->Output("S");
    }
}
