<?php

namespace App\Http\Controllers;

use App\Models\Schedule;
use App\Models\Order;
use App\Models\OrderDetail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Exception;

class OrderController extends Controller
{
    // Katalog Jadwal untuk Customer
    public function index() {
        $schedules = Schedule::with(['movie', 'ticketPrice'])->get();
        return view('customer.index', compact('schedules'));
    }

    // Proses Checkout Pesanan Tiket (Multi-tabel dengan DB Transaction)
    public function store(Request $request) {
        $request->validate([
            'customer_name' => 'required|string|max:255',
            'customer_email' => 'required|email|max:255',
            'tickets' => 'required|array',
            'tickets.*' => 'nullable|integer|min:0',
        ]);

        $orderedTickets = array_filter($request->tickets, fn($qty) => $qty > 0);
        if (empty($orderedTickets)) {
            return back()->with('error', 'Pilih minimal satu tiket film!');
        }

        DB::beginTransaction();
        try {
            $order = Order::create([
                'customer_name' => $request->customer_name,
                'customer_email' => $request->customer_email,
                'total_price' => 0,
                'status' => 'Pending',
            ]);

            $totalPrice = 0;

            foreach ($orderedTickets as $scheduleId => $quantity) {
                $schedule = Schedule::with('ticketPrice')->findOrFail($scheduleId);
                $subtotal = $schedule->ticketPrice->price * $quantity;
                $totalPrice += $subtotal;

                OrderDetail::create([
                    'order_id' => $order->id,
                    'schedule_id' => $schedule->id,
                    'quantity' => $quantity,
                    'subtotal' => $subtotal,
                ]);
            }

            $order->update(['total_price' => $totalPrice]);
            DB::commit();

            return redirect()->route('customer.index')->with('success', 'Pesanan tiket berhasil dibuat! ID Transaksi: #' . $order->id);
        } catch (Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Gagal memproses pesanan: ' . $e->getMessage());
        }
    }

    // Dashboard Admin: Rekap Pesanan Masuk
    public function adminDashboard() {
        $orders = Order::with(['orderDetails.schedule.movie', 'orderDetails.schedule.ticketPrice'])->latest()->get();
        return view('dashboard', compact('orders'));
    }

    // Update Status Pesanan / Pembayaran oleh Admin
    public function updateStatus(Request $request, $id) {
        $request->validate(['status' => 'required|string']);
        $order = Order::findOrFail($id);
        $order->update(['status' => $request->status]);

        return back()->with('success', "Status pesanan #{$order->id} berhasil diperbarui!");
    }
}
