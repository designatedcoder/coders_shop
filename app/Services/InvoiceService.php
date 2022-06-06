<?php

namespace App\Services;

use LaravelDaily\Invoices\Classes\Party;
use LaravelDaily\Invoices\Facades\Invoice;
use LaravelDaily\Invoices\Classes\InvoiceItem;

class InvoiceService {

    public function createInvoice($order) {
        $client = new Party([
            'name'          => 'Coder\'s Shop',
        ]);

        $customer = new Party([
            'name'          => $order->billing_name,
            'address'       => $order->billing_address.' | '.$order->billing_city.', '.$order->billing_state.' '.$order->billing_zip_code,
            'custom_fields' => [
                'email' => $order->billing_email,
            ],
        ]);

        foreach($order->products as $product) {
            $items[] = (new InvoiceItem())->title($product->name)->description($product->description)->pricePerUnit($product->price/100)->quantity($product->pivot->quantity);
        }

        $invoice = Invoice::make()
        // ability to include translated invoice status
        // in case it was paid
            ->seller($client)
            ->buyer($customer)
            ->series('Coder\'s Shop')
            ->serialNumberFormat('{SEQUENCE}/{SERIES}')
            ->filename('Coders_Shop_'. ''. $order->confirmation_number)
            ->totalDiscount($order->billing_discount/100)
            ->taxRate(config('cart.tax'))
            ->shipping(0)
            ->addItems($items);
            // ->logo(public_path('vendor/invoices/sample-logo.png'))
            // You can additionally save generated invoice to configured disk

        // Then send email to party with link

        // And return invoice itself to browser or have a different view
        return $invoice;
    }
}
