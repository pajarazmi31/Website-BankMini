@props(['total' => 3, 'current' => 1])

<div class="flex items-center justify-end gap-1.5 mt-5 pt-2">
    <!-- Previous Button -->
    @if ($current > 1)
        <a href="{{ request()->fullUrlWithQuery(['page' => $current - 1]) }}" class="w-[28px] h-[28px] rounded-[8px] bg-brand-blue text-white flex items-center justify-center text-[12px] hover:bg-[#152a42] transition-all duration-200 shadow-sm hover:shadow-md">
            <i class="ph-bold ph-caret-left"></i>
        </a>
    @else
        <button class="w-[28px] h-[28px] rounded-[8px] bg-brand-blue text-white flex items-center justify-center text-[12px] opacity-50 cursor-not-allowed" disabled>
            <i class="ph-bold ph-caret-left"></i>
        </button>
    @endif
    
    @for ($i = 1; $i <= $total; $i++)
        @if ($i == $current)
            <!-- Active Page (Text) -->
            <span class="w-[28px] h-[28px] flex items-center justify-center text-[14px] font-extrabold text-brand-blue">{{ $i }}</span>
        @else
            <!-- Other Pages (Links) -->
            <a href="{{ request()->fullUrlWithQuery(['page' => $i]) }}" class="w-[28px] h-[28px] rounded-[8px] bg-brand-blue text-white flex items-center justify-center text-[13px] font-bold hover:bg-[#152a42] transition-all duration-200 shadow-sm hover:shadow-md">
                {{ $i }}
            </a>
        @endif

        {{-- Add ellipsis if there are many pages (simulated for now) --}}
        @if ($total > 5 && $i == 3 && $total > $i + 1)
            <span class="w-[20px] flex items-center justify-center text-[13px] font-bold text-gray-400 tracking-widest">...</span>
            @php $i = $total - 1; @endphp
        @endif
    @endfor
    
    <!-- Next Button -->
    @if ($current < $total)
        <a href="{{ request()->fullUrlWithQuery(['page' => $current + 1]) }}" class="w-[28px] h-[28px] rounded-[8px] bg-brand-blue text-white flex items-center justify-center text-[12px] hover:bg-[#152a42] transition-all duration-200 shadow-sm hover:shadow-md">
            <i class="ph-bold ph-caret-right"></i>
        </a>
    @else
        <button class="w-[28px] h-[28px] rounded-[8px] bg-brand-blue text-white flex items-center justify-center text-[12px] opacity-50 cursor-not-allowed" disabled>
            <i class="ph-bold ph-caret-right"></i>
        </button>
    @endif
</div>
