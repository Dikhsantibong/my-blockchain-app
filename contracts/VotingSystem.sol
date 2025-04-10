// SPDX-License-Identifier: MIT
pragma solidity ^0.8.0;

contract VotingSystem {
    struct Vote {
        address voter;
        uint256 candidateId;
        uint256 timestamp;
    }

    mapping(address => bool) public hasVoted;
    mapping(uint256 => uint256) public votesCount;
    Vote[] public votes;

    event VoteCast(address indexed voter, uint256 indexed candidateId, uint256 timestamp);

    function castVote(uint256 _candidateId) public {
        require(!hasVoted[msg.sender], "You have already voted");
        
        hasVoted[msg.sender] = true;
        votesCount[_candidateId]++;
        
        votes.push(Vote({
            voter: msg.sender,
            candidateId: _candidateId,
            timestamp: block.timestamp
        }));
        
        emit VoteCast(msg.sender, _candidateId, block.timestamp);
    }

    function getVoteCount(uint256 _candidateId) public view returns (uint256) {
        return votesCount[_candidateId];
    }

    function getTotalVotes() public view returns (uint256) {
        return votes.length;
    }

    function getVoterStatus(address _voter) public view returns (bool) {
        return hasVoted[_voter];
    }
} 