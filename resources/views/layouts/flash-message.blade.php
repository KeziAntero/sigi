@if(session('success'))
    <div class="alert alert-success text-center">
        <span class="message-text">{{ session('success') }}</span>
    </div>
@endif

@if(session('error'))
    <div class="alert alert-danger text-center">
        <span class="message-text">{{ session('error') }}</span>
    </div>
@endif


