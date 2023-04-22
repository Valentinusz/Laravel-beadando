@props(['games'])
@php /** @var \Illuminate\Database\Eloquent\Collection<\App\Models\Game> $games */ @endphp

<ol>
    @forelse( $games as $game )
    @php
        $score = $game->score();
    @endphp
    <li class='p-2 my-2 data-wrapper rounded-md hover:bg-indigo-600 grid grid-cols-[90%_10%]'>
        <a class='grid grid-cols-[20%_5%_30%_10%_30%_5%] items-center text-center' href='{{ route('games.show', $game) }}'>
            <span>{{ $game->start->format('Y. m. d. H:i') }}</span>
            <x-team-icon width='12' height='12' :icon=' $game->homeTeam->image '></x-team-icon>
            <span>{{ $game->homeTeam->name }}</span>
            <span>{{ $score['home'] }} : {{ $score['away'] }}</span>
            <span>{{ $game->awayTeam->name }}</span>
            <x-team-icon width='12' height='12' :icon=' $game->awayTeam->image '></x-team-icon>
        </a>
        <span class='flex justify-center items-center'>
            <a href='{{ route('games.edit', $game) }}'>
                <span class="material-icons medium text-center">edit</span>
            </a>
        </span>
    </li>
    @empty
        <div class='text-center text-4xl py-8'>Nincs meccs 😭</div>
    @endforelse
</ol>

