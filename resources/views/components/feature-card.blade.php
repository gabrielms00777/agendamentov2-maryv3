<!-- resources/views/components/feature-card.blade.php -->
@props(['icon', 'title', 'description'])

<div class="bg-white p-6 rounded-xl shadow-md hover:shadow-lg transition-shadow">
    <x-icon :name="$icon" class="w-12 h-12 text-blue-600 mb-4" />
    <h3 class="text-xl font-bold mb-2">{{ $title }}</h3>
    <p class="text-gray-600">{{ $description }}</p>
</div>



