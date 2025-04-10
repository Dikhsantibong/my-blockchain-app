<?php

namespace App\Http\Controllers;

use App\Models\Vote;
use App\Models\Candidate;
use App\Services\BlockchainService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class VotingController extends Controller
{
    private $blockchainService;

    public function __construct(BlockchainService $blockchainService)
    {
        $this->middleware('auth');
        $this->blockchainService = $blockchainService;
    }

    public function index()
    {
        $candidates = Candidate::all();
        $hasVoted = Vote::where('user_id', Auth::id())->exists();
        
        return view('voting.index', compact('candidates', 'hasVoted'));
    }

    public function castVote(Request $request)
    {
        $request->validate([
            'candidate_id' => 'required|exists:candidates,id'
        ]);

        if (Vote::where('user_id', Auth::id())->exists()) {
            return back()->with('error', 'You have already voted');
        }

        try {
            // Cast vote on blockchain
            $transactionHash = $this->blockchainService->castVote(
                $request->candidate_id,
                Auth::user()->eth_address,
                Auth::user()->eth_private_key
            );

            // Record vote in database
            Vote::create([
                'user_id' => Auth::id(),
                'candidate_id' => $request->candidate_id,
                'transaction_hash' => $transactionHash
            ]);

            return redirect()->route('voting.results')->with('success', 'Vote cast successfully!');
        } catch (\Exception $e) {
            return back()->with('error', 'Failed to cast vote: ' . $e->getMessage());
        }
    }

    public function results()
    {
        $candidates = Candidate::with('votes')->get();
        $totalVotes = Vote::count();
        
        foreach ($candidates as $candidate) {
            $candidate->blockchain_votes = $this->blockchainService->getVoteCount($candidate->id);
        }
        
        return view('voting.results', compact('candidates', 'totalVotes'));
    }
} 