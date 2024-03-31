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
        $this->evaluateHands($hands_splitted);
    }

    private function evaluateHands(array $hands): void
    {
        $methods = [
            'StraightFlush', 'FourOfAKind', 'FullHouse', 'Flush',
            'Straight', 'ThreeOfAKind', 'TwoPair', 'OnePair', 'handsWithHighestCard'
        ];

        foreach ($methods as $method) {
            $this->$method($hands);
            if (!empty($this->bestHands)) {
                return;
            }
        }
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
        $originalStraightFlushHands = []; // To Store all original hands that are Straight Flush
        $maxStraightFlushValue = array_search('2', $this->order); // Card with number 2

        foreach ($hands as $cards) {
            $straightFlush = true;
            $straightFlushValue = -1;

            // Copy of the original hand before ordering it
            $originalCards = $cards;

            // Sort the cards
            $sortedCards = $this->sortCards($cards);

            // ** Check the special case: A,2,3,4,5 in any suit **
            $straightSequence = ['A', '5', '4', '3', '2'];
            $straightAnySuit = true;
            foreach ($sortedCards as $index => $card) {
                if (substr($card, 0, -1) !== $straightSequence[$index]) {
                    $straightAnySuit = false;
                    break;
                }
            }
            if ($straightAnySuit) {
                // Check if it is Flush
                $isFlush = $this->isFlush($sortedCards);
                if ($isFlush) {
                    // It's Flush and Straight Flush
                    $originalStraightFlushHands[] = implode(",", $originalCards);
                }
                continue;
            }
            // ** End of Check the special case: A,2,3,4,5 in any suit **

            for ($i = 0; $i < count($sortedCards) - 1; $i++) {
                $currentCard = $sortedCards[$i];
                $nextCard = $sortedCards[$i + 1];

                $currentNumber = substr($currentCard, 0, -1);
                $nextNumber = substr($nextCard, 0, -1);

                $currentPosition = array_search($currentNumber, $this->order);
                $nextPosition = array_search($nextNumber, $this->order);

                // Check if it is Straight
                if ($nextPosition !== $currentPosition + 1) {
                    $straightFlush = false; // Not a Straight Flush
                    break;
                }

                if ($straightFlushValue === -1) {
                    $straightFlushValue = $currentPosition; // Assigns the first value of the Straight Flush
                }
            }
            $suits = [];
            // Is flush
            foreach ($sortedCards as $currentCard) {
                $currentSuit = substr($currentCard, -1);
                $suits[$currentSuit][] = $currentCard;
            }

            if ($straightFlush) {
                // Check if it is Flush
                $isFlush = $this->isFlush($sortedCards);

                if ($isFlush) {
                    // It's Flush and Straight Flush
                    if ($straightFlushValue < $maxStraightFlushValue) {
                        // If it is the highest hand so far, we replace it
                        $originalStraightFlushHands = [implode(",", $originalCards)];
                        $maxStraightFlushValue = $straightFlushValue;
                    } elseif ($straightFlushValue === $maxStraightFlushValue) {
                        // If it is equal to the highest hand so far, we add it
                        $originalStraightFlushHands[] = implode(",", $originalCards);
                    }
                }
            }
        }
        $this->bestHands = $originalStraightFlushHands;
    }

    // Function to check if a hand is Flush
    private function isFlush($cards)
    {
        $suits = [];
        foreach ($cards as $currentCard) {
            $currentSuit = substr($currentCard, -1);
            $suits[$currentSuit][] = $currentCard;
        }

        foreach ($suits as $suit) {
            if (count($suit) === count($cards)) {
                // All cards have the same suit, so it's Flush
                return true;
            }
        }
        return false;
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
            $this->bestHands[] = implode(",", $bestFlush);
        }
    }

    private function Straight($hands)
    {
        $originalStraightHands = []; // Stores all original hands that are Straight
        $maxStraightValue = array_search('2', $this->order); // Card with number 2

        foreach ($hands as $cards) {
            $straight = true;
            $straightValue = -1; // Stores the value of the found Straight

            // Order cards
            $sortedCards = $this->sortCards($cards);

            // Check for special case: A,2,3,4,5
            $straightSequence = ['A', '5', '4', '3', '2'];
            $straightAnySuit = true;
            foreach ($sortedCards as $index => $card) {
                if (substr($card, 0, -1) !== $straightSequence[$index]) {
                    $straightAnySuit = false;
                    break;
                }
            }

            if ($straightAnySuit) {
                $originalStraightHands[] = ['cards' => $cards, 'value' => 0];
                $maxStraightValue = 0;
                continue;
            }

            for ($i = 0; $i < count($sortedCards) - 1; $i++) {
                $currentCard = $sortedCards[$i];
                $nextCard = $sortedCards[$i + 1];

                $currentNumber = substr($currentCard, 0, -1);
                $nextNumber = substr($nextCard, 0, -1);

                $currentPosition = array_search($currentNumber, $this->order);
                $nextPosition = array_search($nextNumber, $this->order);

                if ($nextPosition !== $currentPosition + 1) {
                    $straight = false; // Is not a Straight
                    break;
                }

                if ($straightValue === -1) {
                    $straightValue = $currentPosition; // Assigns the first value of the Straight
                }
            }

            if ($straight) {
                $originalStraightHands[] = ['cards' => $cards, 'value' => $straightValue];
                $maxStraightValue = min($maxStraightValue, $straightValue);
            }
        }

        // Return higher hand with all found hands as parameters
        $this->handsWithHighestCard(array_column($originalStraightHands, 'cards'));
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
            // Compare the first pairs
            $pair1Comparison = array_search($b['pair1'], $this->order) - array_search($a['pair1'], $this->order);
            if ($pair1Comparison !== 0) {
                return $pair1Comparison;
            }
            // Compare the second pairs if the first pairs are the same
            $pair2Comparison = array_search($b['pair2'], $this->order) - array_search($a['pair2'], $this->order);
            if ($pair2Comparison !== 0) {
                return $pair2Comparison;
            }
            // Compare the highest card if both the first and second pairs are the same
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
            // Compare the pair
            $pairComparison = array_search($b['pair'], $this->order) - array_search($a['pair'], $this->order);
            if ($pairComparison !== 0) {
                return $pairComparison;
            }

            // Compare the highest card that is not part of the pair
            for ($i = 0; $i < count($a['restOfCards']); $i++) {
                $restCardComparison = $b['restOfCards'][$i] - $a['restOfCards'][$i];
                if ($restCardComparison !== 0) {
                    return $restCardComparison;
                }
            }

            // If all remaining cards are the same, compare the entire hand as a string
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

        // We sort hands in descending order
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


$hands = ['4S,6C,7S,8D,5H', '5S,7H,8S,9D,6H'];

$instance = new Poker($hands);
