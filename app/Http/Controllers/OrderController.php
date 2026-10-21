<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use App\Models\Order;
use App\Models\OrderDetail;
use App\Models\Schedule;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;
use Illuminate\Validation\ValidationException;

class OrderController extends Controller
{
    public function index()
    {
        $schedules = Schedule::with(['movie', 'ticketPrice'])
            ->where('show_time', '>=', now())
            ->orderBy('show_time')
            ->get();

        return view('customer.index', compact('schedules'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'customer_name' => 'required|string|max:255',
            'customer_email' => 'required|email|max:255',
            'tickets' => 'required|array',
            'tickets.*' => 'nullable|integer|min:0|max:20',
        ]);

        $tickets = array_filter(
            $data['tickets'],
            fn ($quantity) => (int) $quantity > 0
        );

        if (empty($tickets)) {
            return back()
                ->withInput()
                ->with('error', 'Pilih minimal satu tiket.');
        }

        DB::transaction(function () use ($data, $tickets) {
            Customer::updateOrCreate(
                ['email' => $data['customer_email']],
                [
                    'name' => $data['customer_name'],
                    'phone' => '-',
                    'address' => null,
                ]
            );

            $order = Order::create([
                'customer_name' => $data['customer_name'],
                'customer_email' => $data['customer_email'],
                'total_price' => 0,
                'status' => 'pending',
            ]);

            $total = 0;

            foreach ($tickets as $scheduleId => $quantity) {
                $schedule = Schedule::with('ticketPrice')
                    ->findOrFail($scheduleId);

                if ($schedule->show_time < now()) {
                    throw ValidationException::withMessages([
                        'tickets' => 'Jadwal sudah lewat.',
                    ]);
                }

                $subtotal = $schedule->ticketPrice->price
                    * (int) $quantity;

                $total += $subtotal;

                OrderDetail::create([
                    'order_id' => $order->id,
                    'schedule_id' => $schedule->id,
                    'quantity' => (int) $quantity,
                    'subtotal' => $subtotal,
                ]);
            }

            $order->update([
                'total_price' => $total,
            ]);
        });

        return redirect()
            ->route('customer.index')
            ->with(
                'success',
                'Pesanan berhasil dibuat. Silakan simpan nama dan email untuk konfirmasi.'
            );
    }

    public function adminDashboard(Request $request)
    {
        $query = Order::with([
            'orderDetails.schedule.movie',
            'orderDetails.schedule.ticketPrice',
        ])->latest();

        if ($request->filled('from')) {
            $query->whereDate(
                'created_at',
                '>=',
                $request->date('from')
            );
        }

        if ($request->filled('to')) {
            $query->whereDate(
                'created_at',
                '<=',
                $request->date('to')
            );
        }

        $orders = $query->get();

        return view('dashboard', compact('orders'));
    }

    public function updateStatus(Request $request, $id)
    {
        $data = $request->validate([
            'status' => [
                'required',
                Rule::in([
                    'pending',
                    'completed',
                    'cancelled',
                ]),
            ],
        ]);

        Order::findOrFail($id)->update($data);

        return back()->with(
            'success',
            'Status pesanan diperbarui.'
        );
    }
}
