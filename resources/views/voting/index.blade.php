<x-app-layout>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    @if(session('error'))
                        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-4" role="alert">
                            <span class="block sm:inline">{{ session('error') }}</span>
                        </div>
                    @endif

                    <h2 class="text-2xl font-bold mb-6">Cast Your Vote</h2>

                    @if($hasVoted)
                        <div class="bg-yellow-100 border border-yellow-400 text-yellow-700 px-4 py-3 rounded relative">
                            <span class="block sm:inline">You have already cast your vote.</span>
                        </div>
                    @else
                        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                            @foreach($candidates as $candidate)
                                <div class="bg-white rounded-lg shadow-md overflow-hidden">
                                    @if($candidate->photo_path)
                                        <img src="{{ asset('storage/' . $candidate->photo_path) }}" alt="{{ $candidate->name }}" class="w-full h-48 object-cover">
                                    @else
                                        <div class="w-full h-48 bg-gray-200 flex items-center justify-center">
                                            <span class="text-gray-500">No photo available</span>
                                        </div>
                                    @endif
                                    
                                    <div class="p-4">
                                        <h3 class="text-xl font-semibold mb-2">{{ $candidate->name }}</h3>
                                        
                                        <div class="mb-4">
                                            <h4 class="font-medium text-gray-700">Vision:</h4>
                                            <p class="text-gray-600">{{ $candidate->vision }}</p>
                                        </div>
                                        
                                        <div class="mb-4">
                                            <h4 class="font-medium text-gray-700">Mission:</h4>
                                            <p class="text-gray-600">{{ $candidate->mission }}</p>
                                        </div>

                                        <form action="{{ route('voting.cast') }}" method="POST">
                                            @csrf
                                            <input type="hidden" name="candidate_id" value="{{ $candidate->id }}">
                                            <button type="submit" class="w-full bg-blue-500 text-white py-2 px-4 rounded hover:bg-blue-600 transition duration-200">
                                                Vote for {{ $candidate->name }}
                                            </button>
                                        </form>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout> 