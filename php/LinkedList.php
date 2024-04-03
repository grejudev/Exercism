<?php

/*
* Introduction
* You are working on a project to develop a train scheduling system for a busy railway network.
* 
* You've been asked to develop a prototype for the train routes in the scheduling system. Each route consists of a sequence of train stations that a given train stops at.
* 
* Instructions
* Your team has decided to use a doubly linked list to represent each train route in the schedule. Each station along the train's route will be represented by a node in the linked list.
* 
* You don't need to worry about arrival and departure times at the stations. Each station will simply be represented by a number.
* 
* Routes can be extended, adding stations to the beginning or end of a route. They can also be shortened by removing stations from the beginning or the end of a route.
* 
* Sometimes a station gets closed down, and in that case the station needs to be removed from the route, even if it is not at the beginning or end of the route.
* 
* The size of a route is measured not by how far the train travels, but by how many stations it stops at.
 */

declare(strict_types=1);

class LinkedList
{
    private $head;
    public function __construct()
    {
        $this->head = null;
    }

    public function push($station): void
    {
        // Create a new station
        $newStation = new Station();
        $newStation->setData($station);
        if ($this->head) {
            $currentNode = $this->head;
            // Finding last node
            while ($currentNode->getNext() !== null) {
                $currentNode = $currentNode->getNext();
            }
            $currentNode->setNext($newStation);
            $newStation->setPrevious($currentNode);
        } else {
            // List is empty so, new node will be the first node
            $this->head = $newStation;
        }
    }

    public function pop(): ?int
{
    if ($this->head) {
        $currentNode = $this->head;
        $previousNode = null;

        // Finding last station node
        while ($currentNode->getNext() !== null) {
            $previousNode = $currentNode;
            $currentNode = $currentNode->getNext();
        }

        // Check if the last node is not null
        if ($currentNode !== null) {
            $data = $currentNode->getData();
            
            // If previousNode is null, it means the head node is the only node in the list
            if ($previousNode === null) {
                $this->head = null;
            } else {
                // Removing the last node from the list
                $previousNode->setNext(null);
            }
            
            return $data;
        }
    }
    return null; // Return null if the list is empty
}

    public function shift(): int
    {
        if ($this->head !== null) {
            $data = $this->head->getData();
            $this->head = $this->head->getNext();
            if ($this->head !== null) {
                $this->head->setPrevious(null);
            }
            return $data;
        }
        return 0; // or throw an exception indicating the list is empty
    }

    public function unshift($station): void
    {
        $newStation = new Station();
        $newStation->setData($station);
        if ($this->head !== null) {
            $newStation->setNext($this->head);
            $this->head->setPrevious($newStation);
        }
        $this->head = $newStation;
    }
}

class Station
{
    private $data;
    private $next;
    private $previous;

    public function __construct()
    {
        $this->data = 0;
        $this->next = null;
        $this->previous = null;
    }

    public function setData($data): void
    {
        $this->data = $data;
    }
    public function getData(): int
    {
        return $this->data;
    }

    public function setNext($next): void
    {
        $this->next = $next;
    }
    public function getNext(): ?Station
    {
        return $this->next;
    }

    public function setPrevious($previous): void
    {
        $this->previous = $previous;
    }
    public function getPrevious(): ?Station
    {
        return $this->previous;
    }
}
