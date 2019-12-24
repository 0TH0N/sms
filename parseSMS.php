<?php

function parseSMS(string $sms): array
{
    // Extract sum
    $sum = null;
    $found = preg_match_all(
        '/^(\D*)(\d{1,6}[\.\,]?\d{0,2})(\s?[рr].*)$/uim',
        $sms,
        $sum
    );
    if (!$found) {
        throw new Exception('money sum was not found');
    }
    if (count($sum[0]) > 1) {
        throw new Exception("can't clearly distinguish the amount of money");
    }

    $sms = str_replace($sum[2][0], '', $sms);

    // Extract confirmation code
    $code = null;
    $found = preg_match_all('/^(\D*)(\d{4,6})(\D*)$/mu', $sms, $code);
    if (!$found) {
        throw new Exception('verification code was not found');
    }
    if (count($code[0]) > 1) {
        throw new Exception("can't clearly distinguish the confirmation code");
    }

    $sms = str_replace($code[2][0], '', $sms);

    // Extract wallet
    $wallet = null;
    $found = preg_match_all('/\d{11,20}/', $sms, $wallet);
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

$sms = 'd 1913 к
Перевод на счет 410017801376228
cevv 1000,51r Спишется ';
$answer = parseSMS($sms);
print_r($answer);

