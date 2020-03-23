<?php


namespace Bambamboole\LaravelCms\Options\Http\Resources;


use Illuminate\Http\Resources\Json\JsonResource;

class OptionResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param \Illuminate\Http\Request $request
     *
     * @return array
     */
    public function toArray($request)
    {
        return [
            'key' => $this->name,
            'value' => $this->slug,
        ];
    }
}
