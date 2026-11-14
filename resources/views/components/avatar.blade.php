@props(['user', 'size' => 'h-10 w-10'])

@if ($user->foto_thumb_path)
    <img
        src="{{ \Illuminate\Support\Facades\Storage::disk('public')->url($user->foto_thumb_path) }}"
        alt="{{ $user->name }}"
        class="{{ $size }} flex-none rounded-full object-cover"
        loading="lazy"
    >
@else
    <div {{ $attributes->merge(['class' => "$size flex-none flex items-center justify-center rounded-full bg-slate-200 text-sm font-semibold text-slate-600"]) }}>
        {{ mb_substr($user->name, 0, 1) }}
    </div>
@endif