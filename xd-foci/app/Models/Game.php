<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Collection;
use InvalidArgumentException;

/**
 * Class representing a game.
 * @mixin Builder
 *
 * @property integer $id Id of the game.
 * @property Carbon $start Starting datetime of the game.
 * @property bool $finished Boolean that holds whether the game has ended.
 * @property integer $away_team_id Id of the away team.
 * @property Team $awayTeam The away team of the game.
 * @property integer $home_team_id Id of the home team.
 * @property Team $homeTeam The home team of the game.
 * @property Carbon $created_at
 * @property Carbon $updated_at
 * @property Collection<Event> $events Events that happened during the game.
 */
class Game extends Model {
    use HasFactory;

    protected $fillable = ['start', 'finished', 'away_team_id', 'home_team_id'];
    protected $guarded = ['id', 'created_at', 'updated_at',];

    protected $casts = [
        'start' => 'datetime'
    ];

    public function homeTeam(): BelongsTo {
        return $this->belongsTo(Team::class, 'home_team_id');
    }

    public function awayTeam(): BelongsTo {
        return $this->belongsTo(Team::class, 'away_team_id');
    }

    public function events(): HasMany {
        return $this->hasMany(Event::class)->orderBy('minute');
    }

    /**
     * Calculate the score of the game.
     *
     * @return int[]
     */
    public function score(): array {
        $scores = ['home' => 0, 'away' => 0];

        foreach ($this->events as $event) {
            switch ($event->type) {
                case EventType::GOAL: {
                    if ($this->homeTeam->players->contains($event->player)) {
                        $scores['home']++;
                    } elseif ($this->awayTeam->players->contains($event->player)) {
                        $scores['away']++;
                    } else {
                        throw new InvalidArgumentException();
                    }
                    break;
                }
                case EventType::OWN_GOAL: {
                    if ($this->homeTeam->players->contains($event->player)) {
                        $scores['away']++;
                    } elseif ($this->awayTeam->players->contains($event->player)) {
                        $scores['home']++;
                    } else {
                        throw new InvalidArgumentException();
                    }
                    break;
                }
            }
        }

        return $scores;
    }

    /**
     * Checks if the given model is editable.
     *
     * @return bool true if the game is unfinished and has no events associated.
     */
    public function editable(): bool {
        return !$this->finished && $this->events->count() === 0;
    }
}
