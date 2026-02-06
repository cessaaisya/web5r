<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ListFinding;
use App\Models\DailyActivity;

class ListFindingController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $listFindings = ListFinding::with('dailyActivity')->paginate(10);
        return view('list-findings.index', compact('listFindings'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $dailyActivities = DailyActivity::all();
        return view('list-findings.create', compact('dailyActivities'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'daily_activity_id' => 'required|exists:daily_activities,id',
            'level' => 'required|in:s,q,p,c,hr',
            'countermeasure' => 'required|string',
            'countermeasure_schedule' => 'required|date',
            'progress' => 'required|in:pending,in_progress,completed,cancelled',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'captured_image' => 'nullable|string',
        ]);

        $data = $request->all();

        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image')->store('list-findings', 'public');
        } elseif ($request->filled('captured_image')) {
            // Handle captured image from camera
            $imageData = $request->input('captured_image');
            if (preg_match('/^data:image\/(\w+);base64,/', $imageData, $matches)) {
                $imageType = $matches[1];
                $imageData = substr($imageData, strpos($imageData, ',') + 1);
                $imageData = base64_decode($imageData);
                
                $filename = 'list-findings/' . time() . '_' . uniqid() . '.' . $imageType;
                \Storage::disk('public')->put($filename, $imageData);
                $data['image'] = $filename;
            }
        }

        ListFinding::create($data);

        return redirect()->route('list-findings.index')->with('success', 'List Finding created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $listFinding = ListFinding::with('dailyActivity')->findOrFail($id);
        return view('list-findings.show', compact('listFinding'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $listFinding = ListFinding::findOrFail($id);
        $dailyActivities = DailyActivity::all();
        return view('list-findings.edit', compact('listFinding', 'dailyActivities'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            'daily_activity_id' => 'required|exists:daily_activities,id',
            'level' => 'required|in:s,q,p,c,hr',
            'countermeasure' => 'required|string',
            'countermeasure_schedule' => 'required|date',
            'progress' => 'required|in:pending,in_progress,completed,cancelled',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'captured_image' => 'nullable|string',
        ]);

        $listFinding = ListFinding::findOrFail($id);
        $data = $request->all();

        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image')->store('list-findings', 'public');
        } elseif ($request->filled('captured_image')) {
            // Handle captured image from camera
            $imageData = $request->input('captured_image');
            if (preg_match('/^data:image\/(\w+);base64,/', $imageData, $matches)) {
                $imageType = $matches[1];
                $imageData = substr($imageData, strpos($imageData, ',') + 1);
                $imageData = base64_decode($imageData);
                
                $filename = 'list-findings/' . time() . '_' . uniqid() . '.' . $imageType;
                \Storage::disk('public')->put($filename, $imageData);
                $data['image'] = $filename;
            }
        }

        $listFinding->update($data);

        return redirect()->route('list-findings.index')->with('success', 'List Finding updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $listFinding = ListFinding::findOrFail($id);
        $listFinding->delete();

        return redirect()->route('list-findings.index')->with('success', 'List Finding deleted successfully.');
    }
}
