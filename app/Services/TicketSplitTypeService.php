<?php

namespace App\Services;

class TicketSplitTypeService
{
    /**
     * Whether buying $buyCount from a listing with $available tickets
     * respects the seller's split type rule.
     */
    public function isPurchaseAllowed(?string $splitName, int $available, int $buyCount): bool
    {
        if ($buyCount < 1 || $available < 1 || $buyCount > $available) {
            return false;
        }

        $remaining = $available - $buyCount;

        return match ($this->normalize($splitName)) {
            'none' => $remaining === 0,
            'avoid leaving one ticket' => $remaining !== 1,
            'avoid leaving one or three tickets' => ! in_array($remaining, [1, 3], true),
            'avoid leaving odd numbers' => $remaining % 2 === 0,
            default => true, // Any / unknown
        };
    }

    /**
     * Human-readable reason when a quantity is not allowed, or null if allowed.
     */
    public function denialReason(?string $splitName, int $available, int $buyCount): ?string
    {
        if ($this->isPurchaseAllowed($splitName, $available, $buyCount)) {
            return null;
        }

        if ($buyCount < 1) {
            return 'Please select a valid ticket quantity.';
        }

        if ($buyCount > $available) {
            return "Only {$available} ticket(s) are available in this listing.";
        }

        $remaining = $available - $buyCount;

        return match ($this->normalize($splitName)) {
            'none' => "Seller requires all {$available} tickets to be purchased together.",
            'avoid leaving one ticket' => "Buying {$buyCount} would leave {$remaining} ticket — seller does not allow leaving one ticket.",
            'avoid leaving one or three tickets' => "Buying {$buyCount} would leave {$remaining} ticket(s) — seller does not allow leaving one or three tickets.",
            'avoid leaving odd numbers' => "Buying {$buyCount} would leave {$remaining} ticket(s) — seller does not allow leaving an odd number of tickets.",
            default => 'This quantity is not allowed for this listing.',
        };
    }

    private function normalize(?string $splitName): string
    {
        return strtolower(trim((string) $splitName));
    }
}
