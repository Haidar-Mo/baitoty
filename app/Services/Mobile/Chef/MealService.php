<?php

namespace App\Services\Mobile\Chef;

use App\Enums\MediaPathsEnum;
use App\Models\Media;
use App\Traits\HasFiles;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

/**
 * Class MealService.
 */
class MealService
{

    use HasFiles;

    public function create(FormRequest $request)
    {
        $data = $request->validated();

        return DB::transaction(function () use ($data) {

            $meal = auth()->user()->kitchen->meal()->create($data);
            if ($data['attribute']) {
                foreach ($data['attribute'] as $attribute) {
                    $meal->attribute()->create(['name' => $attribute]);
                }
            }
            if ($data['image']) {
                foreach ($data['image'] as $image) {
                    $path = $this->saveFile($image, MediaPathsEnum::MEAL->value);
                    $meal->media()->create(['path' => $path]);
                }
            }

            return $meal->load(['attribute', 'media']);
        });
    }

    public function update(FormRequest $request, string $mealId)
    {
        $data = $request->validated();
        //: check if the meal belongs to the auth user
        $meal = auth()->user()->kitchen()->first()->meal()->find($mealId);
        if (!$meal)
            throw new \Exception('Can`t add Image to this meal', 400);

        DB::transaction(function () use ($meal, $data) {
            return $meal->update($data);
        });
        return $meal->load(['attribute', 'media']);
    }


    public function addImage(Request $request, string $mealId)
    {
        $request->validate([
            'image' => 'image|required'
        ]);

        //: check if the meal belongs to the auth user
        $meal = auth()->user()->kitchen()->first()->meal()->find($mealId);
        if (!$meal)
            throw new \Exception('Can`t add Image to this meal', 400);

        //: Save the image and create a media record
        $path = $this->saveFile($request->image, MediaPathsEnum::MEAL->value);
        $meal->media()->create([
            'path' => $path
        ]);

        return $meal->load(['attribute', 'media']);
    }

    public function removeImage(string $imageId, string $mealId)
    {
        $image = Media::find($imageId);

        //:Check if the meal belongs to the auth user
        $meal = auth()->user()->kitchen()->first()->meal()->find($mealId);
        if (!$meal)
            throw new \Exception('Can`t remove the Image from this meal', 400);

        //:Check if the Image belongs to the meal
        $imageArray = $meal->media()->get()->pluck('id')->toArray();
        if (!in_array($imageId, $imageArray))
            throw new \Exception('Can`t remove the Image from this meal', 400);

        $this->deleteFile($image->path);
        $image->delete();

        return $meal->load(['attribute', 'media']);

    }

    public function changeAvailability(string $id)
    {
        $meal = auth()->user()->kitchen()->first()->meal()->findOrFail($id);
        return DB::transaction(function () use ($meal) {

            $meal->update([
                'is_available' => !$meal->is_available
            ]);
            return $meal->load(['attribute', 'media']);
        });
    }

    public function changeDiscountValue(Request $request, string $mealId)
    {
        //:Check if the meal belongs to the auth user
        $meal = auth()->user()->kitchen()->first()->meal()->find($mealId);
        if (!$meal)
            throw new \Exception('Can`t edit this meal', 400);
        $data = $request->validate([
            'new_price' => 'required|numeric'
        ]);

        $data['new_price'] = $data['new_price'] == 0 ? null : $data['new_price'];

        return DB::transaction(function () use ($meal, $data) {
            $meal->update([
                'new_price' => $data['new_price']
            ]);
            return $meal->load(['attribute', 'media']);
        });
    }

    public function delete(string $id)
    {
        $meal = auth()->user()
            ->kitchen()->first()
            ->meal()->findOrFail($id);
        return DB::transaction(function () use ($meal) {
            foreach ($meal->media as $media) {
                $this->deleteFile($media->path);
            }
            $meal->delete();
        });
    }
}
