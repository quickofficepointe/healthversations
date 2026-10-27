<?php

namespace App\Http\Controllers;

use App\Models\ConsultTestimonial;
use App\Models\TestimonialMeasurement;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ConsultTestimonialController extends Controller
{
    /**
     * ADMIN: Display a listing of testimonials in datatable
     */
    public function index()
    {
        $testimonials = ConsultTestimonial::with('measurements')
            ->latest()
            ->get();

        return view('healthversations.admin.consultation.index', compact('testimonials'));
    }

    /**
     * PUBLIC: Display testimonials for website
     */
    public function publicIndex()
    {
        $testimonials = ConsultTestimonial::with('measurements')
            ->public()
            ->verified()
            ->imagesApproved()
            ->featured()
            ->orderBy('sort_order', 'asc')
            ->orderBy('created_at', 'desc')
            ->get();

        // Group by program type for filtering
        $programTypes = ConsultTestimonial::public()
            ->verified()
            ->imagesApproved()
            ->distinct()
            ->pluck('program_type')
            ->filter()
            ->values();

        return view('frontendviews.consultation.publicindex', compact('testimonials', 'programTypes'));
    }

    /**
     * ADMIN: Show testimonial for view modal
     */
    public function show(ConsultTestimonial $consultTestimonial)
    {
        // Load relationships
        $consultTestimonial->load('measurements');

        // Return JSON for AJAX requests (modal)
        if (request()->expectsJson()) {
            return response()->json([
                'success' => true,
                'testimonial' => $consultTestimonial
            ]);
        }

        // For public viewing (if needed)
        if (!$consultTestimonial->is_eligible_for_display) {
            abort(404);
        }

        $relatedTestimonials = ConsultTestimonial::with('measurements')
            ->public()
            ->verified()
            ->imagesApproved()
            ->where('id', '!=', $consultTestimonial->id)
            ->where('program_type', $consultTestimonial->program_type)
            ->inRandomOrder()
            ->limit(3)
            ->get();

        return view('frontendviews.consultation.show', compact('consultTestimonial', 'relatedTestimonials'));
    }

    /**
     * ADMIN: Get testimonial data for editing
     */
    public function edit(ConsultTestimonial $consultTestimonial)
    {
        // Load relationships
        $consultTestimonial->load('measurements');

        return response()->json([
            'success' => true,
            'testimonial' => $consultTestimonial
        ]);
    }

    /**
     * ADMIN: Store a newly created testimonial
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'client_name' => 'required|string|max:255',
            'client_location' => 'nullable|string|max:255',
            'client_age' => 'nullable|integer|min:1|max:120',
            'client_occupation' => 'nullable|string|max:255',
            'program_type' => 'required|string|max:255',
            'program_duration_weeks' => 'nullable|integer|min:1',
            'weight_loss_kg' => 'nullable|numeric|min:0',
            'weight_gain_kg' => 'nullable|numeric|min:0',
            'inches_lost' => 'nullable|numeric|min:0',
            'before_image' => 'required|image|mimes:jpeg,png,jpg,gif|max:5120',
            'after_image' => 'required|image|mimes:jpeg,png,jpg,gif|max:5120',
            'testimonial_text' => 'required|string',
            'challenges_overcome' => 'nullable|string',
            'key_achievements' => 'nullable|string',
            'rating' => 'required|integer|min:1|max:5',
            'social_media_handle' => 'nullable|string|max:255',
            'featured' => 'boolean',
            'is_verified' => 'boolean',
            'is_public' => 'boolean',
            'measurements' => 'nullable|array',
            'measurements.*.type' => 'required|string',
            'measurements.*.before_value' => 'required|numeric',
            'measurements.*.after_value' => 'required|numeric',
            'measurements.*.unit' => 'required|string',
        ]);

        try {
            // Handle file uploads
            if ($request->hasFile('before_image')) {
                $validated['before_image'] = $request->file('before_image')->store('testimonials/before', 'public');
            }

            if ($request->hasFile('after_image')) {
                $validated['after_image'] = $request->file('after_image')->store('testimonials/after', 'public');
            }

            // Auto-approve images for admin-created testimonials
            $validated['images_approved'] = true;

            // Set default values for checkboxes
            $validated['featured'] = $request->has('featured') ? 1 : 0;
            $validated['is_verified'] = $request->has('is_verified') ? 1 : 0;
            $validated['is_public'] = $request->has('is_public') ? 1 : 0;

            // Create testimonial
            $testimonial = ConsultTestimonial::create($validated);

            // Create measurements if provided
            if ($request->has('measurements')) {
                foreach ($request->measurements as $measurementData) {
                    TestimonialMeasurement::create([
                        'testimonial_id' => $testimonial->id,
                        'measurement_type' => $measurementData['type'],
                        'before_value' => $measurementData['before_value'],
                        'after_value' => $measurementData['after_value'],
                        'unit' => $measurementData['unit'],
                    ]);
                }
            }

            return response()->json([
                'success' => true,
                'message' => 'Testimonial created successfully!',
                'testimonial' => $testimonial->load('measurements')
            ]);

        } catch (\Exception $e) {
            // Clean up uploaded files if creation fails
            if (isset($validated['before_image']) && Storage::disk('public')->exists($validated['before_image'])) {
                Storage::disk('public')->delete($validated['before_image']);
            }
            if (isset($validated['after_image']) && Storage::disk('public')->exists($validated['after_image'])) {
                Storage::disk('public')->delete($validated['after_image']);
            }

            return response()->json([
                'success' => false,
                'message' => 'Error creating testimonial: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * ADMIN: Update the specified testimonial
     */
    public function update(Request $request, ConsultTestimonial $consultTestimonial)
    {
        $validated = $request->validate([
            'client_name' => 'required|string|max:255',
            'client_location' => 'nullable|string|max:255',
            'client_age' => 'nullable|integer|min:1|max:120',
            'client_occupation' => 'nullable|string|max:255',
            'program_type' => 'required|string|max:255',
            'program_duration_weeks' => 'nullable|integer|min:1',
            'weight_loss_kg' => 'nullable|numeric|min:0',
            'weight_gain_kg' => 'nullable|numeric|min:0',
            'inches_lost' => 'nullable|numeric|min:0',
            'before_image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:5120',
            'after_image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:5120',
            'testimonial_text' => 'required|string',
            'challenges_overcome' => 'nullable|string',
            'key_achievements' => 'nullable|string',
            'rating' => 'required|integer|min:1|max:5',
            'social_media_handle' => 'nullable|string|max:255',
            'featured' => 'boolean',
            'is_verified' => 'boolean',
            'is_public' => 'boolean',
            'images_approved' => 'boolean',
            'measurements' => 'nullable|array',
            'measurements.*.id' => 'nullable|exists:testimonial_measurements,id',
            'measurements.*.type' => 'required|string',
            'measurements.*.before_value' => 'required|numeric',
            'measurements.*.after_value' => 'required|numeric',
            'measurements.*.unit' => 'required|string',
        ]);

        try {
            // Handle file uploads
            $oldBeforeImage = null;
            $oldAfterImage = null;

            if ($request->hasFile('before_image')) {
                $oldBeforeImage = $consultTestimonial->before_image;
                $validated['before_image'] = $request->file('before_image')->store('testimonials/before', 'public');
            }

            if ($request->hasFile('after_image')) {
                $oldAfterImage = $consultTestimonial->after_image;
                $validated['after_image'] = $request->file('after_image')->store('testimonials/after', 'public');
            }

            // Set checkbox values
            $validated['featured'] = $request->has('featured') ? 1 : 0;
            $validated['is_verified'] = $request->has('is_verified') ? 1 : 0;
            $validated['is_public'] = $request->has('is_public') ? 1 : 0;
            $validated['images_approved'] = $request->has('images_approved') ? 1 : 0;

            // Update testimonial
            $consultTestimonial->update($validated);

            // Update or create measurements
            if ($request->has('measurements')) {
                $existingMeasurementIds = [];

                foreach ($request->measurements as $measurementData) {
                    if (isset($measurementData['id'])) {
                        // Update existing measurement
                        $measurement = TestimonialMeasurement::where('id', $measurementData['id'])
                            ->where('testimonial_id', $consultTestimonial->id)
                            ->first();

                        if ($measurement) {
                            $measurement->update([
                                'measurement_type' => $measurementData['type'],
                                'before_value' => $measurementData['before_value'],
                                'after_value' => $measurementData['after_value'],
                                'unit' => $measurementData['unit'],
                            ]);
                            $existingMeasurementIds[] = $measurement->id;
                        }
                    } else {
                        // Create new measurement
                        $measurement = TestimonialMeasurement::create([
                            'testimonial_id' => $consultTestimonial->id,
                            'measurement_type' => $measurementData['type'],
                            'before_value' => $measurementData['before_value'],
                            'after_value' => $measurementData['after_value'],
                            'unit' => $measurementData['unit'],
                        ]);
                        $existingMeasurementIds[] = $measurement->id;
                    }
                }

                // Delete measurements that were removed
                TestimonialMeasurement::where('testimonial_id', $consultTestimonial->id)
                    ->whereNotIn('id', $existingMeasurementIds)
                    ->delete();
            } else {
                // If no measurements provided, delete all existing ones
                TestimonialMeasurement::where('testimonial_id', $consultTestimonial->id)->delete();
            }

            // Clean up old images
            if ($oldBeforeImage && Storage::disk('public')->exists($oldBeforeImage)) {
                Storage::disk('public')->delete($oldBeforeImage);
            }
            if ($oldAfterImage && Storage::disk('public')->exists($oldAfterImage)) {
                Storage::disk('public')->delete($oldAfterImage);
            }

            return response()->json([
                'success' => true,
                'message' => 'Testimonial updated successfully!',
                'testimonial' => $consultTestimonial->fresh('measurements')
            ]);

        } catch (\Exception $e) {
            // Clean up new uploaded files if update fails
            if (isset($validated['before_image']) && Storage::disk('public')->exists($validated['before_image'])) {
                Storage::disk('public')->delete($validated['before_image']);
            }
            if (isset($validated['after_image']) && Storage::disk('public')->exists($validated['after_image'])) {
                Storage::disk('public')->delete($validated['after_image']);
            }

            return response()->json([
                'success' => false,
                'message' => 'Error updating testimonial: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * ADMIN: Remove the specified testimonial
     */
    public function destroy(ConsultTestimonial $consultTestimonial)
    {
        try {
            // Store image paths for deletion
            $beforeImage = $consultTestimonial->before_image;
            $afterImage = $consultTestimonial->after_image;

            // Delete the testimonial (measurements will cascade delete if foreign key is set up)
            $consultTestimonial->delete();

            // Delete associated images
            if ($beforeImage && Storage::disk('public')->exists($beforeImage)) {
                Storage::disk('public')->delete($beforeImage);
            }
            if ($afterImage && Storage::disk('public')->exists($afterImage)) {
                Storage::disk('public')->delete($afterImage);
            }

            return response()->json([
                'success' => true,
                'message' => 'Testimonial deleted successfully!'
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error deleting testimonial: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * ADMIN: Toggle featured status
     */
    public function toggleFeatured(ConsultTestimonial $consultTestimonial)
    {
        try {
            $consultTestimonial->update([
                'featured' => !$consultTestimonial->featured
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Featured status updated!',
                'featured' => $consultTestimonial->featured
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error updating featured status: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * ADMIN: Bulk actions (delete, publish, unpublish)
     */
    public function bulkAction(Request $request)
    {
        $request->validate([
            'ids' => 'required|array',
            'action' => 'required|in:delete,publish,unpublish,feature,unfeature'
        ]);

        try {
            $testimonials = ConsultTestimonial::whereIn('id', $request->ids)->get();

            foreach ($testimonials as $testimonial) {
                switch ($request->action) {
                    case 'delete':
                        $testimonial->delete();
                        break;
                    case 'publish':
                        $testimonial->update(['is_public' => true]);
                        break;
                    case 'unpublish':
                        $testimonial->update(['is_public' => false]);
                        break;
                    case 'feature':
                        $testimonial->update(['featured' => true]);
                        break;
                    case 'unfeature':
                        $testimonial->update(['featured' => false]);
                        break;
                }
            }

            return response()->json([
                'success' => true,
                'message' => 'Bulk action completed successfully!'
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error performing bulk action: ' . $e->getMessage()
            ], 500);
        }
    }
}
