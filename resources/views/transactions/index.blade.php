@php
    use Illuminate\Support\Facades\Route;
    use Illuminate\Support\Facades\Auth;
@endphp

@extends('layouts.app')

@section('content')
<div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    
    <!-- Header -->
    <div class="flex items-center justify-between mb-8">
        <div>
            <h1 class="text-3xl font-bold text-white mb-2">Transaction History</h1>
            <p class="text-gray-400">View all your purchases and transactions</p>
        </div>
        <a href="{{ url('/home') }}" class="inline-flex items-center px-4 py-2 bg-white/5 hover:bg-white/10 border border-white/10 rounded-lg text-gray-300 hover:text-white transition-all duration-200">
            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
            </svg>
            Back to Home
        </a>
    </div>

    <!-- Transactions List -->
    @if($transactions->count() > 0)
        <div class="space-y-4">
            @foreach ($transactions as $trx)
                @php
                    $status = strtolower($trx->status);
                    $statusConfig = [
                        'success' => [
                            'icon' => 'M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z',
                            'color' => 'green',
                            'text' => 'Success',
                            'emoji' => '✅'
                        ],
                        'pending' => [
                            'icon' => 'M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z',
                            'color' => 'yellow',
                            'text' => 'Pending',
                            'emoji' => '🔄'
                        ],
                        'failed' => [
                            'icon' => 'M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z',
                            'color' => 'red',
                            'text' => 'Failed',
                            'emoji' => '❌'
                        ]
                    ];
                    $config = $statusConfig[$status] ?? $statusConfig['pending'];
                @endphp

                <div class="bg-white/5 backdrop-blur-xl rounded-xl border border-white/10 shadow-lg overflow-hidden hover:border-white/20 transition-all duration-200">
                    <div class="p-6">
                        <div class="flex flex-col md:flex-row md:items-center md:justify-between space-y-4 md:space-y-0">
                            <!-- Transaction Info -->
                            <div class="flex-1 space-y-3">
                                <div class="flex items-start space-x-4">
                                    <!-- Status Icon -->
                                    <div class="flex-shrink-0 w-12 h-12 bg-{{ $config['color'] }}-500/20 rounded-xl flex items-center justify-center">
                                        <svg class="w-6 h-6 text-{{ $config['color'] }}-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="{{ $config['icon'] }}"/>
                                        </svg>
                                    </div>

                                    <div class="flex-1">
                                        <!-- Receipt Number -->
                                        <div class="flex items-center space-x-2 mb-2">
                                            <span class="text-sm text-gray-400">Receipt:</span>
                                            <code class="px-3 py-1 bg-white/10 rounded-lg text-white font-mono text-sm">
                                                {{ $trx->resi }}
                                            </code>
                                        </div>

                                        <!-- Date -->
                                        <div class="flex items-center space-x-2 text-gray-400 text-sm">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                            </svg>
                                            <span>{{ $trx->created_at->format('d M Y, H:i') }}</span>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Price & Status -->
                            <div class="flex flex-col md:items-end space-y-3">
                                <!-- Total Price -->
                                <div class="text-right">
                                    <div class="text-sm text-gray-400 mb-1">Total Amount</div>
                                    <div class="text-2xl font-bold text-transparent bg-clip-text bg-gradient-to-r from-blue-400 to-purple-600">
                                        Rp {{ number_format($trx->total_harga, 0, ',', '.') }}
                                    </div>
                                </div>

                                <!-- Status Badge -->
                                <span class="inline-flex items-center px-4 py-2 bg-{{ $config['color'] }}-500/20 border border-{{ $config['color'] }}-500/50 text-{{ $config['color'] }}-300 rounded-lg text-sm font-medium">
                                    <span class="mr-2">{{ $config['emoji'] }}</span>
                                    {{ $config['text'] }}
                                </span>
                            </div>
                        </div>

                        <!-- Actions -->
                        <div class="mt-6 pt-4 border-t border-white/10 flex items-center justify-between">
                            <div class="text-sm text-gray-400">
                                Transaction ID: <span class="text-gray-300">#{{ $trx->id }}</span>
                            </div>
                            <a href="{{ route('transactions.print', $trx->id) }}" 
                               class="inline-flex items-center px-4 py-2 bg-blue-500/20 hover:bg-blue-500/30 border border-blue-500/50 text-blue-300 rounded-lg transition-all duration-200 text-sm font-medium">
                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"/>
                                </svg>
                                Print Receipt
                            </a>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

        <!-- Pagination -->
        @if($transactions->hasPages())
        <div class="mt-8">
            {{ $transactions->links() }}
        </div>
        @endif
    @else
        <!-- Empty State -->
        <div class="bg-white/5 backdrop-blur-xl rounded-2xl border border-white/10 p-12 text-center">
            <div class="max-w-md mx-auto">
                <svg class="w-24 h-24 mx-auto text-gray-600 mb-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01"/>
                </svg>
                <h3 class="text-2xl font-bold text-white mb-3">No Transactions Yet</h3>
                <p class="text-gray-400 mb-6">You haven't made any purchases. Start shopping to see your transaction history here.</p>
                <a href="{{ url('/home') }}" 
                   class="inline-flex items-center px-6 py-3 bg-gradient-to-r from-blue-500 to-purple-600 hover:from-blue-600 hover:to-purple-700 text-white font-semibold rounded-xl transition-all duration-200 shadow-lg shadow-purple-500/30">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"/>
                    </svg>
                    Start Shopping
                </a>
            </div>
        </div>
    @endif
</div>
@endsection
