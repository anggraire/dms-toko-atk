@extends('layouts.app')

@section('title', 'Dashboard')
@section('heading', 'Dashboard')

@section('content')
    @php
        // Tampilan saja: href masih '#'. Nanti ganti dengan route(...) saat sudah siap disambungkan.
        // Untuk menambah menu baru, cukup salin satu blok [...] di bawah.
        $menus = [
            [
                'title'   => 'Dokumen Perusahaan',
                'desc'    => 'Legalitas dan kontrak usaha toko.',
                'items'   => ['NIB dan NPWP', 'Izin usaha', 'Kontrak sewa toko', 'Kontrak supplier'],
                'href'    => '#',
                'iconBg'  => 'bg-brand-50 text-brand-600 group-hover:bg-brand-600 group-hover:text-white',
                'path'    => 'M3.75 21h16.5M4.5 3h15M5.25 3v18m13.5-18v18M9 6.75h1.5m-1.5 3h1.5m-1.5 3h1.5m3-6H15m-1.5 3H15m-1.5 3H15M9 21v-3.375c0-.621.504-1.125 1.125-1.125h3.75c.621 0 1.125.504 1.125 1.125V21',
            ],
            [
                'title'   => 'Dokumen Penjualan',
                'desc'    => 'Bukti transaksi dengan pelanggan.',
                'items'   => ['Nota dan struk kasir', 'Faktur ke sekolah atau kantor', 'Surat pesanan', 'Surat jalan'],
                'href'    => '#',
                'iconBg'  => 'bg-blue-50 text-blue-600 group-hover:bg-blue-600 group-hover:text-white',
                'path'    => 'M2.25 3h1.386c.51 0 .955.343 1.087.835l.383 1.437M7.5 14.25a3 3 0 00-3 3h15.75m-12.75-3h11.218c1.121-2.3 2.1-4.684 2.924-7.138a60.114 60.114 0 00-16.536-1.84M7.5 14.25L5.106 5.272M6 20.25a.75.75 0 11-1.5 0 .75.75 0 011.5 0zm12.75 0a.75.75 0 11-1.5 0 .75.75 0 011.5 0z',
            ],
            [
                'title'   => 'Dokumen Keuangan',
                'desc'    => 'Catatan uang masuk, keluar, dan pajak.',
                'items'   => ['Bukti pembayaran', 'Laporan kas', 'Bukti setor pajak', 'Laporan laba rugi'],
                'href'    => '#',
                'iconBg'  => 'bg-amber-50 text-amber-600 group-hover:bg-amber-600 group-hover:text-white',
                'path'    => 'M2.25 18.75a60.07 60.07 0 0115.797 2.101c.727.198 1.453-.342 1.453-1.096V18.75M3.75 4.5v.75A.75.75 0 013 6h-.75m0 0v-.375c0-.621.504-1.125 1.125-1.125H20.25M2.25 6v9m18-10.5v.75c0 .414.336.75.75.75h.75m-1.5-1.5h.375c.621 0 1.125.504 1.125 1.125v9.75c0 .621-.504 1.125-1.125 1.125h-.375m1.5-1.5H21a.75.75 0 00-.75.75v.75m0 0H3.75m0 0h-.375a1.125 1.125 0 01-1.125-1.125V15m1.5 1.5v-.75A.75.75 0 003 15h-.75M15 10.5a3 3 0 11-6 0 3 3 0 016 0zm3 0h.008v.008H18V10.5zm-12 0h.008v.008H6V10.5z',
            ],
            [
                'title'   => 'Dokumen Retur',
                'desc'    => 'Barang yang dikembalikan atau ditolak.',
                'items'   => ['Retur dari pelanggan', 'Retur ke supplier', 'Berita acara barang rusak', 'Nota kredit dan debit'],
                'href'    => '#',
                'iconBg'  => 'bg-rose-50 text-rose-600 group-hover:bg-rose-600 group-hover:text-white',
                'path'    => 'M9 15L3 9m0 0l6-6M3 9h12a6 6 0 010 12h-3',
            ],
        ];
    @endphp

    <div class="grid gap-5 sm:grid-cols-2 xl:grid-cols-4">
        @foreach ($menus as $menu)
            <a href="{{ $menu['href'] }}"
               class="group flex flex-col rounded-2xl border border-slate-200 bg-white p-6 shadow-card transition-colors hover:border-brand-500 focus:outline-none focus-visible:ring-2 focus-visible:ring-brand-500 focus-visible:ring-offset-2">
                <div class="flex h-14 w-14 items-center justify-center rounded-2xl transition-colors {{ $menu['iconBg'] }}">
                    <svg class="h-7 w-7" fill="none" viewBox="0 0 24 24" stroke-width="1.7" stroke="currentColor" aria-hidden="true">
                        <path stroke-linecap="round" stroke-linejoin="round" d="{{ $menu['path'] }}"/>
                    </svg>
                </div>

                <h3 class="mt-5 text-lg font-bold tracking-tight text-slate-900">{{ $menu['title'] }}</h3>
                <p class="mt-1 text-sm text-slate-500">{{ $menu['desc'] }}</p>

                <ul class="mt-5 space-y-2 border-t border-slate-100 pt-4 text-sm text-slate-600">
                    @foreach ($menu['items'] as $item)
                        <li class="flex items-center gap-2">
                            <span class="h-1.5 w-1.5 shrink-0 rounded-full bg-slate-300 transition-colors group-hover:bg-brand-500"></span>
                            <span>{{ $item }}</span>
                        </li>
                    @endforeach
                </ul>
            </a>
        @endforeach
    </div>
@endsection