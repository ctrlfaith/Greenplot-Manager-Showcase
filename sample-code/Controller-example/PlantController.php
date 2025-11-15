<?php

namespace App\Http\Controllers;

use App\Models\Plant;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;

class PlantController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(): View
    {
        $plants = Plant::orderBy('id', 'asc')->paginate(10);

        return view('plants.index', compact('plants'));
    }

    public function create(): View
    {
        return view('plants.create');
    }

    public function store(Request $request): RedirectResponse
    {
        $data = $request->validate([
            'name'                 => ['required', 'string', 'max:100'],
            'watering_interval'    => ['nullable', 'integer', 'min:0'],
            'fertilizing_interval' => ['nullable', 'integer', 'min:0'],
            'harvesting_days'      => ['nullable', 'integer', 'min:0'],
            'fertilizer_type'      => ['nullable', 'string', 'max:100'],
            'disease_info'         => ['nullable', 'string'],
            'pest_control'         => ['nullable', 'string'],
        ]);

        Plant::create($data);

        return redirect()
            ->route('plants.index')
            ->with('success', 'สร้างข้อมูลพืชเรียบร้อย');
    }

    public function show(Plant $plant): View
    {
        return view('plants.show', compact('plant'));
    }

    public function edit(Plant $plant): View
    {
        return view('plants.edit', compact('plant'));
    }

    public function update(Request $request, Plant $plant): RedirectResponse
    {
        $data = $request->validate([
            'name'                 => ['required', 'string', 'max:100'],
            'watering_interval'    => ['nullable', 'integer', 'min:0'],
            'fertilizing_interval' => ['nullable', 'integer', 'min:0'],
            'harvesting_days'      => ['nullable', 'integer', 'min:0'],
            'fertilizer_type'      => ['nullable', 'string', 'max:100'],
            'disease_info'         => ['nullable', 'string'],
            'pest_control'         => ['nullable', 'string'],
        ]);

        $plant->update($data);

        return redirect()
            ->route('plants.index')
            ->with('success', 'อัปเดตข้อมูลเรียบร้อย');
    }

    public function destroy(Plant $plant): RedirectResponse
    {
        $plant->delete();

        return redirect()
            ->route('plants.index')
            ->with('success', 'ลบข้อมูลพืชเรียบร้อย');
    }
}