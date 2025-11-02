<?php

namespace App\Http\Controllers\API\Home;

use App\Http\Controllers\Controller;
use App\Http\Resources\API\ServiceResource;
use App\Http\Resources\API\SliderResource;
use App\Http\Resources\API\SucessStoryResource;

use App\Http\Resources\API\VideoResource;
use App\Models\Service;
use App\Models\Slider;
use App\Models\Video;
use App\Models\SucessStory;
use App\Models\AppointmentType;
use App\Http\Resources\API\AppointmentTypeResource;
use App\Http\Requests\Api\BookAppointmentRequest;
use App\Http\Resources\API\BookAppointmentResource;
use App\Models\BookAppointment;
use Illuminate\Http\Request;
use App\Http\Resources\API\WhyChooseUsResource;
use App\Models\WhyChooseUs;
use App\Models\CustomerRate;
use App\Http\Resources\API\CustomerRateResource;
use App\Http\Resources\API\HowWeWorkResource;
use App\Models\HowWeWork;
use App\Models\Article;
use App\Http\Resources\API\ArticleResource;
use App\Http\Resources\API\CategoryResource;
use App\Models\Category;
use App\Models\Address;
use App\Http\Resources\API\AddressResource;
use App\Http\Resources\API\ProductResource;
use App\Models\Product;
use App\Http\Resources\API\FAQResource;
use App\Models\FAQ;
use App\Models\RealResult;
use App\Http\Resources\API\RealResultResource;


class HomeController extends Controller
{
    public function home(Request $request)
    {
        $logo =  setting('logo');
        return apiSuccess([

            'settings' => [
                'logo' => $logo ? asset('storage/' . $logo) : null,
                'years_of_experience' => setting('years_of_experience'),
                'address' => setting('site_address')[app()->getLocale()] ?? '',
                'see_the_transformation' => [
                    'image_before' => setting('image_before') ? asset('storage/' . setting('image_before')) : null,
                    'image_after' => setting('image_after') ? asset('storage/' . setting('image_after')) : null,
                ],
                'contact' => [
                    'mobile' => setting('site_phone'),
                    'email' => setting('site_email'),
                    'whatsapp' => setting('site_whatsapp'),
                ],
                'social_media' => [
                    'facebook' => setting('social_facebook'),
                    'instagram' => setting('social_instagram'),
                    'twitter' => setting('social_twitter'),
                ],
                'legal_documents' => [
                    'privacy_policy' => setting('privacy_policy')[app()->getLocale()] ?? '',
                    'terms_conditions' => setting('terms_conditions')[app()->getLocale()] ?? '',
                    // 'faq' => setting('faq')[app()->getLocale()] ?? '',
                    'disclaimer' => setting('disclaimer')[app()->getLocale()] ?? '',
                ],
            ],
            'sliders' => SliderResource::collection(Slider::where('active', true)->get()),
            'top_products' => ProductResource::collection(Product::where('active', true)->featured()->latest()->take(15)->get()),
            'services' => ServiceResource::collection(Service::where('active', true)->get()),
            'videos' => VideoResource::collection(Video::where('active', true)->get()),
            'sucess_stories' => SucessStoryResource::collection(SucessStory::where('active', true)->get()),
            'faqs' => FAQResource::collection(FAQ::where('active', true)->get()),
            'real_results' => RealResultResource::collection(RealResult::with('products')->where('active', true)->get()),

            'about_office' => [
                'title' => setting('about_office.title.' . app()->getLocale()),
                'description' => setting('about_office.description.' . app()->getLocale()),
                'features' => collect(setting('about_office.features'))->pluck(app()->getLocale())->toArray(),

                'image' => asset('storage/' . setting('about_office.image')),
            ],
            'our_story' => [
                'title' => setting('our_story.title.' . app()->getLocale()),
                'description' => setting('our_story.description.' . app()->getLocale()),
                'image' => asset('storage/' . setting('our_story.image')),
            ],
            'why_choose_us' => WhyChooseUsResource::collection(WhyChooseUs::where('active', true)->get()),
            'customer_rates' => CustomerRateResource::collection(CustomerRate::where('active', true)->get()),
            'how_we_works' => HowWeWorkResource::collection(HowWeWork::where('active', true)->get()),
        ]);
    }
    public function categories(Request $request)
    {
        $categories = Category::where('active', true)->get();
        return apiSuccess(CategoryResource::collection($categories));
    }
    public function addresses(Request $request)
    {
        $addresses = Address::where('active', true)->get();
        return apiSuccess(AddressResource::collection($addresses));
    }
}
