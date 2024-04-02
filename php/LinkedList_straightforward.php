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
    private $list;
    public function __construct()
    {
        $this->list = new SplDoublyLinkedList();
    }

    public function push($station): void
    {
        $this->list->push($station);
    }

    public function pop(): int
    {
        return $this->list->pop();
    }

    public function shift(): int
    {
        return $this->list->shift();
    }

    public function unshift($station): void
    {
        $this->list->unshift($station);
    }
}
