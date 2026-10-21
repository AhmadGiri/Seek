
<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl">
            Jadwal Tayang
        </h2>
    </x-slot>

    <div class="max-w-6xl mx-auto p-6">
        {{-- Tombol tambah jadwal --}}
        <a
            href="{{ route('schedules.create') }}"
            class="inline-block bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded"
        >
            + Tambah Jadwal
        </a>

        {{-- Notifikasi sukses --}}
        @if (session('success'))
            <p class="bg-green-100 text-green-800 p-3 my-3 rounded">
                {{ session('success') }}
            </p>
        @endif

        {{-- Tabel jadwal tayang --}}
        <div class="overflow-x-auto mt-4">
            <table class="w-full bg-white border border-gray-200 rounded">
                <thead>
                    <tr class="bg-gray-100 text-left">
                        <th class="p-3">Film</th>
                        <th class="p-3">Waktu</th>
                        <th class="p-3">Studio</th>
                        <th class="p-3">Harga</th>
                        <th class="p-3">Aksi</th>
                    </tr>
                </thead>

                <tbody>
                    @forelse ($schedules as $schedule)
                        <tr class="border-t hover:bg-gray-50">
                            <td class="p-3">
                                {{ $schedule->movie->title }}
                            </td>

                            <td class="p-3">
                                {{ $schedule->show_time }}
                            </td>

                            <td class="p-3">
                                {{ $schedule->studio }}
                            </td>

                            <td class="p-3">
                                Rp {{ number_format($schedule->ticketPrice->price, 0, ',', '.') }}
                            </td>

                            <td class="p-3 whitespace-nowrap">
                                <a
                                    href="{{ route('schedules.edit', $schedule) }}"
                                    class="text-blue-600 hover:text-blue-800"
                                >
                                    Edit
                                </a>

                                <form
                                    method="POST"
                                    action="{{ route('schedules.destroy', $schedule) }}"
                                    class="inline"
                                    onsubmit="return confirm('Hapus jadwal?')"
                                >
                                    @csrf
                                    @method('DELETE')

                                    <button
                                        type="submit"
                                        class="text-red-600 hover:text-red-800 ml-2"
                                    >
                                        Hapus
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td
                                colspan="5"
                                class="p-6 text-center text-gray-500"
                            >
                                Belum ada jadwal tayang.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        {{-- Pagination --}}
        <div class="mt-4">
            {{ $schedules->links() }}
        </div>
    </div>
</x-app-layout>
