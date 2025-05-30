<!-- resources/views/components/testimonial-card.blade.php -->
@props(['name', 'role', 'quote', 'avatar'])

<div class="bg-gray-50 p-6 rounded-xl">
    <div class="flex items-center mb-4">
        <img src="{{ $avatar }}" alt="{{ $name }}" class="w-12 h-12 rounded-full mr-4">
        <div>
            <h4 class="font-bold">{{ $name }}</h4>
            <p class="text-gray-600 text-sm">{{ $role }}</p>
        </div>
    </div>
    <p class="text-gray-700 italic">"{{ $quote }}"</p>
</div>