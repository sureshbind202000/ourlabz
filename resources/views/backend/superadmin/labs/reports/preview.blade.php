<div class="a4-preview" style="

    width: 210mm;

    height: 297mm;

    background: white;

    margin: 0 auto;

    position: relative;

    font-family: Arial, sans-serif;

    overflow: hidden;

    box-shadow: 0 0 5px rgba(0,0,0,0.1);

">


    {{-- Header (full width) --}}

    <div style="width: 100%;">

        <img src="{{ asset($layout->header) }}" alt="Header" style="width: 100%; height: auto; display: block;">

    </div>


    {{-- Body Content Area --}}

    <div style="padding: 20px 30px; min-height: 175mm;">

        <p class="text-muted text-center">[ Report content goes here ]</p>

    </div>

    {{-- Footer (full width, positioned at bottom) --}}

    <div style="position: absolute;left: 0;bottom: 10px; width: 100%;">

        <img src="{{ asset($layout->footer) }}" alt="Footer" style="width: 100%; height: auto; display: block;">

    </div>

</div>

