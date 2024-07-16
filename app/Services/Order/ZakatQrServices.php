<?php
namespace App\Services\Order;

use App\Models\OrderService;
use SimpleSoftwareIO\QrCode\Facades\QrCode;

class ZakatQrServices{
    public function __construct(
        private OrderService $orderService
    ) {}

    public function getQrCode() : string {
        $taxNumber = $this->orderService->vendor?->tax_num;
        $created_at = $this->orderService->created_at->format('Y-m-d\TH:i:s');
        $totalAmount = $this->orderService->total;
        $taxAmount = $this->orderService->vat;

        $vendorName = $this->orderService->vendor?->getTranslation("name", "ar");

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
