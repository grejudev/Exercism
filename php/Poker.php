<?php

/*
* Instructions
* Pick the best hand(s) from a list of poker hands.
* 
* See wikipedia for an overview of poker hands.
 */

declare(strict_types=1);

class Poker
{
    public array $bestHands = [];
    private array $order = ["A", "K", "Q", "J", "10", "9", "8", "7", "6", "5", "4", "3", "2"];

    public function __construct(array $hands)
    {
        $hands_splitted = [];
        // Separate cards
        foreach ($hands as $str) {
            $hands_splitted[] = explode(",", $str);
        }

        // Call methods for hand evaluation in order of highest to lowest
        $this->StraightFlush($hands_splitted);
        if (!empty($this->bestHands)) return;

        $this->FourOfAKind($hands_splitted);
        if (!empty($this->bestHands)) return;

        $this->FullHouse($hands_splitted);
        if (!empty($this->bestHands)) return;

        // Add more hand evaluations here...
    }

    private function sortCards(array &$cards)
    {
        $sortedCards = $cards;
        usort($sortedCards, function ($a, $b) {
            // Get card's numbers
            $num_a = substr($a, 0, -1);
            $num_b = substr($b, 0, -1);

            // Get the positions of the card numbers in the $order array
            $pos_a = array_search($num_a, $this->order);
            $pos_b = array_search($num_b, $this->order);

            // Compare the positions
            return $pos_a - $pos_b;
        });
        return $sortedCards;
    }

    private function StraightFlush($hands)
    {
        $originalStraightFlushHands = []; // Stores all original hands that are StraightFlus
        $maxStraightFlushValue = -1; // Stores the highest value of the StraightFlus found

        foreach ($hands as $cards) {
            $straightFlush = true;
            $straightFlushValue = -1; // Stores the value of the found StraightFlus

            // Order cards
            $sortedCards = $this->sortCards($cards);

            for ($i = 0; $i < count($sortedCards) - 1; $i++) {
                $currentCard = $sortedCards[$i];
                $nextCard = $sortedCards[$i + 1];

                $currentNumber = substr($currentCard, 0, -1);
                $nextNumber = substr($nextCard, 0, -1);

                $currentPosition = array_search($currentNumber, $this->order);
                $nextPosition = array_search($nextNumber, $this->order);

                if ($nextPosition !== $currentPosition + 1) {
                    $straightFlush = false; // Is not a StraightFlus
                    break;
                }

                if ($straightFlushValue === -1) {
                    $straightFlushValue = $currentPosition; // Assigns the first value of the StraightFlus
                }
            }

            if ($straightFlush) {
                $originalStraightFlushHands[] = ['cards' => $cards, 'value' => $straightFlushValue];
                $maxStraightFlushValue = max($maxStraightFlushValue, $straightFlushValue);
            }
        }

        // Filter out hands that contain the highest straight or ties
        $this->bestHands = array_filter($originalStraightFlushHands, function ($hand) use ($maxStraightFlushValue) {
            return $hand['value'] === $maxStraightFlushValue;
        });

        // Extract only cards from filtered hands in string format
        $this->bestHands = array_map(function ($hand) {
            return implode(",", $hand['cards']);
        }, $this->bestHands);
    }

    private function FourOfAKind($hands)
    {
        $fourOfAKindHands = [];

        foreach ($hands as $cards) {
            $numberValue = -1;
            $numbers = [];
            foreach ($cards as $currentCard) {
                $currentNumber = substr($currentCard, 0, -1);
                $numbers[$currentNumber] = isset($numbers[$currentNumber]) ? $numbers[$currentNumber] + 1 : 1;
            }

            // Find the number that appears four times
            foreach ($numbers as $number => $count) {
                if ($count === 4) {
                    $numberValue = array_search($number, $this->order);
                    $fourOfAKindHands[] = ['cards' => $cards, 'value' => $numberValue];
                    break;
                }
            }
        }

        // Sort four-of-a-kind hands by the highest card value
        usort($fourOfAKindHands, function ($a, $b) {
            return $a['value'] - $b['value'];
        });
        // Add all the highest four-of-a-kind hands to $this->bestHands if they have the same value
        if (!empty($fourOfAKindHands)) {
            $highestValue = $fourOfAKindHands[0]['value'];
            foreach ($fourOfAKindHands as $hand) {
                if ($hand['value'] === $highestValue) {
                    $this->bestHands[] = implode(",", $hand['cards']);
                } else {
                    break;
                }
            }
        }
    }

    private function FullHouse($hands)
    {
        $fullHouseHands = [];

        foreach ($hands as $cards) {
            $numberValue = -1;
            $numbers = [];
            foreach ($cards as $currentCard) {
                $currentNumber = substr($currentCard, 0, -1);
                $numbers[$currentNumber] = isset($numbers[$currentNumber]) ? $numbers[$currentNumber] + 1 : 1;
            }

            if (in_array(3, $numbers) && in_array(2, $numbers)) {
                $trioValue = null;
                $pairValue = null;
                foreach ($numbers as $number => $count) {
                    if ($count === 3) {
                        $trioValue = array_search($number, $this->order);
                    }
                    if ($count === 2) {
                        $pairValue = array_search($number, $this->order);
                    }
                }
                $fullHouseHands[] = ['cards' => $cards, 'trio_value' => $trioValue, 'pair_value' => $pairValue];
            }
        }

        // Sort full house hands by the trio value and then by the pair value
        usort($fullHouseHands, function ($a, $b) {
            if ($a['trio_value'] !== $b['trio_value']) {
                return $b['trio_value'] - $a['trio_value']; // Sort by trio value in descending order
            } elseif ($a['pair_value'] !== $b['pair_value']) {
                return $b['pair_value'] - $a['pair_value']; // Sort by pair value in descending order
            } else {
                return 0;
            }
        });

        // Find the highest trio value
        $highestTrioValue = null;
        foreach ($fullHouseHands as $hand) {
            if ($highestTrioValue === null || $hand['trio_value'] < $highestTrioValue) {
                $highestTrioValue = $hand['trio_value'];
            }
        }

        // Find the highest pair value among hands with the highest trio value
        $highestPairValue = null;
        foreach ($fullHouseHands as $hand) {
            if ($hand['trio_value'] === $highestTrioValue) {
                if ($highestPairValue === null || $hand['pair_value'] < $highestPairValue) {
                    $highestPairValue = $hand['pair_value'];
                }
            }
        }

        // Add the best full house hand(s) to $this->bestHands
        $bestHands = [];
        foreach ($fullHouseHands as $hand) {
            if ($hand['trio_value'] === $highestTrioValue && $hand['pair_value'] === $highestPairValue) {
                $bestHands[] = implode(",", $hand['cards']);
            }
        }

        // If there are no hands with the highest pair value, try to find hands with the highest trio value only
        if (empty($bestHands)) {
            foreach ($fullHouseHands as $hand) {
                if ($hand['trio_value'] === $highestTrioValue) {
                    $bestHands[] = implode(",", $hand['cards']);
                }
            }
        }

        $this->bestHands = $bestHands;
    }
}



$hands = ['4S,5H,4D,5D,4H', '3S,3H,2S,3D,3C'];

$instance = new Poker($hands);
echo '<pre>';

echo '</pre>';
