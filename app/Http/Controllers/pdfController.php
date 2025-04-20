<?php

namespace App\Http\Controllers;

use App\Models\Shipping;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;

class pdfController extends Controller
{
    public function generatePdf(Request $request, $shipping)
    {
        $shipp = Shipping::with('shipping_cards', 'lead')->find($shipping);
        if (!$shipp) {
            return response()->json(['error' => 'Shipping not found'], 404);
        }
        $pdf = Pdf::loadView('app.pdf.shippingReceipt', ['shipp' => $shipp]);
        return $pdf->download('shippingReceipt.pdf');
    }
}
