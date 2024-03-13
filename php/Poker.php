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

        $this->StraightFlush($hands_splitted);
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
}



$hands = ['8S,10S,9C,JD,7H', '9D,10H,JS,8D,7C'];

$instance = new Poker($hands);
echo '<pre>';

echo '</pre>';
