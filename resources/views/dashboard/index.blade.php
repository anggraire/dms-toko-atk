@extends('layouts.app')

@section('title', 'Dashboard')
@section('heading', 'Pusat Arsip Dokumen')
@section('subheading', 'DMS Toko ATK')

@php
    $categoriesMenu = [
        [
            'title'      => 'Surat & Kontrak',
            'desc'       => 'Legalitas, NIB, NPWP, izin usaha',
            'slug'       => 'surat-kontrak',
            'count'      => $categories['surat-kontrak']->documents_count ?? 0,
            'href'       => route('documents.index', ['category_slug' => 'surat-kontrak']),
            'color'      => 'emerald',
            'folderBg'   => 'from-emerald-400 to-emerald-600',
            'path'       => 'M3.75 21h16.5M4.5 3h15M5.25 3v18m13.5-18v18M9 6.75h1.5m-1.5 3h1.5m-1.5 3h1.5m3-6H15m-1.5 3H15m-1.5 3H15M9 21v-3.375c0-.621.504-1.125 1.125-1.125h3.75c.621 0 1.125.504 1.125 1.125V21',
        ],
        [
            'title'      => 'Faktur & Nota Penjualan',
            'desc'       => 'Nota kasir, faktur ATK, surat jalan',
            'slug'       => 'faktur-supplier',
            'count'      => $categories['faktur-supplier']->documents_count ?? 0,
            'href'       => route('documents.index', ['category_slug' => 'faktur-supplier']),
            'color'      => 'blue',
            'folderBg'   => 'from-blue-400 to-blue-600',
            'path'       => 'M2.25 3h1.386c.51 0 .955.343 1.087.835l.383 1.437M7.5 14.25a3 3 0 00-3 3h15.75m-12.75-3h11.218c1.121-2.3 2.1-4.684 2.924-7.138a60.114 60.114 0 00-16.536-1.84M7.5 14.25L5.106 5.272M6 20.25a.75.75 0 11-1.5 0 .75.75 0 011.5 0zm12.75 0a.75.75 0 11-1.5 0 .75.75 0 011.5 0z',
        ],
        [
            'title'      => 'Keuangan & Pajak',
            'desc'       => 'Bukti bayar, laporan kas, pajak',
            'slug'       => 'dokumen-pajak',
            'count'      => $categories['dokumen-pajak']->documents_count ?? 0,
            'href'       => route('documents.index', ['category_slug' => 'dokumen-pajak']),
            'color'      => 'amber',
            'folderBg'   => 'from-amber-400 to-amber-600',
            'path'       => 'M2.25 18.75a60.07 60.07 0 0115.797 2.101c.727.198 1.453-.342 1.453-1.096V18.75M3.75 4.5v.75A.75.75 0 013 6h-.75m0 0v-.375c0-.621.504-1.125 1.125-1.125H20.25M2.25 6v9m18-10.5v.75c0 .414.336.75.75.75h.75m-1.5-1.5h.375c.621 0 1.125.504 1.125 1.125v9.75c0 .621-.504 1.125-1.125 1.125h-.375m1.5-1.5H21a.75.75 0 00-.75.75v.75m0 0H3.75m0 0h-.375a1.125 1.125 0 01-1.125-1.125V15m1.5 1.5v-.75A.75.75 0 003 15h-.75M15 10.5a3 3 0 11-6 0 3 3 0 016 0zm3 0h.008v.008H18V10.5zm-12 0h.008v.008H6V10.5z',
        ],
        [
            'title'      => 'Retur & Klaim',
            'desc'       => 'Nota retur, debit/kredit, klaim supplier',
            'slug'       => 'dokumen-retur',
            'count'      => $categories['dokumen-retur']->documents_count ?? 0,
            'href'       => route('documents.index', ['category_slug' => 'dokumen-retur']),
            'color'      => 'rose',
            'folderBg'   => 'from-rose-400 to-rose-600',
            'path'       => 'M9 15L3 9m0 0l6-6M3 9h12a6 6 0 010 12h-3',
        ],
    ];
