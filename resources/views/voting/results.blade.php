<x-app-layout>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <div class="flex justify-between items-center mb-6">
                        <h2 class="text-2xl font-bold text-gray-800">Voting Results</h2>
                        <a href="{{ route('voting.index') }}" 
                           class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded">
                            Back to Voting
                        </a>
                    </div>

                    <div class="mb-6">
                        <div class="bg-blue-50 border border-blue-200 rounded-lg p-4">
                            <div class="flex items-center">
                                <div class="flex-shrink-0">
                                    <svg class="h-5 w-5 text-blue-400" viewBox="0 0 20 20" fill="currentColor">
                                        <path fill-rule="evenodd" 
                                              d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" 
                                              clip-rule="evenodd" />
                                    </svg>
                                </div>
                                <div class="ml-3">
                                    <h3 class="text-sm font-medium text-blue-800">Total Votes Cast: {{ $totalVotes }}</h3>
                                    <p class="text-sm text-blue-600 mt-1">Results are verified on the blockchain for transparency.</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="space-y-6">
                        @foreach($candidates as $candidate)
                            <div class="bg-white rounded-lg shadow p-6 border border-gray-200">
                                <div class="flex items-center justify-between mb-4">
                                    <div>
                                        <h3 class="text-lg font-semibold text-gray-800">{{ $candidate->name }}</h3>
                                        <p class="text-sm text-gray-500">Candidate ID: {{ $candidate->id }}</p>
                                    </div>
                                    <div class="text-right">
                                        <p class="text-2xl font-bold text-blue-600">
                                            {{ $candidate->votes->count() }} votes
                                        </p>
                                        <p class="text-sm text-gray-500">
                                            ({{ $totalVotes > 0 ? round(($candidate->votes->count() / $totalVotes) * 100, 1) : 0 }}%)
                                        </p>
                                    </div>
                                </div>

                                <div class="relative pt-1">
                                    <div class="overflow-hidden h-3 text-xs flex rounded bg-blue-100">
                                        <div style="width: {{ $totalVotes > 0 ? ($candidate->votes->count() / $totalVotes) * 100 : 0 }}%"
                                             class="shadow-none flex flex-col text-center whitespace-nowrap text-white justify-center bg-blue-500 transition-all duration-500">
                                        </div>
                                    </div>
                                </div>

                                <div class="mt-4 grid grid-cols-2 gap-4 text-sm">
                                    <div>
                                        <p class="text-gray-600"><strong>Blockchain Votes:</strong> {{ $candidate->blockchain_votes }}</p>
                                    </div>
                                    <div>
                                        <p class="text-gray-600"><strong>Database Votes:</strong> {{ $candidate->votes->count() }}</p>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout> 