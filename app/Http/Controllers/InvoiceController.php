<?php

namespace App\Http\Controllers;

use App\Helpers\NumberToWords;
use App\Models\Invoice;
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
        $validated = $this->validateInvoice($request);

        $invoice = DB::transaction(function () use ($validated) {
            $totalAmount = $this->calculateTotal($validated['items']);

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

            $this->syncItems($invoice, $validated['items']);

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

    public function edit(Invoice $invoice)
    {
        $invoice->load('items');

        $initialItems = $invoice->items->map(fn ($item) => [
            'description' => $item->description,
            'capacity' => $item->capacity,
            'brand' => $item->brand,
            'origin' => $item->origin,
            'quantity' => $item->quantity,
            'unit_price' => $item->unit_price,
        ])->values()->all();

        return view('invoices.edit', compact('invoice', 'initialItems'));
    }

    public function update(Request $request, Invoice $invoice)
    {
        $validated = $this->validateInvoice($request);

        DB::transaction(function () use ($invoice, $validated) {
            $totalAmount = $this->calculateTotal($validated['items']);

            $invoice->update([
                'recipient_name' => $validated['recipient_name'],
                'recipient_address' => $validated['recipient_address'],
                'recipient_contact' => $validated['recipient_contact'],
                'subject' => $validated['subject'],
                'total_amount' => $totalAmount,
                'amount_in_words' => NumberToWords::taka($totalAmount),
            ]);

            $invoice->items()->delete();
            $this->syncItems($invoice, $validated['items']);
        });

        return redirect()
            ->route('invoices.show', $invoice)
            ->with('success', 'Invoice updated successfully.');
    }

    public function print(Invoice $invoice)
    {
        $invoice->load('items');

        return view('invoices.print', compact('invoice'));
    }

    public function download(Invoice $invoice)
    {
        return redirect()->route('invoices.print', [
            'invoice' => $invoice,
            'download' => '1',
        ]);
    }

    public function destroy(Invoice $invoice)
    {
        $number = $invoice->invoice_number;
        $invoice->delete();

        return redirect()
            ->route('dashboard')
            ->with('success', "Invoice {$number} deleted successfully.");
    }

    private function validateInvoice(Request $request): array
    {
        return $request->validate([
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
    }

    private function calculateTotal(array $items): float
    {
        $totalAmount = 0;

        foreach ($items as $item) {
            $totalAmount += $item['quantity'] * $item['unit_price'];
        }

        return $totalAmount;
    }

    private function syncItems(Invoice $invoice, array $items): void
    {
        foreach ($items as $index => $item) {
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
