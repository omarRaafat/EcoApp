<?php
namespace App\Services\Order;

use App\Models\Order;
use SimpleSoftwareIO\QrCode\Facades\QrCode;

class ZakatQrCode {
    public function __construct(
        private Order $order
    ) {}

    public function getQrCode() : string {
        $taxNumber = $this->order->vendor->tax_num;
        $created_at = $this->order->created_at->format('Y-m-d\TH:i:s');
        $totalAmount = $this->order->total;
        $taxAmount = $this->order->vat;

        $vendorName = $this->order->vendor->getTranslation("name", "ar");

        $qrData = chr(1);
        $qrData .= chr(strlen($vendorName));
        $qrData .= $vendorName;
        $qrData .= chr(2);
        $qrData .= chr(strlen("$taxNumber"));
        $qrData .= "$taxNumber";
        $qrData .= chr(3);
        $qrData .= chr(strlen("$created_at"));
        $qrData .= "$created_at";
        $qrData .= chr(4);
        $qrData .= chr(strlen(round($totalAmount, 2)));
        $qrData .= round($totalAmount, 2);
        $qrData .= chr(5);
        $qrData .= chr(strlen(round($taxAmount, 2)));
        $qrData .= round($taxAmount, 2);

        $qrData = base64_encode($qrData);

        $qrCode = QrCode::encoding('UTF-8')->format('svg')->size(125)->generate($qrData);

        return $qrCode;
    }
}
