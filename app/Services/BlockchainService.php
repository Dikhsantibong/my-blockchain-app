<?php

namespace App\Services;

use Web3\Web3;
use Web3\Contract;
use Web3\Providers\HttpProvider;
use Web3\RequestManagers\HttpRequestManager;

class BlockchainService
{
    private $web3;
    private $contract;
    private $contractAddress;

    public function __construct()
    {
        try {
            $provider = new HttpProvider(new HttpRequestManager(
                env('ETHEREUM_NODE_URL', 'http://127.0.0.1:8545'),
                30 // timeout
            ));
            
            $this->web3 = new Web3($provider);
            $this->contractAddress = env('VOTING_CONTRACT_ADDRESS');
            
            // Contract ABI will be stored in a JSON file
            $contractAbi = json_decode(file_get_contents(base_path('contracts/VotingSystem.json')), true)['abi'];
            
            $this->contract = new Contract($this->web3->provider, $contractAbi);
        } catch (\Exception $e) {
            throw new \Exception('Failed to initialize Web3: ' . $e->getMessage());
        }
    }

    public function castVote($candidateId, $userAddress, $privateKey)
    {
        try {
            $transactionHash = null;
            $this->contract->at($this->contractAddress)->send(
                'castVote',
                $candidateId,
                [
                    'from' => $userAddress,
                    'gas' => '0x200b20' // Approximately 2,100,000 gas
                ],
                function ($err, $result) use (&$transactionHash) {
                    if ($err !== null) {
                        throw new \Exception($err->getMessage());
                    }
                    $transactionHash = $result;
                }
            );
            
            return $transactionHash;
        } catch (\Exception $e) {
            throw new \Exception('Failed to cast vote on blockchain: ' . $e->getMessage());
        }
    }

    public function getVoteCount($candidateId)
    {
        try {
            $count = null;
            $this->contract->at($this->contractAddress)->call(
                'getVoteCount',
                $candidateId,
                function ($err, $result) use (&$count) {
                    if ($err !== null) {
                        throw new \Exception($err->getMessage());
                    }
                    $count = $result[0]->toString();
                }
            );
            return $count;
        } catch (\Exception $e) {
            throw new \Exception('Failed to get vote count: ' . $e->getMessage());
        }
    }

    public function hasVoted($address)
    {
        try {
            $hasVoted = null;
            $this->contract->at($this->contractAddress)->call(
                'getVoterStatus',
                $address,
                function ($err, $result) use (&$hasVoted) {
                    if ($err !== null) {
                        throw new \Exception($err->getMessage());
                    }
                    $hasVoted = $result[0];
                }
            );
            return $hasVoted;
        } catch (\Exception $e) {
            throw new \Exception('Failed to check voter status: ' . $e->getMessage());
        }
    }
} 