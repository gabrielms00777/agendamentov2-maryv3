<!-- resources/views/components/step-card.blade.php -->
@props(['step', 'title', 'description'])

<div class="flex items-start gap-4">
    <div class="bg-blue-600 text-white rounded-full w-10 h-10 flex items-center justify-center flex-shrink-0 mt-1">
        {{ $step }}
    </div>
    <div>
        <h3 class="text-xl font-bold mb-2">{{ $title }}</h3>
        <p class="text-gray-600">{{ $description }}</p>
    </div>
</div>