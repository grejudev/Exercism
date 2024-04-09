<?php

/*
Instructions
Translate RNA sequences into proteins.

RNA can be broken into three nucleotide sequences called codons, and then translated to a polypeptide like so:

RNA: "AUGUUUUCU" => translates to

Codons: "AUG", "UUU", "UCU" => which become a polypeptide with the following sequence =>

Protein: "Methionine", "Phenylalanine", "Serine"

There are 64 codons which in turn correspond to 20 amino acids; however, all of the codon sequences and resulting amino acids are not important in this exercise. If it works for one codon, the program should work for all of them. However, feel free to expand the list in the test suite to include them all.

There are also three terminating codons (also known as 'STOP' codons); if any of these codons are encountered (by the ribosome), all translation ends and the protein is terminated.

All subsequent codons after are ignored, like this:

RNA: "AUGUUUUCUUAAAUG" =>

Codons: "AUG", "UUU", "UCU", "UAA", "AUG" =>

Protein: "Methionine", "Phenylalanine", "Serine"

Note the stop codon "UAA" terminates the translation and the final methionine is not translated into the protein sequence.

Below are the codons and resulting Amino Acids needed for the exercise.

Codon	            Protein
AUG	                Methionine
UUU, UUC	        Phenylalanine
UUA, UUG	        Leucine
UCU, UCC, UCA, UCG	Serine
UAU, UAC	        Tyrosine
UGU, UGC	        Cysteine
UGG	                Tryptophan
UAA, UAG, UGA	    STOP
 */

declare(strict_types=1);

class ProteinTranslation
{
    private array $aminoAcids = [
        "Methionine" => "AUG",
        "Phenylalanine" => "UUU UUC",
        "Leucine" => "UUA UUG",
        "Serine" => "UCU UCC UCA UCG",
        "Tyrosine" => "UAU UAC",
        "Cysteine" => "UGU UGC",
        "Tryptophan" => "UGG",
        "STOP" => "UAA UAG UGA",
    ];
    public function getProteins($str): array
    {

        $proteins = [];
        if ($str === "") {
            return $proteins;
        }

        $codons = str_split($str, 3);
        print_r($codons);

        $i = 0;
        foreach ($codons as $codon) {
            $i++; // num iterations
            foreach ($this->aminoAcids as $key => $elements) {
                $sub_elements = explode(" ", $elements);
                foreach ($sub_elements as $key2 => $value) {
                    if ($value === $codon) {
                        if ($key === "STOP") {
                            return $proteins;
                        }
                        array_push($proteins, $key);
                    }
                }
            }
            if (count($proteins) !== $i) {
                throw new \InvalidArgumentException('Invalid codon');
            }
        }

        return $proteins;
    }
}

$instance = new ProteinTranslation();
$result = $instance->getProteins("UGGUGUUAUUAAUGGUUU");
print_r($result);
