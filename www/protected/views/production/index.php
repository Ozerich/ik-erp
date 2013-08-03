<aside>
    <a href="#" class="btn btn-success btn-new-order">Новый заказ</a>

    <section class="calendar-block">
        <div id="calendar">
            <div class="calendar-header">
                <a href="#" class="arrow-left icon-chevron-left"></a>
                <a href="#" class="arrow-right icon-chevron-right"></a>
                <span></span>
            </div>
            <div class="calendar-table">
                <table>
                    <thead>
                    <tr>
                        <th><span>Пн</span></th>
                        <th><span>Вт</span></th>
                        <th><span>Ср</span></th>
                        <th><span>Чт</span></th>
                        <th><span>Пт</span></th>
                        <th><span>Сб</span></th>
                        <th><span>Вс</span></th>
                    </tr>
                    </thead>
                    <tbody>
                    </tbody>
                </table>
            </div>
        </div>
    </section>

    <section class="categories-block">
        <ul>
            <li><a href="#">В работе</a></li>
            <li><a href="#">Заказы на производство</a></li>
            <li><a href="#">Наряды в металл</a></li>
            <li><a href="#">Наряды в фанеру</a></li>
            <li><a href="#">Наряды на сборку</a></li>
            <li><a href="#">Наряды в брус</a></li>
            <li><a href="#">Ведомости к отругзке</a></li>
        </ul>
    </section>

</aside>

<section id="content">
    <header>
        <div class="btn-group" data-toggle="buttons-radio">
            <button type="button" class="btn active">Табличный вид</button>
            <button type="button" class="btn">Сетевой вид</button>
            <button type="button" class="btn">На рассмотрении</button>
        </div>
        <div class="right-buttons">
            <button class="btn"><span class="icon-minus-sign"></span> <span class="icon-plus-sign"></span>
                Свернуть/Развернуть всё
            </button>
            <button class="btn"><span class="icon-print"></span> Печать</button>
        </div>
    </header>

    <article>
        <header>
            <table>
                <tbody>
                    <tr>
                        <td class="cell-date">
                            <button><span class="icon-minus-sign"></span></button>
                            <span class="date">22 июня <span class="day">пн</span></span>
                        </td>
                        <td class="cell-name">
                            <span class="name">Заказ № 345 от 12.07.13</span>
                        </td>
                    </tr>
                </tbody>
            </table>
        </header>
    </article>

</section>

<script src="/js/components/calendar.js"></script>
<script src="/js/pages/production.js"></script>