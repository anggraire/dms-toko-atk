@extends('layouts.app')

@section('title', 'Daftar Dokumen')
@section('heading', 'Arsip Dokumen Operasional')
@section('subheading', 'Daftar Dokumen')

@section('content')

{{-- ─── Header + Upload CTA ──────────────────────────────────────────── --}}
<div class="mb-6 flex flex-wrap items-center justify-between gap-4">
    <p class="text-sm text-slate-500">
        Pencarian, pemfilteran, dan pemantauan seluruh arsip nota faktur, kwitansi, dan kontrak toko.
    </p>
    <a href="{{ route('documents.create') }}" class="btn-primary">
        <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15"/>
        </svg>
        <span>Unggah Dokumen Baru</span>
    </a>
</div>

{{-- ─── Filter & Search Toolbar ─────────────────────────────────────── --}}
<div class="card-base mb-6 p-4">
    <form method="GET" action="{{ route('documents.index') }}" class="grid gap-3 sm:grid-cols-12 items-end">
        <div class="sm:col-span-5">
            <label for="search" class="field-label">Cari Arsip</label>
            <div class="relative">
                <div class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-3.5 text-slate-400">
                    <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-5.197-5.197m0 0A7.5 7.5 0 105.196 5.196a7.5 7.5 0 0010.607 10.607z"/>
                    </svg>
                </div>
                <input id="search" name="search" type="text" value="{{ request('search') }}"
                       placeholder="Judul, nomor nota, atau nama supplier..."
                       class="field-input !pl-10">
            </div>
        </div>

        <div class="sm:col-span-3">
            <label for="category_id" class="field-label">Kategori</label>
            <select id="category_id" name="category_id" class="field-input">
                <option value="">Semua Kategori</option>
                @foreach ($categories as $cat)
                    <option value="{{ $cat->id }}" @selected(request('category_id') == $cat->id || request('category_slug') == $cat->slug)>
                        {{ $cat->name }}
                    </option>
                @endforeach
            </select>
        </div>

        <div class="sm:col-span-2">
            <label for="payment_status" class="field-label">Status Bayar</label>
            <select id="payment_status" name="payment_status" class="field-input">
                <option value="">Semua Status</option>
                <option value="lunas"       @selected(request('payment_status') == 'lunas')>Lunas</option>
                <option value="belum_lunas" @selected(request('payment_status') == 'belum_lunas')>Belum Lunas</option>
                <option value="n/a"         @selected(request('payment_status') == 'n/a')>N/A</option>
            </select>
        </div>

        <div class="sm:col-span-2 flex items-center gap-2">
            <button type="submit" class="btn-primary w-full !py-2.5">Filter</button>
            @if(request()->hasAny(['search','category_id','category_slug','payment_status','has_amount','due_soon']))
                <a href="{{ route('documents.index') }}"
                   class="btn-secondary !p-2.5 shrink-0" title="Reset filter">
                    <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/>
                    </svg>
                </a>
            @endif
        </div>
    </form>

    {{-- Active Filter Chips --}}
    @if(request()->hasAny(['search','category_id','category_slug','payment_status','has_amount','due_soon']))
        <div class="mt-3 flex flex-wrap items-center gap-2 border-t border-slate-100 pt-3">
            <span class="text-xs font-semibold text-slate-600">Filter aktif:</span>
            @if(request('search'))
                <span class="badge-slate">Pencarian: "{{ request('search') }}"</span>
            @endif
            @if(request('category_id') || request('category_slug'))
                @php
                    $activeCat = request('category_id')
                        ? $categories->firstWhere('id', request('category_id'))
                        : $categories->firstWhere('slug', request('category_slug'));
                @endphp
                @if($activeCat)
                    <span class="badge-emerald font-semibold">📁 {{ $activeCat->name }}</span>
                @endif
            @endif
            @if(request('payment_status'))
                <span class="badge-slate">Status: {{ ucfirst(str_replace('_',' ',request('payment_status'))) }}</span>
            @endif
            @if(request()->boolean('has_amount'))
                <span class="badge-slate">💰 Bernominal</span>
            @endif
            @if(request()->boolean('due_soon'))
                <span class="badge-rose font-semibold">⚠️ Jatuh Tempo 7 Hari</span>
            @endif
            <a href="{{ route('documents.index') }}" class="text-xs font-semibold text-brand-600 hover:underline">Hapus semua</a>
        </div>
    @endif
