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

        $this->Flush($hands_splitted);
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
        $originalStraightFlushHands = []; // Almacena todas las manos originales que son Straight Flush
        $maxStraightFlushValue = array_search('2', $this->order); // Card with number 2

        foreach ($hands as $cards) {
            $straightFlush = true;
            $straightFlushValue = -1; // Almacena el valor del Straight Flush encontrado

            // Copia de la mano original antes de ordenarla
            $originalCards = $cards;

            // Ordena las cartas
            $sortedCards = $this->sortCards($cards);

            for ($i = 0; $i < count($sortedCards) - 1; $i++) {
                $currentCard = $sortedCards[$i];
                $nextCard = $sortedCards[$i + 1];

                $currentNumber = substr($currentCard, 0, -1);
                $nextNumber = substr($nextCard, 0, -1);

                $currentPosition = array_search($currentNumber, $this->order);
                $nextPosition = array_search($nextNumber, $this->order);

                // Verifica si es Straight
                if ($nextPosition !== $currentPosition + 1) {
                    $straightFlush = false; // No es un Straight Flush
                    break;
                }

                if ($straightFlushValue === -1) {
                    $straightFlushValue = $currentPosition; // Asigna el primer valor del Straight Flush
                }
            }
            $suits = [];
            // Is flush
            foreach ($sortedCards as $currentCard) {
                $currentSuit = substr($currentCard, -1);
                $suits[$currentSuit][] = $currentCard;
            }

            // Verifica si es Flush
            if ($straightFlush) {
                foreach ($suits as $suit) {
                    if (count($suit) === count($sortedCards)) {
                        // Es Flush y Straight Flush
                        if ($straightFlushValue < $maxStraightFlushValue) {
                            // Si es la mano más alta hasta el momento, la reemplazamos
                            $originalStraightFlushHands = [implode(",", $originalCards)];
                            $maxStraightFlushValue = $straightFlushValue;
                        } elseif ($straightFlushValue === $maxStraightFlushValue) {
                            // Si es igual a la mano más alta hasta el momento, la agregamos
                            $originalStraightFlushHands[] = implode(",", $originalCards);
                        }
                        break;
                    }
                }
            }
        }
        // Almacena las manos Straight Flush más altas
        $this->bestHands = $originalStraightFlushHands;
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

    private function Flush($hands)
    {
        $bestFlush = [];

        foreach ($hands as $originalCards) {
            // Make a copy of the original cards
            $cards = $originalCards;

            $suits = [];
            foreach ($cards as $currentCard) {
                $currentSuit = substr($currentCard, -1);
                $suits[$currentSuit][] = $currentCard;
            }

            foreach ($suits as $suit => $cards) {
                if (count($cards) >= 5) {
                    // Take the top 5 cards for the flush
                    $flush = array_slice($cards, 0, 5);

                    // Check if this flush is better than the current best flush
                    if (empty($bestFlush)) {
                        $bestFlush = $flush;
                    } else {
                        $comparison = $this->compareFlushes($flush, $bestFlush);
                        if ($comparison > 0) {
                            $bestFlush = $flush;
                        }
                    }
                }
            }
        }

        // Add the best flush hand to $this->bestHands
        if (!empty($bestFlush)) {
            // Convert the best flush to a comma-separated string and add it to $this->bestHands
            $this->bestHands[] = implode(",", $bestFlush);
        }
    }



    private function compareFlushes($flush1, $flush2)
    {
        // Compare the ranks of the highest cards in the flushes
        for ($i = 0; $i < 5; $i++) {
            $rank1 = substr($flush1[$i], 0, -1);
            $rank2 = substr($flush2[$i], 0, -1);
            $comparison = array_search($rank2, $this->order) - array_search($rank1, $this->order);
            if ($comparison !== 0) {
                return $comparison;
            }
        }
        return 0; // The flushes are equal
    }
}



$hands = ['4H,6H,7H,8H,5H', '5S,7S,8S,9S,6S'];
// $hands = ['4H,7H,8H,9H,6H', '2S,4S,5S,6S,7S'];


$instance = new Poker($hands);
echo '<pre>';

echo '</pre>';
