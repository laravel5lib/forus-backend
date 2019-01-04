<?php

namespace App\Http\Resources;

use App\Models\Organization;
use Gate;
use Illuminate\Http\Resources\Json\Resource;

class OrganizationResource extends Resource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        /** @var Organization $organization */
        $organization = $this->resource;

        $ownerData = [];

        if (Gate::allows('organizations.update', $organization)) {
            $ownerData = collect($organization)->only([
                'iban', 'btw', 'website', 'phone', 'email', 'email_public',
                'phone_public', 'website_public'
            ])->toArray();
        }

        return collect($organization)->only([
            'id', 'identity_address', 'name', 'kvk',
            $organization->email_public ? 'email': '',
            $organization->phone_public ? 'phone': '',
            $organization->website_public ? 'website': ''
        ])->merge([
            'permissions' => $organization->identityPermissions(
                auth()->id()
            )->pluck('key'),
            'logo' => new MediaResource($organization->logo),
            'product_categories' => ProductCategoryResource::collection(
                $organization->product_categories
            )
        ])->merge($ownerData)->toArray();
    }
}
