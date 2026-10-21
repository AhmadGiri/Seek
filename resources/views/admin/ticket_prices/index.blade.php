
<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl">
            Harga Tiket
        </h2>
    </x-slot>

    <div class="max-w-5xl mx-auto p-6">
        {{-- Tombol tambah harga --}}
        <a
            href="{{ route('ticket-prices.create') }}"
            class="inline-block bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded"
        >
            + Tambah Harga
        </a>

        {{-- Notifikasi sukses --}}
        @if (session('success'))
            <div class="bg-green-100 text-green-800 p-3 my-3 rounded">
                {{ session('success') }}
            </div>
        @endif

        {{-- Notifikasi error --}}
        @if (session('error'))
            <div class="bg-red-100 text-red-800 p-3 my-3 rounded">
                {{ session('error') }}
            </div>
        @endif

        {{-- Tabel harga tiket --}}
        <div class="overflow-x-auto mt-4">
            <table class="w-full bg-white border border-gray-200 rounded">
                <thead>
                    <tr class="bg-gray-100 text-left">
                        <th class="p-3">Kategori Hari</th>
                        <th class="p-3">Harga</th>
                        <th class="p-3">Aksi</th>
                    </tr>
                </thead>

                <tbody>
                    @forelse ($prices as $price)
                        <tr class="border-t hover:bg-gray-50">
                            <td class="p-3">
                                {{ $price->category_day }}
                            </td>

                            <td class="p-3 whitespace-nowrap">
                                Rp {{ number_format($price->price, 0, ',', '.') }}
                            </td>

                            <td class="p-3 whitespace-nowrap">
                                <a
                                    href="{{ route('ticket-prices.edit', $price) }}"
                                    class="text-blue-600 hover:text-blue-800"
                                >
                                    Edit
                                </a>

                                <form
                                    method="POST"
                                    action="{{ route('ticket-prices.destroy', $price) }}"
                                    class="inline"
                                    onsubmit="return confirm('Yakin ingin menghapus harga tiket ini?')"
                                >
                                    @csrf
                                    @method('DELETE')

                                    <button
                                        type="submit"
                                        class="text-red-600 hover:text-red-800 ml-3"
                                    >
                                        Hapus
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td
                                colspan="3"
                                class="p-6 text-center text-gray-500"
                            >
                                Belum ada data harga tiket.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        {{-- Pagination --}}
        <div class="mt-4">
            {{ $prices->links() }}
        </div>
    </div>
</x-app-layout>
