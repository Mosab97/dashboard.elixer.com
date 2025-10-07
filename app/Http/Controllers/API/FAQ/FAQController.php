<?php

namespace App\Http\Controllers\API\FAQ;

use App\Http\Controllers\Controller;
use App\Http\Resources\API\FAQResource;
use App\Models\FAQ;
use Illuminate\Http\Request;
use App\Http\Resources\API\PaginatedResourceCollection;

class FAQController extends Controller
{
    public function index(Request $request)
    {
        $faqs = FAQ::where('active', true)->latest()
            ->paginate(10);
        return apiSuccess(new PaginatedResourceCollection($faqs, FAQResource::class));

        return apiSuccess(FAQResource::collection($faqs));
    }

    public function show(FAQ $faq)
    {
        return apiSuccess(new FAQResource($faq));
    }
}
