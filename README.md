# quest
Тестовое задание на должность PHP-разработчика

Вычисление статистики по платежам на тестовых данных и вывод полученной информации в консоль.

<h2>Установка</h2>
<pre>
$ git clone https://github.com/BoesesGenie/quest.git
$ composer install
</pre>

<h2>Использование</h2>
<pre>
$ php quest_done.php statistic --without-documents --with-documents
</pre>

--without-documents - Без докуметов

--with-documents - С документами

Если опции не заданы или заданы обе опции, выводятся обе строки таблицы - платежи с документами и без.
