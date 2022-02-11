<style>
table, table td.body {
	background: #fff;
	border-top-color: #fff;
	border-bottom-color: #fff;
}
table td.header .inner-body{
	box-shadow:  none;
}
table td.body .inner-body{
	border: 16px solid rgb(39, 62, 116);
}
table td.header, table td.header a , table.footer td p  {
	font-family: "Arial Narrow", "Arial" , Sans-serif;
	color: rgb(39, 62, 116);
	font-size: 16px;
	text-align: left;
}
table.action, table.action table{
	background-color: transparent;
} 
.body .content-cell h1{
	text-align: center;
}
.body .content-cell a, .body .content-cell p{
	color: rgb(23, 33, 57);
} 
.body .content-cell table.action .button-primary{
	border-color: rgb(39, 62, 116);
	background-color: rgb(39, 62, 116);
	color: #fff;
}
</style>

@component('mail::layout')
{{-- Header --}}
@slot('header')
@component('mail::header', ['url' => config('app.url')])

	<table class="inner-body">
		<tr>
			<td rowspan="2">
				<a class="fflch-logo-link" href="{{ config('app.url')}}">
			  		<img class="fflch-logo-img" width="100px" height="32px" src="https://listas.fflch.usp.br/vendor/laravel-usp-theme/skins/fflch/images/logo_fflch.png"  alt="Logo da FFLCH">
				</a>
			</td>
			<td>
				<a class="fflch-slogan-link"  href="{{ config('app.url')}}">FACULDADE DE FILOSOFIA, LETRAS E CIÊNCIAS HUMANAS</a>
			</td>
		</tr>
		<tr>
			
			<td>
				<a class="fflch-site-name-link" href="{{ config('app.url')}}">{{ config('app.name')}} </a>
			</td>
			
		</tr>
		
	</table>
@endcomponent
@endslot

{{-- Body --}}
# Gerenciamento de Inscrições

 	  	 
Olá, <br>	 
Clique no botão para acessar o gerenciamento de inscrições do seu e-mail no sistema de listas da FFLCH. 

@component('mail::button', ['url' => $unsubscribe_link])
Gerenciar minhas inscrições
@endcomponent

O botão não está funcionando? Copie a URL abaixo e cole-a no seu navegador: <br>
{{$unsubscribe_link}}





{{-- Footer --}}
@slot('footer')
@component('mail::footer')
<a class="fflch-logo-usp-link" href="https://www.usp.br" target="_blank">
	<img class="fflch-logo-usp-img" height="40px" src="https://listas.fflch.usp.br/vendor/laravel-usp-theme/skins/fflch/images/usp.png" alt="Logo da Universidade de São Paulo">
</a> 

@endcomponent
@endslot
@endcomponent


