<?php

namespace App\Http\Controllers;

use App\Http\Requests\WidgetRequest;
use App\Models\User;
use Intervention\Image\Facades\Image;

class WidgetController extends Controller
{
    public function __invoke(WidgetRequest $request, User $user)
    {
        $image = Image::canvas($request->width(), $request->height(), $request->backgroundColor());
        $image->text(
            round($user->getAvgScore()) . '%',
            (int)floor($request->width() / 2),
            (int)floor($request->height() / 2),
            function ($font) use ($request) {
                $font->file(resource_path('fonts/arial.ttf'));
                $fontSize = (int)ceil(($request->width() + $request->height()) / 7.9);
                $font->size($fontSize);
                $font->color($request->textColor());
                $font->align('center');
                $font->valign('center');
            }
        );

        return $image->response('png', 100);
    }
}
