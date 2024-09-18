<div>
    <form wire:submit.prevent="sendMessage">
        <textarea wire:model="message" placeholder="Enter your message..." rows="4" cols="50"></textarea>
        <br>
        <button type="submit">Send Message</button>
    </form>

        <h4>Response:</h4>
        <p>{{ $response }}</p>
</div>
