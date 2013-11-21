


# Apper ( Application Object Creator )

## Amaç

Apper, hızlı bir şekilde uygulama oluşturup kendisini özelleştirebilen bir yapı sunmaktadır. Sunduğu Obje her türlü şekilde şekil alabilir ve geliştirilebilir. Ayrıca gayet basit ve kolay bir kullanımı bulunmaktadır.

### Hello World!
```
$apper = apper( function( $app ) {
	echo 'Hello World!<br/>';
} );
$apper->run();
```
Burada yapılan şey; $apper değişkenine Apper nesnesi atandı. ```apper()``` içine yazılan fonksiyon ise $apper nesnesinin ana fonksiyonunu oluşturmakta. En son bu ana fonksiyonu çalıştırmak için ```$apper->run();``` ifadesi kullanılır.

## Kurulumu

Apper indirildikten sonra sadece ```index.php``` dosyasının ```require``` edilmesi yeterlidir.

## Apper oluşturma yolları

Apper oluşturnın bir çok yolu vardır.

### ```apper``` Fonksiyonu

Yeni bir Apper nesnesi oluşturur. Apper\Application'dan nesne oluşturur.

```apper( $mainFunction, $binds = array() )```

- ```$mainFunction```: Apper çalıştırılacağı zaman çalışacak Callable.
- ```$binds```: Apper nesnesine otomatik verilecek Bind'ler.

Örnek:
```
$foo = apper( function( $app ) {
	echo 'Hello World!<br/>';
}, array(
	“name” => “foo",
	"version" => "0.0.1"
) );
```

### ```staticApper``` Fonksiyonu

Static fonksiyonlara sahip bir Apper Class'ı oluşturur. Oluşturulan Class Apper\StaticApplication'a bağlıdır.

```staticApper( $className, $mainFunction, $binds = array() )```

- ```$className```: Oluşturulacak Class'ın ismi. Bu Class eğer belli bir Namespace'in altında oluşturulmak istenirse ```namespace\\foo``` şeklinde doldurulmalıdır.
- ```$mainFunction```: Apper çalıştırılacağı zaman çalışacak Callable.
- ```$binds```: Apper nesnesine otomatik verilecek Bind'ler.

### Apper'ı Static veya Nesne ile Kontrol Etmek Arasındaki Fark

Apper'ı Static olarak yöneten Apper\StaticApplication kendi içinde Apper\Application oluşturmaktadır. ```__callStatic``` ile Apper\Application'ın fonksiyonlarına erişim imkanı vermektedir. Apper\StaticApplication'ın temel görevi Apper\Application'ı nesne olarak bulundurup, Static erişim imkanı vererek, Class'ı direk olarak projenin heryerinde çağırma imkanı vermektir.

Kısacası Apper\Application'dan çağırdığınız bütün fonksiyonları Apper\StaticApplication ile Static şekilde çağırabilirsiniz.

## Apper ile Bind İşlemleri

Bind'ler Apper nesnesinde tutulan değerlerdir. Bu değerler istenildiği gibi oluşturulup, silinip, değiştirilebilirler. Nesneye eklenen Bindler ```bindings```'de array içinde tutulur.

### ```set``` Fonksiyonu

```set``` ile herhangi bind oluşturulabilir veya düzeltilebilir.

```set( $key, $value )```

- ```$key```: Bind'in çağrılacağı zaman kullanılan anahtar.
- ```$value```: Bind çağrıldığında dönülecek değer.

Örnek:
```
$app->set( "pass", 1234 );
```

### ```get``` Fonksiyonu

```get``` ile önceden oluşturulan Bind'in değeri alınır.

```get( $key )```

- ```$key```: Bind keyi.

Örnek:
```
$app->get( "pass" );
```

### ```setted``` Fonksiyonu

```setted``` ile Bind'in varolup olmadığı öğrenilir.

```setted( $key, $val = null )```

- ```$key```: Varlığı sorulan Bnd keyi.
- ```$val```: Eğer Bind yok ise yerine konulması istenen değer.

### ```call``` Fonksiyonu

```call``` ile Callable olarak ayarlanmış bir Bind'i çalıştırmayı sağlar.

```call( $key, $arguments = array() )```

- ```$key```: Callable olan Bind.
- ```$arguments```: Çalıştırılan Bind'e gönderilen argümanlar.

Örnek:
```
$app->set( "hi", function( $app, $sayWho ) {
	echo $app->get( "name" ) . " say hi to " . $sayWho;
} );

$app->call( "hi", $sayWho );
```

Not: Burada dikkat edilmesi gerekilen nokta, ```call``` ile gönderilen ilk argümanın Apper nesnesi olmasıdır.

## Apper ile Olay işlemleri ( Events )

Apper, basit ama etkili bir Event sistemine sahiptir.

### ```on``` Fonksiyonu

Apper nesnesine Event oluşturur.

```on( $name, $function, $arguments = array(), $one = false )```

- ```$name```: Event ismi.
- ```$function```: Event fonksiyon listesine eklenecek Callable.
- ```$arguments```: Fonksiyon çağrıldığında beraberinde yollacak argümanlar.
- ```$one```: Fonksiyon Event tetiklendiğinde bir kez çalıştırıldıktan sonra Event fonksiyonları listesinden sil.

Ör:
```
$app->on( "saySomething", function( $app ) {
	echo "saySomething Event is running.";
} );
```

### ```trigger``` Fonksiyonu

Event listesindeki olayı tetikler. Olay tetiklemesi ile fonksiyon listesi sırası ile çalıştırılır.

```trigger( $eventName, $arguments = array() )```

