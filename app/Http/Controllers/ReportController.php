<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Report;

class ReportController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $reports = Report::paginate(10);
        return view('reports.index', compact('reports'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $categories = ['Ringkas', 'Rapi', 'Resik', 'Rawat', 'Rajin'];
        return view('reports.create', compact('categories'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'category' => 'required|in:ringkas,rapi,resik,rawat,rajin',
            'metric_name' => 'required|string|max:255',
            'value' => 'required|string|max:255',
            'report_date' => 'nullable|date',
        ]);

        Report::create($request->all());

        return redirect()->route('reports.index')->with('success', 'Report created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $report = Report::findOrFail($id);
        return view('reports.show', compact('report'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $report = Report::findOrFail($id);
        $categories = ['reduce', 'reuse', 'recycle', 'recover', 'rethink'];
        return view('reports.edit', compact('report', 'categories'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            'category' => 'required|in:reduce,reuse,recycle,recover,rethink',
            'metric_name' => 'required|string|max:255',
            'value' => 'required|string|max:255',
            'report_date' => 'nullable|date',
        ]);

        $report = Report::findOrFail($id);
        $report->update($request->all());

        return redirect()->route('reports.index')->with('success', 'Report updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $report = Report::findOrFail($id);
        $report->delete();

        return redirect()->route('reports.index')->with('success', 'Report deleted successfully.');
    }
}
