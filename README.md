Eğer bu siteleri sizde denemek isterseniz şu adımları uygulayabilirsiniz.

1- XAMPP'ı İndirin ve Kurun
2- XAMPP'i başlattıktan sonra, Apache ve MySQL servislerini çalıştırın.
3- Veritabanı Oluşturun
4- XAMPP'in phpMyAdmin aracını kullanarak bir veritabanı oluşturun.
5- http://localhost/phpmyadmin/ adresine gidin, sol menüde Yeni butonuna tıklayarak bir veritabanı oluşturun. Örnek olarak proje adında bir veritabanı oluşturabilirsiniz.
6- Veritabanı Yapısını İçe Aktarın
7- Projenin SQL dosyasını phpMyAdmin üzerinden veritabanınıza içe aktarın. Bu işlemle birlikte gerekli tablolar ve veriler veritabanınıza yüklenecektir.
8- PHP Dosyasındaki Veritabanı Bağlantısını Yapılandırın
9- Projeyi çalıştırabilmek için PHP dosyasındaki veritabanı bağlantısını doğru şekilde yapılandırmanız gerekmektedir.(Aşağıdaki kısımları düzeltmeniz gerekicek!)
    $servername: Genellikle localhost olur, çünkü XAMPP yerel sunucunuzda çalışır.
    $username: XAMPP'in varsayılan kullanıcı adı root'tur.
    $password: XAMPP'in varsayılan şifresi boştur, yani "" (boş bırakın).
    $dbname: phpMyAdmin üzerinden oluşturduğunuz veritabanının adı (bu örnekte proje).
10- Proje dosyalarını XAMPP'in htdocs klasörüne kopyalayın. htdocs genellikle C:\xampp\htdocs\ dizininde yer alır.
11- Daha sonra tarayıcınızda http://localhost/proje_adı adresine giderek projeyi çalıştırabilirsiniz.




!Uyarılar!
----------
Bu uygulama, XSS (Cross-Site Scripting), SQL Injection ve OS Command Injection gibi güvenlik açıklarını test etmek amacıyla geliştirilmiştir. Gerçek sistemlerde bu tür testlerin yapılması, güvenlik riskleri oluşturabilir. Yalnızca güvenli test ortamlarında kullanınız.































Process.php
-----------

Bu sayfa, web uygulamalarındaki üç farklı güvenlik açığını (XSS, SQL Enjeksiyonu ve OS Komut Enjeksiyonu) test etmek için tasarlanmış bir formu içeriyor. İşte sayfanın temel özellikleri:

1. HTML Yapısı:
  Form Elemanları:

      XSS Testi: Kullanıcının girilen metni doğrudan ekranda görüntüler (XSS açığı).
   
      SQL Testi: Kullanıcının girdiği veriye dayalı olarak bir SQL sorgusu çalıştırır ve veritabanından sonuçları gösterir (SQL enjeksiyonu).
   
      OS Komut Testi: Kullanıcının girdiği komutları doğrudan sunucuda çalıştırır (OS komut enjeksiyonu).

---------------------------------------------------------------------------------------------------------
   
2. PHP Kodları:
----------------

      XSS: Kullanıcının girdiği metin, herhangi bir filtreleme yapılmadan doğrudan sayfada gösterilir. Bu, XSS zafiyetine yol açabilir.
   
      SQL Enjeksiyonu: Kullanıcıdan alınan veriye doğrudan SQL sorgusu eklenir. Bu, kötü niyetli kullanıcıların veritabanına zarar vermesine veya hassas verileri görüntülemesine yol açabilir.
   
      OS Komut Enjeksiyonu: Kullanıcının girdiği komut, sunucuda herhangi bir doğrulama yapılmadan çalıştırılır. Bu, bir saldırganın sunucu üzerinde komut çalıştırmasına neden olabilir.

----------------------------------------------------------------------------------------------------------
   
3. Çıktı Alanı:
---------------

Her testin sonucu, formun alt kısmında görüntülenir.
      XSS testi, kullanıcı tarafından girilen veriyi doğrudan gösterirken;
      SQL testi veritabanından alınan sonuçları gösterir.
      OS Komut testi ise komutun çıktısını ekranda gösterir.

----------------------------------------------------------------------------------------------------------
   
4. JavaScript:
--------------

Form gönderildikten sonra kullanıcı tarafından girilen değerler, formun yeniden yüklenmesinden sonra korunur. Bu, sayfa yeniden yüklendiğinde kullanıcı girdilerini kaybetmemek için kullanılır.



