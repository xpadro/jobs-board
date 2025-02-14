<!-- Defineix una propietat amb el nom 'active'. Si no, ho tractara com a atribut -->
@props(['active' => false, 'type' => 'a'])


<!-- Aixi seria amb blade
@if ($type == 'a')
-->

<?php if ($type == 'a') : ?>
    <a class="{{$active ? 'bg-gray-900 text-white' : 'text-gray-300 hover:bg-gray-700 hover:text-white'}} rounded-md bg-px-3 py-2 text-sm font-medium" 
    aria-current="{{$active ? 'page' : 'false'}}"
    {{$attributes}}
    >{{$slot}}</a>

<!-- Aixi seria amb blade
@else
-->
<?php else : ?>
    <button class="{{$active ? 'bg-gray-900 text-white' : 'text-gray-300 hover:bg-gray-700 hover:text-white'}} rounded-md bg-px-3 py-2 text-sm font-medium" 
    aria-current="{{$active ? 'page' : 'false'}}"
    {{$attributes}}
    >{{$slot}}</button>

<!-- Aixi seria amb blade
@endif
-->
<?php endif ?>