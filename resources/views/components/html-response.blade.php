<x-enlighten-expansible-section :collapsed="0">
    <x-enlighten-dynamic-tabs :tabs="['preview' => 'Preview', 'html' => 'HTML', 'blade']">
        <x-slot name="preview">
            <x-enlighten-iframe srcdoc="{{ $request->response_preview }}"/>
        </x-slot>
        <x-slot name="html">
            <x-enlighten-pre :code="$request->response_body" language="html"></x-enlighten-pre>
        </x-slot>
        @if(!empty($request->response_template))
            <x-slot name="blade">
                <x-enlighten-pre :code="$request->response_template" language="html"></x-enlighten-pre>
            </x-slot>
        @endif
    </x-enlighten-dynamic-tabs>
</x-enlighten-expansible-section>
