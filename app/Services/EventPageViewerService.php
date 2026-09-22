<?php

namespace App\Services;

use Carbon\Carbon;
use Illuminate\Support\Facades\Cache;

class EventPageViewerService
{
    private const PRESENCE_WINDOW_SECONDS = 75;

    private const PRESENCE_TTL_MINUTES = 10;

    private const SEEN_TTL_HOURS = 2;

    public function ping(int $eventId, string $viewerId): array
    {
        $now = Carbon::now();

        $this->touchPresence($eventId, $viewerId, $now);
        $this->touchSeenWindow($eventId, $viewerId, $now);

        return $this->stats($eventId, $now);
    }

    public function stats(int $eventId, ?Carbon $now = null): array
    {
        $now = $now ?? Carbon::now();

        return [
            'current' => $this->currentViewers($eventId, $now),
            'past_hour' => $this->pastHourViewers($eventId, $now),
        ];
    }

    private function presenceKey(int $eventId): string
    {
        return "event_page_presence_{$eventId}";
    }

    private function seenKey(int $eventId): string
    {
        return "event_page_seen_{$eventId}";
    }

    private function touchPresence(int $eventId, string $viewerId, Carbon $now): void
    {
        $key = $this->presenceKey($eventId);
        $map = Cache::get($key, []);
        if (! is_array($map)) {
            $map = [];
        }

        $cutoff = $now->copy()->subSeconds(self::PRESENCE_WINDOW_SECONDS * 2)->timestamp;
        $map = array_filter($map, fn ($timestamp) => (int) $timestamp >= $cutoff);
        $map[$viewerId] = $now->timestamp;

        Cache::put($key, $map, now()->addMinutes(self::PRESENCE_TTL_MINUTES));
    }

    private function touchSeenWindow(int $eventId, string $viewerId, Carbon $now): void
    {
        $key = $this->seenKey($eventId);
        $map = Cache::get($key, []);
        if (! is_array($map)) {
            $map = [];
        }

        $cutoff = $now->copy()->subHour()->timestamp;
        $map = array_filter($map, fn ($timestamp) => (int) $timestamp >= $cutoff);
        $map[$viewerId] = $now->timestamp;

        Cache::put($key, $map, now()->addHours(self::SEEN_TTL_HOURS));
    }

    private function currentViewers(int $eventId, Carbon $now): int
    {
        $map = Cache::get($this->presenceKey($eventId), []);
        if (! is_array($map)) {
            return 0;
        }

        $cutoff = $now->copy()->subSeconds(self::PRESENCE_WINDOW_SECONDS)->timestamp;

        return count(array_filter($map, fn ($timestamp) => (int) $timestamp >= $cutoff));
    }

    private function pastHourViewers(int $eventId, Carbon $now): int
    {
        $map = Cache::get($this->seenKey($eventId), []);
        if (! is_array($map)) {
            return 0;
        }

        $cutoff = $now->copy()->subHour()->timestamp;

        return count(array_filter($map, fn ($timestamp) => (int) $timestamp >= $cutoff));
    }
}