@endphp

@section('content')

{{-- ═══════════════════════════════════════════════════════════════
     SECTION 1 — Page Header + Primary CTA
═══════════════════════════════════════════════════════════════ --}}
<div class="mb-8 flex flex-col justify-between gap-4 sm:flex-row sm:items-start">
    <div>
        <p class="text-sm text-slate-500">
            Halo, <span class="font-semibold text-slate-700">{{ auth()->user()->name }}</span> —
            sistem arsip digital toko ATK Anda. Kelola, telusuri, dan pindai dokumen di satu tempat.
        </p>
    </div>
</div>

{{-- ═══════════════════════════════════════════════════════════════
     SECTION 2 — Quick Stats Bar (ringkas, 1 baris)
═══════════════════════════════════════════════════════════════ --}}
<div class="mb-8 grid grid-cols-2 gap-3 lg:grid-cols-4">
    <a href="{{ route('documents.index') }}" class="stat-card group flex items-center gap-3 hover:border-brand-500">
        <div class="flex h-10 w-10 shrink-0 items-center justify-center rounded-xl bg-brand-50 text-brand-600 group-hover:bg-brand-600 group-hover:text-white transition-colors">
            <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke-width="1.8" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 14.25v-2.625a3.375 3.375 0 00-3.375-3.375h-1.5A1.125 1.125 0 0113.5 7.125v-1.5a3.375 3.375 0 00-3.375-3.375H8.25m0 12.75h7.5m-7.5 3H12M10.5 2.25H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 00-9-9z"/>
            </svg>
        </div>
        <div>
            <p class="text-xl font-extrabold text-slate-900 leading-none">{{ $totalDocuments }}</p>
            <p class="mt-0.5 text-xs text-slate-500 font-medium">Total Berkas</p>
        </div>
    </a>
    <a href="{{ route('documents.index', ['has_amount' => 1]) }}" class="stat-card group flex items-center gap-3 hover:border-blue-500">
        <div class="flex h-10 w-10 shrink-0 items-center justify-center rounded-xl bg-blue-50 text-blue-600 group-hover:bg-blue-600 group-hover:text-white transition-colors">
            <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke-width="1.8" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" d="M12 6v12m-3-2.818l.879.659c1.171.879 3.07.879 4.242 0 1.172-.879 1.172-2.303 0-3.182C13.536 12.219 12.768 12 12 12c-.725 0-1.45-.22-2.003-.659-1.106-.879-1.106-2.303 0-3.182s2.9-.879 4.006 0l.415.33M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
            </svg>
        </div>
        <div>
            <p class="text-base font-extrabold text-slate-900 leading-none truncate">Rp {{ number_format($totalAmountSum / 1000, 0, ',', '.') }}K</p>
            <p class="mt-0.5 text-xs text-slate-500 font-medium">Nilai Transaksi</p>
        </div>
    </a>
    <a href="{{ route('documents.index', ['payment_status' => 'belum_lunas']) }}" class="stat-card group flex items-center gap-3 hover:border-amber-500">
        <div class="flex h-10 w-10 shrink-0 items-center justify-center rounded-xl bg-amber-50 text-amber-600 group-hover:bg-amber-600 group-hover:text-white transition-colors">
            <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke-width="1.8" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" d="M12 6v6h4.5m4.5 0a9 9 0 11-18 0 9 9 0 0118 0z"/>
            </svg>
        </div>
        <div>
            <p class="text-xl font-extrabold text-amber-600 leading-none">{{ $unpaidCount }}</p>
            <p class="mt-0.5 text-xs text-slate-500 font-medium">Nota Belum Lunas</p>
        </div>
    </a>
    <a href="{{ route('documents.index', ['due_soon' => 1]) }}" class="stat-card group flex items-center gap-3 hover:border-rose-500">
        <div class="flex h-10 w-10 shrink-0 items-center justify-center rounded-xl bg-rose-50 text-rose-600 group-hover:bg-rose-600 group-hover:text-white transition-colors">
            <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke-width="1.8" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" d="M14.857 17.082a23.848 23.848 0 005.454-1.31A8.967 8.967 0 0118 9.75v-.7V9A6 6 0 006 9v.75a8.967 8.967 0 01-2.312 6.022c1.733.64 3.56 1.085 5.455 1.31m5.714 0a24.255 24.255 0 01-5.714 0m5.714 0a3 3 0 11-5.714 0"/>
            </svg>
        </div>
        <div>
            <p class="text-xl font-extrabold {{ count($dueSoonDocuments ?? []) > 0 ? 'text-rose-600' : 'text-slate-900' }} leading-none">
                {{ count($dueSoonDocuments ?? []) }}
            </p>
            <p class="mt-0.5 text-xs text-slate-500 font-medium">Jatuh Tempo (7 hari)</p>
        </div>
    </a>
