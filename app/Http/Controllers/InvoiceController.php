<?php

namespace App\Http\Controllers;

use App\Models\Invoice;
use App\Models\InvoiceItem;
use App\Models\Proyek;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Barryvdh\DomPDF\Facade\Pdf;

class InvoiceController extends Controller
{
    public function index()
    {
        $invoices = Invoice::with(['proyek', 'items'])
            ->orderBy('created_at', 'desc')
            ->paginate(10);
            
        // Get statistics
        $stats = [
            'paid' => Invoice::where('status', 'paid')->count(),
            'sent' => Invoice::where('status', 'sent')->count(),
            'draft' => Invoice::where('status', 'draft')->count(),
            'overdue' => Invoice::where('status', 'overdue')->count()
        ];

        return view('invoices.index', compact('invoices', 'stats'));
    }

    public function create()
    {
        $proyeks = Proyek::all();
        return view('invoices.create', compact('proyeks'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'id_proyek' => 'required|exists:proyek,id_proyek',
            'client_name' => 'required|string|max:255',
            'client_email' => 'required|email|max:255',
            'client_address' => 'required|string',
            'invoice_date' => 'required|date',
            'due_date' => 'required|date|after_or_equal:invoice_date',
            'tax_rate' => 'nullable|numeric|min:0|max:100',
            'discount_amount' => 'nullable|numeric|min:0',
            'notes' => 'nullable|string',
            'items' => 'required|array|min:1',
            'items.*.description' => 'required|string|max:255',
            'items.*.quantity' => 'required|integer|min:1',
            'items.*.unit_price' => 'required|numeric|min:0'
        ]);

        DB::transaction(function () use ($validated) {
            $invoice = Invoice::create([
                'invoice_number' => Invoice::generateInvoiceNumber(),
                'id_proyek' => $validated['id_proyek'],
                'client_name' => $validated['client_name'],
                'client_email' => $validated['client_email'],
                'client_address' => $validated['client_address'],
                'invoice_date' => $validated['invoice_date'],
                'due_date' => $validated['due_date'],
                'tax_rate' => $validated['tax_rate'] ?? 0,
                'discount_amount' => $validated['discount_amount'] ?? 0,
                'notes' => $validated['notes'],
                'subtotal' => 0,
                'tax_amount' => 0,
                'total_amount' => 0
            ]);

            foreach ($validated['items'] as $item) {
                InvoiceItem::create([
                    'invoice_id' => $invoice->id,
                    'description' => $item['description'],
                    'quantity' => $item['quantity'],
                    'unit_price' => $item['unit_price']
                ]);
            }

            $invoice->calculateTotals();
        });

        return redirect()->route('invoices.index')->with('success', 'Invoice berhasil dibuat!');
    }

    public function show(Invoice $invoice)
    {
        $invoice->load(['proyek', 'items']);
        return view('invoices.show', compact('invoice'));
    }

    public function edit(Invoice $invoice)
    {
        $proyeks = Proyek::all();
        $invoice->load(['proyek', 'items']);
        return view('invoices.edit', compact('invoice', 'proyeks'));
    }

    public function update(Request $request, Invoice $invoice)
    {
        $validated = $request->validate([
            'id_proyek' => 'required|exists:proyek,id_proyek',
            'client_name' => 'required|string|max:255',
            'client_email' => 'required|email|max:255',
            'client_address' => 'required|string',
            'invoice_date' => 'required|date',
            'due_date' => 'required|date|after_or_equal:invoice_date',
            'tax_rate' => 'nullable|numeric|min:0|max:100',
            'discount_amount' => 'nullable|numeric|min:0',
            'notes' => 'nullable|string',
            'items' => 'required|array|min:1',
            'items.*.description' => 'required|string|max:255',
            'items.*.quantity' => 'required|integer|min:1',
            'items.*.unit_price' => 'required|numeric|min:0'
        ]);

        DB::transaction(function () use ($validated, $invoice) {
            $invoice->update([
                'id_proyek' => $validated['id_proyek'],
                'client_name' => $validated['client_name'],
                'client_email' => $validated['client_email'],
                'client_address' => $validated['client_address'],
                'invoice_date' => $validated['invoice_date'],
                'due_date' => $validated['due_date'],
                'tax_rate' => $validated['tax_rate'] ?? 0,
                'discount_amount' => $validated['discount_amount'] ?? 0,
                'notes' => $validated['notes']
            ]);

            // Delete existing items
            $invoice->items()->delete();

            // Create new items
            foreach ($validated['items'] as $item) {
                InvoiceItem::create([
                    'invoice_id' => $invoice->id,
                    'description' => $item['description'],
                    'quantity' => $item['quantity'],
                    'unit_price' => $item['unit_price']
                ]);
            }

            $invoice->calculateTotals();
        });

        return redirect()->route('invoices.show', $invoice)->with('success', 'Invoice berhasil diperbarui!');
    }

    public function destroy(Invoice $invoice)
    {
        $invoice->delete();
        return redirect()->route('invoices.index')->with('success', 'Invoice berhasil dihapus!');
    }

    public function updateStatus(Request $request, Invoice $invoice)
    {
        $validated = $request->validate([
            'status' => 'required|in:draft,sent,paid,overdue,cancelled'
        ]);

        $invoice->update([
            'status' => $validated['status'],
            'paid_at' => $validated['status'] === 'paid' ? now() : null
        ]);

        return redirect()->back()->with('success', 'Status invoice berhasil diperbarui!');
    }

    public function downloadPdf(Invoice $invoice)
    {
        $invoice->load(['proyek', 'items']);
        
        $pdf = Pdf::loadView('invoices.pdf', compact('invoice'));
        
        return $pdf->download('invoice-' . $invoice->invoice_number . '.pdf');
    }
}
