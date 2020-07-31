import {SERVICE} from './constants';

/**
 * Функция ищет элемент по селектору
 *
 * @param selector Селектор, по которому производится поиск
 * @param quantity При заданной константе MANY ищет несколько элементов
 * @return Первый обнаруженный DOM-элемент, или, при заданном втором параметре -
 * возвращает массив обнаруженных DOM-элементов
 * @author Nikita Murashov
 * @author MAKAP MOPKOBKUH
 */
function $el(selector, quantity = undefined)
{
    if (quantity === SERVICE.MANY) {
        return Array.from(document.querySelectorAll(selector));
    } else {
        return document.querySelector(selector);
    }
}

/**
 * Функция получает значение атрибута value элемента и верно его форматирует
 *
 * @param elem Элемент, значение атрибута которого нужно получить
 * @param type Подходящий тип данных для значения атрибута
 * @return Отформатированное значение
 * @author Nikita Murashov
 */
function $value(elem, type)
{
    const VALUE = elem.value;

    switch (type) {
        case 'int':
            return parseInt(VALUE);
        case 'float':
            return parseFloat(VALUE);
        default:
            return VALUE;
    }
}

/**
 * Встроенная функция, которая "капитализирует" строку
 *
 * @return "Капитализированная" строка
 * @author Nikita Murashov
 */
String.prototype.toCapitalCase = function()
{
    return this.charAt(0).toUpperCase() + this.slice(1).toLowerCase();
}

export {$el, $value};
