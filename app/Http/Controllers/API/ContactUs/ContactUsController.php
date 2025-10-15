<?php

namespace App\Http\Controllers\API\ContactUs;

use App\Http\Controllers\Controller;
use App\Http\Resources\API\ContactUsResource;
use App\Http\Requests\Api\ContactUs\ContactUsRequest;
use App\Models\ContactUs;

class ContactUsController extends Controller
{
    public function store(ContactUsRequest $request)
    {
        $contactUs = ContactUs::create($request->validated());
        return apiSuccess(new ContactUsResource($contactUs),api('ContactUs added successfully'));
    }
}
