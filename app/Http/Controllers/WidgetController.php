<?php

namespace App\Http\Controllers;

use App\Http\Requests\WidgetRequest;
use App\Models\Review;
use App\Models\User;
use Intervention\Image\Facades\Image;

class WidgetController extends Controller
{

    public function __invoke(WidgetRequest $request, string $userId)
    {
        $user = User::active()->findOrFail($userId);
        $score = (float)Review::whereUserId($user->getKey())->published()->avg('score');
        $score = (int)round($score);

        $width = (int)($request->get('width') ?? 100);
        $height = (int)($request->get('height') ?? 100);
        $textColor = $request->get('text_color') ?? 'fff';
        $backgroundColor = $request->get('background_color') ?? '000';
        $x = (int)floor($width / 2);
        $y = (int)floor($height / 2);
        $fontSize = (int)ceil(($width + $height) / 7.9);

        $img = Image::canvas($width, $height, "#$backgroundColor");
        $img->text(
            "$score%",
            $x,
            $y,
            function ($font) use ($fontSize, $textColor) {
                $font->file(resource_path('fonts/arial.ttf'));
                $font->size($fontSize);
                $font->color("#$textColor");
                $font->align('center');
                $font->valign('center');
            }
        );

        return $img->response();
    }
}
