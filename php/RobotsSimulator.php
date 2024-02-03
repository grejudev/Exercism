<?php

declare(strict_types=1);

class Robot
{
    /**
     * @var int[]
     */
    public $position;

    /**
     * @var string
     */
    public $direction;

    const DIRECTION_NORTH = 'norte';
    const DIRECTION_SOUTH = 'sur';
    const DIRECTION_EAST = 'este';
    const DIRECTION_WEST = 'oeste';

    public function __construct(array $position, string $direction)
    {
        $this->position = $position;
        $this->direction = $direction;
    }

    public function turnRight(): self
    {
        switch ($this->direction) {
            case self::DIRECTION_NORTH:
                $this->direction = self::DIRECTION_EAST;
                break;
            case self::DIRECTION_EAST:
                $this->direction = self::DIRECTION_SOUTH;
                break;
            case self::DIRECTION_SOUTH:
                $this->direction = self::DIRECTION_WEST;
                break;
            case self::DIRECTION_WEST:
                $this->direction = self::DIRECTION_NORTH;
                break;
        }
        return $this;
    }

    public function turnLeft(): self
    {
        switch ($this->direction) {
            case self::DIRECTION_NORTH:
                $this->direction = self::DIRECTION_WEST;
                break;
            case self::DIRECTION_EAST:
                $this->direction = self::DIRECTION_NORTH;
                break;
            case self::DIRECTION_SOUTH:
                $this->direction = self::DIRECTION_EAST;
                break;
            case self::DIRECTION_WEST:
                $this->direction = self::DIRECTION_SOUTH;
                break;
        }
        return $this;
    }

    public function advance(): self
    {
        // Actualiza la posición según la dirección
        switch ($this->direction) {
            case "norte":
                $this->position[1]++;
                break;
            case "este":
                $this->position[0]++;
                break;
            case "sur":
                $this->position[1]--;
                break;
            case "oeste":
                $this->position[0]--;
                break;
        }
        return $this;
    }

    public function instructions(string $journey)
    {
        $validInstructions = ['R', 'L', 'A'];
        $arr_journey = str_split($journey);

        foreach ($arr_journey as $instruction) {
            if (!in_array($instruction, $validInstructions)) {
                throw new \InvalidArgumentException('Instrucción no válida: ' . $instruction);
            }
            switch ($instruction) {
                case "R":
                    $this->turnRight();
                    break;
                case "L":
                    $this->turnLeft();
                    break;
                case "A":
                    $this->advance();
                    break;
            }
        }
    }
}
