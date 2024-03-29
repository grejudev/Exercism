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
        // Single hands always wins
        if (count($hands_splitted) === 1) {
            $this->bestHands[] = implode(",", $hands);
            return;
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

        $this->Straight($hands_splitted);
        if (!empty($this->bestHands)) return;

        $this->ThreeOfAKind($hands_splitted);
        if (!empty($this->bestHands)) return;

        $this->TwoPair($hands_splitted);
        if (!empty($this->bestHands)) return;

        $this->OnePair($hands_splitted);
        if (!empty($this->bestHands)) return;

        $this->handsWithHighestCard($hands_splitted);
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
                    $bestHands[] = $hand['cards'];
                } else {
                    break;
                }
            }
            $this->handsWithHighestCard($bestHands);
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

    private function Straight($hands)
    {
        $originalStraightHands = []; // Stores all original hands that are StraightFlus
        $maxStraightValue = array_search('2', $this->order); // Card with number 2

        foreach ($hands as $cards) {
            $straight = true;
            $straightValue = -1; // Stores the value of the found StraightFlus

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
                    $straight = false; // Is not a StraightFlus
                    break;
                }

                if ($straightValue === -1) {
                    $straightValue = $currentPosition; // Assigns the first value of the StraightFlus
                }
            }

            if ($straight) {
                $originalStraightHands[] = ['cards' => $cards, 'value' => $straightValue];
                $maxStraightValue = min($maxStraightValue, $straightValue);
            }
        }

        // Filter out hands that contain the highest straight or ties
        $this->bestHands = array_filter($originalStraightHands, function ($hand) use ($maxStraightValue) {
            return $hand['value'] === $maxStraightValue;
        });

        // Extract only cards from filtered hands in string format
        $this->bestHands = array_map(function ($hand) {
            return implode(",", $hand['cards']);
        }, $this->bestHands);
    }

    private function ThreeOfAKind($hands)
    {
        $threeOfAKindHands = [];

        foreach ($hands as $cards) {
            $numberValue = -1;
            $numbers = [];
            foreach ($cards as $currentCard) {
                $currentNumber = substr($currentCard, 0, -1);
                $numbers[$currentNumber] = isset($numbers[$currentNumber]) ? $numbers[$currentNumber] + 1 : 1;
            }

            // Find the number that appears three times
            foreach ($numbers as $number => $count) {
                if ($count === 3) {
                    $numberValue = array_search($number, $this->order);
                    $threeOfAKindHands[] = ['cards' => $cards, 'value' => $numberValue];
                    break;
                }
            }
        }

        // Sort three-of-a-kind hands by the highest card value
        usort($threeOfAKindHands, function ($a, $b) {
            return $a['value'] - $b['value'];
        });
        // Add all the highest three-of-a-kind hands to $this->bestHands if they have the same value
        if (!empty($threeOfAKindHands)) {
            $highestValue = $threeOfAKindHands[0]['value'];
            foreach ($threeOfAKindHands as $hand) {
                if ($hand['value'] === $highestValue) {
                    $bestHands[] = $hand['cards'];
                } else {
                    break;
                }
            }
            $this->handsWithHighestCard($bestHands);
        }
    }

    private function TwoPair($hands)
    {
        $twoPair = [];

        foreach ($hands as $cards) {
            $numbers = [];
            foreach ($cards as $currentCard) {
                $currentNumber = substr($currentCard, 0, -1);
                $numbers[$currentNumber] = isset($numbers[$currentNumber]) ? $numbers[$currentNumber] + 1 : 1;
            }

            // Find pairs that appear twice
            $pairValues = [];
            foreach ($numbers as $number => $count) {
                if ($count === 2) {
                    $pairValues[] = $number;
                }
            }

            // Check if two pairs were found
            if (count($pairValues) === 2) {
                rsort($pairValues);
                // Add the hand with the two pairs and the value of the highest card of the hands to $twoPair
                $twoPair[] = ['cards' => $cards, 'pair1' => $pairValues[0], 'pair2' => $pairValues[1], 'highCard' => $this->getHighCardThatIsNotPair($cards, $pairValues[0], $pairValues[1])];
            }
        }

        usort($twoPair, function ($a, $b) {
            // Compara las primeras parejas
            $pair1Comparison = array_search($b['pair1'], $this->order) - array_search($a['pair1'], $this->order);
            if ($pair1Comparison !== 0) {
                return $pair1Comparison;
            }
            // Compara las segundas parejas si las primeras parejas son iguales
            $pair2Comparison = array_search($b['pair2'], $this->order) - array_search($a['pair2'], $this->order);
            if ($pair2Comparison !== 0) {
                return $pair2Comparison;
            }
            // Compara la carta más alta si tanto las primeras como las segundas parejas son iguales
            return array_search($a['highCard'], $this->order) - array_search($b['highCard'], $this->order);
        });

        if (!empty($twoPair)) {
            $highestTwoPair = end($twoPair);
            $this->bestHands[] = implode(",", $highestTwoPair['cards']);
        }
    }

    private function OnePair($hands)
    {
        $onePair = [];

        foreach ($hands as $cards) {
            $numbers = [];
            foreach ($cards as $currentCard) {
                $currentNumber = substr($currentCard, 0, -1);
                $numbers[$currentNumber] = isset($numbers[$currentNumber]) ? $numbers[$currentNumber] + 1 : 1;
            }

            // Find pair
            $pairValue = [];
            foreach ($numbers as $number => $count) {
                if ($count === 2) {
                    $pairValue[] = $number;
                    $onePair[] = ['cards' => $cards, 'pair' => $pairValue[0], 'restOfCards' => $this->getRestCards($cards, $pairValue[0])];
                }
            }
        }

        usort($onePair, function ($a, $b) {
            // Comparar la pareja
            $pairComparison = array_search($b['pair'], $this->order) - array_search($a['pair'], $this->order);
            if ($pairComparison !== 0) {
                return $pairComparison;
            }

            // Comparar la carta más alta que no forma parte de la pareja
            for ($i = 0; $i < count($a['restOfCards']); $i++) {
                $restCardComparison = $b['restOfCards'][$i] - $a['restOfCards'][$i];
                if ($restCardComparison !== 0) {
                    return $restCardComparison;
                }
            }

            // Si todas las cartas restantes son iguales, comparar la mano completa como una cadena
            return strcmp(implode(",", $a['cards']), implode(",", $b['cards']));
        });

        if (!empty($onePair)) {
            $highestPair = end($onePair);
            $this->bestHands[] = implode(",", $highestPair['cards']);
        }
    }

    private function handsWithHighestCard($hands)
    {
        if (empty($hands)) {
            return;
        }
        $maxHands = [$hands[0]]; // We initialize $maxHand with the first hand

        // Ordenamos hands descending order
        foreach ($hands as $hand) {
            $sortedHands[] = $this->sortCards($hand);
        }

        // Iterate hands
        $maxHandSorted = $sortedHands[0];
        for ($i = 1; $i < count($sortedHands); $i++) {
            $currentHand = $sortedHands[$i];

            // Compare the cards in each position until one is different
            for ($j = 0; $j < count($currentHand); $j++) {
                $currentValue = array_search(substr($currentHand[$j], 0, -1), $this->order);
                $maxHandSorted_Value = array_search(substr($maxHandSorted[$j], 0, -1), $this->order);
                if ($currentValue === $maxHandSorted_Value && $j === count($currentHand) - 1) { // If all cards number are equal
                    $maxHands[] = $hands[$i];
                    continue;
                } elseif ($currentValue < $maxHandSorted_Value) {
                    // Higher card was found: new $maxHand found so far
                    $maxHandSorted = $sortedHands[$i];
                    $maxHands = [$hands[$i]];
                    break;
                } elseif ($currentValue > $maxHandSorted_Value) {
                    // Smaller card was found: $maxHand remains the same
                    break;
                }
            }
        }

        // Return $maxHands
        foreach ($maxHands as $cards) {
            $this->bestHands[] = implode(",", $cards);
        }
    }

    // Obtain the highest card that is not part of the two pairs
    private function getHighCardThatIsNotPair($cards, $pair1, $pair2)
    {
        $numbers = [];
        foreach ($cards as $currentCard) {
            $currentNumber = substr($currentCard, 0, -1);
            if ($currentNumber != $pair1 && $currentNumber != $pair2) {
                $numbers[] = array_search($currentNumber, $this->order);
            }
        }
        rsort($numbers);
        return $numbers[0];
    }

    // Obtain the rest of cards that is not part of the pair
    private function getRestCards($cards, $pair)
    {
        $numbers = [];
        foreach ($cards as $currentCard) {
            $currentNumber = substr($currentCard, 0, -1);
            if ($currentNumber != $pair) {
                $numbers[] = array_search($currentNumber, $this->order);
            }
        }
        sort($numbers);
        return $numbers;
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



// $hands = ['4S,6C,7S,8D,5H', '5S,7H,8S,9D,6H'];
// $hands = ['4H,7H,8H,9H,6H', '2S,4S,5S,6S,7S'];
// Three pair
// $hands = ['2S,8H,2H,8D,JH', '4S,5H,4C,8S,4H'];
// Two pairs
// $hands = ['JS,KH,JD,KD,3H', 'JS,KH,KC,JS,8D'];
// Pair
// $hands = ['4S,4H,6S,3D,JH', '7S,4H,6C,4D,JD'];
$hands = ['4S,AH,AS,7C,AD', '4S,AH,AS,8C,AD'];

$instance = new Poker($hands);
