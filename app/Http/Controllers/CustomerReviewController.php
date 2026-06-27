<?php

namespace App\Http\Controllers;

use App\Models\CustomerReview;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;

class CustomerReviewController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $data = CustomerReview::orderBy('sort_order')->orderBy('id', 'desc')->get();

        return view('admin.customer_review.list', compact('data'));
    }

    public function create()
    {
        return view('admin.customer_review.create');
    }

    public function show($id)
    {
        $data = CustomerReview::findOrFail($id);

        return view('admin.customer_review.view', compact('data'));
    }

    public function store(Request $request)
    {
        $this->assertPhotoUploadIsValid($request);

        $validated = $request->validate([
            'customer_name' => 'required|string|max:255',
            'subtitle' => 'nullable|string|max:255',
            'rating' => 'required|numeric|min:1|max:5',
            'review_content' => 'required|string',
            'customer_photo' => 'nullable|file|image|mimes:jpeg,png,jpg,webp|max:2048',
            'is_active' => 'required|in:0,1',
            'sort_order' => 'nullable|integer|min:0',
        ], [
            'customer_photo.max' => 'Customer photo must not be larger than 2MB.',
            'customer_photo.image' => 'Customer photo must be a valid image file.',
        ]);

        $review = new CustomerReview();
        $review->customer_name = $validated['customer_name'];
        $review->subtitle = $validated['subtitle'] ?? null;
        $review->rating = $validated['rating'];
        $review->review_content = $validated['review_content'];
        $review->is_active = $validated['is_active'];
        $review->sort_order = $validated['sort_order'] ?? 0;

        if ($request->hasFile('customer_photo')) {
            try {
                $review->customer_photo = $this->storePhoto($request->file('customer_photo'));
            } catch (\Throwable $exception) {
                report($exception);

                throw ValidationException::withMessages([
                    'customer_photo' => 'Customer photo upload failed. Please try a JPG, PNG or WEBP under 2MB.',
                ]);
            }
        }

        $review->save();

        return redirect('customer_review/list')->with('success', 'Customer review created successfully.');
    }

    public function edit($id)
    {
        $data = CustomerReview::findOrFail($id);

        return view('admin.customer_review.edit', compact('data'));
    }

    public function update(Request $request)
    {
        $this->assertPhotoUploadIsValid($request);

        $validated = $request->validate([
            'id' => 'required|exists:customer_reviews,id',
            'customer_name' => 'required|string|max:255',
            'subtitle' => 'nullable|string|max:255',
            'rating' => 'required|numeric|min:1|max:5',
            'review_content' => 'required|string',
            'customer_photo' => 'nullable|file|image|mimes:jpeg,png,jpg,webp|max:2048',
            'is_active' => 'required|in:0,1',
            'sort_order' => 'nullable|integer|min:0',
        ], [
            'customer_photo.max' => 'Customer photo must not be larger than 2MB.',
            'customer_photo.image' => 'Customer photo must be a valid image file.',
        ]);

        $review = CustomerReview::findOrFail($validated['id']);
        $review->customer_name = $validated['customer_name'];
        $review->subtitle = $validated['subtitle'] ?? null;
        $review->rating = $validated['rating'];
        $review->review_content = $validated['review_content'];
        $review->is_active = $validated['is_active'];
        $review->sort_order = $validated['sort_order'] ?? 0;

        if ($request->hasFile('customer_photo')) {
            try {
                $review->customer_photo = $this->storePhoto($request->file('customer_photo'));
            } catch (\Throwable $exception) {
                report($exception);

                throw ValidationException::withMessages([
                    'customer_photo' => 'Customer photo upload failed. Please try a JPG, PNG or WEBP under 2MB.',
                ]);
            }
        }

        $review->save();

        return redirect('customer_review/edit/' . $review->id)->with('success', 'Customer review updated successfully.');
    }

    public function delete($id)
    {
        $review = CustomerReview::findOrFail($id);
        $review->delete();

        return redirect('customer_review/list')->with('success', 'Customer review deleted successfully.');
    }

    private function storePhoto($file): string
    {
        $directory = storage_path('uploads/customer_reviews');

        if (! is_dir($directory)) {
            mkdir($directory, 0755, true);
        }

        if (! is_writable($directory)) {
            throw new \RuntimeException('Upload folder is not writable.');
        }

        $extension = $file->getClientOriginalExtension() ?: $file->extension();
        $imageName = time() . '_' . Str::random(10) . '.' . $extension;
        $file->move($directory, $imageName);

        return $imageName;
    }

    private function assertPhotoUploadIsValid(Request $request): void
    {
        if (! empty($_FILES['customer_photo']['error'])) {
            $error = (int) $_FILES['customer_photo']['error'];

            if ($error === UPLOAD_ERR_INI_SIZE || $error === UPLOAD_ERR_FORM_SIZE) {
                throw ValidationException::withMessages([
                    'customer_photo' => 'Customer photo must not be larger than 2MB.',
                ]);
            }

            if ($error !== UPLOAD_ERR_OK && $error !== UPLOAD_ERR_NO_FILE) {
                throw ValidationException::withMessages([
                    'customer_photo' => 'Customer photo could not be uploaded. Please try again.',
                ]);
            }
        }
    }
}
