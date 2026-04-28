<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\Models\PenggajianModel;

class MidtransWebhookController extends Controller
{
    public function handleIris(Request $request)
    {
        // Midtrans IRIS webhook payload
        $payload = $request->all();

        Log::info('Midtrans IRIS Webhook Received', $payload);

        // Contoh struktur response IRIS webhook:
        // {
        //   "reference_no": "PAY-123",
        //   "status": "processed", // or "rejected", "failed"
        //   "amount": "10000.00"
        // }

        $referenceNo = $payload['reference_no'] ?? null;
        $status = $payload['status'] ?? null;

        if (!$referenceNo || !$status) {
            return response()->json(['status' => 'ignored']);
        }

        $penggajian = PenggajianModel::where('midtrans_reference_no', $referenceNo)->first();

        if (!$penggajian) {
            return response()->json(['status' => 'not_found'], 404);
        }

        $penggajian->midtrans_status = $status;

        if ($status === 'processed' || $status === 'completed') {
            $penggajian->status_pembayaran = 'lunas';
        } elseif ($status === 'failed' || $status === 'rejected') {
            $penggajian->status_pembayaran = 'tertunda';
        }

        $penggajian->save();

        return response()->json(['status' => 'success']);
    }

    public function simulateWebhook(Request $request)
    {
        $referenceNo = $request->input('reference_no');

        if (!$referenceNo) {
            return redirect()->back()->with('error', 'Reference Number tidak ditemukan.');
        }

        // Simulasi hit endpoint Webhook
        $request = Request::create('/midtrans/iris-webhook', 'POST', [
            'reference_no' => $referenceNo,
            'status' => 'processed',
            'amount' => 0 // Mock amount
        ]);
        
        $response = app()->handle($request);

        return redirect()->back()->with('success', 'Simulasi Webhook berhasil. Status telah menjadi Lunas.');
    }
}
