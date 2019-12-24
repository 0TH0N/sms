<?php

function parseSMS(string $sms): array
{
    // Extract sum
    $sum = null;
    $found = preg_match_all(
        '/^(\D*)(\d{1,6}[.,]\d{2})(\D*)$/mu',
        $sms,
        $sum
    );
    if (!$found) {
        $found = preg_match_all(
            '/^(\D*)(\d{1,6})(\s?[рr].*)$/mui',
            $sms,
            $sum
        );
    }
    if (!$found) {
        throw new Exception('money sum was not found');
    }
    if (count($sum[0]) > 1) {
        throw new Exception("can't clearly distinguish the amount of money");
    }

    // cut found number from sms
    $sms = str_replace($sum[2][0], '', $sms);

    // Extract confirmation code
    $code = null;
    $found = preg_match_all('/^(\D*)(\d{4,6})(\D*)$/m', $sms, $code);
    if (!$found) {
        throw new Exception('verification code was not found');
    }
    if (count($code[0]) > 1) {
        throw new Exception("can't clearly distinguish the confirmation code");
    }

    // cut found number from sms
    $sms = str_replace($code[2][0], '', $sms);

    // Extract wallet
    $wallet = null;
    $found = preg_match_all('/\d{11,20}/m', $sms, $wallet);
    if (!$found) {
        throw new Exception('wallet number was not found');
    }
    if (count($wallet[0]) > 1) {
        throw new Exception("can't clearly distinguish the wallet");
    }

    $answer = [
        'code'   => $code[2][0],
        'sum'    => $sum[2][0],
        'wallet' => $wallet[0][0]
    ];

    return $answer;
}
