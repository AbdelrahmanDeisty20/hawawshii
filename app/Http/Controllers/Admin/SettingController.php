<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Setting;
use App\Models\DeliveryArea;
use App\Models\Review;
use App\Models\Feature;
use App\Models\Step;
use App\Models\Faq;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class SettingController extends Controller
{
    // ... (كل الفنكشنز السابقة موجودة) ...

    public function index() { $settings = Setting::pluck('value', 'key'); return view('admin.settings', compact('settings')); }
    public function updateSettings(Request $request) {
        foreach ($request->except('_token') as $key => $value) { Setting::updateOrCreate(['key' => $key], ['value' => $value]); }
        return back()->with('success', 'تم حفظ التغييرات');
    }

    public function features() { $features = Feature::all(); return view('admin.features', compact('features')); }
    public function storeFeature(Request $request) {
        $data = $request->all();
        if ($request->hasFile('image')) { $data['image'] = $request->file('image')->store('features', 'public'); }
        Feature::create($data); return back()->with('success', 'تمت الإضافة');
    }
    public function deleteFeature(Feature $feature) {
        if ($feature->image) { Storage::disk('public')->delete($feature->image); }
        $feature->delete(); return back()->with('success', 'تم الحذف');
    }

    public function areas() { $areas = DeliveryArea::all(); return view('admin.areas', compact('areas')); }
    public function storeArea(Request $request) { DeliveryArea::create($request->all()); return back()->with('success', 'تمت الإضافة'); }
    public function deleteArea(DeliveryArea $area) { $area->delete(); return back()->with('success', 'تم الحذف'); }

    public function steps() { $steps = Step::orderBy('order')->get(); return view('admin.steps', compact('steps')); }
    public function storeStep(Request $request) {
        $data = $request->all();
        if ($request->hasFile('image')) { $data['image'] = $request->file('image')->store('steps', 'public'); }
        Step::create($data); return back()->with('success', 'تمت الإضافة');
    }
    public function deleteStep(Step $step) {
        if ($step->image) { Storage::disk('public')->delete($step->image); }
        $step->delete(); return back()->with('success', 'تم الحذف');
    }

    public function reviews() { $reviews = Review::latest()->get(); return view('admin.reviews', compact('reviews')); }
    public function storeReview(Request $request) {
        $data = $request->all();
        if ($request->hasFile('image')) { $data['image'] = $request->file('image')->store('reviews', 'public'); }
        Review::create($data); return back()->with('success', 'تمت الإضافة');
    }
    public function deleteReview(Review $review) {
        if ($review->image) { Storage::disk('public')->delete($review->image); }
        $review->delete(); return back()->with('success', 'تم الحذف');
    }

    public function pixels() { $settings = Setting::pluck('value', 'key'); return view('admin.pixels', compact('settings')); }

    // إدارة الأسئلة الشائعة (FAQs)
    public function faqs()
    {
        $faqs = Faq::orderBy('order')->get();
        return view('admin.faqs', compact('faqs'));
    }

    public function storeFaq(Request $request)
    {
        Faq::create($request->all());
        return back()->with('success', 'تم إضافة السؤال');
    }

    public function deleteFaq(Faq $faq)
    {
        $faq->delete();
        return back()->with('success', 'تم حذف السؤال');
    }
}
