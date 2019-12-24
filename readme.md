В данной функции происходит попытка парсинга из входящей СМС от 
Яндекс.деньги:
1) Кода подтверждения.
2) Суммы.
3) Номера кошелька.

В первую очередь мы пытаемся изъять сумму. Сначала ищем набор цифр 
разделенных точкой или запятой с 1 до 6 цифр до разделителя, 
и двумя цифрами после них. 

Если не получилось, то тогда предпринимаем новую попытку и ищем набор 
из цифр от 1 до 6 и следующим за ним символом r или р (русская) без 
учета регистра с возможным наличием одного пробела между цифрами и 
буквой.

Если после этого опять не нашли, выбрасываем соответствующую ошибку.
Если же найдено более одного подходящего элемента, то тоже выбрасываем
соответствующую ошибку.

В случае успешного нахождения удаляем найденные цифры из текста СМС.

Затем мы пытаемся изъять код подтверждения. Там просто пытаемся найти
набор цифр размером от 4 до 6, по сторонам от которых стоят нецифровые
символы (избегаем ошибки с парсингом номера кошелька вместо кода 
подтверждения). Выбрасываем соответствующие ошибки если не нашли ничего,
либо нашли более одного варианта. В случае успеха вырезаем найденное 
число из СМС.

На последнем этапе мы ищем набор число размером от 11 до 20 цифр.
Судя по найденной информации размер номеров кошельков Яндекс.деньги
находятся в этих диапазонах. Другими условиями поиска пренебрегаем
так как такая большая последовательность цифр не требует в данных 
условиях дополнительных усилий по её поиску. В случае отсутствия
найденной последовательности или 2 и более подходящих наборов цифр
выбрасываем соотетствующие исключения.

В конце формируем ответ в виде ассоциативного массива и возвращем его
как ответ функции.