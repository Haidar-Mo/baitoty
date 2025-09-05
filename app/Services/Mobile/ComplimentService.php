<?php

namespace App\Services\Mobile;

use App\Http\Requests\Mobile\ComplimentCreateRequest;
use App\Models\Compliment;
use App\Traits\FirebaseNotificationTrait;
use App\Traits\HasFiles;
use Arr;

/**
 * Class ComplimentService.
 */
class ComplimentService
{
    use HasFiles, FirebaseNotificationTrait;
    public function sendCompliment(ComplimentCreateRequest $request)
    {
        $data = $request->validated();

        if (Arr::hasAny($data, 'image')) {
            $data['image'] = $this->saveFile($request->image, 'compliment');
        }

        $data = request()->user()->compliment()->create($data);
        return $data;
    }
}
