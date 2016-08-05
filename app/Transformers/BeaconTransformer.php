<?php

namespace App\Transformers;
use App\Beacon;
use League\Fractal\TransformerAbstract;

class UserTransformer extends TransformerAbstract
{

    /**
     * Turn this item object into a generic array
     *
     * @param Beacon $beacon
     * @return array
     */
    public function beaconTransformer(Beacon $beacon)
    {
        return [
            'id'              => (int) $beacon->id,
            'name'            => $beacon->name,
            'belief'          => $beacon->belief,
            'beacon_tag'      => $beacon->beacon_tag,
            'guide'           => $beacon->guide,
            'tag_usage'       => $beacon->tag_usage,
            'tag_views'       => $beacon->tag_views,
            'total_tag_usage' => $beacon->total_tag_usage,
            ];
    }

}