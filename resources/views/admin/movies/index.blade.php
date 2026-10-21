<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">Master Data Judul Film</h2>
    </x-slot>

    <div class="py-12 max-w-7xl mx-auto sm:px-6 lg:px-8">
        <a href="{{ route('movies.create') }}" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded mb-4 inline-block font-semibold">+ Tambah Film Baru</a>
        
        @if(session('success'))
            <div class="bg-green-100 border border-green-400 text-green-700 p-3 rounded mb-4">{{ session('success') }}</div>
        @endif

        <table class="w-full bg-white border mt-4 shadow-sm rounded-lg overflow-hidden">
            <thead>
                <tr class="bg-gray-100 border-b text-gray-600 text-sm text-left">
                    <th class="p-3">Poster</th>
                    <th class="p-3">Judul Film</th>
                    <th class="p-3">Genre</th>
                    <th class="p-3">Durasi</th>
                    <th class="p-3 text-center">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach($movies as $movie)
                <tr class="border-b text-sm">
                    <td class="p-3">
                        @if($movie->poster)
                            <img src="{{ asset('storage/' . $movie->poster) }}" class="w-12 h-16 object-cover rounded shadow-sm">
                        @else
                            <span class="text-gray-400 text-xs">No Poster</span>
                        @endif
                    </td>
                    <td class="p-3 font-semibold">{{ $movie->title }}</td>
                    <td class="p-3">{{ $movie->genre }}</td>
                    <td class="p-3">{{ $movie->duration }} Menit</td>
                    <td class="p-3 text-center">
                        <a href="{{ route('movies.edit', $movie->id) }}" class="text-blue-600 hover:underline mr-3 font-semibold">Edit</a>
                        <form action="{{ route('movies.destroy', $movie->id) }}" method="POST" class="inline">
                            @csrf
                            @method('DELETE')
                            <button type="submit" onclick="return confirm('Yakin ingin menghapus film ini?')" class="text-red-600 hover:underline font-semibold">Hapus</button>
                        </form>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
        <div class="mt-4">{{ $movies->links() }}</div>
    </div>
</x-app-layout>