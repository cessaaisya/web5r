<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\DailyActivity;

class DailyActivityController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $dailyActivities = DailyActivity::with('listFindings')->paginate(10);
        return view('daily-activities.index', compact('dailyActivities'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('daily-activities.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'zone' => 'required|string|max:255',
            'pic_name' => 'required|string|max:255',
            'date' => 'required|date',
            'abnormality' => 'required|in:y,n',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'captured_image' => 'nullable|string',
        ]);

        $data = $request->all();

        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image')->store('daily-activities', 'public');
        } elseif ($request->filled('captured_image')) {
            // Handle captured image from camera
            $imageData = $request->input('captured_image');
            if (preg_match('/^data:image\/(\w+);base64,/', $imageData, $matches)) {
                $imageType = $matches[1];
                $imageData = substr($imageData, strpos($imageData, ',') + 1);
                $imageData = base64_decode($imageData);
                
                $filename = 'daily-activities/' . time() . '_' . uniqid() . '.' . $imageType;
                \Storage::disk('public')->put($filename, $imageData);
                $data['image'] = $filename;
            }
        }

        DailyActivity::create($data);

        return redirect()->route('daily-activities.index')->with('success', 'Daily Activity created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $dailyActivity = DailyActivity::with('listFindings')->findOrFail($id);
        return view('daily-activities.show', compact('dailyActivity'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $dailyActivity = DailyActivity::findOrFail($id);
        return view('daily-activities.edit', compact('dailyActivity'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            'zone' => 'required|string|max:255',
            'pic_name' => 'required|string|max:255',
            'date' => 'required|date',
            'abnormality' => 'required|in:y,n',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'captured_image' => 'nullable|string',
        ]);

        $dailyActivity = DailyActivity::findOrFail($id);
        $data = $request->all();

        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image')->store('daily-activities', 'public');
        } elseif ($request->filled('captured_image')) {
            // Handle captured image from camera
            $imageData = $request->input('captured_image');
            if (preg_match('/^data:image\/(\w+);base64,/', $imageData, $matches)) {
                $imageType = $matches[1];
                $imageData = substr($imageData, strpos($imageData, ',') + 1);
                $imageData = base64_decode($imageData);
                
                $filename = 'daily-activities/' . time() . '_' . uniqid() . '.' . $imageType;
                \Storage::disk('public')->put($filename, $imageData);
                $data['image'] = $filename;
            }
        }

        $dailyActivity->update($data);

        return redirect()->route('daily-activities.index')->with('success', 'Daily Activity updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $dailyActivity = DailyActivity::findOrFail($id);
        $dailyActivity->delete();

        return redirect()->route('daily-activities.index')->with('success', 'Daily Activity deleted successfully.');
    }
}
