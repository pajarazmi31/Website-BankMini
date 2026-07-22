@props(['total' => 3, 'current' => 1, 'paginator' => null])

@php
    $showPagination = true;
    if ($paginator instanceof \Illuminate\Contracts\Pagination\LengthAwarePaginator) {
        $total = $paginator->lastPage();
        $current = $paginator->currentPage();
        if ($paginator->total() === 0) {
            $showPagination = false;
        }
    } else {
        if ($total <= 0) {
            $showPagination = false;
        }
    }
@endphp

@if ($showPagination)
<div class="flex items-center justify-end gap-1.5 mt-5 pt-2">
    <!-- Previous Button -->
    @if ($paginator instanceof \Illuminate\Contracts\Pagination\LengthAwarePaginator)
        @if ($paginator->onFirstPage())
            <button class="w-[28px] h-[28px] rounded-[8px] bg-brand-blue text-white flex items-center justify-center text-[12px] opacity-50 cursor-not-allowed" disabled>
                <i class="ph-bold ph-caret-left"></i>
            </button>
        @else
            <a href="{{ $paginator->previousPageUrl() }}" 
               class="w-[28px] h-[28px] rounded-[8px] bg-brand-blue text-white flex items-center justify-center text-[12px] hover:bg-[#152a42] transition-all duration-200 shadow-sm hover:shadow-md flex justify-center items-center">
                <i class="ph-bold ph-caret-left"></i>
            </a>
        @endif
    @else
        <button class="w-[28px] h-[28px] rounded-[8px] bg-brand-blue text-white flex items-center justify-center text-[12px] hover:bg-[#152a42] transition-all duration-200 shadow-sm hover:shadow-md disabled:opacity-50 disabled:cursor-not-allowed" {{ $current == 1 ? 'disabled' : '' }}>
            <i class="ph-bold ph-caret-left"></i>
        </button>
    @endif
    
@for ($i = 1; $i <= $total; $i++)
        
        {{-- Aturan tampil: halaman 1, halaman terakhir, dan halaman di sebelah (kiri/kanan) halaman aktif --}}
        @if ($i == 1 || $i == $total || ($i >= $current - 1 && $i <= $current + 1))
            
            @if ($i == $current)
                <!-- Active Page (Text) -->
                <span class="w-[28px] h-[28px] flex items-center justify-center text-[14px] font-extrabold text-brand-blue">{{ $i }}</span>
            @else
                <!-- Other Pages (Buttons/Links) -->
                @if ($paginator instanceof \Illuminate\Contracts\Pagination\LengthAwarePaginator)
                    <a href="{{ $paginator->url($i) }}" class="w-[28px] h-[28px] rounded-[8px] bg-brand-blue text-white flex items-center justify-center text-[13px] font-bold hover:bg-[#152a42] transition-all duration-200 shadow-sm hover:shadow-md flex justify-center items-center">
                        {{ $i }}
                    </a>
                @else
                    <button class="w-[28px] h-[28px] rounded-[8px] bg-brand-blue text-white flex items-center justify-center text-[13px] font-bold hover:bg-[#152a42] transition-all duration-200 shadow-sm hover:shadow-md">
                        {{ $i }}
                    </button>
                @endif
            @endif
            
        {{-- Logika baru untuk menampilkan elipsis (...) di kiri atau kanan area halaman aktif --}}
        @elseif ($i == $current - 2 || $i == $current + 2)
            <span class="w-[20px] flex items-center justify-center text-[13px] font-bold text-gray-400 tracking-widest">...</span>
        @endif
        
    @endfor
    
    <!-- Next Button -->
    @if ($paginator instanceof \Illuminate\Contracts\Pagination\LengthAwarePaginator)
        @if ($paginator->hasMorePages())
            <a href="{{ $paginator->nextPageUrl() }}" 
               class="w-[28px] h-[28px] rounded-[8px] bg-brand-blue text-white flex items-center justify-center text-[12px] hover:bg-[#152a42] transition-all duration-200 shadow-sm hover:shadow-md flex justify-center items-center">
                <i class="ph-bold ph-caret-right"></i>
            </a>
        @else
            <button class="w-[28px] h-[28px] rounded-[8px] bg-brand-blue text-white flex items-center justify-center text-[12px] opacity-50 cursor-not-allowed" disabled>
                <i class="ph-bold ph-caret-right"></i>
            </button>
        @endif
    @else
        <button class="w-[28px] h-[28px] rounded-[8px] bg-brand-blue text-white flex items-center justify-center text-[12px] hover:bg-[#152a42] transition-all duration-200 shadow-sm hover:shadow-md disabled:opacity-50 disabled:cursor-not-allowed" {{ $current == $total ? 'disabled' : '' }}>
            <i class="ph-bold ph-caret-right"></i>
        </button>
    @endif
</div>
@endif