</div>

{{-- ═══════════════════════════════════════════════════════════════
     SECTION 3 — Folder / Category Grid (LARGE CARDS — DMS feel)
═══════════════════════════════════════════════════════════════ --}}
<div class="mb-8">
    <div class="mb-4 flex items-center justify-between">
        <div class="flex items-center gap-2.5">
            <svg class="h-5 w-5 text-slate-400" fill="none" viewBox="0 0 24 24" stroke-width="1.8" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 12.75V12A2.25 2.25 0 014.5 9.75h15A2.25 2.25 0 0121.75 12v.75m-8.69-6.44l-2.12-2.12a1.5 1.5 0 00-1.061-.44H4.5A2.25 2.25 0 002.25 6v12a2.25 2.25 0 002.25 2.25h15A2.25 2.25 0 0021.75 18V9a2.25 2.25 0 00-2.25-2.25h-5.379a1.5 1.5 0 01-1.06-.44z"/>
            </svg>
            <h3 class="text-base font-bold text-slate-900">Folder Kategori Dokumen</h3>
        </div>
        <a href="{{ route('documents.index') }}" class="text-xs font-semibold text-brand-600 hover:text-brand-700 hover:underline flex items-center gap-1">
            <span>Lihat semua</span>
            <svg class="h-3.5 w-3.5" fill="none" viewBox="0 0 24 24" stroke-width="2.5" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" d="M8.25 4.5l7.5 7.5-7.5 7.5"/>
            </svg>
        </a>
    </div>

    <div class="grid grid-cols-2 gap-4 lg:grid-cols-4">
        @foreach ($categoriesMenu as $menu)
        <a href="{{ $menu['href'] }}"
           class="group relative flex flex-col overflow-hidden rounded-2xl border border-slate-200/90 bg-white shadow-card transition-all duration-200 hover:-translate-y-1 hover:shadow-elevated hover:border-slate-300">

            {{-- Folder Tab Shape at top --}}
            <div class="h-24 bg-gradient-to-br {{ $menu['folderBg'] }} flex items-center justify-center relative">
                {{-- Subtle folder tab indicator --}}
                <div class="absolute top-0 left-0 h-4 w-12 rounded-br-xl bg-white/20"></div>

                {{-- Document icon stack (decorative) --}}
                <div class="relative flex items-center justify-center">
                    {{-- Back "paper" --}}
                    <div class="absolute -right-2 -top-2 h-10 w-8 rotate-6 rounded-sm bg-white/20"></div>
                    <div class="absolute -left-1 -top-1 h-10 w-8 -rotate-3 rounded-sm bg-white/25"></div>
                    {{-- Main icon --}}
                    <div class="relative flex h-12 w-12 items-center justify-center rounded-xl bg-white/25 ring-1 ring-white/30 shadow-lg">
                        <svg class="h-6 w-6 text-white" fill="none" viewBox="0 0 24 24" stroke-width="1.8" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="{{ $menu['path'] }}"/>
                        </svg>
                    </div>
                </div>

                {{-- Document count badge --}}
                <div class="absolute top-3 right-3">
                    <span class="rounded-full bg-white/30 px-2 py-0.5 text-[11px] font-bold text-white backdrop-blur-sm ring-1 ring-white/20">
                        {{ $menu['count'] }} berkas
                    </span>
                </div>
            </div>

            {{-- Folder Body --}}
            <div class="flex flex-1 flex-col p-4">
                <h4 class="text-sm font-bold leading-snug text-slate-900 group-hover:text-brand-600 transition-colors">
                    {{ $menu['title'] }}
                </h4>
                <p class="mt-1 flex-1 text-xs text-slate-500 leading-relaxed">
                    {{ $menu['desc'] }}
                </p>
                <div class="mt-3 flex items-center gap-1 text-xs font-semibold text-slate-400 group-hover:text-brand-600 transition-colors">
                    <span>Buka folder</span>
                    <svg class="h-3.5 w-3.5 transition-transform group-hover:translate-x-0.5" fill="none" viewBox="0 0 24 24" stroke-width="2.5" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M8.25 4.5l7.5 7.5-7.5 7.5"/>
                    </svg>
                </div>
            </div>
        </a>
        @endforeach

        {{-- Add / Upload Tile --}}
    </div>