</div>

{{-- ─── Document Card Grid ────────────────────────────────────────────── --}}
@if ($documents->isEmpty())
    <div class="flex flex-col items-center justify-center rounded-2xl border-2 border-dashed border-slate-200 bg-white py-20 text-center">
        <div class="flex h-20 w-20 items-center justify-center rounded-2xl bg-slate-100">
            <svg class="h-10 w-10 text-slate-300" fill="none" viewBox="0 0 24 24" stroke-width="1.2" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-5.197-5.197m0 0A7.5 7.5 0 105.196 5.196a7.5 7.5 0 0010.607 10.607z"/>
            </svg>
        </div>
        <h3 class="mt-5 text-base font-bold text-slate-700">Tidak ada dokumen yang sesuai</h3>
        <p class="mt-1 max-w-sm text-sm text-slate-400">
            Coba ubah kata kunci pencarian, ganti filter, atau unggah dokumen baru.
        </p>
        <div class="mt-6 flex justify-center gap-3">
            @if(request()->hasAny(['search','category_id','payment_status']))
                <a href="{{ route('documents.index') }}" class="btn-secondary">Reset Filter</a>
            @endif
            <a href="{{ route('documents.create') }}" class="btn-primary">Unggah Dokumen</a>
        </div>
    </div>
@else
    {{-- Result count --}}
    <div class="mb-4 flex items-center justify-between">
        <p class="text-sm text-slate-500">
            Menampilkan
            <span class="font-semibold text-slate-700">{{ $documents->firstItem() }}–{{ $documents->lastItem() }}</span>
            dari <span class="font-semibold text-slate-700">{{ $documents->total() }}</span> dokumen
        </p>
    </div>

    {{-- ── Card Grid ──────────────────────────────────────────────────── --}}
    <div class="grid gap-5 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4">
        @foreach ($documents as $doc)
            @php
                $isPdf    = $doc->file_mime_type === 'application/pdf';
                $isImage  = str_starts_with($doc->file_mime_type ?? '', 'image/');
                $isLunas  = $doc->payment_status === 'lunas';
                $isUnpaid = $doc->payment_status === 'belum_lunas';
                $catSlug  = $doc->category?->slug ?? 'lainnya';
                $catMap   = [
                    'surat-kontrak'   => ['bg'=>'bg-emerald-50','text'=>'text-emerald-700','ring'=>'ring-emerald-200','dot'=>'bg-emerald-500'],
                    'faktur-supplier' => ['bg'=>'bg-blue-50',   'text'=>'text-blue-700',   'ring'=>'ring-blue-200',   'dot'=>'bg-blue-500'],
                    'dokumen-pajak'   => ['bg'=>'bg-amber-50',  'text'=>'text-amber-700',  'ring'=>'ring-amber-200',  'dot'=>'bg-amber-500'],
                    'dokumen-retur'   => ['bg'=>'bg-rose-50',   'text'=>'text-rose-700',   'ring'=>'ring-rose-200',   'dot'=>'bg-rose-500'],
                ];
                $c = $catMap[$catSlug] ?? ['bg'=>'bg-slate-100','text'=>'text-slate-600','ring'=>'ring-slate-200','dot'=>'bg-slate-400'];
            @endphp

            <a href="{{ route('documents.show', $doc->id) }}"
               class="group flex flex-col overflow-hidden rounded-2xl border border-slate-200/90 bg-white shadow-card transition-all duration-200 hover:-translate-y-1 hover:shadow-elevated hover:border-slate-300">

                {{-- ── Preview Area ──────────────────────────────────── --}}
                <div class="relative flex h-44 w-full items-center justify-center overflow-hidden bg-slate-100">

                    @if ($isImage)
                        {{-- Actual image preview --}}
                        <img src="{{ route('documents.file', $doc->id) }}"
                             alt="{{ $doc->title }}"
                             loading="lazy"
                             class="h-full w-full object-cover transition-transform duration-300 group-hover:scale-105">
                        <div class="absolute inset-0 bg-slate-900/0 transition-colors group-hover:bg-slate-900/10"></div>

                    @elseif ($isPdf)
                        {{-- PDF paper-stack placeholder --}}
                        <div class="flex flex-col items-center justify-center gap-3">
                            <div class="relative flex items-center justify-center">
                                <div class="absolute -right-3 -top-2 h-16 w-14 rotate-6 rounded-md bg-white/80 ring-1 ring-slate-300/60 shadow-xs"></div>
                                <div class="absolute -left-2 -top-1 h-16 w-14 -rotate-3 rounded-md bg-white/60 ring-1 ring-slate-300/40 shadow-xs"></div>
                                <div class="relative flex h-16 w-14 flex-col items-center justify-between rounded-md bg-white pt-2 pb-2 ring-1 ring-slate-300/80 shadow-sm">
                                    {{-- Folded corner --}}
                                    <div class="absolute right-0 top-0 h-0 w-0 border-b-[14px] border-l-[14px] border-b-transparent border-l-slate-200"></div>
                                    <svg class="mt-1 h-7 w-7 text-red-400" fill="none" viewBox="0 0 24 24" stroke-width="1.4" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 14.25v-2.625a3.375 3.375 0 00-3.375-3.375h-1.5A1.125 1.125 0 0113.5 7.125v-1.5a3.375 3.375 0 00-3.375-3.375H8.25m0 12.75h7.5m-7.5 3H12M10.5 2.25H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 00-9-9z"/>
                                    </svg>
                                    <div class="w-8 space-y-1 pb-1">
                                        <div class="h-1 rounded-full bg-slate-200"></div>
                                        <div class="h-1 w-4/5 rounded-full bg-slate-200"></div>
                                        <div class="h-1 w-3/5 rounded-full bg-slate-200"></div>
                                    </div>
                                </div>
                            </div>
                            <span class="rounded-md bg-red-100 px-2.5 py-0.5 text-xs font-bold uppercase tracking-wide text-red-600 ring-1 ring-red-200">PDF</span>
                        </div>

                    @else
                        <div class="flex flex-col items-center gap-2 text-slate-400">
                            <svg class="h-12 w-12" fill="none" viewBox="0 0 24 24" stroke-width="1.2" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 14.25v-2.625a3.375 3.375 0 00-3.375-3.375h-1.5A1.125 1.125 0 0113.5 7.125v-1.5a3.375 3.375 0 00-3.375-3.375H8.25m0 12.75h7.5m-7.5 3H12M10.5 2.25H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 00-9-9z"/>
                            </svg>
                            <span class="text-xs">File Dokumen</span>
                        </div>
                    @endif

                    {{-- File-type badge (top-left) --}}
                    <div class="absolute top-2.5 left-2.5">
                        @if ($isPdf)
                            <span class="rounded bg-red-600 px-1.5 py-0.5 text-[10px] font-bold uppercase text-white shadow-sm">PDF</span>
                        @elseif ($isImage)
                            <span class="rounded bg-brand-600 px-1.5 py-0.5 text-[10px] font-bold uppercase text-white shadow-sm">IMG</span>
                        @endif
                    </div>

                    {{-- Payment status badge (top-right) --}}
                    @if ($isLunas)
                        <div class="absolute top-2.5 right-2.5">
                            <span class="badge-emerald !text-[10px] shadow-sm">
                                <span class="h-1.5 w-1.5 rounded-full bg-emerald-500"></span> Lunas
                            </span>
                        </div>
                    @elseif ($isUnpaid)
                        <div class="absolute top-2.5 right-2.5">
                            <span class="badge-amber !text-[10px] shadow-sm">
                                <span class="h-1.5 w-1.5 rounded-full bg-amber-500"></span> Belum Lunas
                            </span>
                        </div>
                    @endif
                </div>

                {{-- ── Card Body ─────────────────────────────────────── --}}
                <div class="flex flex-1 flex-col p-4">
                    {{-- Category chip --}}
                    @if ($doc->category)
                        <div class="mb-2.5">
                            <span class="inline-flex items-center gap-1 rounded-md px-2 py-0.5 text-[10px] font-bold ring-1 ring-inset {{ $c['bg'] }} {{ $c['text'] }} {{ $c['ring'] }}">
                                <span class="h-1.5 w-1.5 rounded-full {{ $c['dot'] }}"></span>
                                {{ $doc->category->name }}
                            </span>
                        </div>
                    @endif

                    {{-- Title --}}
                    <h4 class="line-clamp-2 text-sm font-bold leading-snug text-slate-900 group-hover:text-brand-600 transition-colors">
                        {{ $doc->title }}
                    </h4>

                    {{-- Doc number --}}
                    <div class="mt-1 flex items-center gap-1.5">
                        <span class="font-mono text-[11px] text-slate-400">
                            {{ $doc->document_number ?? 'Tanpa Nomor' }}
                        </span>
                        @if($doc->importance_level === 'rahasia')
                            <span class="rounded bg-rose-50 px-1 py-0.5 text-[9px] font-bold uppercase text-rose-600 ring-1 ring-rose-200">Rahasia</span>
                        @endif
                    </div>

                    {{-- Supplier --}}
                    @if ($doc->entity_name)
                        <p class="mt-1.5 truncate text-xs text-slate-500">{{ $doc->entity_name }}</p>
                    @endif

                    {{-- Footer: amount + date + actions --}}
                    <div class="mt-auto border-t border-slate-100 pt-3">
                        <div class="flex items-end justify-between gap-2">
                            <div class="min-w-0">
                                @if ($doc->total_amount > 0)
                                    <p class="font-mono text-xs font-bold text-slate-900">
                                        Rp {{ number_format((float)$doc->total_amount, 0, ',', '.') }}
                                    </p>
                                @else
                                    <p class="text-xs text-slate-400">Tanpa nominal</p>
                                @endif
                                <p class="mt-0.5 text-[10px] text-slate-400">
                                    {{ $doc->document_date
                                        ? \Carbon\Carbon::parse($doc->document_date)->format('d M Y')
                                        : $doc->created_at->format('d M Y') }}
                                </p>
                            </div>
                            <div class="flex shrink-0 items-center gap-1.5">
                                <span class="inline-flex items-center gap-1 rounded-lg bg-slate-100 px-2.5 py-1.5 text-[11px] font-semibold text-slate-600 group-hover:bg-brand-600 group-hover:text-white transition-colors">
                                    Buka
                                    <svg class="h-3 w-3 transition-transform group-hover:translate-x-0.5" fill="none" viewBox="0 0 24 24" stroke-width="2.5" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M8.25 4.5l7.5 7.5-7.5 7.5"/>
                                    </svg>
                                </span>
                                @if(auth()->user()->isPemilik())
                                    <a href="{{ route('documents.edit', $doc->id) }}"
                                       onclick="event.stopPropagation()"
                                       class="flex h-7 w-7 items-center justify-center rounded-lg border border-slate-200 text-slate-400 hover:border-slate-300 hover:bg-slate-50 hover:text-slate-700 transition-colors"
                                       title="Edit">
                                        <svg class="h-3.5 w-3.5" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M16.862 4.487l1.687-1.688a1.875 1.875 0 112.652 2.652L10.582 16.07a4.5 4.5 0 01-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 011.13-1.897l8.932-8.931zm0 0L19.5 7.125M18 14v4.75A2.25 2.25 0 0115.75 21H5.25A2.25 2.25 0 013 18.75V8.25A2.25 2.25 0 015.25 6H10"/>
                                        </svg>
                                    </a>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </a>
        @endforeach
    </div>

    {{-- Pagination --}}
    @if ($documents->hasPages())
        <div class="mt-8 flex justify-center">
            {{ $documents->links() }}
        </div>
    @endif
@endif

@endsection