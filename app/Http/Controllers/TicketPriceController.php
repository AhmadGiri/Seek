<?php

namespace App\Http\Controllers;

use App\Models\TicketPrice;
use Illuminate\Http\Request;

class TicketPriceController extends Controller
{
    public function index() {
        $prices = TicketPrice::latest()->paginate(10);
        return view('admin.ticket_prices.index', compact('prices'));
    }

    public function create() {
        return view('admin.ticket_prices.create');
    }

    public function store(Request $request) {
        $request->validate([
            'category_day' => 'required|string|max:255',
            'price' => 'required|integer|min:0',
        ]);

        TicketPrice::create($request->all());

        return redirect()->route('ticket-prices.index')->with('success', 'Data harga tiket berhasil ditambahkan!');
    }

    public function edit(TicketPrice $ticketPrice) {
        return view('admin.ticket_prices.edit', compact('ticketPrice'));
    }

    public function update(Request $request, TicketPrice $ticketPrice) {
        $request->validate([
            'category_day' => 'required|string|max:255',
            'price' => 'required|integer|min:0',
        ]);

        $ticketPrice->update($request->all());

        return redirect()->route('ticket-prices.index')->with('success', 'Data harga tiket berhasil diperbarui!');
    }

    public function destroy(TicketPrice $ticketPrice) {
        $ticketPrice->delete();
        return redirect()->route('ticket-prices.index')->with('success', 'Data harga tiket berhasil dihapus!');
    }
}
