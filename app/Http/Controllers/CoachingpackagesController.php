<?php

namespace App\Http\Controllers;

use App\Models\Coachingpackage;
use App\Models\CoachingPackages;
USE App\Models\Packagefeatures;
use illuminate\Support\Facades\Storage;
use Illuminate\Http\Request;

class CoachingpackagesController extends Controller
{

    public function index()
    {
        $packages = CoachingPackages::with('features')
            ->orderBy('sort_order')
            ->get();

        return view('healthversations.admin.coaching.index', compact('packages'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'package_name' => 'required|string|max:255',
            'duration' => 'required|string|max:255',
            'price_usd' => 'required|numeric|min:0',
            'price_kes' => 'required|numeric|min:0',
            'bg_color' => 'required|string|max:7',
            'button_text' => 'required|string|max:255',
            'button_link' => 'nullable|url',
            'is_active' => 'boolean',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'features' => 'required|array',
            'features.*' => 'required|string|max:255'
        ]);

        // Handle image upload
        if ($request->hasFile('image')) {
            $validated['image'] = $request->file('image')->store('package_images', 'public');
        }

        // Create package
        $package = CoachingPackages::create($validated);

        // Create features
        foreach ($request->features as $feature) {
            $package->features()->create(['feature' => $feature]);
        }

        return redirect()->route('admin.coaching-packages.index')
                       ->with('success', 'Package created successfully!');
    }

    public function update(Request $request, CoachingPackages $coachingPackage)
    {
        $validated = $request->validate([
            'package_name' => 'required|string|max:255',
            'duration' => 'required|string|max:255',
            'price_usd' => 'required|numeric|min:0',
            'price_kes' => 'required|numeric|min:0',
            'bg_color' => 'required|string|max:20',
            'button_text' => 'required|string|max:50',
            'button_link' => 'nullable|url',
            'is_active' => 'boolean',
            'features' => 'required|array|min:1',
            'features.*' => 'string|max:255',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048'
        ]);

        $packageData = [
            'package_name' => $validated['package_name'],
            'duration' => $validated['duration'],
            'price_usd' => $validated['price_usd'],
            'price_kes' => $validated['price_kes'],
            'bg_color' => $validated['bg_color'],
            'button_text' => $validated['button_text'],
            'button_link' => $validated['button_link'],
            'is_active' => $validated['is_active'] ?? false
        ];

        // Handle image upload
    if ($request->hasFile('image')) {
        // Delete old image if exists
        if ($coachingPackage->image) {
            Storage::disk('public')->delete($coachingPackage->image);
        }
        $validated['image'] = $request->file('image')->store('package_images', 'public');
    }

    // Update package
    $coachingPackage->update($validated);

    // Sync features - delete existing and create new ones
    $coachingPackage->features()->delete();
    foreach ($request->features as $feature) {
        $coachingPackage->features()->create(['feature' => $feature]);
    }

    return redirect()->route('admin.coaching-packages.index')
                   ->with('success', 'Package updated successfully!');
}
    

    public function destroy(CoachingPackages $coachingPackage)
    {
        // Delete associated image if exists
        if ($coachingPackage->image) {
            Storage::disk('public')->delete($coachingPackage->image);
        }

        $coachingPackage->features()->delete();
        $coachingPackage->delete();

        return redirect()->route('admin.coaching-packages.index')
            ->with('success', 'Package deleted successfully!');
    }

    public function updateOrder(Request $request)
    {
        foreach ($request->order as $i => $id) {
            CoachingPackages::where('id', $id)->update(['sort_order' => $i + 1]);
        }

        return response()->json(['success' => true]);
    }
}
