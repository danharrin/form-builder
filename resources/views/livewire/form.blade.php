<div class="bg-gray-50 min-h-screen">
    <form wire:submit.prevent="submit" class="p-8 space-y-8 max-w-4xl mx-auto">
        <div class="p-8 bg-white shadow">
            {{ $this->form }}
        </div>

        <x-forms::button type="submit">
            Submit
        </x-forms::button>
    </form>
</div>
