@props([
    'striped' => true,
    'hover' => true,
])

<div class="table-container">
    <table {{ $attributes->merge(['class' => 'table']) }}>
        @isset($head)
            <thead>
                <tr>
                    {{ $head }}
                </tr>
            </thead>
        @endisset

        <tbody class="{{ $striped ? '' : '[&>tr:nth-child(even)]:bg-transparent' }} {{ $hover ? '' : '[&>tr]:hover:bg-transparent' }}">
            {{ $slot }}
        </tbody>

        @isset($foot)
            <tfoot>
                {{ $foot }}
            </tfoot>
        @endisset
    </table>
</div>
