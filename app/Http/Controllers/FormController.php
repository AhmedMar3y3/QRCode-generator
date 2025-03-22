<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreFormRequest;
use App\Models\Form;
use App\Notifications\FormCreatedNotification;
use Endroid\QrCode\Builder\Builder;
use Endroid\QrCode\Encoding\Encoding;
use Endroid\QrCode\ErrorCorrectionLevel;
use Endroid\QrCode\Writer\PngWriter;
use Illuminate\Support\Facades\Notification;

class FormController extends Controller
{
    public function createForm(StoreFormRequest $request)
    {
        $form = Form::create($request->validated());

        $url = url('/forms/' . $form->id);
        $result = Builder::create()
            ->writer(new PngWriter())
            ->data($url)
            ->encoding(new Encoding('UTF-8'))
            ->errorCorrectionLevel(ErrorCorrectionLevel::High)
            ->size(200)
            ->margin(10)
            ->build();

        $qrCodeBase64 = base64_encode($result->getString());

        $form->qrcode = $qrCodeBase64;
        $form->save();

        Notification::route('mail', $form->email)
            ->notify(new FormCreatedNotification());

        return response()->json($form, 201);
    }

    public function getFormById($id)
    {
        $form = Form::findOrFail($id);
        return response()->json($form);
    }
}
