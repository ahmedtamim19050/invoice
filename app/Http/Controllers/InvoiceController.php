<?php

namespace App\Http\Controllers;

use App\Helpers\NumberToWords;
use App\Models\Invoice;
use App\Support\InvoicePdfGenerator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class InvoiceController extends Controller
{
    public function create()
    {
        return view('invoices.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'recipient_name' => ['required', 'string', 'max:255'],
            'recipient_address' => ['required', 'string'],
            'recipient_contact' => ['required', 'string', 'max:50'],
            'subject' => ['required', 'string', 'max:255'],
            'items' => ['required', 'array', 'min:1'],
            'items.*.description' => ['required', 'string', 'max:255'],
            'items.*.capacity' => ['nullable', 'string', 'max:255'],
            'items.*.brand' => ['nullable', 'string', 'max:255'],
            'items.*.origin' => ['nullable', 'string', 'max:255'],
            'items.*.quantity' => ['required', 'integer', 'min:1'],
            'items.*.unit_price' => ['required', 'numeric', 'min:0'],
        ]);

        $invoice = DB::transaction(function () use ($validated) {
            $totalAmount = 0;

            foreach ($validated['items'] as $item) {
                $totalAmount += $item['quantity'] * $item['unit_price'];
            }

            $invoice = Invoice::create([
                'invoice_number' => $this->generateInvoiceNumber(),
                'recipient_name' => $validated['recipient_name'],
                'recipient_address' => $validated['recipient_address'],
                'recipient_contact' => $validated['recipient_contact'],
                'subject' => $validated['subject'],
                'total_amount' => $totalAmount,
                'amount_in_words' => NumberToWords::taka($totalAmount),
                'user_id' => auth()->id(),
            ]);

            foreach ($validated['items'] as $index => $item) {
                $lineTotal = $item['quantity'] * $item['unit_price'];

                $invoice->items()->create([
                    'description' => $item['description'],
                    'capacity' => $item['capacity'] ?? null,
                    'brand' => $item['brand'] ?? null,
                    'origin' => $item['origin'] ?? null,
                    'quantity' => $item['quantity'],
                    'unit_price' => $item['unit_price'],
                    'total_price' => $lineTotal,
                    'sort_order' => $index,
                ]);
            }

            return $invoice;
        });

        return redirect()
            ->route('invoices.show', $invoice)
            ->with('success', 'Invoice created successfully.');
    }

    public function show(Invoice $invoice)
    {
        $invoice->load('items');

        return view('invoices.show', compact('invoice'));
    }

    public function print(Invoice $invoice)
    {
        $invoice->load('items');

        return view('invoices.print', compact('invoice'));
    }

    public function download(Invoice $invoice)
    {
        $invoice->load('items');

        $filename = str_replace('/', '-', $invoice->invoice_number).'.pdf';

        return InvoicePdfGenerator::make($invoice)->download($filename);
    }

    public function destroy(Invoice $invoice)
    {
        $number = $invoice->invoice_number;
        $invoice->delete();

        return redirect()
            ->route('dashboard')
            ->with('success', "Invoice {$number} deleted successfully.");
    }

    private function generateInvoiceNumber(): string
    {
        $year = now()->format('Y');
        $lastInvoice = Invoice::whereYear('created_at', $year)
            ->orderByDesc('id')
            ->first();

        $sequence = $lastInvoice
            ? ((int) substr($lastInvoice->invoice_number, -4)) + 1
            : 1;

        return sprintf('BBH-%s-%04d', $year, $sequence);
    }
}
