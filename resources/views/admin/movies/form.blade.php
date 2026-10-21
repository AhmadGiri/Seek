
<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl">
            {{ $movie->exists ? 'Edit' : 'Tambah' }} Film
        </h2>
    </x-slot>

    <div class="max-w-2xl mx-auto p-6 bg-white mt-6">
        <form
            method="POST"
            enctype="multipart/form-data"
            action="{{ $movie->exists
                ? route('movies.update', $movie)
                : route('movies.store') }}"
        >
            @csrf

            @if ($movie->exists)
                @method('PUT')
            @endif

            @foreach ([
                'title' => 'Judul Film',
                'genre' => 'Genre',
                'duration' => 'Durasi (menit)',
            ] as $field => $label)
                <label class="block mt-3">
                    {{ $label }}
                </label>

                <input
                    type="{{ $field === 'duration' ? 'number' : 'text' }}"
                    name="{{ $field }}"
                    value="{{ old($field, $movie->$field) }}"
                    class="w-full border rounded p-2"
                    @if ($field === 'duration')
                        min="1"
                    @endif
                    required
                >

                @error($field)
                    <p class="text-red-600">
                        {{ $message }}
                    </p>
                @enderror
            @endforeach

            <label class="block mt-3">
                Sinopsis
            </label>

            <textarea
                name="synopsis"
                class="w-full border rounded p-2"
                required
            >{{ old('synopsis', $movie->synopsis) }}</textarea>

            @error('synopsis')
                <p class="text-red-600">
                    {{ $message }}
                </p>
            @enderror

            <label class="block mt-3">
                Poster
            </label>

            <input
                type="file"
                name="image"
                accept=".jpg,.jpeg,.png,.webp"
                class="block mt-1"
            >

            @error('image')
                <p class="text-red-600">
                    {{ $message }}
                </p>
            @enderror

            @if ($movie->exists && $movie->image)
                <div class="mt-3">
                    <p class="text-sm text-gray-600 mb-2">
                        Poster saat ini:
                    </p>

                    <img
                        src="{{ asset('storage/' . $movie->image) }}"
                        alt="Poster {{ $movie->title }}"
                        class="w-32 rounded"
                    >
                </div>
            @endif

            <div class="mt-4">
                <button
                    type="submit"
                    class="bg-blue-600 hover:bg-blue-700 text-white rounded px-4 py-2"
                >
                    Simpan
                </button>

                <a
                    href="{{ route('movies.index') }}"
                    class="ml-3 text-gray-600 hover:text-gray-900"
                >
                    Kembali
                </a>
            </div>
        </form>
    </div>
</x-app-layout>
