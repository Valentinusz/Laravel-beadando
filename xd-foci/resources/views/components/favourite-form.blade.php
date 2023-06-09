@props(['team', 'left'])
@php
    /** @var \App\Models\User $user */
    $user = \Illuminate\Support\Facades\Auth::user();
    $favourite = $user && $user->teams->contains($team)
@endphp
<form method='POST' action='{{ route('teams.favourite', $team) }}'
      class='flex items-center'
>
    @csrf
    <button type='submit'
            @class(['hover:text-yellow-600', 'material-icons', 'medium', 'text-center' => !isset($left), 'text-left' => isset($left)])
            title='{{ $favourite ? 'Törlés a kedvencekből' : 'Hozzáadás a kedvencekhez' }}'
    >
        {{ $favourite  ? 'star' : 'star_border'}}
    </button>
</form>
