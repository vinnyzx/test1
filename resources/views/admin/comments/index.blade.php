@extends('admin.layouts.app')

@section('content')
<div class="bg-background-light text-gray-800 min-h-screen antialiased font-sans">
    <header class="bg-white border-b border-gray-200 sticky top-0 z-30 shadow-sm">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 h-16 flex items-center justify-between">
            <div>
                <h1 class="text-xl font-bold text-gray-900 leading-tight flex items-center gap-2">
                    <span class="material-symbols-outlined text-primary">chat</span>
                    Quan ly Comments
                </h1>
            </div>
            <div class="text-sm text-slate-500 font-semibold">
                Tong so: {{ $comments->count() }} comment
            </div>
        </div>
    </header>

    <main class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        @if(session('success'))
            <div class="mb-6 p-4 bg-green-50 border border-green-200 text-green-700 rounded-xl text-sm font-semibold flex items-center gap-2 shadow-sm">
                <span class="material-symbols-outlined text-green-600 text-lg">check_circle</span>
                {{ session('success') }}
            </div>
        @endif

        <div class="mb-6 overflow-hidden rounded-2xl bg-[#0f141a] text-white shadow-[0_15px_45px_-25px_rgba(15,20,26,0.85)]">
            <div class="grid gap-6 px-5 py-5 lg:grid-cols-[220px_minmax(0,1fr)] lg:px-6">
                <div class="flex flex-col justify-center">
                    <div class="flex items-end gap-2">
                        <span class="text-5xl font-black leading-none">{{ number_format($averageRating, 1) }}</span>
                        <span class="pb-1 text-2xl font-bold text-slate-300">/5</span>
                    </div>
                    <div class="mt-3 flex items-center gap-0.5 text-primary">
                        @for($i = 1; $i <= 5; $i++)
                            <span class="material-symbols-outlined text-[22px]">star</span>
                        @endfor
                    </div>
                    <p class="mt-2 text-lg font-medium text-slate-200">{{ $totalRatings }} luot danh gia</p>
                </div>

                <div class="flex flex-col justify-center gap-3">
                    @foreach($ratingBreakdown as $star => $count)
                        @php
                            $percent = $totalRatings > 0 ? round(($count / $totalRatings) * 100, 2) : 0;
                        @endphp
                        <div class="grid grid-cols-[30px_minmax(0,1fr)_84px] items-center gap-3">
                            <div class="flex items-center gap-1 text-base font-bold text-white">
                                <span>{{ $star }}</span>
                                <span class="material-symbols-outlined text-primary text-[18px]">star</span>
                            </div>
                            <div class="h-2.5 overflow-hidden rounded-full bg-slate-800">
                                <div class="h-full rounded-full bg-red-500 transition-all duration-300" style="width: {{ $percent }}%"></div>
                            </div>
                            <div class="text-right text-sm text-slate-300">{{ $count }} danh gia</div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>

        <div class="bg-white rounded-xl shadow-[0_2px_10px_-3px_rgba(6,81,237,0.1)] border border-gray-100 overflow-hidden">
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-white">
                        <tr>
                            <th class="px-6 py-4 text-left text-xs font-black text-gray-500 uppercase">ID</th>
                            <th class="px-6 py-4 text-left text-xs font-black text-gray-500 uppercase">Loai</th>
                            <th class="px-6 py-4 text-left text-xs font-black text-gray-500 uppercase">User</th>
                            <th class="px-6 py-4 text-left text-xs font-black text-gray-500 uppercase">Product</th>
                            <th class="px-6 py-4 text-left text-xs font-black text-gray-500 uppercase">Anh</th>
                            <th class="px-6 py-4 text-left text-xs font-black text-gray-500 uppercase">Noi dung</th>
                            <th class="px-6 py-4 text-left text-xs font-black text-gray-500 uppercase">Thoi gian</th>
                            <th class="px-6 py-4 text-right text-xs font-black text-gray-500 uppercase">Action</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-100">
                        @forelse ($comments as $comment)
                            <tr class="hover:bg-yellow-50/30 transition-colors">
                                <td class="px-6 py-4 text-sm font-bold text-slate-700">#{{ $comment->id }}</td>
                                <td class="px-6 py-4 text-sm whitespace-nowrap">
                                    @if($comment->parent_id)
                                        <div class="flex flex-col gap-1">
                                            <span class="inline-flex w-fit items-center rounded-full bg-blue-100 px-2.5 py-1 text-[11px] font-bold text-blue-700">
                                                Reply
                                            </span>
                                            <span class="text-xs text-slate-400">
                                                Thuoc comment #{{ $comment->parent_id }}
                                            </span>
                                        </div>
                                    @else
                                        <span class="inline-flex items-center rounded-full bg-green-100 px-2.5 py-1 text-[11px] font-bold text-green-700">
                                            Comment mở đầu
                                        </span>
                                    @endif
                                </td>
                                <td class="px-6 py-4 text-sm text-slate-600 font-medium">
                                    {{ $comment->user?->name ?? $comment->guest_name ?? 'Guest' }}
                                </td>
                                <td class="px-6 py-4 text-sm">
                                    @if($comment->product)
                                        <a href="{{ route('products.show', $comment->product->id) }}#comments" class="font-bold text-blue-600 hover:text-blue-800 transition-colors">
                                            {{ $comment->product->name }}
                                        </a>
                                    @else
                                        <span class="text-slate-400 italic">San pham da xoa</span>
                                    @endif
                                </td>
                                <td class="px-6 py-4">
                                    @if($comment->image_path)
                                        <img src="{{ asset('storage/' . $comment->image_path) }}" alt="comment image" class="h-14 w-14 rounded-lg border border-slate-200 object-cover bg-slate-50">
                                    @else
                                        <div class="flex h-14 w-14 items-center justify-center rounded-lg border border-dashed border-slate-200 bg-slate-50 text-slate-300">
                                            <span class="material-symbols-outlined text-[20px]">image</span>
                                        </div>
                                    @endif
                                </td>
                                <td class="px-6 py-4 text-sm text-slate-600 max-w-xl">
                                    <div class="{{ $comment->parent_id ? 'border-l-4 border-blue-200 pl-4' : '' }}">
                                        <div class="line-clamp-2">{{ $comment->content }}</div>
                                    </div>
                                </td>
                                <td class="px-6 py-4 text-sm text-slate-500 whitespace-nowrap">
                                    {{ $comment->created_at->format('d/m/Y H:i') }}
                                </td>
                                <td class="px-6 py-4 text-right">
                                    <a href="{{ route('products.show', $comment->product->id) }}#comment-{{ $comment->id }}" class="inline-flex items-center justify-center rounded-lg bg-slate-50 px-3 py-2 text-xs font-bold text-slate-700 hover:bg-slate-100 transition-colors border border-slate-200">
                                        Xem lai
                                    </a>
                                    <form action="{{ route('admin.comments.destroy', $comment) }}" method="POST" class="inline ml-2" onsubmit="return confirm('Xoa comment nay?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="inline-flex items-center justify-center rounded-lg bg-red-50 px-3 py-2 text-xs font-bold text-red-600 hover:bg-red-100 transition-colors border border-red-200">
                                            Xoa
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="8" class="px-6 py-16 text-center text-gray-400 bg-gray-50/50">
                                    <span class="material-symbols-outlined text-5xl mb-3 text-gray-300 block">chat</span>
                                    <p class="text-sm font-medium text-gray-500">Chua co comment nao.</p>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </main>
</div>
@endsection
