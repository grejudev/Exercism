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
        // Order cards
        $sortedHands = [];
        for ($i = 0; $i < count($hands_splitted); $i++) {
            $cards = $hands_splitted[$i];
            $sortedHands[] = $this->sortCards($cards);
        }
        $this->StraightFlush($sortedHands);
    }

    private function sortCards(array &$cards)
    {
        usort($cards, function ($a, $b) {
            // Get card's numbers
            $num_a = substr($a, 0, -1);
            $num_b = substr($b, 0, -1);

            // Get the positions of the card numbers in the $order array
            $pos_a = array_search($num_a, $this->order);
            $pos_b = array_search($num_b, $this->order);

            // Compare the positions
            return $pos_a - $pos_b;
        });
        return $cards;
    }

    private function StraightFlush($hands)
    {
        $straightFlushHands = []; // Almacena todas las manos con escalera
        $maxStraightFlushValue = -1; // Almacena el valor más alto de la escalera encontrada

        foreach ($hands as $cards) {
            $straightFlush = true;
            $straightFlushValue = -1; // Almacena el valor de la escalera encontrada

            for ($i = 0; $i < count($cards) - 1; $i++) {
                $currentCard = $cards[$i];
                $nextCard = $cards[$i + 1];

                $currentNumber = substr($currentCard, 0, -1);
                $nextNumber = substr($nextCard, 0, -1);

                $currentPosition = array_search($currentNumber, $this->order);
                $nextPosition = array_search($nextNumber, $this->order);

                if ($nextPosition !== $currentPosition + 1) {
                    $straightFlush = false; // No es una escalera
                    break;
                }

                if ($straightFlushValue === -1) {
                    $straightFlushValue = $currentPosition; // Asigna el primer valor de la escalera
                }
            }

            if ($straightFlush) {
                $straightFlushHands[] = $cards;
                $maxStraightFlushValue = max($maxStraightFlushValue, $straightFlushValue);
            }
        }

        // Filtra las manos que contienen la escalera más alta o empates
        $highests = array_filter($straightFlushHands, function ($cards) use ($maxStraightFlushValue) {
            $firstCardValue = array_search(substr($cards[0], 0, -1), $this->order);
            return $firstCardValue === $maxStraightFlushValue;
        });

        // Si hay escaleras, almacena las manos con escaleras en $bestHands
        if (!empty($highests)) {
            $results = array_values($highests);
            foreach ($results as $result) {
                $this->bestHands[] = implode(",", $result);
            }
        }
    }
}



$hands = ['JS,10S,9C,8D,7H', 'JD,10H,8S,9D,7C'];

$instance = new Poker($hands);
echo '<pre>';

echo '</pre>';
