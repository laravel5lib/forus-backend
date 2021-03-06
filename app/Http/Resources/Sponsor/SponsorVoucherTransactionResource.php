<?php

namespace App\Http\Resources\Sponsor;

use App\Http\Resources\ProductResource;
use App\Http\Resources\VoucherTransactionNoteResource;
use App\Models\VoucherTransaction;
use Illuminate\Http\Resources\Json\Resource;

class SponsorVoucherTransactionResource extends Resource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        /** @var VoucherTransaction $voucherTransaction */
        $voucherTransaction = $this->resource;

        return collect($voucherTransaction)->only([
            "id", "organization_id", "product_id", "created_at",
            "updated_at", "address", "state", "payment_id",
        ])->merge([
            'created_at_locale' => $voucherTransaction->created_at_locale,
            'updated_at_locale' => $voucherTransaction->updated_at_locale,
            'amount' => currency_format($voucherTransaction->amount),
            'timestamp' => $voucherTransaction->created_at->timestamp,
            "organization" => collect($voucherTransaction->provider)->only([
                "id", "name"
            ]),
            "product" => new ProductResource($voucherTransaction->product),
            "fund" => collect($voucherTransaction->voucher->fund)->only([
                "id", "name", "organization_id"
            ]),
            'notes' => VoucherTransactionNoteResource::collection(
                $voucherTransaction->notes->where('group', 'sponsor')->values()
            )
        ])->toArray();
    }
}
