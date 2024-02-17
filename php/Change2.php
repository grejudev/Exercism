<?php
/*
Instructions
Correctly determine the fewest number of coins to be given to a customer such that the sum of the coins' value would equal the correct amount of change.

For example
An input of 15 with [1, 5, 10, 25, 100] should return one nickel (5) and one dime (10) or [5, 10]
An input of 40 with [1, 5, 10, 25, 100] should return one nickel (5) and one dime (10) and one quarter (25) or [5, 10, 25]
Edge cases
Does your algorithm work for any given set of coins?
Can you ask for negative change?
Can you ask for a change value smaller than the smallest coin value?
*/

declare(strict_types=1);

function findFewestCoins(array $coins, int $amount): array
{
    if ($amount < 0) {
        throw new InvalidArgumentException('Cannot make change for negative value');
    }

    // Si el monto es cero, no se necesitan monedas
    if ($amount === 0) {
        return [];
    }

    // Crear un array para almacenar la cantidad mínima de monedas para cada monto
    $minCoins = array_fill(0, $amount + 1, PHP_INT_MAX);

    // La cantidad mínima de monedas para un monto de 0 es 0
    $minCoins[0] = 0;

    // Calcular la cantidad mínima de monedas para cada monto
    foreach ($coins as $coin) {
        for ($i = $coin; $i <= $amount; $i++) {
            if ($minCoins[$i - $coin] !== PHP_INT_MAX) {
                $minCoins[$i] = min($minCoins[$i], 1 + $minCoins[$i - $coin]);
            }
        }
    }

    // Si no es posible hacer cambio exacto, lanzar una excepción
    if ($minCoins[$amount] === PHP_INT_MAX) {
        // Si no hay monedas disponibles, lanzar una excepción diferente
        if (min($coins) > $amount) {
            throw new InvalidArgumentException('No coins small enough to make change');
        }
        throw new InvalidArgumentException('No combination can add up to target');
    }

    // Reconstruir la solución
    $solution = [];
    $remainingAmount = $amount;

    while ($remainingAmount > 0) {
        $coinAdded = false;
        foreach ($coins as $coin) {
            if ($remainingAmount >= $coin && $minCoins[$remainingAmount - $coin] + 1 == $minCoins[$remainingAmount]) {
                $solution[] = $coin;
                $remainingAmount -= $coin;
                $coinAdded = true;
                break;
            }
        }

        // Si no se pudo agregar ninguna moneda, lanzar una excepción
        if (!$coinAdded) {
            throw new InvalidArgumentException('No coins small enough to make change');
        }
    }

    return $solution;
}