- ```$eventName```: Tetiklenecek Event ismi.
- ```$arguments```: Event listesindeki fonksiyonlara ortak gönderilecek argüman listesi.

```trigger``` Event'i tetiklemeden önce ```before.$eventName```'i tetikler. Sonrasında Event'i tetikler. Event tetiklendikten sonra ```before.$eventName```'i tetikler.

### ```one``` Fonksiyonu

```on``` fonksiyonundaki $one değerini otomatik olarak ```true``` olarak Event'e fonksiyon ekler.

```one( $name, $function, $arguments = array(), $one = false )```

- ```$name```: Event ismi.
- ```$function```: Event fonksiyon listesine eklenecek Callable.
- ```$arguments```: Fonksiyon çağrıldığında beraberinde yollacak argümanlar.

### ```before``` Fonksiyonu

```before.$eventName```'e fonksiyon ekler.

```before( $name, $function, $arguments = array(), $one = false )```

- ```$name```: Event ismi.
- ```$function```: Event fonksiyon listesine eklenecek Callable.
- ```$arguments```: Fonksiyon çağrıldığında beraberinde yollacak argümanlar.
- ```$one```: Fonksiyon Event tetiklendiğinde bir kez çalıştırıldıktan sonra Event fonksiyonları listesinden sil.

### ```after``` Fonksiyonu

```after.$eventName```'e fonksiyon ekler.

```after( $name, $function, $arguments = array(), $one = false )```

- ```$name```: Event ismi.
- ```$function```: Event fonksiyon listesine eklenecek Callable.
- ```$arguments```: Fonksiyon çağrıldığında beraberinde yollacak argümanlar.
- ```$one```: Fonksiyon Event tetiklendiğinde bir kez çalıştırıldıktan sonra Event fonksiyonları listesinden sil.

### ```isEvent``` Fonksiyonu

Event'in olup olmadığını döner.

```isEvent( $eventName )```

- ```$eventName```: Varlığı sorulan Event.

## Apper Nesnesine Fonksiyon Eklemek

Apper nesnesi her çeşit kalıba uyum sağlaması için tasarlanmıştır. Nesneye Fonksiyon eklemek son derece kolaydır. Nesneye eklenen fonksiyonlar ```monkeyPatches```'de array içinde tutulur.

### ```setPatch``` Fonksiyonu

Fonksiyon ekler.

```setPatch( $functionName, $function );```

- ```$functionName```: Fonksiyon ismi.
- ```$function```: Callable içerik.

Örnek:
```
$app->setPatch( "sayHi", function( $app ) {
	echo "Hi!";
} );
```

### ```delPatch``` Fonksiyonu

Fonksiyon siler.

```delPatch( $functionName );```

- ```$functionName```: Fonksiyon ismi.

### ```patched``` Fonksiyonu

Fonksiyon varlığını döndürür.

```patched( $functionName, $function = null );```

- ```$functionName```: Fonksiyon ismi.
- ```$function```: Eğer fonksiyon yok ise yerine konması istenen Callable içerik.

### ```getPatch``` Fonksiyonu

Fonksiyonu döndürür.

```getPatch( $functionName );```

- ```$functionName```: Fonksiyon ismi.

### Patch ile Eklenen Fonksiyonu Çağırmak

Patch ile eklenen fonksiyon normal fonksiyonmuş gibi çağrılabilir.

Örnek:
```
$app->setPatch( "sayHi", function( $app ) {
	echo "Hi!";
} );

$app->sayHi();
```

## Apper Detayları

### Bind ile Patch Arasındaki Fark

Bind ve Patch ile fonksiyon eklenebilir, fakat patch ile eklenenler direk çağrılabilir, bind ile eklenenler ```call``` ile çağrılabilir. Ayrıca pacth sistemi fonksiyon eklemek için tasarlanmıştır. Onun için Patch sistemi ile fonksiyon eklenmesi daha doğrudur.

### Otomatik oluşturulan Bind'ler

Apper'ın otomatik olarak atadığı Bind'ler mevcuttur.

- ```name```: Apper nesnesinin ismidir. Apper oluşturulurken Bind'lere eklenmezse otomatik olarak Class ismini(```__CLASS__```) alır.
- ```version```: Apper nesnesinin verisiyonudur. Apper oluşturulurken Bind'lere eklenmezse otomatik olarak ```0.0.0``` alır.
- ```main_function```: Apper'ın ```run``` fonksiyonu ile çalıştırılan Bind'idir. Apper oluşturulurken eklenen fonksiyondur. Apper nesnesi oluşturulduktan sonra normal bir şekilde Bind editleme ile değiştirilebilir.

### ```run``` Fonksiyonu

Apper nesnesinin ```main_function``` Bind'ini ```call``` ile çalıştırır.

```run( $arguments = array() )```

- ```$arguments```: ```main_function``` Bind'ine göndeirilen argümanlar.

### ```version``` Fonksiyonu

Apper nesnesinin ```version``` Bind'ini döndürür.

## Performans Hakkında

Benchmark testleri daha yapılmadı fakat performansı korumak adına şu tavsiyeler verilebilir:

- Static Apper'ı gerek kalmadıkça kullanmayın. Çünkü bütün fonksiyonları ```Magic Method``` ile çağırmaktadır.

- Fonksiyon çağırma hızını arttırmak için fonksiyonları Bind ile tutun. Çünkü Pach ile tutarsanız, fonksiyon ```Magic Method``` ile çağrılır. Bind ile direk çağırabilirsiniz.

## Son

Apper için oluşturulan test dosyaları Apper'ı kullanmak için fikir verebilir.

Destek için kalaomer@hotmail.com adresinden destek alabilirsiniz.
