{{-- html xd--}}

<h1> Pagina de contacto {{$nombre}} {{$edad}} </h1>

@if(is_null($edad))
	No existe la edad
@else
	Si existe la edad: {{$edad}}
@endif

<?php $numero=4; ?>

Tabl adl {{$numero}}
@for($i=0; $i<=10;$i++)
	{{$i.' x 2 ='.$i*$numero}}</br>
@endfor

<?php $x=1; ?>
@while($x<=10)
	{{'Hola mundo'.$i}}
	{{$x++}}
@endwhile