</div>

{{-- ═══════════════════════════════════════════════════════════════
     SECTION 4 — Alert Tagihan Jatuh Tempo
═══════════════════════════════════════════════════════════════ --}}
@if (!empty($dueSoonDocuments) && $dueSoonDocuments->isNotEmpty())
<div class="mb-8 rounded-2xl border border-amber-200/90 bg-amber-50/60 p-5">
    <div class="mb-3 flex items-center gap-2.5">
        <span class="flex h-8 w-8 items-center justify-center rounded-xl bg-amber-500 text-white">
            <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m-9.303 3.376c-.866 1.5.217 3.374 1.948 3.374h14.71c1.73 0 2.813-1.874 1.948-3.374L13.949 3.378c-.866-1.5-3.032-1.5-3.898 0L2.697 16.126zM12 15.75h.007v.008H12v-.008z"/>
            </svg>
        </span>
        <div class="flex-1">
            <h4 class="text-sm font-bold text-amber-950">
                {{ $dueSoonDocuments->count() }} nota supplier mendekati atau melewati jatuh tempo
            </h4>
            <p class="text-xs text-amber-800">Segera tindak lanjuti pembayaran agar arus barang tidak terganggu.</p>
        </div>
        <a href="{{ route('documents.index', ['payment_status' => 'belum_lunas']) }}" class="shrink-0 text-xs font-bold text-amber-900 hover:underline">
            Lihat semua &rarr;
        </a>
    </div>
    <div class="grid gap-2 sm:grid-cols-2 lg:grid-cols-3">
        @foreach ($dueSoonDocuments as $dueDoc)
            @php
                $dueDate  = \Carbon\Carbon::parse($dueDoc->due_date);
                $isOver   = $dueDate->isPast() && !$dueDate->isToday();
                $diff     = now()->startOfDay()->diffInDays($dueDate->startOfDay(), false);
            @endphp
            <a href="{{ route('documents.show', $dueDoc->id) }}"
               class="flex items-center justify-between gap-3 rounded-xl border border-amber-200/80 bg-white px-3.5 py-3 text-xs shadow-xs hover:border-amber-300 transition-all">
                <div class="min-w-0">
                    <p class="truncate font-bold text-slate-900">{{ $dueDoc->title }}</p>
                    <p class="truncate text-slate-500">{{ $dueDoc->entity_name ?? 'Supplier' }} · {{ $dueDoc->formattedAmount() }}</p>
                </div>
                <span class="{{ $isOver ? 'badge-rose' : 'badge-amber' }} shrink-0 !text-[10px]">
                    {{ $isOver ? 'Lewat '.abs($diff).' hr' : ($diff === 0 ? 'Hari ini' : $diff.' hr lagi') }}
                </span>
            </a>
        @endforeach
    </div>
