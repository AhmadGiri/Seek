
<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl">
            {{ $ticketPrice->exists ? 'Edit' : 'Tambah' }} Harga Tiket
        </h2>
    </x-slot>

    <div class="max-w-xl mx-auto p-6 bg-white mt-6 rounded shadow-sm">
        <form
            method="POST"
            action="{{ $ticketPrice->exists
                ? route('ticket-prices.update', $ticketPrice)
                : route('ticket-prices.store') }}"
        >
            @csrf

            @if ($ticketPrice->exists)
                @method('PUT')
            @endif

            {{-- Kategori hari --}}
            <label for="category_day" class="block font-medium">
                Kategori Hari
            </label>

            <input
                type="text"
                id="category_day"
                name="category_day"
                class="border rounded w-full p-2 mt-1"
                value="{{ old('category_day', $ticketPrice->category_day) }}"
                placeholder="Contoh: Weekday atau Weekend"
                required
            >

            @error('category_day')
                <p class="text-red-600 text-sm mt-1">
                    {{ $message }}
                </p>
            @enderror

            {{-- Harga tiket --}}
            <label for="price" class="block font-medium mt-3">
                Harga (Rupiah)
            </label>

            <input
                type="number"
                id="price"
                name="price"
                min="0"
                step="1"
                class="border rounded w-full p-2 mt-1"
                value="{{ old('price', $ticketPrice->price) }}"
                placeholder="Contoh: 50000"
                required
            >

            @error('price')
                <p class="text-red-600 text-sm mt-1">
                    {{ $message }}
                </p>
            @enderror

            {{-- Tombol aksi --}}
            <div class="flex items-center gap-3 mt-4">
                <button
                    type="submit"
                    class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded"
                >
                    Simpan
                </button>

                <a
                    href="{{ route('ticket-prices.index') }}"
                    class="text-gray-600 hover:text-gray-900"
                >
                    Kembali
                </a>
            </div>
        </form>
    </div>
</x-app-layout>
