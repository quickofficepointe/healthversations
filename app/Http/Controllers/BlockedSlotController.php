<?php

namespace App\Http\Controllers;

use App\Models\BlockedSlot;
use Illuminate\Http\Request;

class BlockedSlotController extends Controller
{
    public function index()
    {
        $blockedSlots = BlockedSlot::upcoming()
            ->orderBy('blocked_date')
            ->orderBy('start_time')
            ->paginate(20);

        return view('healthversations.admin.blockedslots.index', compact('blockedSlots'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'blocked_date' => 'required|date|after_or_equal:today',
            'full_day' => 'nullable|boolean',
            'start_time' => 'required_unless:full_day,1|nullable|date_format:H:i',
            'end_time' => 'required_unless:full_day,1|nullable|date_format:H:i|after:start_time',
            'reason' => 'nullable|string|max:255',
        ]);

        if ($request->boolean('full_day')) {
            $validated['start_time'] = '00:00';
            $validated['end_time'] = '23:59';
        }

        BlockedSlot::create([
            'blocked_date' => $validated['blocked_date'],
            'start_time' => $validated['start_time'],
            'end_time' => $validated['end_time'],
            'reason' => $validated['reason'] ?? null,
        ]);

        return back()->with('success', 'Time slot blocked successfully.');
    }

    public function destroy($id)
    {
        BlockedSlot::findOrFail($id)->delete();

        return back()->with('success', 'Blocked slot removed.');
    }

    public function getCount()
    {
        return response()->json(['count' => BlockedSlot::upcoming()->count()]);
    }
}
