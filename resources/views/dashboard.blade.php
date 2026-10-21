<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Daftar Pemesanan Tiket Bioskop') }}
            </h2>
            <div class="flex items-center gap-3">
                <a href="{{ route('movies.index') }}" class="inline-flex items-center px-4 py-2 bg-indigo-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-indigo-700 shadow-sm transition">
                    Kelola Film
                </a>
                <a href="{{ route('ticket-prices.index') }}" class="inline-flex items-center px-4 py-2 bg-green-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-green-700 shadow-sm transition">
                    Kelola Harga
                </a>
                <a href="{{ route('schedules.index') }}" class="inline-flex items-center px-4 py-2 bg-blue-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-700 shadow-sm transition">
                    Kelola Jadwal
                </a>
            </div>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            @if(session('success'))
                <div class="mb-4 p-4 bg-green-100 border-l-4 border-green-500 text-green-700 rounded shadow-sm font-medium">
                    {{ session('success') }}
                </div>
            @endif

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg border border-gray-200">
                <div class="p-6 text-gray-900 overflow-x-auto">
                    <table class="w-full text-left border-collapse">
                        <thead class="bg-gray-100 text-gray-700 uppercase text-xs">
                            <tr>
                                <th class="p-4 border-b"># ID</th>
                                <th class="p-4 border-b">Pelanggan</th>
                                <th class="p-4 border-b">Email</th>
                                <th class="p-4 border-b">Rincian Tiket</th>
                                <th class="p-4 border-b">Total Harga</th>
                                <th class="p-4 border-b">Status</th>
                                <th class="p-4 border-b text-center">Aksi Status</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y text-sm">
                            @forelse($orders as $order)
                            <tr class="hover:bg-gray-50">
                                <td class="p-4 font-bold text-gray-700">#{{ $order->id }}</td>
                                <td class="p-4 font-medium">{{ $order->customer_name }}</td>
                                <td class="p-4 text-gray-500">{{ $order->customer_email }}</td>
                                <td class="p-4">
                                    <ul class="list-disc list-inside space-y-1 text-gray-600">
                                        @foreach($order->orderDetails as $detail)
                                        <li>
                                            <strong>{{ $detail->schedule->movie->title ?? 'Film' }}</strong> 
                                            ({{ $detail->schedule->studio ?? '-' }}) 
                                            x{{ $detail->quantity }} 
                                            <span class="text-xs text-gray-400">(Rp {{ number_format($detail->subtotal) }})</span>
                                        </li>
                                        @endforeach
                                    </ul>
                                </td>
                                <td class="p-4 font-bold text-green-600">
                                    Rp {{ number_format($order->total_price) }}
                                </td>
                                <td class="p-4">
                                    @if(strtolower($order->status) == 'pending')
                                        <span class="bg-yellow-100 text-yellow-800 text-xs font-bold px-2.5 py-1 rounded">PENDING</span>
                                    @elseif(strtolower($order->status) == 'completed' || strtolower($order->status) == 'selesai')
                                        <span class="bg-green-100 text-green-800 text-xs font-bold px-2.5 py-1 rounded">SELESAI</span>
                                    @else
                                        <span class="bg-red-100 text-red-800 text-xs font-bold px-2.5 py-1 rounded">{{ strtoupper($order->status) }}</span>
                                    @endif
                                </td>
                                <td class="p-4 text-center">
                                    <form action="{{ route('admin.orders.updateStatus', $order->id) }}" method="POST">
                                        @csrf
                                        @method('PATCH')
                                        <select name="status" onchange="this.form.submit()" class="text-xs border border-gray-300 rounded p-1.5 bg-white shadow-sm font-semibold">
                                            <option value="pending" {{ strtolower($order->status) == 'pending' ? 'selected' : '' }}>Pending</option>
                                            <option value="completed" {{ strtolower($order->status) == 'completed' || strtolower($order->status) == 'selesai' ? 'selected' : '' }}>Selesai / Lunas</option>
                                            <option value="cancelled" {{ strtolower($order->status) == 'cancelled' ? 'selected' : '' }}>Batalkan</option>
                                        </select>
                                    </form>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="7" class="p-6 text-center text-gray-500">Belum ada pemesanan tiket masuk.</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>