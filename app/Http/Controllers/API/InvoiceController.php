<?php

namespace App\Http\Controllers\API;

use App\Models\Order;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class InvoiceController extends Controller
{
    public function preview(Request $request, Order $order)
    {
        $order = $order->load(['country','city','items.product']);
            //->where('orders.id',$order->id)
            //->select(['orders.*'])->first();

        //return $order;

        $pdf = Pdf::loadView('invoices.template', [
            'order' => $order,
            'invoiceNumber' => 'INV-' . str_pad($order->id, 6, '0', STR_PAD_LEFT),
            'invoiceDate' => now()->format('F d, Y'),
        ]);

        return $pdf->stream('invoice-' . $order->id . '.pdf');
    }
}