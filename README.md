# Antigate
Class for anti-captcha.com

Требуется вписать ключ в $secret_key = '';

Использование

```php
$captcha_text = Antigate::read('http://site.com/image.jpg');
```

Требуется класс request. https://github.com/MashinaMashina/request
