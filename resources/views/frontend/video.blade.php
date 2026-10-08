@extends('layouts.app')

@section('title', 'Galeri Video — CuplikCom')

@section('content')
<div class="space-y-8">
    
    <!-- Video Header -->
    <div class="bg-zinc-950 text-white rounded-xl p-6 sm:p-8 border border-zinc-800 flex flex-col md:flex-row md:items-center justify-between gap-4">
        <div>
            <div class="flex items-center gap-2 mb-2">
                <span class="w-2.5 h-2.5 rounded-full bg-red-600 animate-pulse"></span>
                <span class="text-xs font-bold uppercase tracking-wider text-red-400">Saluran Multimedia</span>
            </div>
            <h1 class="text-2xl sm:text-3xl font-black uppercase tracking-tight text-white">
                Galeri Video Cuplik
            </h1>
            <p class="text-xs text-gray-400 mt-1">
                Kompilasi liputan investigasi khusus, siaran langsung peristiwa Pantura, dan wawancara eksklusif.
            </p>
        </div>
    </div>

    <!-- Featured Video (Big Player) -->
    @if($featuredVideo)
        <div class="bg-zinc-950 rounded-xl p-6 border border-zinc-800 text-white grid grid-cols-1 lg:grid-cols-12 gap-6 items-center shadow-lg">
            <div class="lg:col-span-8">
                <div class="aspect-video w-full rounded-lg overflow-hidden border border-zinc-800 shadow-2xl">
                    <iframe class="w-full h-full" src="https://www.youtube.com/embed/{{ $featuredVideo->youtube_id }}" title="{{ $featuredVideo->judul }}" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
                </div>
            </div>
            <div class="lg:col-span-4 space-y-3">
                <span class="bg-red-600 text-white text-[10px] font-extrabold px-2 py-0.5 rounded uppercase">Video Utama</span>
                <h2 class="text-xl font-bold leading-snug text-white hover:text-red-400 transition-colors">
                    <a href="{{ route('video.show', $featuredVideo->slug) }}">
                        {{ $featuredVideo->judul }}
                    </a>
                </h2>
                <div class="text-xs text-gray-400 flex items-center gap-3">
                    <span>{{ $featuredVideo->formatted_date }}</span>
                    <span>·</span>
                    <span>{{ number_format($featuredVideo->dibaca) }} tayang</span>
                </div>
            </div>
        </div>
    @endif

    <!-- Videos Grid -->
    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
        @foreach($videos as $vid)
            <div class="bg-white dark:bg-zinc-900 border border-gray-200 dark:border-zinc-800 rounded-xl p-3.5 hover:shadow-md transition-all">
                <a href="{{ route('video.show', $vid->slug) }}" class="group block space-y-2.5">
                    <div class="relative aspect-video bg-zinc-800 rounded-lg overflow-hidden img-zoom-wrap">
                        @if($vid->youtube_id)
                            <img src="https://img.youtube.com/vi/{{ $vid->youtube_id }}/mqdefault.jpg" alt="{{ $vid->judul }}" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-300">
                        @endif
                        @if($vid->durasi)
                            <span class="absolute bottom-1.5 right-1.5 bg-black/80 text-[10px] text-white px-1.5 py-0.5 rounded font-mono font-bold">{{ $vid->durasi }}</span>
                        @endif
                    </div>
                    <div class="text-[11px] text-gray-400">{{ $vid->formatted_date }}</div>
                    <h3 class="font-bold text-xs leading-snug line-clamp-2 text-gray-900 dark:text-gray-100 group-hover:text-red-500 transition-colors">
                        {{ $vid->judul }}
                    </h3>
                </a>
            </div>
        @endforeach
    </div>

    <div class="pt-6">
        {{ $videos->links() }}
    </div>

</div>
@endsection
