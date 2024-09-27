<?php


namespace App\Services;

use App\Models\OTP;
use Illuminate\Support\Facades\Validator;

class VerificationService
{
    public function __construct()
    {}

    public function createOtp($email): int
    {
        $otp = mt_rand(1279,9792);

        OTP::updateOrCreate(
            [],
            [
                'email' => $email,
                'value' => $otp,
                'expires_after' => (int)env('OTP_EXPIRES_AFTER'),
            ]
        );

        return $otp;
    }

    public function verifyOtp($otp, $email): array
    {
        $record = OTP::where('value', $otp)
        ->where('email', $email)->first();

        if(!$record){
            return [
                'status' => false,
                'message' => 'Invalid OTP!'
            ];
        }

        $now = strtotime(now());
        $created = strtotime($record->updated_at);

        // check if otp has expired
        $difference = ($now - $created)/60;

        // Expiration is in minutes
        if($difference >= $record->expires_after){
            $record->delete();
            return [
                'status' => false,
                'message' => 'OTP has expired!'
            ];
        }
        $record->delete();

        return [
            'status' => true,
            'message' => 'OTP is valid!'
        ];
    }
}
