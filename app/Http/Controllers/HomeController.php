<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Mail\AdminInquiryMail;
use App\Mail\UserInquiryConfirmationMail;
use App\Mail\NewsletterAdminMail;
use App\Mail\NewsletterUserMail;
use App\Models\Inquiry;
use App\schedule;
use App\newsletter;
use App\post;
use App\banner;
use Blog;
use App\imagetable;
use DB;
use Mail;
use View;
use Session;
use App\Http\Helpers\UserSystemInfoHelper;
use App\Http\Traits\HelperTrait;
use App\Models\Banner as ModelsBanner;
use App\Models\Product;
use App\Models\ProductImage;
use Auth;
use App\Profile;
use App\Page;
use Image;
use App\Models\Category;

class HomeController extends Controller
{
    use HelperTrait;

    public function __construct()
    {
        $logo = imagetable::select('img_path')
            ->where('table_name', '=', 'logo')
            ->first();

        $favicon = imagetable::select('img_path')
            ->where('table_name', '=', 'favicon')
            ->first();

        View()->share('logo', $logo);
        View()->share('favicon', $favicon);
    }


    public function index()
    {
        $banner = DB::table('banners')->where('status', 1)->first();
        $testinomial = DB::table('testimonial')->where('status', 1)->get();

        // Sare products load karo taake filter tabs sahi kaam karein
        $products = Product::with('primaryImage')
            ->where('status', 1)
            ->orderByDesc('id')
            ->get();

        $latestProduct = Product::with('primaryImage')
            ->where('status', 1)
            ->orderByDesc('id')
            ->first();

        $categories = DB::table('category')->where('status', 1)->get();
        $page = DB::table('pages')->where('id', '1')->first();
        $section = DB::table('sections')->where('page_id', '1')->get();



        return view('welcome', compact('banner', 'testinomial', 'products', 'categories', 'latestProduct', 'page', 'section'));
    }

    public function about()
    {
        return view('about');
    }

    public function blogDetail($id)
    {
        $blog = DB::class::table('blog')->where('id', $id)->first();
        return view('blog', compact('blog'));
    }

    public function books()
    {
        $categories = DB::table('category')->where('status', 1)->get();

        $products = Product::with('primaryImage')
            ->where('status', 1)
            ->orderByDesc('id')
            ->get();

        return view('books', compact('products', 'categories'));
    }

    public function bookDetail($slug)
    {
        $product = Product::with('primaryImage', 'galleryImages')
            ->where('slug', $slug)
            ->where('status', 1)
            ->firstOrFail();

        $formats = [];
        if ($product->paperback_price && $product->paperback_price > 0) {
            $formats[] = ['f' => 'Paperback', 'p' => (float) $product->paperback_price];
        }
        if ($product->ebook_price && $product->ebook_price > 0) {
            $formats[] = ['f' => 'eBook', 'p' => (float) $product->ebook_price];
        }
        if ($product->rustica_price && $product->rustica_price > 0) {
            $formats[] = ['f' => 'Rústica', 'p' => (float) $product->rustica_price];
        }
        if ($product->taschenbuch_price && $product->taschenbuch_price > 0) {
            $formats[] = ['f' => 'Taschenbuch', 'p' => (float) $product->taschenbuch_price];
        }
        if (empty($formats)) {
            $formats[] = ['f' => 'Paperback', 'p' => 0];
        }

        return view('books-detail', compact('product', 'formats'));
    }


    // ============================================
    // OTHER FUNCTIONS
    // ============================================

    public function bulkAndCourseOrders()
    {
        return view('bulk-and-course-orders');
    }

    public function contact()
    {
        return view('contact');
    }

    public function exopolitics()
    {
        $blogs = DB::table('blog')->where('status', 1)->orderByDesc('id')->get();
        return view('exopolitics', compact('blogs'));
    }

    public function foreignRights()
    {
        return view('foreign-rights');
    }

    public function returns()
    {
        return view('returns');
    }

    public function shippingAndDelivery()
    {
        return view('shipping-and-delivery');
    }

    public function careerSubmit(Request $request)
    {
        inquiry::create($request->all());
        return response()->json(['message' => 'Thank you for contacting us. We will get back to you asap', 'status' => true]);
    }

    public function newsletterSubmit(Request $request)
    {
        $request->validate([
            'newsletter_email' => 'required|email',
        ]);

        $email = trim($request->newsletter_email);
        $is_email = \App\Models\Newsletter::where('newsletter_email', $email)->count();
        if ($is_email == 0) {
            $newsletter = new \App\Models\Newsletter;
            $newsletter->newsletter_email = $email;
            $newsletter->save();

            $adminEmail = config('mail.admin_email') ?: (config('mail.from.address') ?: 'admin@alfredlambremontwebre.com');

            // Send confirmation email to subscriber
            try {
                Mail::to($email)->send(new NewsletterUserMail($email));
            } catch (\Exception $e) {
                \Log::error('Newsletter User Mail Error: ' . $e->getMessage());
            }

            // Send notification email to admin
            try {
                Mail::to($adminEmail)->send(new NewsletterAdminMail($email));
            } catch (\Exception $e) {
                \Log::error('Newsletter Admin Mail Error: ' . $e->getMessage());
            }

            return response()->json(['message' => 'Thank you! You have been subscribed successfully.', 'status' => true]);
        } else {
            return response()->json(['message' => 'This email is already subscribed.', 'status' => false]);
        }
    }

    public function updateContent(Request $request)
    {
        $id = $request->input('id');
        $keyword = $request->input('keyword');
        $htmlContent = $request->input('htmlContent');
        if ($keyword == 'page') {
            $update = DB::table('pages')
                ->where('id', $id)
                ->update(array('content' => $htmlContent));
            if ($update) {
                return response()->json(['message' => 'Content Updated Successfully', 'status' => true]);
            } else {
                return response()->json(['message' => 'Error Occurred', 'status' => false]);
            }
        } else if ($keyword == 'section') {
            $update = DB::table('section')
                ->where('id', $id)
                ->update(array('value' => $htmlContent));
            if ($update) {
                return response()->json(['message' => 'Content Updated Successfully', 'status' => true]);
            } else {
                return response()->json(['message' => 'Error Occurred', 'status' => false]);
            }
        }
    }

    public function store(Request $request)
    {
        $request->validate([
            'fname' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'notes' => 'required|string',
        ]);

        $inquiry = Inquiry::create([
            'form_name' => 'Contact',
            'fname' => $request->fname,
            'email' => $request->email,
            'notes' => $request->notes,
        ]);

        $adminEmail = config('mail.admin_email') ?: config('mail.from.address');

        try {
            if ($adminEmail) {
                Mail::to($adminEmail)->send(new AdminInquiryMail($inquiry));
            }
        } catch (\Throwable $e) {
            \Log::error('Contact Admin Mail Error: ' . $e->getMessage());
        }

        try {
            Mail::to($inquiry->email)->send(new UserInquiryConfirmationMail($inquiry));
        } catch (\Throwable $e) {
            \Log::error('Contact User Mail Error: ' . $e->getMessage());
        }

        // Yeh change karein - 'message' ki jagah 'success' use karein
        return back()->with('success', 'Thank you! Your message has been sent successfully.');
    }
}
