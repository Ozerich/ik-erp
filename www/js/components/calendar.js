$.fn.Calendar = function () {
    var that = this;

    var monthNames = ['Январь', 'Февраль', 'Март', 'Апрель', 'Май', 'Июнь', 'Июль', 'Август', 'Сентябрь', 'Октябрь', 'Ноябрь', 'Декабрь'];

    var today = new Date;

    this.currentMonth = today.getMonth();
    this.currentYear = today.getFullYear();

    var $btn_left = $(this).find('.arrow-left');
    var $btn_right = $(this).find('.arrow-right');
    var $content = $(this).find('tbody');
    var $header = $(this).find('.calendar-header span');

    var updateMonth = function () {

        var i, j, html = '';

        $header.text(monthNames[that.currentMonth] + ' ' + that.currentYear);

        var firstDay = new Date(that.currentYear, that.currentMonth, 1).getDay();
        var daysCount = new Date(that.currentYear, that.currentMonth + 1, 0).getDate();

        html += '<tr>';
        for (i = 0; i < (firstDay == 0 ? 7 : firstDay) - 1; i++) {
            html += '<td class="empty"></td>';
        }
        for (j = 1, i = i + 1; i <= 7; i++, j++) {
            html += '<td><span>' + j + '</span></td>';
        }
        html += '</tr>';

        for (i = j, j = 1; i <= daysCount; i++, j++) {
            if (j == 1) {
                html += '<tr>';
            }

            html += '<td><span>' + i + '</span></td>';

            if (j == 7) {
                html += '</tr>';
                j = 0;
            }
        }

        if (j != 1) {
            for (; j <= 7; j++) {
                html += '<td class="empty"></td>';
            }
            html += '</tr>';
        }

        $content.html(html);
    };

    $btn_left.on('click', function () {
        that.currentMonth--;

        if (that.currentMonth < 0) {
            that.currentMonth = 11;
            that.currentYear--;
        }

        updateMonth();

        return false;
    });

    $btn_right.on('click', function () {
        that.currentMonth++;

        if (that.currentMonth > 11) {
            that.currentMonth = 0;
            that.currentYear++;
        }

        updateMonth();

        return false;
    });

    updateMonth();
};

/*
 <tr>
 <td class="empty"></td>
 <td class="day"><span>1</span></td>
 <td class="day"><span>2</span></td>
 <td class="day"><span>3</span></td>
 <td class="day"><span>4</span></td>
 <td class="day"><span>5</span></td>
 <td class="day"><span>6</span></td>
 </tr>
 <tr>
 <td class="day"><span>1</span></td>
 <td class="day"><span>2</span></td>
 <td class="day"><span>3</span></td>
 <td class="day"><span>4</span></td>
 <td class="day"><span>5</span></td>
 <td class="day"><span>6</span></td>
 <td class="day"><span>7</span></td>
 </tr>
 <tr>
 <td class="day"><span>1</span></td>
 <td class="day"><span>2</span></td>
 <td class="day"><span>3</span></td>
 <td class="day"><span>4</span></td>
 <td class="day"><span>5</span></td>
 <td class="day"><span>6</span></td>
 <td class="day"><span>7</span></td>
 </tr>
 <tr>
 <td class="day"><span>1</span></td>
 <td class="day"><span>2</span></td>
 <td class="day"><span>3</span></td>
 <td class="day"><span>4</span></td>
 <td class="empty"></td>
 <td class="empty"></td>
 <td class="empty"></td>
 </tr>
 */