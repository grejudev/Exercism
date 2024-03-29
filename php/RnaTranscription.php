<?php


declare(strict_types=1);

function toRna(string $dna): string
{
    $rna = "";

    for ($i = 0; $i < strlen($dna); $i++) {
        $nucleotides = $dna[$i];
        switch ($nucleotides) {
            case 'G':
                $rna .= 'C';
                break;
            case 'C':
                $rna .= 'G';
                break;
            case 'T':
                $rna .= 'A';
                break;
            case 'A':
                $rna .= 'U';
                break;
        }
    }

    return $rna;
}
