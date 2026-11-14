@props(['user', 'size' => 'w-8 h-8'])

@if($user->foto_thumb_path)
    <img src="{{ $user->fotoThumbUrl() }}" alt="{{ $user->name }}" {{ $attributes->merge(['class' => "$size rounded-full object-cover border border-gray-200 shadow-sm"]) }}>
@else
    <div {{ $attributes->merge(['class' => "$size rounded-full bg-gray-100 flex items-center justify-center border border-gray-200 shadow-sm text-gray-400"]) }}>
        <svg class="w-1/2 h-1/2" fill="currentColor" viewBox="0 0 24 24">
            <path d="M24 20.993V24H0v-2.996A14.977 14.977 0 0112.004 15c4.904 0 9.26 2.354 11.996 5.993zM16.002 8.999a4 4 0 11-8 0 4 4 0 018 0z" />
        </svg>
        <span class="hidden">{{ substr($user->name, 0, 1) }}</span>
    </div>
@endif