Genel Amaç:
Bu sayfa, eğitim ve güvenlik testi amacıyla web uygulamalarındaki yaygın güvenlik açıklarını (XSS, SQL Enjeksiyonu, OS Komut Enjeksiyonu) simüle etmek ve bu zafiyetleri keşfetmek için tasarlanmıştır. Ancak, bu tür açıklar gerçek bir uygulamada ciddi güvenlik tehditleri oluşturabilir, bu nedenle yalnızca kontrollü ve güvenli ortamda test edilmelidir.





















Fixed.php
----------

1. HTML Yapısal Değişiklikler:
  Başlık ve Stil Düzenlemeleri:

      Önceki Kod: Başlıklar ve stil konusunda bazı iyileştirmeler yoktu.

      Yeni Kod: Görünüm için daha profesyonel bir tasarım kullanılmış. HTML başlıkları (h1, h2, h3) ve içerik kutusu düzeni, arka plan renkleri ve butonlar daha dikkatlice stilize edilmiş.





-----------------------------------------------------------------------------------------------------




2. PHP İşlemleri:
    Genel İşleyiş:

        Önceki Kod: PHP ile form verilerini alırken bazı güvenlik önlemleri alınmıştı, ancak SQL sorgusunda temel güvenlik önlemleri yetersizdi (örneğin, SQL Injection'a karşı korunma eksikti).

        Yeni Kod: PHP kısmı güvenlik açısından iyileştirilmiş. Formdan gelen veriler "htmlspecialchars()" fonksiyonu ile güvenli hale getirilip, çıktıların doğru şekilde ekrana basılması sağlanmış. Bu sayede XSS (Cross-Site Scripting) saldırılarına karşı bir önlem alınmış.



SQL Injection Güvenliği:
------------------------

    Önceki Kod: SQL sorgusunda doğrudan kullanıcıdan alınan veriyi kullanıyordu, bu da SQL Injection   saldırılarına yol açabilir.

    Yeni Kod: SQL Injection'a karşı prepare ve bind_param kullanılmış. Bu sayede, SQL sorgularına kullanıcı girdisi doğrudan eklenmek yerine parametreli sorgularla güvenli bir şekilde işleniyor.



XSS (Cross-Site Scripting) Güvenliği:
-------------------------------------

    Önceki Kod: XSS koruması konusunda herhangi bir işlem yapılmamıştı.

    Yeni Kod: XSS saldırılarına karşı önlem olarak "htmlspecialchars()" fonksiyonu kullanılarak, kullanıcıdan gelen inputlar güvenli hale getirilmiş ve çıktılar HTML olarak güvenli şekilde ekrana yazdırılmış.



OS Command Injection:
----------------------

    Önceki Kod: OS komutları doğrudan kullanıcı tarafından çalıştırılıyordu.

    Yeni Kod: OS komutlarıyla yapılan işlemde, kullanıcıdan alınan IP adresi doğrulandıktan sonra "escapeshellarg()" kullanılarak komutlar güvenli hale getirilmiş. Bu, komut enjeksiyonunu önlemeye yönelik önemli bir adımdır.



----------------------------------------------------------------------------------------------------------




3. Kullanıcı Girdisi İşleme:
----------------------------

    Önceki Kod: Kullanıcıdan gelen veriler doğrudan işlenmeden ekrana basılıyordu. Bu, XSS saldırılarına olanak tanıyabilir.

    Yeni Kod: Herhangi bir kullanıcı girdisi PHP tarafından alındığında, "htmlspecialchars()" fonksiyonu ile zararlı karakterler temizlenip, çıktılar güvenli hale getirilmiş. Böylece XSS saldırılarına karşı ek güvenlik önlemi alınmış.



----------------------------------------------------------------------------------------------------------

    

4. Sonuçların Gösterimi:
------------------------

    Önceki Kod: Sonuçlar doğrudan formdan sonra ekrana basılıyordu, ancak stil açısından çok fazla düzenleme yoktu.
    
    Yeni Kod: Sonuçlar daha temiz ve düzenli bir şekilde gösteriliyor. XSS, SQL ve OS Command sonuçları için özel başlıklar ve stiller eklenmiş. Ayrıca, çıktılar görsel olarak daha dikkat çekici ve kullanıcı dostu hale getirilmiş.

    
Özet:
Yeni kodda, güvenlik önlemleri ve kullanıcı deneyimi önemli ölçüde iyileştirilmiş. Özellikle XSS, SQL Injection ve OS Command Injection gibi güvenlik açıklarına karşı alınan önlemler, daha güvenli bir uygulama sağlamakta. Ayrıca, görsel düzenlemeler ve kullanıcı dostu tasarım iyileştirmeleri yapılmış. Bu yeni kod, daha profesyonel bir güvenlik testi sayfası sunuyor.






