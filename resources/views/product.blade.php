<h3>{{ $title }}</h3>
Kullanıcı ID: {{ $id }}<br>
Product Type: {{ ucfirst($r_type) }}
<br><br>
@if($id==1)
    {{ '1 numaralı ürün gösteriliyor.' }}
@elseif($id==2)
    {{ '2 numaralı ürün gösteriliyor' }}
@else
    {{ '2\'den büyük ürünler gösteriliyor.' }}
@endif
<br><br>
@for($i=1;$i<=10;$i++)
    Product: {{ $i }}<br>
@endfor
<br>
@foreach($categories as $category)
    {{ $category }}<br>
@endforeach
<br>
@foreach($urunler as $urun)
    {{ $loop->iteration.' '.$urun }}<br>
@endforeach


