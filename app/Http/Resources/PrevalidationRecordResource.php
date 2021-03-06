<?php

namespace App\Http\Resources;

use App\Models\PrevalidationRecord;
use Illuminate\Http\Resources\Json\Resource;

/**
 * Class PrevalidationRecordResource
 * @property PrevalidationRecord $resource
 * @package App\Http\Resources
 */
class PrevalidationRecordResource extends Resource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return collect($this->resource)->only([
            'id', 'record_type_id', 'value'
        ])->merge([
            'key' => $this->resource->record_type->key,
            'name' => $this->resource->record_type->name,
        ])->toArray();
    }
}