</div>
@endif

{{-- ═══════════════════════════════════════════════════════════════
     SECTION 5 — Dokumen Terbaru (Large Document Cards — UTAMA)
═══════════════════════════════════════════════════════════════ --}}
<div>
    <div class="mb-4 flex items-center justify-between">
        <div class="flex items-center gap-2.5">
            <svg class="h-5 w-5 text-slate-400" fill="none" viewBox="0 0 24 24" stroke-width="1.8" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" d="M12 6v6h4.5m4.5 0a9 9 0 11-18 0 9 9 0 0118 0z"/>
            </svg>
            <h3 class="text-base font-bold text-slate-900">Dokumen Terbaru</h3>
        </div>
        <a href="{{ route('documents.index') }}" class="text-xs font-semibold text-brand-600 hover:text-brand-700 hover:underline flex items-center gap-1">
            <span>Lihat semua arsip</span>
            <svg class="h-3.5 w-3.5" fill="none" viewBox="0 0 24 24" stroke-width="2.5" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" d="M8.25 4.5l7.5 7.5-7.5 7.5"/>
            </svg>
        </a>
    </div>

    @if ($documents->isEmpty())
        {{-- Empty state (styled as document area) --}}
        <div class="flex flex-col items-center justify-center rounded-2xl border-2 border-dashed border-slate-200 bg-white py-20 text-center">
            <div class="flex h-20 w-20 items-center justify-center rounded-2xl bg-slate-100">
                <svg class="h-10 w-10 text-slate-300" fill="none" viewBox="0 0 24 24" stroke-width="1.2" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 14.25v-2.625a3.375 3.375 0 00-3.375-3.375h-1.5A1.125 1.125 0 0113.5 7.125v-1.5a3.375 3.375 0 00-3.375-3.375H8.25m0 12.75h7.5m-7.5 3H12M10.5 2.25H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 00-9-9z"/>
                </svg>
            </div>
            <h4 class="mt-5 text-base font-bold text-slate-700">Arsip masih kosong</h4>
            <p class="mt-1 max-w-xs text-sm text-slate-400">
                Unggah nota belanja, faktur supplier, atau surat kontrak pertama Anda untuk memulai.
            </p>
            <a href="{{ route('documents.create') }}" class="btn-primary mt-6">
                <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15"/>
                </svg>
                Unggah Dokumen Pertama
            </a>
        </div>
    @else
        {{-- LARGE Document Card Grid --}}
        <div class="grid gap-4 sm:grid-cols-2 xl:grid-cols-4">
            @foreach ($documents as $doc)
                @php
                    $isPdf    = $doc->file_mime_type === 'application/pdf';
                    $isLunas  = $doc->payment_status === 'lunas';
                    $isUnpaid = $doc->payment_status === 'belum_lunas';
                    $catColors = [
                        'surat-kontrak'  => ['bg' => 'bg-emerald-50', 'text' => 'text-emerald-700', 'border' => 'border-emerald-200', 'dot' => 'bg-emerald-500'],
                        'faktur-supplier'=> ['bg' => 'bg-blue-50',    'text' => 'text-blue-700',    'border' => 'border-blue-200',    'dot' => 'bg-blue-500'],
                        'dokumen-pajak'  => ['bg' => 'bg-amber-50',   'text' => 'text-amber-700',   'border' => 'border-amber-200',   'dot' => 'bg-amber-500'],
                        'dokumen-retur'  => ['bg' => 'bg-rose-50',    'text' => 'text-rose-700',    'border' => 'border-rose-200',    'dot' => 'bg-rose-500'],
                    ];
                    $slug  = $doc->category?->slug ?? 'lainnya';
                    $color = $catColors[$slug] ?? ['bg' => 'bg-slate-50', 'text' => 'text-slate-600', 'border' => 'border-slate-200', 'dot' => 'bg-slate-400'];
                @endphp

                <a href="{{ route('documents.show', $doc->id) }}"
                   class="group flex flex-col overflow-hidden rounded-2xl border border-slate-200/90 bg-white shadow-card transition-all duration-200 hover:-translate-y-1 hover:shadow-elevated hover:border-slate-300">

                    {{-- Document "Preview" Header --}}
                    <div class="relative flex h-28 flex-col items-center justify-center gap-2 bg-slate-50 border-b border-slate-100">

                        {{-- File type badge (top-left) --}}
                        <div class="absolute top-3 left-3">
                            @if ($isPdf)
                                <span class="rounded-md bg-red-100 px-2 py-0.5 text-[10px] font-bold uppercase text-red-600 ring-1 ring-red-200">PDF</span>
                            @else
                                <span class="rounded-md bg-slate-200 px-2 py-0.5 text-[10px] font-bold uppercase text-slate-600">IMG</span>
                            @endif
                        </div>

                        {{-- Payment status badge (top-right) --}}
                        @if ($isLunas)
                            <div class="absolute top-3 right-3">
                                <span class="badge-emerald !text-[10px]">
                                    <span class="h-1.5 w-1.5 rounded-full bg-emerald-500"></span>
                                    Lunas
                                </span>
                            </div>
                        @elseif ($isUnpaid)
                            <div class="absolute top-3 right-3">
                                <span class="badge-amber !text-[10px]">
                                    <span class="h-1.5 w-1.5 rounded-full bg-amber-500"></span>
                                    Belum Lunas
                                </span>
                            </div>
                        @endif

                        {{-- Large document icon --}}
                        <div class="flex h-14 w-12 flex-col items-center justify-center rounded-lg bg-white shadow-sm ring-1 ring-slate-200/80 transition-transform group-hover:scale-105">
                            @if ($isPdf)
                                <div class="flex h-full w-full flex-col items-center justify-center rounded-lg bg-gradient-to-b from-red-50 to-white">
                                    <svg class="h-7 w-7 text-red-500" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 14.25v-2.625a3.375 3.375 0 00-3.375-3.375h-1.5A1.125 1.125 0 0113.5 7.125v-1.5a3.375 3.375 0 00-3.375-3.375H8.25m0 12.75h7.5m-7.5 3H12M10.5 2.25H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 00-9-9z"/>
                                    </svg>
                                    <span class="mt-0.5 text-[9px] font-extrabold uppercase tracking-wider text-red-500">PDF</span>
                                </div>
                            @else
                                <div class="flex h-full w-full flex-col items-center justify-center rounded-lg bg-gradient-to-b from-brand-50 to-white">
                                    <svg class="h-7 w-7 text-brand-500" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 15.75l5.159-5.159a2.25 2.25 0 013.182 0l5.159 5.159m-1.5-1.5l1.409-1.409a2.25 2.25 0 013.182 0l2.909 2.909m-18 3.75h16.5a1.5 1.5 0 001.5-1.5V6a1.5 1.5 0 00-1.5-1.5H3.75A1.5 1.5 0 002.25 6v12a1.5 1.5 0 001.5 1.5zm10.5-11.25h.008v.008h-.008V8.25zm.375 0a.375.375 0 11-.75 0 .375.375 0 01.75 0z"/>
                                    </svg>
                                    <span class="mt-0.5 text-[9px] font-extrabold uppercase tracking-wider text-brand-500">IMG</span>
                                </div>
                            @endif
                        </div>

                        {{-- Faint "lines" decoration to mimic document content --}}
                        <div class="absolute bottom-3 flex flex-col gap-1 w-16 opacity-20">
                            <div class="h-1 rounded-full bg-slate-400 w-full"></div>
                            <div class="h-1 rounded-full bg-slate-400 w-4/5"></div>
                            <div class="h-1 rounded-full bg-slate-400 w-3/5"></div>
                        </div>
                    </div>

                    {{-- Document Meta / Body --}}
                    <div class="flex flex-1 flex-col p-4">
                        {{-- Category tag --}}
                        @if ($doc->category)
                            <span class="mb-2 inline-flex w-fit items-center gap-1 rounded-md px-2 py-0.5 text-[10px] font-bold {{ $color['bg'] }} {{ $color['text'] }} ring-1 ring-inset {{ $color['border'] }}">
                                <span class="h-1.5 w-1.5 rounded-full {{ $color['dot'] }}"></span>
                                {{ $doc->category->name }}
                            </span>
                        @endif

                        {{-- Title --}}
                        <h4 class="line-clamp-2 text-sm font-bold leading-snug text-slate-900 group-hover:text-brand-600 transition-colors">
                            {{ $doc->title }}
                        </h4>

                        {{-- Supplier name --}}
                        @if ($doc->entity_name)
                            <p class="mt-1 truncate text-xs text-slate-500">
                                {{ $doc->entity_name }}
                            </p>
                        @endif

                        {{-- Footer meta --}}
                        <div class="mt-auto pt-3 border-t border-slate-100 flex items-center justify-between gap-2">
                            @if ($doc->total_amount > 0)
                                <span class="font-mono text-xs font-bold text-slate-800">
                                    Rp {{ number_format($doc->total_amount, 0, ',', '.') }}
                                </span>
                            @else
                                <span class="text-xs text-slate-400">— Tanpa nominal</span>
                            @endif

                            <span class="text-[10px] text-slate-400 font-medium shrink-0">
                                {{ $doc->document_date ? $doc->document_date->format('d/m/Y') : $doc->created_at->format('d/m/Y') }}
                            </span>
                        </div>
                    </div>
                </a>
            @endforeach

            {{-- "View More" tile --}}
            <a href="{{ route('documents.index') }}"
               class="group flex flex-col items-center justify-center gap-3 rounded-2xl border-2 border-dashed border-slate-200 bg-white py-8 text-center transition-all hover:border-brand-300 hover:bg-brand-50/30">
                <div class="flex h-12 w-12 items-center justify-center rounded-xl bg-slate-100 text-slate-400 group-hover:bg-brand-100 group-hover:text-brand-600 transition-all">
                    <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke-width="1.8" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 9.776c.112-.017.227-.026.344-.026h15.812c.117 0 .232.009.344.026m-16.5 0a2.25 2.25 0 00-1.883 2.542l.857 6a2.25 2.25 0 002.227 1.932H19.05a2.25 2.25 0 002.227-1.932l.857-6a2.25 2.25 0 00-1.883-2.542m-16.5 0V6A2.25 2.25 0 016 3.75h3.879a1.5 1.5 0 011.06.44l2.122 2.12a1.5 1.5 0 001.06.44H18A2.25 2.25 0 0120.25 9v.776"/>
                    </svg>
                </div>
                <div>
                    <p class="text-sm font-bold text-slate-600 group-hover:text-brand-700">Lihat Semua Arsip</p>
                    <p class="mt-0.5 text-xs text-slate-400">{{ $totalDocuments }} berkas tersimpan</p>
                </div>
            </a>
        </div>
    @endif
</div>

@endsection

@push('scripts')
<script>
    // Animate cards on load
    document.querySelectorAll('.shadow-card').forEach((el, i) => {
        el.style.opacity = '0';
        el.style.transform = 'translateY(12px)';
        el.style.transition = 'opacity 0.3s ease, transform 0.3s ease';
        el.style.transitionDelay = (i * 30) + 'ms';
        requestAnimationFrame(() => requestAnimationFrame(() => {
            el.style.opacity = '1';
            el.style.transform = 'translateY(0)';
        }));
    });
</script>
@endpush