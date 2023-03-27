# PHP CRONJOB
![](https://img.shields.io/badge/Ver.-1.0.1-dark) ![](https://img.shields.io/badge/Author-trfoxs-blue) ![](https://img.shields.io/badge/profile-semihbtr-green?logo=linkedin&style=flat-square) ![](https://shields.io/badge/license-MIT-informational) ![](https://img.shields.io/badge/english-red) ![](https://img.shields.io/badge/turkish-red)

php ile basit cronjob oluşturma

### Gereksinimler
- PHP 5.6.x ve üzeri !
- exec,shell_exec allow olmalıdır!

### Kurulum
- Github ile verileri indirin
- require('cronjob.php'); sayfanıza ekleyin.

### Komutlar
- [x] insert (crontab insert) #80
- [x] remove (crontab remove) #93
- [x] error (error report) #111
- [x] (protected) _exec #153
- [x] (protected) valid #130

### Cron Örneği için 
Aşağıdaki adres üzerinden, online olarak cron oluşturabilir ve örneklere bakabilirsiniz.
[cronhub.io](https://crontab.cronhub.io/)
    
### KULLANIM
dosya aktarıkır ve fonksiyon çağırılır.
```php
require('cronjob.php');
$cron = new cronjob();
```
#### INSERT || ADD

```php
$cron->minute = '*/60'; // dakika (0-59)
$cron->hour = '*'; // saat (0 - 23)
$cron->day = '*'; // ayın günleri (1 - 31)
$cron->month = '*'; // ay (1 - 12)
$cron->week = '*'; // haftanın günü (0 - 6) pazardan-cumartesi
$cron->run = 'image/test.php'; // çalıştırılacak komut

$cron->add();

var_dump($cron->error());
	string '' (length=0)
```
----
### DELETE | REMOVE
```php
$cron->minute = '*/60'; // dakika (0-59)
$cron->hour = '*'; // saat (0 - 23)
$cron->day = '*'; // ayın günleri (1 - 31)
$cron->month = '*'; // ay (1 - 12)
$cron->week = '*'; // haftanın günü (0 - 6) pazardan-cumartesi
$cron->run = 'image/test.php'; // çalıştırılacak komut

$cron->remove();
```
----
### ERROR | $this->error();

Error komutları;
	- 0 => true, 
	- 1 => true, 
	- 2 => 'Missing keyword or command', 
	- 126=>'Permission problem or command is not an executable', 
	- 127=>'Command not found',
```php
if ($this->error()) {
	echo $this->error();
}
```
