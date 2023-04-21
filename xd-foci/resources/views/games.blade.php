@php
/** @var \Illuminate\Database\Eloquent\Collection<\App\Models\Game> $ongoing */
/** @var \Illuminate\Pagination\LengthAwarePaginator $finished */
@endphp

<x-app-layout>
    <x-short-banner title='Mérkőzések'></x-short-banner>
    <div>
        <section class='px-6 py-8'>
            <h2 class='text-4xl my-6 flex gap-2'>Folyamatban lévő mérkőzések
                <x-icon-link :link=" route('games.create') " icon='add_circle'></x-icon-link>
            </h2>
            <x-game-list :games="$ongoing"></x-game-list>
        </section>

        <section class='px-6 py-8'>
            <h2 class='text-4xl py-4'>Lezárult mérkőzések</h2>
            <x-game-list :games="$finished->items()"></x-game-list>
            <div class='text-center'>
                {{ $finished->links() }}
            </div>
        </section>
    </div>
</x-app-layout>
