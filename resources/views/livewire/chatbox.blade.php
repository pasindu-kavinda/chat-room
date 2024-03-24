<?php

use App\Events\MessageSent;
use Livewire\Attributes\On;
use Livewire\Volt\Component;

new class extends Component {
    public array $messages = [];
    public string $message = '';
    public int $id = 0;

    public function addMessage()
    {
        MessageSent::dispatch(auth()->user()->id, auth()->user()->name, $this->message);
        $this->reset('message');
    }

    #[On('echo:messages,MessageSent')]
    public function onMessageSent($event)
    {
        $this->messages[] = $event;
    }
}; ?>

<div>
    <div class="flex flex-col" style="height: 500px">
        <div class="bg-gray-200 flex-1 overflow-y-scroll :rounded-lg">
            <div class="px-4 py-2">

                @foreach ($messages as $message)
                    @if (auth()->user()->id === (int) $message['id'])
                        <div class="flex items-center justify-end">
                            <div class="bg-blue-500 text-white rounded-lg p-2 shadow mr-2 mb-1 max-w-sm">
                                {{ $message['message'] }}
                            </div>
                            <img class="w-8 h-8 rounded-full" src="https://picsum.photos/50/50" alt="User Avatar">
                        </div>
                    @else
                        <div class="flex items-center mb-2">
                            <img class="w-8 h-8 rounded-full mr-2" src="https://picsum.photos/50/50" alt="User Avatar">
                            <div class="font-medium text-black">{{ $message['name'] }}</div>
                        </div>
                        <div class="bg-white text-black rounded-lg p-2 shadow mb-2 max-w-sm">
                            {{ $message['message'] }}
                        </div>
                    @endif
                @endforeach


            </div>
        </div>
        <div class="bg-gray-100 px-4 py-2">
            <form wire:submit.prevent="addMessage">
                <div class="flex items-center">
                    <input wire:model="message" x-ref="messageInput" id="message" name="message"
                        class="w-full border text-black rounded-full py-2 px-4 mr-2" type="text"
                        placeholder="Type your message...">
                    <button class="bg-blue-500 hover:bg-blue-700 text-white font-medium py-2 px-4 rounded-full">
                        Send
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
