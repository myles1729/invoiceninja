<?php
/**
 * Invoice Ninja (https://invoiceninja.com)
 *
 * @link https://github.com/invoiceninja/invoiceninja source repository
 *
 * @copyright Copyright (c) 2020. Invoice Ninja LLC (https://invoiceninja.com)
 *
 * @license https://opensource.org/licenses/AAL
 */

namespace App\Transformers;

use App\Models\Activity;
use App\Models\Backup;
use App\Transformers\ActivityTransformer;
use App\Utils\Traits\MakesHash;

class InvoiceHistoryTransformer extends EntityTransformer
{
    use MakesHash;

    protected $defaultIncludes = [
        'activity'
    ];

    protected $availableIncludes = [
        'activity'
    ];

    public function transform(Backup $backup)
    {
        return [
            'id' => $this->encodePrimaryKey($backup->id),
            'activity_id' => $this->encodePrimaryKey($backup->activity_id),
            'json_backup' => (string) $backup->json_backup ?: '',
            'html_backup' => (string) $backup->html_backup ?: '',
            'created_at' => (int)$backup->created_at,
            'updated_at' => (int)$backup->updated_at,
        ];
    }

    public function includeActivity(Backup $backup)
    {
        $transformer = new ActivityTransformer($this->serializer);

        return $this->includeItem($backup->activity, $transformer, Activity::class);
    }
}
