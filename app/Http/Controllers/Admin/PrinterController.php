<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Printer;
use Illuminate\Http\Request;

class PrinterController extends Controller
{
    public function index()
    {
        $printers = Printer::all();
        return view('admin.printers.index', compact('printers'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'connection_type' => ['required', 'in:BLUETOOTH,USB,NETWORK'],
            'paper_width' => ['required', 'in:58mm,80mm'],
            'status' => ['required', 'in:ACTIVE,INACTIVE'],
            'ip_address' => ['nullable', 'string'],
        ]);

        $settings = [];
        if (!empty($validated['ip_address'])) {
            $settings['ip_address'] = $validated['ip_address'];
        }

        Printer::create([
            'name' => $validated['name'],
            'connection_type' => $validated['connection_type'],
            'paper_width' => $validated['paper_width'],
            'status' => $validated['status'],
            'settings' => $settings,
        ]);

        return redirect()->route('admin.printers.index')
            ->with('success', 'Perangkat thermal printer berhasil ditambahkan!');
    }

    public function update(Request $request, Printer $printer)
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'connection_type' => ['required', 'in:BLUETOOTH,USB,NETWORK'],
            'paper_width' => ['required', 'in:58mm,80mm'],
            'status' => ['required', 'in:ACTIVE,INACTIVE'],
        ]);

        $printer->update($validated);

        return redirect()->route('admin.printers.index')
            ->with('success', 'Konfigurasi printer berhasil diperbarui!');
    }

    public function destroy(Printer $printer)
    {
        $printer->delete();

        return redirect()->route('admin.printers.index')
            ->with('success', 'Printer berhasil dihapus!');
    }
}
