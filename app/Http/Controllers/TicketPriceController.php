<?php

namespace App\Http\Controllers;

use App\Models\TicketPrice;
use Illuminate\Http\Request;

class TicketPriceController extends Controller
{
    public function index()
    {
        $prices = TicketPrice::latest()->paginate(10);

        return view('admin.ticket_prices.index', compact('prices'));
    }

    public function create()
    {
        return view('admin.ticket_prices.form', [
            'ticketPrice' => new TicketPrice(),
        ]);
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'category_day' => 'required|string|max:100',
            'price' => 'required|integer|min:0',
        ]);

        TicketPrice::create($data);

        return redirect()
            ->route('ticket-prices.index')
            ->with('success', 'Harga ditambahkan.');
    }

    public function show(TicketPrice $ticketPrice)
    {
        return redirect()->route('ticket-prices.index');
    }

    public function edit(TicketPrice $ticketPrice)
    {
        return view(
            'admin.ticket_prices.form',
            compact('ticketPrice')
        );
    }

    public function update(Request $request, TicketPrice $ticketPrice)
    {
        $data = $request->validate([
            'category_day' => 'required|string|max:100',
            'price' => 'required|integer|min:0',
        ]);

        $ticketPrice->update($data);

        return redirect()
            ->route('ticket-prices.index')
            ->with('success', 'Harga diperbarui.');
    }

    public function destroy(TicketPrice $ticketPrice)
    {
        if ($ticketPrice->schedules()->exists()) {
            return back()->with(
                'error',
                'Harga masih dipakai jadwal.'
            );
        }

        $ticketPrice->delete();

        return redirect()
            ->route('ticket-prices.index')
            ->with('success', 'Harga dihapus.');
    }
}
