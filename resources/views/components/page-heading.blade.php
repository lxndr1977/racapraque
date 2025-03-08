@props([
    'title' => '',
    'description' => ''
])

<div class="py-8">
    <h1 class="font-medium text-3xl text-primary text-center">
        {{ $title }}
    </h1>
    <p class="text-lg">{{ $description }}</p>
</div>
