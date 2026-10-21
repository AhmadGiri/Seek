
<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl">
            {{ $schedule->exists ? 'Edit' : 'Tambah' }} Jadwal
        </h2>
    </x-slot>

    <div class="max-w-xl mx-auto p-6 bg-white mt-6 rounded shadow-sm">
        <form
            method="POST"
            action="{{ $schedule->exists
                ? route('schedules.update', $schedule)
                : route('schedules.store') }}"
        >
            @csrf

            @if ($schedule->exists)
                @method('PUT')
            @endif

            {{-- Pilih film --}}
            <label for="movie_id" class="block font-medium">
                Film
            </label>

            <select
                id="movie_id"
                name="movie_id"
                class="w-full border rounded p-2 mt-1"
                required
            >
                <option value="">-- Pilih Film --</option>

                @foreach ($movies as $movie)
                    <option
                        value="{{ $movie->id }}"
                        @selected(old('movie_id', $schedule->movie_id) == $movie->id)
                    >
                        {{ $movie->title }}
                    </option>
                @endforeach
            </select>

            @error('movie_id')
                <p class="text-red-600 text-sm mt-1">
                    {{ $message }}
                </p>
            @enderror

            {{-- Pilih kategori harga --}}
            <label for="ticket_price_id" class="block font-medium mt-3">
                Kategori Harga
            </label>

            <select
                id="ticket_price_id"
                name="ticket_price_id"
                class="w-full border rounded p-2 mt-1"
                required
            >
                <option value="">-- Pilih Kategori Harga --</option>

                @foreach ($prices as $price)
                    <option
                        value="{{ $price->id }}"
                        @selected(old('ticket_price_id', $schedule->ticket_price_id) == $price->id)
                    >
                        {{ $price->category_day }}
                        - Rp {{ number_format($price->price, 0, ',', '.') }}
                    </option>
                @endforeach
            </select>

            @error('ticket_price_id')
                <p class="text-red-600 text-sm mt-1">
                    {{ $message }}
                </p>
            @enderror

            {{-- Tanggal dan waktu --}}
            <label for="show_time" class="block font-medium mt-3">
                Tanggal dan Waktu
            </label>

            <input
                type="datetime-local"
                id="show_time"
                name="show_time"
                class="w-full border rounded p-2 mt-1"
                value="{{ old(
                    'show_time',
                    $schedule->show_time
                        ? \Carbon\Carbon::parse($schedule->show_time)->format('Y-m-d\TH:i')
                        : ''
                ) }}"
                required
            >

            @error('show_time')
                <p class="text-red-600 text-sm mt-1">
                    {{ $message }}
                </p>
            @enderror

            {{-- Studio --}}
            <label for="studio" class="block font-medium mt-3">
                Studio
            </label>

            <input
                type="text"
                id="studio"
                name="studio"
                class="w-full border rounded p-2 mt-1"
                value="{{ old('studio', $schedule->studio) }}"
                placeholder="Contoh: Studio 1"
                required
            >

            @error('studio')
                <p class="text-red-600 text-sm mt-1">
                    {{ $message }}
                </p>
            @enderror

            {{-- Tombol aksi --}}
            <div class="flex items-center gap-3 mt-5">
                <button
                    type="submit"
                    class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded"
                >
                    Simpan
                </button>

                <a
                    href="{{ route('schedules.index') }}"
                    class="text-gray-600 hover:text-gray-900"
                >
                    Kembali
                </a>
            </div>
        </form>
    </div>
</x-app-layout>
