<?php

namespace App\Contracts;

interface PaymentGatewayContract {
    public function charge($user, $request, $confirmation_number);
}
