<?php

declare(strict_types=1);

namespace App\Service;

use App\Repository\ContractRepository;

class ContractNumberGenerator
{
    /**
     * String to introduce in contract numbers.
     *
     * @var string
     */
    public const CONTRACT_NUMBER_ACRONYM = 'CG';

    /**
     * @var ContractRepository
     */
    private $contractRepository;

    public function __construct(ContractRepository $contractRepository)
    {
        $this->contractRepository = $contractRepository;
    }

    public function generateNumber(): string
    {
        $number = date('dmY');
        $number .= self::CONTRACT_NUMBER_ACRONYM;

        $contracts = $this->contractRepository->findContractsWithNumberBeginningOn($number);

        $contractNumbers = [];

        foreach ($contracts as $contract) {
            $contractNumbers[$contract->getNumber()] = true;
        }

        $n = 0;

        while (isset($contractNumbers[$number.(++$n)]));

        return $number.$n;
    }
}
