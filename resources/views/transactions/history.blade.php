@extends('layouts.app')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    
    <!-- Header -->
    <div class="flex items-center justify-between mb-8">
        <div>
            <h1 class="text-3xl font-bold text-white mb-2">Transaction History</h1>
            <p class="text-gray-400">Manage all customer transactions</p>
        </div>
        <a href="{{ route('admin.home') }}" class="inline-flex items-center px-4 py-2 bg-white/5 hover:bg-white/10 border border-white/10 rounded-lg text-gray-300 hover:text-white transition-all duration-200">
            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/>
            </svg>
            Back to Dashboard
        </a>
    </div>

    @if($transactions->isEmpty())
        <!-- Empty State -->
        <div class="bg-white/5 backdrop-blur-xl rounded-2xl border border-white/10 p-12 text-center">
            <svg class="w-24 h-24 mx-auto text-gray-600 mb-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
            </svg>
            <h3 class="text-2xl font-bold text-white mb-3">No Transactions</h3>
            <p class="text-gray-400">No transactions have been made yet.</p>
        </div>
    @else
        <!-- Transactions Table -->
        <div class="bg-white/5 backdrop-blur-xl rounded-2xl border border-white/10 shadow-2xl overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full">
                    <thead>
                        <tr class="bg-white/5 border-b border-white/10">
                            <th class="px-6 py-4 text-left text-sm font-semibold text-gray-300">Transaction ID</th>
                            <th class="px-6 py-4 text-left text-sm font-semibold text-gray-300">Customer</th>
                            <th class="px-6 py-4 text-left text-sm font-semibold text-gray-300">Date</th>
                            <th class="px-6 py-4 text-left text-sm font-semibold text-gray-300">Status</th>
                            <th class="px-6 py-4 text-right text-sm font-semibold text-gray-300">Total</th>
                            <th class="px-6 py-4 text-center text-sm font-semibold text-gray-300">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-white/10">
                        @foreach($transactions as $transaction)
                        <tr class="hover:bg-white/5 transition-colors duration-150">
                            <!-- Transaction ID -->
                            <td class="px-6 py-4">
                                <code class="px-2 py-1 bg-white/10 rounded text-sm text-white font-mono">
                                    #{{ $transaction->id }}
                                </code>
                            </td>

                            <!-- Customer Name -->
                            <td class="px-6 py-4">
                                <div class="flex items-center space-x-3">
                                    <div class="w-10 h-10 bg-gradient-to-br from-blue-500 to-purple-600 rounded-full flex items-center justify-center">
                                        <span class="text-white font-semibold text-sm">
                                            {{ strtoupper(substr($transaction->user->name ?? 'U', 0, 1)) }}
                                        </span>
                                    </div>
                                    <span class="text-white font-medium">
                                        {{ $transaction->user->name ?? 'Unknown' }}
                                    </span>
                                </div>
                            </td>

                            <!-- Date -->
                            <td class="px-6 py-4">
                                <div class="flex items-center space-x-2 text-gray-400 text-sm">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                    </svg>
                                    <span>{{ $transaction->created_at->format('d M Y') }}</span>
                                </div>
                            </td>

                            <!-- Status -->
                            <td class="px-6 py-4">
                                @php
                                    $statusConfig = [
                                        'pending' => ['color' => 'yellow', 'icon' => '🔄', 'text' => 'Pending'],
                                        'success' => ['color' => 'green', 'icon' => '✅', 'text' => 'Success'],
                                        'cancelled' => ['color' => 'red', 'icon' => '❌', 'text' => 'Cancelled']
                                    ];
                                    $config = $statusConfig[$transaction->status] ?? $statusConfig['pending'];
                                @endphp
                                <span class="inline-flex items-center px-3 py-1 bg-{{ $config['color'] }}-500/20 border border-{{ $config['color'] }}-500/50 text-{{ $config['color'] }}-300 rounded-lg text-sm">
                                    <span class="mr-2">{{ $config['icon'] }}</span>
                                    {{ $config['text'] }}
                                </span>
                            </td>

                            <!-- Total -->
                            <td class="px-6 py-4 text-right">
                                <span class="text-white font-semibold">
                                    Rp {{ number_format($transaction->total_harga, 0, ',', '.') }}
                                </span>
                            </td>

                            <!-- Actions -->
                            <td class="px-6 py-4">
                                <form action="{{ route('transactions.updateStatus', $transaction->id) }}" method="POST" class="flex justify-center">
                                    @csrf
                                    @method('PUT')

                                    @if($transaction->status === 'pending')
                                        <div class="relative inline-block text-left" x-data="{ open: false }">
                                            <button @click="open = !open" type="button" 
                                                    class="inline-flex items-center px-4 py-2 bg-yellow-500/20 hover:bg-yellow-500/30 border border-yellow-500/50 text-yellow-300 rounded-lg transition-all duration-200 text-sm">
                                                Change Status
                                                <svg class="ml-2 w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                                                </svg>
                                            </button>
                                            <div x-show="open" @click.away="open = false" 
                                                 class="absolute right-0 mt-2 w-48 bg-slate-800 rounded-lg shadow-xl border border-white/10 z-10"
                                                 x-transition>
                                                <button type="submit" name="status" value="success" 
                                                        class="w-full text-left px-4 py-3 text-green-300 hover:bg-green-500/20 rounded-t-lg transition-colors">
                                                    ✅ Mark as Success
                                                </button>
                                                <button type="submit" name="status" value="cancelled" 
                                                        class="w-full text-left px-4 py-3 text-red-300 hover:bg-red-500/20 rounded-b-lg transition-colors">
                                                    ❌ Cancel
                                                </button>
                                            </div>
                                        </div>

                                    @elseif($transaction->status === 'success')
                                        <div class="relative inline-block text-left" x-data="{ open: false }">
                                            <button @click="open = !open" type="button" 
                                                    class="inline-flex items-center px-4 py-2 bg-green-500/20 border border-green-500/50 text-green-300 rounded-lg text-sm">
                                                ✅ Success
                                                <svg class="ml-2 w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                                                </svg>
                                            </button>
                                            <div x-show="open" @click.away="open = false" 
                                                 class="absolute right-0 mt-2 w-48 bg-slate-800 rounded-lg shadow-xl border border-white/10 z-10"
                                                 x-transition>
                                                <button type="submit" name="status" value="cancelled" 
                                                        class="w-full text-left px-4 py-3 text-red-300 hover:bg-red-500/20 rounded-lg transition-colors">
                                                    ❌ Cancel Transaction
                                                </button>
                                            </div>
                                        </div>

                                    @elseif($transaction->status === 'cancelled')
                                        <span class="inline-flex items-center px-4 py-2 bg-red-500/20 border border-red-500/50 text-red-300 rounded-lg text-sm cursor-not-allowed">
                                            ❌ Cancelled
                                        </span>
                                    @endif
                                </form>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Pagination -->
        @if($transactions->hasPages())
        <div class="mt-6">
            {{ $transactions->links() }}
        </div>
        @endif
    @endif
</div>

<!-- Alpine.js for dropdowns -->
<script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
@endsection
