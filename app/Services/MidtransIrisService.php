<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class MidtransIrisService
{
    protected $serverKey;
    protected $isProduction;
    protected $baseUrl;

    public function __construct()
    {
        // Secara default menggunakan environment variabel atau fallback ke dummy untuk sandbox
        $this->serverKey = env('MIDTRANS_SERVER_KEY', 'SB-Mid-server-YOUR_DUMMY_KEY');
        $this->isProduction = env('MIDTRANS_IS_PRODUCTION', false);
        $this->baseUrl = $this->isProduction 
            ? 'https://app.midtrans.com/iris/api/v1' 
            : 'https://app.sandbox.midtrans.com/iris/api/v1';
    }

    /**
     * Membuat request Disbursement (Payout) ke Midtrans IRIS
     */
    public function createPayout($referenceNo, $amount, $bankAccountName, $bankAccountNo, $bankName, $email)
    {
        $isMock = env('MIDTRANS_MOCK_MODE', true);

        if ($isMock) {
            Log::info("MOCK Midtrans Payout Created: {$referenceNo}");
            return [
                'success' => true,
                'data' => [
                    'reference_no' => $referenceNo,
                    'status' => 'queued'
                ]
            ];
        }

        try {
            $response = Http::withBasicAuth($this->serverKey, '')
                ->withHeaders([
                    'Accept' => 'application/json',
                    'Content-Type' => 'application/json',
                ])
                ->post("{$this->baseUrl}/payouts", [
                    'payouts' => [
                        [
                            'beneficiary_name' => $bankAccountName,
                            'beneficiary_account' => $bankAccountNo,
                            'beneficiary_bank' => $bankName,
                            'beneficiary_email' => $email,
                            'amount' => (string) $amount,
                            'notes' => "Pembayaran Gaji Ref: {$referenceNo}",
                        ]
                    ]
                ]);

            if ($response->successful()) {
                return [
                    'success' => true,
                    'data' => $response->json(),
                ];
            }

            Log::error('Midtrans IRIS Payout Error', [
                'status' => $response->status(),
                'response' => $response->json(),
            ]);

            return [
                'success' => false,
                'message' => $response->json('errors') ?? 'Terjadi kesalahan saat memanggil API Midtrans',
                'data' => $response->json()
            ];

        } catch (\Exception $e) {
            Log::error('Midtrans IRIS Exception: ' . $e->getMessage());
            return [
                'success' => false,
                'message' => $e->getMessage(),
            ];
        }
    }

    /**
     * Mengecek status transaksi Payout
     */
    public function checkPayoutStatus($referenceNo)
    {
        try {
            $response = Http::withBasicAuth($this->serverKey, '')
                ->withHeaders([
                    'Accept' => 'application/json',
                ])
                ->get("{$this->baseUrl}/payouts/{$referenceNo}");

            if ($response->successful()) {
                return [
                    'success' => true,
                    'data' => $response->json(),
                ];
            }

            return [
                'success' => false,
                'message' => 'Gagal mengecek status payout',
            ];

        } catch (\Exception $e) {
            return [
                'success' => false,
                'message' => $e->getMessage(),
            ];
        }
    }
}
