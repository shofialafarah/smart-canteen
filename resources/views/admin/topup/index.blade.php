<x-app-layout>
    <div class="min-h-screen bg-[#121212] text-white py-12 px-6">
        <div class="max-w-5xl mx-auto">
            <div class="flex justify-between items-center mb-8 border-b border-orange-500/30 pb-6">
                <h2 class="text-3xl font-black text-orange-500 uppercase italic">Konfirmasi <span class="text-white">Top Up</span></h2>
            </div>

            <div class="bg-[#1e1e1e] rounded-3xl border border-white/5 overflow-hidden shadow-2xl">
                <table class="w-full text-left">
                    <thead class="bg-orange-600/10 text-orange-500 uppercase text-xs font-black italic">
                        <tr>
                            <th class="px-6 py-4">Nama Pengguna</th>
                            <th class="px-6 py-4">Nominal</th>
                            <th class="px-6 py-4">Waktu Request</th>
                            <th class="px-6 py-4 text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-white/5">
                        @forelse($pendingTopUps as $tp)
                        <tr class="hover:bg-white/[0.02] transition-all">
                            <td class="px-6 py-4">
                                <p class="font-bold">{{ $tp->user->name }}</p>
                                <p class="text-[10px] text-gray-500 uppercase italic">{{ $tp->user->role }}</p>
                            </td>
                            <td class="px-6 py-4 font-black text-white">
                                Rp {{ number_format($tp->nominal, 0, ',', '.') }}
                            </td>
                            <td class="px-6 py-4 text-xs text-gray-500">
                                {{ $tp->created_at->diffForHumans() }}
                            </td>
                            <td class="px-6 py-4 text-center">
                                <form action="{{ route('admin.topup.approve', $tp->id) }}" method="POST">
                                    @csrf @method('PATCH')
                                    <button type="submit" class="bg-orange-600 hover:bg-orange-500 text-white text-[10px] font-black px-4 py-2 rounded-xl uppercase transition-all shadow-lg">
                                        Konfirmasi Terima Uang
                                    </button>
                                </form>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="4" class="px-6 py-20 text-center text-gray-500 italic">
                                Belum ada permintaan top up masuk.
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</x-app-layout>